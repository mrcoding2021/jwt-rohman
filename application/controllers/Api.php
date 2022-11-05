<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';

use chriskacerguis\RestServer\RestController;
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;


class Api extends RestController
{

    function configToken()
    {
        $cnf['exp'] = 10; //detik
        $cnf['secretkey'] = '2212336221';
        return $cnf;
    }
    
    public function get_post()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $exp = time() + 3600;
        $token = array(
            "iss" => 'jwtsistem',
            "aud" => 'abdulrohman',
            "iat" => time(),
            "nbf" => time() + 10,
            "exp" => $exp,
            "data" => array(
                "username" => $username,
                "password" => $password,
            )
        );

        $data = $this->db->get_where('user', ['email' => $username])->row();
        
        if ($data) {
            $jwt = JWT::encode($token, $this->configToken()['secretkey']);
            if (password_verify($password, $data->password)) {
                $output = [
                    'kode' => 200,
                    'pesan' => 'Berhasil login',
                    "token" => $jwt,
                    "expireAt" => $token['exp']
                ];
                $this->response($output, 200);
            } else {
                return $this->response(array('kode' => '401', 'pesan' => 'username atau password salah', 'data' => []), '401');
            }
        } else {
            return $this->response(array('kode' => '401', 'pesan' => 'signature tidak sesuai', 'data' => []), '401');
        }
    }

    public function authtoken()
    {
        $secret_key = $this->configToken()['secretkey'];
        $token = null;
        $authHeader = $this->input->request_headers()['Authorization'];
        $arr = explode(" ", $authHeader);
        $token = $arr[1];
        if ($token) {
            try {
                $decoded = JWT::decode($token, $this->configToken()['secretkey'], array('HS256'));
                if ($decoded) {
                    $res = [
                        'usename'   => $decoded->data->username,
                    ];
                    $this->session->set_userdata($res);
                    return true;
                }
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    public function users_get($id = '')
    {
        if ($this->authtoken() == false) {
            return $this->response(array('kode' => '401', 'pesan' => 'signature tidak sesuai', 'data' => []), '401');
            die();
        }

        if ($id) {
            $data = $this->db->get_where('user', ['id_user' => $id])->row();
            if (!$data) {
                return $this->response(array('kode' => '401', 'pesan' => 'Data tidak ditemukan', 'data' => []), '401');
                die();
            }
            $this->response($data, 200);
        } else {
            $user = $this->session->userdata('usename');
            $res = $this->db->get_where('user', ['email' => $user])->row();
            if ($res->role == 'admin') {
                $res = $this->db->get('user')->result();
                $data = array('data' => $res);
                $this->response($data, 200);
            } else {
                return $this->response(array('kode' => '401', 'pesan' => 'Hanya Admin yang bisa akses Data', 'data' => []), '401');
                die();
            }
        }
    }

    public function users_post()
    {
        if ($this->authtoken() == false) {
            return $this->response(array('kode' => '401', 'pesan' => 'signature tidak sesuai', 'data' => []), '401');
            die();
        }
        $email = $this->input->post('email');
        $dataExis = $this->db->get_where('user', ['email' => $email])->row();
        if ($dataExis) {
            return $this->response(array('kode' => '401', 'pesan' => 'Email sudah terdaftar', 'data' => []), '401');
            die();
        } else {
            $data = [
                'name'          => $this->input->post('name'),
                'email'         => $email,
                'password'      => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role'          => $this->input->post('role'),
                'created_at'    => date('Y-m-d H:i:s')
            ];
            $this->db->insert('user', $data);
            $output = [
                'kode' => 200,
                'pesan' => 'Input User Baru berhasil !',
            ];
            $this->response($output, 200);
        }
    }

    public function users_delete($id = '')
    {
        if ($this->authtoken() == false) {
            return $this->response(array('kode' => '401', 'pesan' => 'signature tidak sesuai', 'data' => []), '401');
            die();
        }
        if ($id == '') {
            return $this->response(array('kode' => '401', 'pesan' => 'Error Handling', 'data' => []), '401');
            die();
        }
        $user = $this->session->userdata('usename');
        $res = $this->db->get_where('user', ['email' => $user])->row();
        if ($res->role == 'admin') {
            $dataExis = $this->db->get_where('user', ['id_user' => $id])->row();
            if ($dataExis->role != 'admin') {
                $this->db->delete('user', ['id_user' => $id]);
                $output = [
                    'kode' => 200,
                    'pesan' => 'Data User Berhasil terhapus !',
                ];
                $this->response($output, 200);
            } else {
                return $this->response(array('kode' => '401', 'pesan' => 'Admin tidak bisa di hapus', 'data' => []), '401');
                die();
            }
        } else {
            return $this->response(array('kode' => '401', 'pesan' => 'Hanya admin yang bisa menghapus data', 'data' => []), '401');
            die();
        }
    }
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function index()
	{
		$this->load->view('login');
	}

	public function api_post($id = '')
	{
		$token = substr($this->input->post('token'), 7);
		// $token = $this->input->post('token');
		if ($id != '') {
			$url = 'http://siswa.test/api/users/' . $id;
		} else {
			$url = 'http://siswa.test/api/users/';
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer " . $token));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		// echo $result;
		$result = json_decode($result, true);

		echo json_encode($result);
	}

	public function insert()
	{
		$token = substr($this->input->post('token'), 7);
		// $token = $this->input->post('token');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$role = $this->input->post('role');
		$name = $_POST['name'];
		$array = [
			'name'		=> $name,
			'email'		=> $email,
			'password'	=> $password,
			'role'		=> $role,
		];
		// $array = http_build_query($array);
		$url = 'http://siswa.test/api/users/';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data', "Authorization: Bearer " . $token));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		// echo $result;
		$result = json_decode($result, true);
		echo json_encode($result);
	}

	public function delete($id)
	{
		$token = substr($this->input->post('token'), 7);
		// $token = $this->input->post('token');
		$url = 'http://siswa.test/api/users/' . $id;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer " . $token));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		// echo $result;
		$result = json_decode($result, true);
		echo json_encode($result);
	}
}

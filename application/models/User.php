<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model
{
    public function get_list_produk()
    {
        return $this->db->get('produk_nizar');
    }

    public function getRow($table, $where = [])
    {
        $query = $this->db->get_where($table, $where)->row();
        return $query;
    }

    public function is_valid($username)
    {
        $this->db->where('email', $username);
        $query = $this->db->get('user');
        return $query->row();
    }

    public function is_valid_num($username)
    {
        $this->db->where('email', $username);
        $query = $this->db->get('user');
        return $query->num_rows();
    }

    public function register($email, $password)
    {
      $this->db->set('email', $email);
      $this->db->set('password', $password);
      $this->db->insert('user');
    }
}

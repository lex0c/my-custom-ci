<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $lastname;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $rememberToken;

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;

    /**
     * Loads the necessary resources to the controller.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_user($email)
    {
        $sql = "SELECT id, name, lastname, password FROM users WHERE email = ? LIMIT 1";
        $query = $this->db->query($sql, $email);

        $result = $query->result();

        if(empty($result))
            return null;

        return $result[0];
    }

    public function set_token($id, $token)
    {
        $this->db->set(['remember_token' => $token], FALSE);
        $this->db->where('id', $id);
        $status = $this->db->update('users');

        if($status) {
            return true;
        }

        return false;
    }

    public function get_token($id)
    {
        $sql = "SELECT remember_token FROM users WHERE id = ?";
        $query = $this->db->query($sql, $id);

        $result = $query->result();

        if(empty($result))
            return null;

        return $result[0];
    }

}

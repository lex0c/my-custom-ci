<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * User data.
     *
     * @var string
     */
    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function get_by_email($email)
    {
        $email = htmlentities($email);
        $sql = "SELECT id, name, lastname, password FROM users WHERE email = ? LIMIT 1";
        $query = $this->db->query($sql, $email);
        $result = $query->result();

        if (!empty($result)) {
            return $result[0];
        }

        return null;
    }

    /**
     *
     */
    public function save(array $user)
    {
        $user['created_at'] = date("Y-m-d H:i:s");
        $user['updated_at'] = date("Y-m-d H:i:s");

        $user = array_map('htmlentities', $user);
        $status = $this->db->insert('users', $user);

        unset($user);
        return ($status) ? true : false;
    }

    public function update($id)
    {
        // ...
    }

    public function delete($id)
    {
        // ...
    }

}

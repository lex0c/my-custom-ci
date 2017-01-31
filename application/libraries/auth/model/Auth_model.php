<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model
{
    /**
     * User data.
     *
     * @var string
     */
    public $remember_token;

    /**
     * Reference to CodeIgniter instance
     *
     * @var object
     */
    protected $CI;

    /**
     * Loads the necessary resources to the controller.
     */
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     *
     */
    public function times_tamp()
    {
        return [
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
    }

    /**
     *
     */
    public function get_token($id)
    {
        $sql  = "SELECT remember_token FROM users WHERE id = ?";
        $query = $this->CI->db->query($sql, $id);
        $result = $query->result();

        return (!empty($result)) ? $result[0] : null;
    }

    /**
     *
     */
    public function set_token($id, $token)
    {
        $id = (int) $id; $token = htmlentities((string) $token);
        $this->CI->db->set(['remember_token' => $token], false);
        $this->CI->db->where('id', $id);
        $status = $this->CI->db->update('users');

        return $status;
    }

}

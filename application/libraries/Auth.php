<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth
{
    /**
     * Reference to CodeIgniter instance
     *
     * @var object
     */
    protected $CI;

    /**
     *
     */
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('auth/Auth_model', 'authModel');
        $this->CI->load->library('Hash', 'hash');
    }

    /**
     * User authentication and session data creation.
     *
     * @param array  $authData
     * @param string $redirect
     *
     * @return mixed
     */
    public function authenticate(array $authData, $redirect)
    {
        if(!$this->is_authenticated()) {
            $authData = array_map('htmlentities', $authData);
            $authData = array_map('trim', $authData);

            $user = $this->CI->authModel->get_user($authData['email']);

            if($user == null) {
                return $this->CI->load->view('auth/login', array(
                    'errors' => ['Incorrect email or does not exist.'],
                    'email_fail' => 'Incorrect email or does not exist.'
                ));
            } elseif(!$this->CI->hash->is_equals($authData['password'], $user->password)) {
                return $this->CI->load->view('auth/login', array(
                    'errors' => ['Wrong password!'],
                    'password_fail' => 'Wrong password!'
                ));
            }

            $addr  = str_ireplace('.', '', filter_input(INPUT_SERVER, 'REMOTE_ADDR'));
            $agent = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');

            $auth_token = $addr . date("Ymd") . $agent . $user->id;
            $auth_token = $this->CI->hash->generate($auth_token);
            $this->CI->authModel->set_token($user->id, $auth_token);

            $this->CI->session->set_userdata([
                'auth_user_id'       => $user->id,
                'auth_user_name'     => $user->name,
                'auth_user_lastname' => $user->lastname,
                'auth_user_email'    => $authData['email'],
                'auth_user_status'   => $this->CI->hash->generate('isok'),
                'auth_user_token'    => $this->CI->hash->generate($agent . $addr . 'ramm4')
            ]);

        }

        return redirect($redirect, 200);
    }

    /**
     * Checks whether the guest is authenticated.
     *
     * @return boolean
     */
    public function is_authenticated()
    {
        if(($this->CI->session->has_userdata('auth_user_status') != null)
            && ($this->CI->hash->is_equals('isok', $this->CI->session->userdata('auth_user_status')))) {

            $addr  = str_ireplace('.', '', filter_input(INPUT_SERVER, 'REMOTE_ADDR'));
            $agent = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');
            $token = $agent . $addr . 'ramm4';

            if($this->CI->hash->is_equals($token, $this->CI->session->userdata('auth_user_token'))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Redirect client if it tries to access a route that needs
     * authentication.
     *
     * @param string  $access
     * @param string  $redirect
     * @param  array  $excepts
     *
     * @return void
     */
    public function who_see($access, $redirect = '/login', $excepts = [])
    {
        switch($access) {
            case 'auth':
                if(!$this->is_authenticated()) {
                    redirect($redirect);
                }
                break;
            case 'public':
                // ...
                break;
            default:
                throw new InvalidArgumentException('Invalid access type.');
        }
    }

    protected function token_verify()
    {}


    public function logout($redirect = '/')
    {
        $this->CI->session->sess_destroy();
        if(($this->CI->session->has_userdata('auth_user_status') != null)) {
            $this->CI->session->unset_userdata([
                'auth_user_id',
                'auth_user_name',
                'auth_user_lastname',
                'auth_user_email',
                'auth_user_status',
                'auth_user_token'
            ]);

            $this->CI->session->sess_destroy();
        }

        redirect($redirect);
    }

    public function register($name, $email, $password)
    {}

    public function get_user_data()
    {
        return $this->CI->session->all_userdata();
    }

}

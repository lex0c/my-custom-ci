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
    protected $errors = null;

    /**
     *
     */
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('auth/Auth_model', 'auth_model');
        $this->CI->load->library('form_validation');
        $this->CI->load->library('Hash', 'hash');
    }

    /**
     * User authentication and session data creation.
     *
     * @param array $auth_data
     *
     * @return Auth
     */
    public function authenticate(array $auth_data)
    {
        $auth_data = array_map('htmlentities', $auth_data);
        $this->CI->form_validation->set_rules('email', 'e-mail', 'trim|required|valid_email');
        $this->CI->form_validation->set_rules('password', 'password', 'required|min_length[6]');

        if ($this->CI->form_validation->run() !== false) {
            $user = $this->CI->auth_model->get_user($auth_data['email']);

            if(($user == null)
                || (!$this->CI->hash->is_equals($auth_data['password'], $user->password))) {
                $this->errors = 'Invalid credentials';
                return $this;
            }

            $addr  = str_ireplace('.', '', filter_input(INPUT_SERVER, 'REMOTE_ADDR'));
            $agent = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');

            $auth_token = $addr . date("Ymd") . $agent . $user->id;
            $auth_token = $this->CI->hash->generate($auth_token);
            $this->CI->auth_model->set_token($user->id, $auth_token);

            $this->CI->session->set_userdata([
                'auth_user_id'       => $user->id,
                'auth_user_name'     => $user->name,
                'auth_user_lastname' => $user->lastname,
                'auth_user_email'    => $auth_data['email'],
                'auth_user_status'   => $this->CI->hash->generate('isok'),
                'auth_user_token'    => $this->CI->hash->generate($agent . $addr . 'ramm4')
            ]);

            return null;
        }

        $this->errors = validation_errors();
        return $this;
    }

    /**
     * Checks whether the guest is authenticated.
     *
     * @return bool
     */
    public function can()
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
     *
     */
    public function cannot()
    {
        return (!$this->can()) ? true : false;
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
    public function who_see($access, $redirect = 'login', $excepts = [])
    {
        switch($access) {
            case 'auth':
                if(!$this->can()) {
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

    /**
     *
     */
    public function is_authenticated($redirect_to = 'home')
    {
        if ($this->can()) {
//            if (!empty($excepts)) {
//                foreach ($excepts as $except) {
//                    if (($except instanceof $this) && (method_exists($this, $except))) {
//                        //
//                    } else {
//                        return redirect($redirect_to);
//                    }
//                }
//            }

            return redirect($redirect_to);
        }
    }

    /**
     *
     */
    protected function token_verify()
    {}

    /**
     *
     */
    public function logout($redirect = '/')
    {
        $this->CI->session->sess_destroy();
        if(($this->CI->session->has_userdata('auth_user_status') !== null)) {
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

    /**
     *
     */
    public function register(array $register_data)
    {
        $register_data = array_map('htmlentities', $register_data);
        $this->CI->form_validation->set_rules('name', 'name', 'trim|required|min_length[3]|max_length[50]');
        $this->CI->form_validation->set_rules('lastname', 'lastname', 'trim|required|min_length[3]|max_length[50]');
        $this->CI->form_validation->set_rules('email', 'e-mail', 'trim|required|valid_email|max_length[150]');
        $this->CI->form_validation->set_rules('password', 'password', 'required|min_length[6]');
        $this->CI->form_validation->set_rules('password_confirm', 'password', 'required|matches[password]');

        if ($this->CI->form_validation->run() !== false) {

            $addr  = str_ireplace('.', '', filter_input(INPUT_SERVER, 'REMOTE_ADDR'));
            $agent = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');

            $auth_token = $addr . date("Ymd") . $agent . $user->id;
            $auth_token = $this->CI->hash->generate($auth_token);

            $status = $this->CI->auth_model->set_user([
                'name' => $register_data['name'],
                'lastname' => $register_data['lastname'],
                'email'    => $register_data['email'],
                'password' => $this->CI->hash->generate($register_data['password']),
                'remember_token' => $auth_token
            ]);

            if ($status) {
                return null;
            }
        }

        $this->errors = validation_errors();
        return $this;
    }

    /**
     *
     */
    public function get_user_data()
    {
        return $this->CI->session->all_userdata();
    }

    /**
     *
     */
    public function errors()
    {
        $errors = $this->errors;
        $errors = trim($errors);
        $errors = str_ireplace('<p>', '', $errors);
        $errors = str_ireplace('</p>', '', $errors);
        return array_filter(explode('.', $errors));
    }

}

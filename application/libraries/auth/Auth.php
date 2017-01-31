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
     * store the validations errors.
     *
     * @var string
     */
    protected $errors = null;

    /**
     * Create a new auth instance and load necessary resources.
     */
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('form_validation');
        $this->CI->load->model('User_model', 'user');
        $this->CI->load->library('auth/model/Auth_model', 'auth_model');
        $this->CI->load->library('auth/security/Hash', 'hash');
        //$this->CI->load->library('HashMask', 'mask');
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
            $user = $this->CI->user->get_by_email($auth_data['email']);

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
     * Checks whether the guest not is authenticated.
     *
     * @return bool
     */
    public function cannot()
    {
        return (!$this->can()) ? true : false;
    }

    /**
     * Redirect client if it tries to access a route that needs
     * authentication.
     *
     * @param string $access
     * @param string $redirect_to
     * @param array  $excepts
     *
     * @return mixed HttpResponse
     */
    public function who_see($access, $redirect_to = '/', array $excepts = [])
    {
        switch($access) {
            case 'auth':
                if ($this->can()) {
                    return true; // Actions here...
                }

                return redirect($redirect_to);
                break;
            case 'noauth':
                if ($this->cannot()) {
                    return true; // Actions here...
                }

                return redirect($redirect_to);
                break;
            default:
                throw new InvalidArgumentException('Invalid access type.');
        }
    }

    /**
     *
     */
    protected function token_verify()
    {}

    /**
     * Destroy the user data session.
     *
     * @param string $redirect_to
     *
     * @return HttpResponse
     */
    public function logout($redirect_to = '/')
    {
        $this->CI->session->sess_destroy();
        if ($this->CI->session->has_userdata('auth_user_status')) {
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

        return redirect($redirect_to);
    }

    /**
     * Register a new user.
     *
     * @param array $register_data
     *
     * @return Auth
     */
    public function register(array $register_data)
    {
        $register_data = array_map('htmlentities', $register_data);
        $this->CI->form_validation->set_rules('name', 'name', 'trim|required|min_length[3]|max_length[50]');
        $this->CI->form_validation->set_rules('lastname', 'lastname', 'trim|required|min_length[3]|max_length[50]');
        $this->CI->form_validation->set_rules('email', 'e-mail', 'trim|required|valid_email|max_length[100]');
        $this->CI->form_validation->set_rules('password', 'password', 'required|min_length[6]');
        $this->CI->form_validation->set_rules('password_confirm', 'password_confirm', 'required|matches[password]');

        if ($this->CI->form_validation->run() !== false) {

            $addr  = str_ireplace('.', '', filter_input(INPUT_SERVER, 'REMOTE_ADDR'));
            $agent = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');

            $auth_token = $addr . date("Ymd") . $agent . $user->id;
            $auth_token = $this->CI->hash->generate($auth_token);

            $status = $this->CI->user->save([
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
     * Retrieve all session user data.
     *
     * @return array
     */
    public function get_user_data()
    {
        return $this->CI->session->all_userdata();
    }

    public function routes()
    {
        return require_once ('routes.php');
    }

    /**
     * Returns validation errors.
     *
     * @return array
     */
    public function errors()
    {
        $errors = trim($this->errors);
        $errors = str_ireplace('<p>', '', $errors);
        $errors = str_ireplace('</p>', '', $errors);

        return array_filter(explode('.', $errors));
    }

}

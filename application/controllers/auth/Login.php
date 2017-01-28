<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectIfAuthenticated = 'home';

    /**
     * Where to redirect users if incorrect access.
     *
     * @var string
     */
    protected $redirectIfNotAuthenticated = 'welcome';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the form for logging in application.
     *
     * @return HttpResponse
     */
    public function index()
    {
        if(!$this->auth->is_authenticated()) {
            return $this->load->view('auth/login');
        } else {
            redirect($this->redirectIfAuthenticated);
        }
    }

    /**
     * Authenticates the user with their credentials.
     *
     * @return void
     */
    public function authenticable()
    {
        if(!$this->auth->is_authenticated()) {

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Senha', 'trim|required|min_length[6]');

            if($this->form_validation->run() != false) {
                $authData = $this->input->post();
                $this->auth->authenticate([
                    'email'    => $authData['email'],
                    'password' => $authData['password'],
                    'remember' => isset($authData['remember'])?$authData['remember']:false
                ], $this->redirectIfAuthenticated);
            } else {
                $errors = trim(validation_errors());
                $errors = str_ireplace('<p>', '', $errors);
                $errors = str_ireplace('</p>', '', $errors);

                $this->load->view('auth/login', [
                    'errors' => array_filter(explode('.', $errors))
                ]);
            }
        } else {
            redirect($this->redirectIfAuthenticated);
        }
    }

    public function logout()
    {
        if($this->auth->is_authenticated()) {
            $this->auth->logout($this->redirectIfNotAuthenticated);
        }

        redirect($this->redirectIfNotAuthenticated);
    }

}

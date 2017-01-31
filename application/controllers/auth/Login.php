<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirect_to = 'home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth->who_see('noauth');
    }

    /**
     * Show the form for logging in application.
     *
     * @return HttpResponse
     */
    public function index()
    {
        return $this->load->view('auth/sign-in');
    }

    /**
     * Authenticates the user with their credentials.
     *
     * @return HttpResponse
     */
    public function show()
    {
        $callback = $this->auth->authenticate($this->input->post());

        if ($callback !== null) {
            return $this->load->view('auth/sign-in', [
                'errors' => $callback->errors()
            ]);
        }

        return redirect($this->redirect_to);
    }

}

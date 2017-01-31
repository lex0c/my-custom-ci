<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller
{
    /**
     * Where to redirect users after logout.
     *
     * @var string
     */
    protected $redirect_to = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth->who_see('auth');
    }

    /**
     * Destroy the user data session.
     *
     * @return HttpResponse
     */
    public function index()
    {
        return $this->auth->logout($this->redirect_to);
    }

}

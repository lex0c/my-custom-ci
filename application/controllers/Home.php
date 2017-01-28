<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once ("auth/core/Auth.php");

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth->who_see('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return HttpResponse
     */
    public function index()
    {
        $this->load->view('home');
    }
}


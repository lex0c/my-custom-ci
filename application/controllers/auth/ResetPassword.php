<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ResetPassword extends CI_Controller
{
    /**
     * Where to redirect users after recover.
     *
     * @var string
     */
    protected $redirect_to = 'login';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth->who_see('noauth');
    }

    //

}

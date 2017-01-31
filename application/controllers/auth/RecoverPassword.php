<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecoverPassword extends CI_Controller
{
    /**
     * Where to redirect users after recover.
     *
     * @var string
     */
    protected $redirect_to = 'password/reset';

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

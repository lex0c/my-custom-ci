<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Helper to access easy user data.
 */
if(!function_exists('auth_data')) {
    /**
     * Returns some data from the current user.
     *
     * @return object
     */
    function auth_data()
    {
        $CI =& get_instance();
        if($CI->auth->can()) {
            $obj = new stdClass();
            $obj->id = $CI->auth->get_user_data()['auth_user_id'];
            $obj->name = $CI->auth->get_user_data()['auth_user_name'];
            $obj->lastname = $CI->auth->get_user_data()['auth_user_lastname'];
            $obj->email = $CI->auth->get_user_data()['auth_user_email'];

            return $obj;
        }

        return null;
    }
}

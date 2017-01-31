<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Login Routes
 *
 */
$route['login'] = 'auth/Login/index';
$route['login/auth'] = 'auth/Login/show';

// Destroy all session data
$route['logout'] = 'auth/Logout/index';

/**
 * Register Routes
 *
 */
$route['register'] = 'auth/AccountRegister/index';
$route['register/auth'] = 'auth/AccountRegister/store';

/**
 * Recover Routes
 *
 */

// ...
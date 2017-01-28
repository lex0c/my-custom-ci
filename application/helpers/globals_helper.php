<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $value
     * @param  mixed   $default
     *
     * @return mixed
     */
    function env($value, $default = null)
    {
        $value = getenv($value);

        if ($value === false || empty($value)) {
            return htmlentities($default);
        }

        return htmlentities($value);
    }
}

if (!function_exists('asset'))
{
    /**
     * Assets Loader
     *
     * @param  string $assetPath
     *
     * @return string
     */
    function asset($assetPath)
    {
        $path = base_url($assetPath);
        return $path;
    }
}

if (!function_exists('route'))
{
    /**
     * Route alias to call controller methods
     *
     * @param	string $name
     * @param   int    $id
     *
     * @return	string
     */
    function route($name, $id = null)
    {
        $name = str_ireplace('.', DS, $name);
        $url  = ($id != null) ? base_url($name) . DS . "{$id}" : base_url($name);
        return $url;
    }
}

if (!function_exists('redirect'))
{
    /**
     * Route alias to call controller methods
     *
     * @param	string $url
     * @param	int $code
     *
     * @return	HttpResponse
     */
    function redirect($url, $code)
    {
        return redirect($url, 'auto', $code);
    }
}

if (!function_exists('spit'))
{
    /**
     *
     *
     * @param	string $data
     * @param   bool   $scape
     *
     * @return	string
     */
    function spit($data, $scape = false)
    {
        return (!$scape) ? htmlentities($data) : $data;
    }
}

if (!function_exists('old'))
{
    /**
     *
     *
     * @param	string $value
     *
     * @return	string
     */
    function old($value)
    {
        return set_value($value);
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed $data
     * @return void
     */
    function dd($data)
    {
        Symfony\Component\VarDumper\VarDumper::dump($data);
        die(1);
    }
}

if (!function_exists('ie_support_field')) {
    /**
     * Generate a script for support for IE in form.
     *
     * @return string
     */
    function ie_support_field()
    {
        $field = "<!--[if lte IE 8]>\n";
            $field .= "<script src='".asset('js/html5shiv.min.js')."'></script>"."\n";
            $field .= "<script src='".asset('js/respond.min.js')."'></script>"."\n";
        $field .= "<![endif]-->\n";

        return $field;
    }
}

if (! function_exists('csrf_field')) {
    /**
     * Generate CSRF token form.
     *
     * @return string
     */
    function csrf_field()
    {
        //'<input type="hidden" name="csrf_token" value=""/>'
        //return ;
    }
}

if(!function_exists('auth_data')) {
    /**
     * Returns some data from the current user.
     *
     * @return object
     */
    function auth_data()
    {
        require_once (dirname(__DIR__) . '/libraries/Auth.php');
        $auth = new Auth();

        if($auth->is_authenticated()) {
            $obj = new stdClass();
            $obj->id = $auth->get_user_data()['auth_user_id'];
            $obj->name = $auth->get_user_data()['auth_user_name'];
            $obj->lastname = $auth->get_user_data()['auth_user_lastname'];
            $obj->email = $auth->get_user_data()['auth_user_email'];

            return $obj;
        }
    }
}


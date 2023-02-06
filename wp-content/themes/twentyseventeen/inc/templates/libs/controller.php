<?php
define('METHOD', 'AES-256-CBC');
define('SECRET_KEY', '$miscarnesparrilla@encrypt');
define('SECRET_IV', '1014272');
class Controller
{
    function __construct()
    {
    }
    function encryption($string)
    {
        $output = FALSE;
		$key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_encrypt($string, METHOD, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
    }
    function decryption($string)
    {
        $key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
		return $output;
    }
    /**
     * * @arguments retornar arreglo de json json_stringify
     */
    function array_json_stringify($params)
    {        
        return json_decode(stripslashes($params), true);
    }
}

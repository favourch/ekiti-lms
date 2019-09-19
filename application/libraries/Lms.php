<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 *  ==============================================================================
 *  Author    : Sher Khan
 *  Email    : sakhan@otsglobal.org
 *  For        : Stock Manager Advance
 *  Web        : http://otsglobal.org
 *  ==============================================================================
 */

class Lms
{

	public function __construct()
    {
    }

    public function __get($var)
    {
        return get_instance()->$var;
    }
	public function send_json($data)
    {
        header('Content-Type: application/json');
        die(json_encode($data));
        exit;
    }
    
    
}
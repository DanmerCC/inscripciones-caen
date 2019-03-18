<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
//pre_controller
$hook['post_controller_construct'][] = array(
	'class'    => 'PermisionHook',
	'function' => 'verify',
	'filename' => 'PermisionHook.php',
	'filepath' => 'hooks'
	);


$hook['post_controller_construct'][] = array(
	'class'    => 'LoginHook',
	'function' => 'check_login',
	'filename' => 'LoginHook.php',
	'filepath' => 'hooks'
	);

	
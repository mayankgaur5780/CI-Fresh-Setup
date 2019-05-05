<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['company_name'] = 'CI Demo';
$config['site_title'] = 'CI Demo';
$config['from_email'] = 'info@demo.com';
$config['action_status'] = ['1' => 'Active', '0' => 'Inactive'];
$config['other_status'] = ['1' => 'Yes', '0' => 'No'];
$config['genders'] = ['1' => 'Male', '2' => 'Female'];
$config['fcm_legacy_key'] = null;

$config['allowed_image_mimes'] = 'mimes:jpeg,png,bmp,jpg|max:102400';

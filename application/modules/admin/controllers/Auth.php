<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('auth/login');
    }

    public function validate_login()
    {
        $validator = \Lib\Validator::make($_REQUEST, [
            'email' => "required|email",
            'password' => 'required',
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }
        $dataArr = array_from_post(['email', 'password']);

        $response = \Models\Admin::where('email', $dataArr->email)->first();
        if (blank($response)) {
            exit(_error('email_password_incorrect'));
        } elseif ($response->password != encrypt_hash($dataArr->password, $response->hash)) {
            exit(_error('email_password_incorrect'));
        } elseif ($response->status != 1) {
            exit(_error('account_inactive'));
        }

        $this->session->set_userdata('admin_logged_in', true);
        $this->session->set_userdata('admin', $response);

        // Set Navigation in Session
        navigationMenuListing();

        echo _success('success');
    }

    public function forgot_password()
    {
        $this->load->view('auth/forgot_password');
    }

    public function forgot_password_post()
    {
        $validator = \Lib\Validator::make($_REQUEST, [
            'email' => "required|email|exists:admins",
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['email']);

            $admin = \Models\Admin::where('email', $dataArr->email)->first();
            if (blank($admin)) {
                exit(_error('email_incorrect'));
            } elseif ($admin->status == 'Inactive') {
                exit(_error('account_inactive'));
            } elseif ($admin->status == 'Offline') {
                exit(_error('account_offline'));
            }

            // Try to send email
            $configArr = [
                'email' => $admin->email,
                'reset_link' => site_url("admin/reset/password/{$admin->id}/{$admin->hash}"),
            ];
            send_email('reset_password_email', $admin->email, 'Reset Password', $configArr);

            echo _success('recovery_mail_send');

        } catch (Exception $e) {
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function reset_password($id = null, $hash = null)
    {
        $response = \Models\Admin::where('id', $id)
            ->where('hash', $hash)
            ->first();
        if (blank($response)) {
            exit('This link has expired.');
        } else {
            $this->load->view('auth/reset_password', compact('response'));
        }
    }

    public function reset_password_post($id = null)
    {
        $validator = \Lib\Validator::make($_REQUEST, [
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['password']);
            $admin = \Models\Admin::find($id);
            if (blank($admin)) {
                exit(_error('something_went_wrong'));
            }

            $admin->hash = hash_token();
            $admin->password = encrypt_hash($dataArr->password, $admin->hash);
            $admin->save();

            echo _success('password_changed');
        } catch (Exception $e) {
            echo _error($e->getMessage(), null, true, true);
        }
    }
}

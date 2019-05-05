<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $user = getSessionUser();
        $this->load_view('profile/index', compact('user'));
    }

    public function update()
    {
        $user = getSessionUser();
        $validator = \Lib\Validator::make($_REQUEST, [
            'name' => 'required',
            'email' => "required|email|unique:admins,email,{$user->id},id",
            'dial_code' => 'required',
            'mobile' => 'required|numeric',
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['name', 'email', 'dial_code', 'mobile']);

            \Lib\DB::beginTransaction();

            // Trying to upload image
            if (!empty($_FILES['profile_image']['name'])) {
                $response = upload_image('profile_image');
                $dataArr->profile_image = $response['file_name'];
            }

            $admin = \Models\Admin::find($user->id);
            $admin->name = $dataArr->name;
            $admin->email = strtolower($dataArr->email);
            $admin->dial_code = $dataArr->dial_code;
            $admin->mobile = $dataArr->mobile;
            $admin->save();

            \Lib\DB::commit();

            // Update Session
            updateUserSession();
            echo _success('data_updated');

        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function change_password()
    {
        $validator = \Lib\Validator::make($_REQUEST, [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            \Lib\DB::beginTransaction();

            $dataArr = array_from_post(['current_password', 'password']);
            $admin = \Models\Admin::find(getSessionUser('id'));
            if (blank($admin)) {
                exit(_error('something_went_wrong'));
            } elseif ($admin->password != encrypt_hash($dataArr->current_password, $admin->hash)) {
                exit(_error('current_password_invalid'));
            }

            $admin->password = encrypt_hash($dataArr->password, $admin->hash);
            $admin->save();

            \Lib\DB::commit();
            echo _success('password_changed');
        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function sign_out()
    {
        $this->session->unset_userdata('admin_logged_in');
        $this->session->sess_destroy();
        redirect('admin');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load_view('users/index');
    }

    public function listing()
    {
        echo $this->datatables->select('id, name, email, dial_code, mobile, status')
            ->from('users')
            ->generate();

    }

    public function create()
    {
        $this->load_view('users/create');
    }

    public function create_post()
    {
        $validator = \Lib\Validator::make($_REQUEST, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'dial_code' => 'required',
            'mobile' => 'required',
            'password' => 'required|min:6',
            'status' => 'required',
            'profile_image' => config_item('allowed_image_mimes'),
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['name', 'email', 'dial_code', 'mobile', 'password', 'status']);

            \Lib\DB::beginTransaction();

            $user = new \Models\User();
            $user->name = $dataArr->name;
            $user->email = strtolower($dataArr->email);
            $user->dial_code = $dataArr->dial_code;
            $user->mobile = $dataArr->mobile;
            $user->hash = hash_token();
            $user->password = encrypt_hash($dataArr->password, $user->hash);
            $user->status = $dataArr->status;
            $user->profile_image = upload_image('profile_image');
            $user->save();

            \Lib\DB::commit();
            echo _success('data_saved');

        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function update($id = null)
    {
        redirectIfNull($id, 'admin/users');

        try {
            $user = \Models\User::findOrFail($id);
            $this->load_view('users/update', compact('user'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            show404();
        }
    }

    public function update_post($id = null)
    {
        redirectIfNull($id, 'admin/users');

        $validator = \Lib\Validator::make($_REQUEST, [
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$id},id",
            'dial_code' => 'required',
            'mobile' => 'required',
            'status' => 'required',
            'profile_image' => config_item('allowed_image_mimes'),
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['name', 'email', 'dial_code', 'mobile', 'password', 'status']);

            \Lib\DB::beginTransaction();

            $user = \Models\User::find($id);
            $user->name = $dataArr->name;
            $user->email = strtolower($dataArr->email);
            $user->dial_code = $dataArr->dial_code;
            $user->mobile = $dataArr->mobile;
            $user->status = $dataArr->status;
            if (!empty($_FILES['profile_image']['name'])) {
                $user->profile_image = upload_image('profile_image');
            }
            $user->save();

            \Lib\DB::commit();
            echo _success('data_saved');

        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function delete($id = null)
    {
        \Models\User::where('id', $id)->delete();
        echo _success();
    }

    public function change_password($id = null)
    {
        redirectIfNull($id, 'admin/users');

        try {
            $user = \Models\User::findOrFail($id);
            $this->load_view('users/change_password', compact('user'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            show404();
        }
    }

    public function change_password_post($id = null)
    {
        $validator = \Lib\Validator::make($_REQUEST, [
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['password']);

            \Lib\DB::beginTransaction();

            $user = \Models\User::find($id);
            $user->password = encrypt_hash($dataArr->password, $user->hash);
            $user->save();

            \Lib\DB::commit();
            echo _success('data_saved');

        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function view($id = null)
    {
        redirectIfNull($id, 'admin/users');

        try {
            $user = \Models\User::findOrFail($id);
            $this->load_view('users/view', compact('user'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            show404();
        }
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admins extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load_view('admins/index');
    }

    public function listing()
    {
        echo $this->datatables->select('admins.id, admins.name, admins.email, admins.dial_code, admins.mobile, admin_roles.name AS role, admins.status')
            ->from('admins')
            ->join('admin_roles', 'admin_roles.id=admins.role_id')
        ->where('admins.id <>', getSessionUser('id'))
            ->generate();

    }

    public function create()
    {
        $roles = \Models\Role::where('status', 1)->get();
        $this->load_view('admins/create', compact('roles'));
    }

    public function create_post()
    {
        $validator = \Lib\Validator::make($_REQUEST, [
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:admins',
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
            $dataArr = array_from_post(['role_id', 'name', 'email', 'dial_code', 'mobile', 'password', 'status']);

            \Lib\DB::beginTransaction();

            $admin = new \Models\Admin();
            $admin->role_id = $dataArr->role_id;
            $admin->name = $dataArr->name;
            $admin->email = strtolower($dataArr->email);
            $admin->dial_code = $dataArr->dial_code;
            $admin->mobile = $dataArr->mobile;
            $admin->hash = hash_token();
            $admin->password = encrypt_hash($dataArr->password, $admin->hash);
            $admin->status = $dataArr->status;
            $admin->profile_image = upload_image('profile_image');
            $admin->save();

            \Lib\DB::commit();
            echo _success('data_saved');

        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function update($id = null)
    {
        redirectIfNull($id, 'admin/admins');

        try {
            $admin = \Models\Admin::findOrFail($id);
            $roles = \Models\Role::where('status', 1)->get();
            $this->load_view('admins/update', compact('admin', 'roles'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            show404();
        }
    }

    public function update_post($id = null)
    {
        redirectIfNull($id, 'admin/admins');

        $validator = \Lib\Validator::make($_REQUEST, [
            'role_id' => 'required',
            'name' => 'required',
            'email' => "required|email|unique:admins,email,{$id},id",
            'dial_code' => 'required',
            'mobile' => 'required',
            'status' => 'required',
            'profile_image' => config_item('allowed_image_mimes'),
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['role_id', 'name', 'email', 'dial_code', 'mobile', 'password', 'status']);

            \Lib\DB::beginTransaction();

            $admin = \Models\Admin::find($id);
            $admin->role_id = $dataArr->role_id;
            $admin->name = $dataArr->name;
            $admin->email = strtolower($dataArr->email);
            $admin->dial_code = $dataArr->dial_code;
            $admin->mobile = $dataArr->mobile;
            $admin->status = $dataArr->status;
            if (!empty($_FILES['profile_image']['name'])) {
                $admin->profile_image = upload_image('profile_image');
            }
            $admin->save();

            \Lib\DB::commit();
            echo _success('data_saved');

        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function delete($id = null)
    {
        \Models\Admin::where('id', $id)->delete();
        echo _success();
    }

    public function change_password($id = null)
    {
        redirectIfNull($id, 'admin/admins');

        try {
            $admin = \Models\Admin::findOrFail($id);
            $this->load_view('admins/change_password', compact('admin'));
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

            $admin = \Models\Admin::find($id);
            $admin->password = encrypt_hash($dataArr->password, $admin->hash);
            $admin->save();

            \Lib\DB::commit();
            echo _success('data_saved');

        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function view($id = null)
    {
        redirectIfNull($id, 'admin/admins');

        try {
            $admin = \Models\Admin::findOrFail($id);
            $admin->role = \Models\Role::select('name')->where('id', $admin->role_id)->first();
            $this->load_view('admins/view', compact('admin'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            show404();
        }
    }
}

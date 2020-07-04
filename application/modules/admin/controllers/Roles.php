<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Roles extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load_view('roles/index');
    }

    public function listing()
    {
        echo $this->datatables->select('id, name, status')
            ->from('admin_roles')
            ->generate();

    }

    public function create()
    {
        $this->load_view('roles/create');
    }

    public function create_post()
    {
        $validator = \Lib\Validator::make($_REQUEST, [
            'name' => 'required|unique:admin_roles',
            'status' => 'required',
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['name', 'status']);

            \Lib\DB::beginTransaction();

            $role = new \Models\Role();
            $role->name = $dataArr->name;
            $role->status = $dataArr->status;
            $role->save();

            \Lib\DB::commit();
            echo _success('data_saved');

        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function update($id = null)
    {
        redirectIfNull($id, 'admin/roles');

        try {
            $role = \Models\Role::findOrFail($id);
            $this->load_view('roles/update', compact('role'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            show404();
        }
    }

    public function update_post($id = null)
    {
        redirectIfNull($id, 'admin/roles');

        $validator = \Lib\Validator::make($_REQUEST, [
            'name' => "required|unique:admin_roles,name,{$id},id",
            'status' => 'required',
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['name', 'status']);

            \Lib\DB::beginTransaction();

            $role = Models\Role::find($id);
            $role->name = $dataArr->name;
            $role->status = $dataArr->status;
            $role->save();

            \Lib\DB::commit();
            echo _success('data_saved');

        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function permissions($id = null)
    {
        redirectIfNull($id, 'admin/roles');

        try {
            $navigation = getGroupNavigation();
            $rolePermissions = getRolePermission($id);
            
            $this->load_view('roles/permissions', compact('id', 'navigation', 'rolePermissions'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            show404();
        }
    }

    public function permissions_post($id = null)
    {
        redirectIfNull($id, 'admin/roles');

        $validator = \Lib\Validator::make($_REQUEST, [
            'navigation_id' => 'required|array',
            'navigation_id.*' => 'required|numeric',
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['navigation_id']);

            \Lib\DB::beginTransaction();

            \Models\RolePermission::where('role_id', $id)->delete();

            foreach ($dataArr->navigation_id as $navigation_id) {
                $newPermission = new \Models\RolePermission();
                $newPermission->role_id = $id;
                $newPermission->navigation_id = $navigation_id;
                $newPermission->save();
            }

            \Lib\DB::commit();
            echo _success('data_saved');
        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }
}

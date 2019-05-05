<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Navigation extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load_view('navigation/index');
    }

    public function listing()
    {
        echo $this->datatables->select('id, name, parent_id, display_order, status')
            ->from('navigations')
            ->generate();

    }

    public function create()
    {
        $navigation_list = \Models\Navigation::select('id', 'name')
            ->where('status', 1)
            ->whereNull('parent_id')
            ->get();
        $this->load_view('navigation/create', compact('navigation_list'));
    }

    public function create_post()
    {
        $validator = \Lib\Validator::make($_REQUEST, [
            'name' => 'required',
            'action_path' => 'required',
            'display_order' => 'required|numeric',
            'show_in_menu' => 'required|numeric',
            'show_in_permission' => 'required|numeric',
            'status' => 'required|numeric',
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['name', 'action_path', 'icon', 'display_order', 'parent_id', 'show_in_menu', 'show_in_permission', 'status']);

            \Lib\DB::beginTransaction();

            $navigation = new \Models\Navigation();
            $navigation->name = $dataArr->name;
            $navigation->action_path = $dataArr->action_path;
            $navigation->icon = $dataArr->icon;
            $navigation->display_order = $dataArr->display_order;
            $navigation->parent_id = $dataArr->parent_id ? $dataArr->parent_id : null;
            $navigation->show_in_menu = $dataArr->show_in_menu;
            $navigation->show_in_permission = $dataArr->show_in_permission;
            $navigation->status = $dataArr->status;
            $navigation->save();

            \Lib\DB::commit();

            // Refresh Navigation in Session
            navigationMenuListing();

            echo _success('data_saved');
        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function update($id = null)
    {
        redirectIfNull($id, 'admin/navigation');

        try {
            $navigation = \Models\Navigation::findOrFail($id);

            $navigation_list = \Models\Navigation::select('id', 'name')
                ->where('id', '<>', $id)
                ->where('status', 1)
                ->whereNull('parent_id')
                ->get();

            $this->load_view('navigation/update', compact('navigation_list', 'navigation'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            show404();
        }
    }

    public function update_post($id = null)
    {
        redirectIfNull($id, 'admin/navigation');

        $validator = \Lib\Validator::make($_REQUEST, [
            'name' => 'required',
            'action_path' => 'required',
            'display_order' => 'required|numeric',
            'show_in_menu' => 'required|numeric',
            'show_in_permission' => 'required|numeric',
            'status' => 'required|numeric',
        ]);
        if ($validator->fails() === true) {
            exit(_error($validator->errors(), null, true));
        }

        try {
            $dataArr = array_from_post(['name', 'action_path', 'icon', 'display_order', 'parent_id', 'show_in_menu', 'show_in_permission', 'status']);

            \Lib\DB::beginTransaction();

            $navigation = \Models\Navigation::find($id);
            $navigation->name = $dataArr->name;
            $navigation->action_path = $dataArr->action_path;
            $navigation->icon = $dataArr->icon;
            $navigation->display_order = $dataArr->display_order;
            $navigation->parent_id = $dataArr->parent_id ? $dataArr->parent_id : null;
            $navigation->show_in_menu = $dataArr->show_in_menu;
            $navigation->show_in_permission = $dataArr->show_in_permission;
            $navigation->status = $dataArr->status;
            $navigation->save();

            \Lib\DB::commit();

            // Refresh Navigation in Session
            navigationMenuListing();

            echo _success('data_updated');
        } catch (Exception $e) {
            \Lib\DB::rollBack();
            echo _error($e->getMessage(), null, true, true);
        }
    }

    public function delete($id = null)
    {
        \Models\Navigation::where('id', $id)->delete();

        // Refresh Navigation in Session
        navigationMenuListing();

        return _success();
    }
}

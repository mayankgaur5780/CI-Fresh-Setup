<?php defined('BASEPATH') or exit('No direct script access allowed');

use Illuminate\Database\Capsule\Manager as DB;

if (!function_exists('getGroupNavigation')) {
    function getGroupNavigation()
    {
        $navigation = \Models\Navigation::select(DB::raw('id, name, parent_id'))
            ->where('status', 1)
            ->where('show_in_permission', 1)
            ->get()
            ->toArray();

        return count($navigation) ? arrayToTree($navigation, null) : $navigation;
    }
}

if (!function_exists('getRolePermission')) {
    function getRolePermission($accessRoleId)
    {
        return \Models\RolePermission::where('role_id', $accessRoleId)
            ->pluck('navigation_id')
            ->toArray();
    }
}

if (!function_exists('getUsersPermission')) {
    function getUsersPermission($accessAdminId)
    {
        return \Models\UserPermission::where('user_id', $accessAdminId)
            ->pluck('navigation_id')
            ->toArray();
    }
}

if (!function_exists('getUsersPermissionIDs')) {
    function getUsersPermissionIDs($accessAdminId, $accessRoleId)
    {
        $usersPermissions = getUsersPermission($accessAdminId);
        return count($usersPermissions) ? $usersPermissions : getRolePermission($accessRoleId);
    }
}

if (!function_exists('arrayToTree')) {
    function arrayToTree($elements, $parentId = 0)
    {
        $branch = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = arrayToTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
}

// Set Navigation in Session
if (!function_exists('navigationMenuListing')) {
    function navigationMenuListing($guard = 'admin', $saveSession = true, $accessAdminId = null, $accessRoleId = null)
    {
        $excludeRoleId = [1];
        $navigationMasters = [];
        $CI = &get_instance();

        if ($saveSession == true) {
            $guardData = $CI->session->userdata($guard);
            $accessAdminId = $guardData->id;
            $accessRoleId = $guardData->role_id;
        }

        if (in_array($accessRoleId, $excludeRoleId)) {
            $navigationMasters = \Models\Navigation::select(DB::raw('id, name, icon, parent_id, action_path, show_in_menu'))
                ->orderBy('display_order', 'ASC')
                ->where('status', 1)
                ->get()
                ->toArray();
        } else {
            $allowedNavIds = getUsersPermissionIDs($accessAdminId, $accessRoleId);
            if (count($allowedNavIds)) {
                $navigationMasters = \Models\Navigation::select(DB::raw('id, name, icon, parent_id, action_path, show_in_menu'))
                    ->orderBy('display_order', 'ASC')
                    ->whereIn('id', $allowedNavIds)
                    ->where('status', 1)
                    ->get()
                    ->toArray();
            }
        }

        if (count($navigationMasters)) {
            $navigationMasters = arrayToTree($navigationMasters, null);

            if ($saveSession == true) {
                $CI->session->set_userdata("navigation_{$guard}", $navigationMasters);
            }
        }

        return $saveSession === true ? $navigationMasters : true;
    }
}

if (!function_exists('hasAccess')) {
    function hasAccess($actionPath, $exclude = false)
    {
        if ($exclude === true) {
            return true;
        }

        $CI = &get_instance();
        if ($CI->session->userdata('navigationPermissions') !== null) {
            $navigationPermissions = $CI->session->userdata('navigationPermissions');
            $key = array_search($actionPath, array_column($navigationPermissions, 'action_path'));
            return $key !== false ? true : false;
        }
        return false;
    }
}

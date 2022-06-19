<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\Session;
use App\Models\roleHasPermission;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;




class rolesAndPermissionsController extends Controller
{

    function create_roles()
    {
        $data['roles'] = Role::all();

        return view('user.create_roles', $data);
    }

    function manage_roles($id = '')
    {




           $data['permissions'] = permission::all();

        if (!empty($id)) {
            $roles_data  = Role::find($id);
            $data['name'] = $roles_data->name;
            $data['guard_name'] = $roles_data->guard_name;
            $data['id'] = $roles_data->id;
            $data['permissions_data_val'] = roleHasPermission::where(['role_id' => $id])->get();
            return view('user.manage_roles_edit', $data);
        } else {
            $data['name'] = '';
            $data['guard_name'] =  '';
            $data['id'] = '';
            return view('user.manage_roles', $data);
        }
    }






    function manage_role_process(Request $request)
    {

        $name = $request->post('name');
        $id = $request->post('id');





        $validator = validator::make($request->all(), [
            'name' => "required|regex:/(^[A-Za-z0-9_]+$)+/|unique:roles,name,$id",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            if (!empty($id)) {
                $data_save = Role::find($id);
            } else {
                $data_save = new Role();
            }
            $data_save->name = $name;
            $data_save->guard_name  = 'web';
            if ($data_save->save()) {
                $role_id  = $data_save->id;

                    $permission_id = $request->post('permission_id');
                    if (!empty($permission_id)) {
                    $count =   count($permission_id);
                    $get_roleHasPermission_by_role_id = roleHasPermission::where(['role_id' => $role_id])->delete();
                    for ($i = 0; $i < $count; $i++) {
                        $data_save_permission = new roleHasPermission();
                        $data_save_permission->permission_id = $permission_id[$i];
                        $data_save_permission->role_id  =  $role_id;
                        $data_save_permission->save();
                    }
                }
            }
            $msg = 'permission data saved';


          return  response()->json(['success' => $msg]);
        }
    }






    function permissions_role_process(Request $request)
    {
        $name = $request->post('name');
        $id = $request->post('id');

        $validator = validator::make($request->all(), [
            'name' => "required|regex:/(^[A-Za-z0-9_]+$)+/|unique:permissions,name,$id",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            if (!empty($id)) {
                $data_save = permission::find($id);
                $msg = 'permissions data updated';
            } else {
                $data_save = new permission();
                $msg = 'permissions data Added';
            }
            $data_save->name = $name;
            $data_save->guard_name = 'web';
            $data_save->save();
            return response()->json(['success' => $msg]);
        }
    }







    function categories_status($id, $changed_status)
    {
        $status_data = Role::find($id);
        $status_data->is_enabled = $changed_status;
        $status_data->save();
        Session::flash('message', "Role Status updated");
        return Redirect::back();
    }




    function role_delete(Request $request)
    {
        $id = $request->post('id');
        $delete_data = Role::find($id);
        $delete_data->delete();
        return response()->json(['success' => 'deleted', 'msg' => 'Role data deleted']);
    }



    function role_permissions_delete(Request $request)
    {
        $id = $request->post('id');
        $delete_data = Permission::find($id);
        $delete_data->delete();
        return response()->json(['success' => 'deleted', 'msg' => 'Permission data deleted']);
    }



    function role_permissions($id = '')
    {
        $data['RolePermission'] = Permission::all();
        if (!empty($id)) {
            $RolePermission = Permission::find($id);
            $data['name'] = $RolePermission->name;
            $data['id'] = $RolePermission->id;
        } else {
            $data['name'] = '';
            $data['id'] = '';
        }

        return view('user.role_permissions', $data);
    }
}

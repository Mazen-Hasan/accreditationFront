<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Traits\CallAPI;

class RoleController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $body = [];
            $result = CallAPI::postAPI('role/getAll',$body);
            $errCode = $result['errCode'];
            $errMsg = $result['errMsg'];
            $data = $result['data'];
            $data = json_decode(json_encode($data));


            return datatables()->of($data->data)
                ->addColumn('action', function ($data) {
                    $button = '';

                    if ($data->can_edit == 1) {
                        $button .= '<a href="javascript:void(0)" id="edit-type" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                        if($data->status = 1){
                            $button .= '<a href="javascript:void(0);" id="deActivate-type" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Deactivate"><i class="fas fa-ban"></i></a>';
                        }
                        else{
                            $button .= '<a href="javascript:void(0);" id="activate-type" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Activate"><i class="fas fa-check-circle"></i></a>';
                        }
                    }

                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a  href="' . route('getRolePermissions', $data->id) . '" id="role-permissions" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Permissions" title="Permissions"><i class="far fa-list-alt""></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.Role.roles');
    }

    public function updateRolePermissions(Request $request)
    {
        $role_id = $request->role_id;
        $permissions = $request->permission_ids;

        $body = [
            "role_id" => $role_id,
            "permission_ids" => $permissions
        ];

        $result = CallAPI::postAPI('role/permissions/update', $body);

//        $errCode = $result['errCode'];
//        $errMsg = $result['errMsg'];

        return Response::json($result);
    }

    public function getRolePermissions($role_id)
    {
        $body = [
            'role_id' => $role_id
        ];
        $result = CallAPI::postAPI('role/permissions/getAll',$body);
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $role_name = $data['role_name'];
        $data = json_encode($data['data']);

        return view('pages.Role.role-permissions')->with('role_id',$role_id)->with('role_name',$role_name)->with('permissions', $data);
    }
}

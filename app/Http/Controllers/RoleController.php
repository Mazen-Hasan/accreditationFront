<?php

namespace App\Http\Controllers;

use App\Http\Traits\ParseAPIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Traits\CallAPI;

class RoleController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $body = [];

            $url = 'role/getAll';

            $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

            $data = json_decode(json_encode($result['data']['data']));

            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                    $button = '';

                    if ($data->can_edit == 1) {
                        $button .= '<a href="javascript:void(0)" id="edit-role" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" id="delete-role" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Delete" title="Delete"><i class="far fa-trash-alt"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        if($data->status == 1){
                            $button .= '<a href="javascript:void(0);" id="deActivate-role" data-toggle="tooltip" data-original-title="Deactivate" data-id="' . $data->id . '" title="Deactivate"><i class="fas fa-ban"></i></a>';
                        }
                        else{
                            $button .= '<a href="javascript:void(0);" id="activate-role" data-toggle="tooltip" data-original-title="Activate" data-id="' . $data->id . '" title="Activate"><i class="fas fa-check-circle"></i></a>';
                        }
                    }

                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a  href="' . route('rolePermissionsGetAll', $data->id) . '" id="role-permissions" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Permissions" title="Permissions"><i class="far fa-list-alt""></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.Role.roles');
    }

    public function create(Request $request)
    {
        $url = 'role/create';

        $body = [
            "name" => $request->role_name,
            "status" => $request->status
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function update(Request $request)
    {
        $url = 'role/update';

        $body = [
            "role_id" => $request->role_id,
            "name" => $request->role_name,
            "status" => $request->status
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function getById($id)
    {
        $url = 'role/getByID';

        $body = [
            "role_id" => $id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function changeStatus($id, $status)
    {
        $url = 'role/enable';

        $body = [
            "role_id" => $id
        ];

        if($status == 0){
            $url = 'role/disable';
        }

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function delete($id)
    {
        $url = 'role/delete';

        $body = [
            "role_id" => $id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function updatePermissions(Request $request)
    {
        $url = 'role/permissions/update';

        $body = [
            "role_id" => $request->role_id,
            "permission_ids" => $request->permission_ids
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function getPermissions($role_id)
    {
        $url = 'role/permissions/getAll';

        $body = [
            'role_id' => $role_id
        ];

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url,$body));

        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $role_name = $data['role_name'];
        $permissions = json_encode($data['data']);

        return view('pages.Role.role-permissions')->with('role_id',$role_id)->with('role_name',$role_name)->with('permissions', $permissions)
            ->with('errMsg', $errMsg)->with('errCode', $errCode);
    }


}

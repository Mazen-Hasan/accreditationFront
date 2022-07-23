<?php

namespace App\Http\Controllers;

use App\Http\Traits\ParseAPIResponse;
use App\Models\SelectOption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Http\Traits\CallAPI;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $body = [];

            $url = 'user/getAll';

            $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

            $data = json_decode(json_encode($result['data']['data']));

            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                	$button = '&nbsp;&nbsp;';
                	if($data->can_deactivated == 1){
                    	$button .= '<a href="' . route('userGetById', $data->user_id) . '" data-toggle="tooltip"  id="edit-event" data-id="' . $data->user_id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    	$button .= '&nbsp;&nbsp;';
                        if($data->status == 1){
                            $button .= '<a href="javascript:void(0);" id="deActivate-user" data-toggle="tooltip" data-original-title="Deactivate" data-id="' . $data->user_id . '" title="Deactivate"><i class="fas fa-ban"></i></a>';
                        }
                        else{
                            $button .= '<a href="javascript:void(0);" id="activate-user" data-toggle="tooltip" data-original-title="Activate" data-id="' . $data->user_id . '" title="Activate"><i class="fas fa-check-circle"></i></a>';
                        }
                        $button .= '&nbsp;&nbsp;';
                    }
                    $button .= '<a href="javascript:void(0);" id="reset_password" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->user_id . '"  title="Reset password"><i class="fas fa-retweet"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a  href="' . route('getUserPermissions', $data->user_id) . '" id="user-permissions" data-toggle="tooltip"  data-id="' . $data->user_id . '" data-original-title="Permissions" title="Permissions"><i class="far fa-list-alt""></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.Users.users');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $companyId = $request->post_id;
        if ($companyId == null) {
            $company = User::updateOrCreate(['id' => $companyId],
                ['name' => $request->name,
                    'password' => Hash::make($request->password),
                    'email' => $request->email,
                ]);
        } else {
            $company = User::updateOrCreate(['id' => $companyId],
                ['name' => $request->name,
                    'email' => $request->email,
                ]);
        }
        if ($companyId == null) {
            DB::table('users_roles')->insert(
                array(
                    'user_id' => $company->id,
                    'role_id' => $request->role
                )
            );
        } else {
            DB::table('users_roles')->where('user_id', $companyId)->update(array(
                'role_id' => $request->role,
            ));
        }

        return Response::json($company);
    }

    public function create()
    {
        $body = [];

        $url = 'role/getAll';

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

        $roles = $result['data']['data'];

        return view('pages.Users.user-add')->with('roles', $roles);
    }

    public function save(Request $request)
    {
       $url = 'user/create';

        $body = [
            "user_name" => $request->user_name,
            "email" => $request->email,
            "password" => $request->password,
            "role_id" => $request->role_id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function getById($id)
    {
        $url = 'user/getByID';

        $body = [
            "user_id" => $id
        ];

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

        $user = $result['data'];

        $url = 'role/getAll';

        $body = [
        ];

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

        $roles = $result['data']['data'];

        return view('pages.Users.user-edit')->with('user', $user)->with('roles', $roles);
    }

    public function update(Request $request)
    {
        $url = 'user/update';

        $body = [
            "user_id" => $request->user_id,
            "user_name" => $request->user_name,
            "email" => $request->email,
            "role_id" => $request->role_id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function changeStatus($id, $status)
    {
        $url = 'user/enable';

        $body = [
            "user_id" => $id
        ];

        if($status == 0){
            $url = 'user/disable';
        }

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function passwordReset(Request $request)
    {
        $url = 'user/passwordReset';

        $body = [
            "user_id" => $request->user_id,
            "new_password" => $request->password,
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function updatePermissions(Request $request)
    {
        $url = 'user/permissions/update';

        $body = [
            "user_id" => $request->user_id,
            "permission_ids" =>  $request->permission_ids
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function getPermissions($user_id)
    {
        $url = 'user/permissions/getAll';

        $body = [
            'user_id' => $user_id
        ];

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url,$body));

        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $user_name = $data['user_name'];
        $permissions = json_encode($data['data']);

        return view('pages.Users.user-permissions')->with('user_id',$user_id)->with('user_name',$user_name)->with('permissions', $permissions)
            ->with('errMsg', $errMsg)->with('errCode', $errCode);
    }

}

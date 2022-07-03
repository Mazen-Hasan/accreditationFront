<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Response;
use App\Http\Traits\CallAPI;
use App\Models\EventType;

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
                    $button .= '<a  href="' . route('getRolePermissions', [$data->id, $data->name]) . '" id="role-permissions" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Permissions" title="Permissions"><i class="far fa-list-alt""></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.Role.roles');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // try{
        // $postId = $request->post_id;
        // $post = EventType::updateOrCreate(['id' => $postId],
        //     ['name' => $request->name,
        //         'status' => $request->status
        //     ]);
        // } catch (\Exception $e) {
        //     return Response::json(array(
        //         'code' => 400,
        //         'message' => $e->getMessage()
        //     ), 400);
        // }
        // return Response::json($post);
        $eventId = $request->post_id;
        if($eventId != ''){
            $body = [
                'event_type_id' => $eventId,
                'name' => $request->name,
                'status' => $request->status
            ];
            $result = CallAPI::postAPI('eventType/edit',$body);
        }else{
            $body = [
                'name' => $request->name,
                'status' => $request->status
            ];
            $result = CallAPI::postAPI('eventType/create',$body);
        }
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        return Response::json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     */


    public function edit($id)
    {
        // $where = array('id' => $id);
        // $post = EventType::where($where)->first();
        // return Response::json($post);
        $body = [
            'event_type_id' => $id
        ];
        $result = CallAPI::postAPI('eventType/getByID',$body);
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        return Response::json($data->data[0]);
    }


    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $post = EventType::where('id', $id)->delete();

        return Response::json($post);
    }

    public function changeStatus($id, $status)
    {
        // $post = EventType::updateOrCreate(['id' => $id],
        //     [
        //         'status' => $status
        //     ]);
        // return Response::json($post);
        $body = [
            'event_type_id' => $id
        ];
        if($status == 1){
            $result = CallAPI::postAPI('eventType/enable',$body);
        }
        else{
            $result = CallAPI::postAPI('eventType/disable',$body);
        }
        //$result = CallAPI::postAPI('companyCategory/create',$body);
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        return Response::json($data);
    }

    public function getRolePermissions($role_id, $role_name)
    {
         if (request()->ajax()) {
             $body = [
                 'role_id' => $role_id
             ];
             $result = CallAPI::postAPI('role/permissions/getAll',$body);
             $errCode = $result['errCode'];
             $errMsg = $result['errMsg'];
             $data = $result['data'];
             $data = json_decode(json_encode($data));

             var_dump($data);

             return datatables()->of($data->data)
                 ->addColumn('action', function ($data) {
                     $button = '<a href="javascript:void(0)" id="edit-type" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                     $button .= '&nbsp;&nbsp;';
                     if ($data->status == 1) {
                         $button .= '<a href="javascript:void(0);" id="deActivate-type" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Deactivate"><i class="fas fa-ban"></i></a>';
                     } else {
                         $button .= '<a href="javascript:void(0);" id="activate-type" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Activate"><i class="fas fa-check-circle"></i></a>';
                     }
                     $button .= '&nbsp;&nbsp;';
                     $button .= '<a href="javascript:void(0)" id="role-permissions" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Permissions" title="Permissions"><i class="fas fa-list-alt""></i></a>';
                     return $button;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
         }
        return view('pages.Role.role-permissions')->with('role_id',$role_id)->with('role_name',$role_name);
    }
}

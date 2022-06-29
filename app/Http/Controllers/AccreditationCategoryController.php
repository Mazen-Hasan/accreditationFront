<?php

namespace App\Http\Controllers;

use App\Models\AccreditationCategory;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Response;
use App\Http\Traits\CallAPI;


class AccreditationCategoryController extends Controller
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
            $result = CallAPI::postAPI('accreditationCategory/getAll',$body);
            $errCode = $result['errCode'];
            $errMsg = $result['errMsg'];
            $data = $result['data'];
            $data = json_decode(json_encode($data));
            return datatables()->of($data->data)
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="edit-category" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    if ($data->status == 1) {
                        $button .= '<a href="javascript:void(0);" id="deActivate-category" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Deactivate"><i class="fas fa-ban"></i></a>';
                    } else {
                        $button .= '<a href="javascript:void(0);" id="activate-category" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Activate"><i class="fas fa-check-circle"></i></a>';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.AccreditationCategory.accreditationCategory');
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
        // $post = AccreditationCategory::updateOrCreate(['id' => $postId],
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
        $accreditation_category_Id = $request->post_id;
        if($accreditation_category_Id != ''){
            $body = [
                'accreditation_category_id' => $accreditation_category_Id,
                'name' => $request->name,
                'status' => $request->status
            ];
            $result = CallAPI::postAPI('accreditationCategory/edit',$body);
        }else{
            $body = [
                'name' => $request->name,
                'status' => $request->status
            ];
            $result = CallAPI::postAPI('accreditationCategory/create',$body);
        }
        // $body = [
        //     'name' => $request->name,
        //     'status' => $request->status
        // ];
        // $result = CallAPI::postAPI('accreditationCategory/create',$body);
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
        $body = [
            'accreditation_category_id' => $id
        ];
        $result = CallAPI::postAPI('accreditationCategory/getByID',$body);
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        return Response::json($data->data[0]);
        // $where = array('id' => $id);
        // $post = AccreditationCategory::where($where)->first();
        // return Response::json($post);
    }


    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $post = AccreditationCategory::where('id', $id)->delete();

        return Response::json($post);
    }

    public function changeStatus($id, $status)
    {
        $body = [
            'accreditation_category_id' => $id
        ];
        if($status == 1){
            $result = CallAPI::postAPI('accreditationCategory/enable',$body);
        }
        else{
            $result = CallAPI::postAPI('accreditationCategory/disable',$body);
        }
        //$result = CallAPI::postAPI('companyCategory/create',$body);
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        return Response::json($data);
        // $post = AccreditationCategory::updateOrCreate(['id' => $id],
        //     [
        //         'status' => $status
        //     ]);
        // return Response::json($post);
    }


}



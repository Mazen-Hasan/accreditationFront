<?php

namespace App\Http\Controllers;

use App\Http\Traits\LogTrait;
use App\Models\CompanyCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use App\Http\Traits\CallAPI;
use Redirect;

class CompanyCategoryController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            // $action_id = Config::get('actionEnum.actions.com-cat-all');
            // $action_result = '1';
            // LogTrait::supperAdminLog($action_id, $action_result, '', '');
            $body = [];
            $result = CallAPI::postAPI('companyCategory/getAll',$body);
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
        return view('pages.CompanyCategory.companyCategories');
    }

    public function store(Request $request)
    {
        // $action_result = '';
        // $action_id = '';
        // try {
        //     $categoryId = $request->category_id;

        //     $params = 'companyCategoryName=' . $request->name . ', status=' . $request->status;

        //     if($categoryId == null){
        //         $action_id = Config::get('actionEnum.actions.com-cat-add');
        //     }
        //     else{
        //         $action_id = Config::get('actionEnum.actions.com-cat-edit');
        //         $params = 'companyCategoryId=' . $categoryId . ', ' . $params;
        //     }

        //     $category = CompanyCategory::updateOrCreate(['id' => $categoryId],
        //         ['name' => $request->name,
        //             'status' => $request->status
        //         ]);
        //     $action_result = '1';
        //     LogTrait::supperAdminLog($action_id, $action_result, $params, '');

        // } catch (Exception $e) {
        //     $action_result = Config::get('resultEnum.results.FAILED');
        //     LogTrait::supperAdminLog($action_id, $action_result, $params, $e->getMessage());

        //     return Response::json(array(
        //         'code' => -999,
        //         'message' => $e->getMessage(),
        //         'data' => ''
        //     ), -999);
        // }
        $company_category_Id = $request->category_id;
        if($company_category_Id != ''){
            $body = [
                'company_category_id' => $company_category_Id,
                'name' => $request->name,
                'status' => $request->status
            ];
            $result = CallAPI::postAPI('companyCategory/edit',$body);
        }else{
            $body = [
                'name' => $request->name,
                'status' => $request->status
            ];
            $result = CallAPI::postAPI('companyCategory/create',$body);
        }
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        return Response::json($data);
    }

    public function edit($id)
    {
        $body = [
            'company_category_id' => $id
        ];
        $result = CallAPI::postAPI('companyCategory/getByID',$body);
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        return Response::json($data->data[0]);
        // $where = array('id' => $id);
        // $category = CompanyCategory::where($where)->first();
        // return Response::json($category);
    }


//    /**
//     * Remove the specified resource from storage.
//     *
//     */
//    public function destroy($id)
//    {
//        $category = CompanyCategory::where('id', $id)->delete();
//
//        return Response::json($category);
//    }

    public function changeStatus($id, $status)
    {
        $body = [
            'company_category_id' => $id
        ];
        if($status == 1){
            $result = CallAPI::postAPI('companyCategory/enable',$body);
        }
        else{
            $result = CallAPI::postAPI('companyCategory/disable',$body);
        }
        //$result = CallAPI::postAPI('companyCategory/create',$body);
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        return Response::json($data);
        // if($status == 1){
        //     $action_id = Config::get('actionEnum.actions.com-cat-activate');
        // }
        // else{
        //     $action_id = Config::get('actionEnum.actions.com-cat-deactivate');
        // }

        // $params = 'companyCategoryID=' . $id . ', status=' . $status;

        // try {
        //     $category = CompanyCategory::updateOrCreate(['id' => $id],
        //         [
        //             'status' => $status
        //         ]);

        //     $action_result = '1';
        //     LogTrait::supperAdminLog($action_id, $action_result, $params, '');
        //     return Response::json($category);

        // } catch (Exception $e) {
        //     $action_result = Config::get('resultEnum.results.FAILED');
        //     LogTrait::supperAdminLog($action_id, $action_result, $params, $e->getMessage());

        //     return Response::json(array(
        //         'code' => -999,
        //         'message' => $e->getMessage(),
        //         'data' => ''
        //     ), -999);
        // }
    }
}

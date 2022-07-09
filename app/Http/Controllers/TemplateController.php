<?php

namespace App\Http\Controllers;

use App\Http\Traits\CallAPI;
use App\Http\Traits\ParseAPIResponse;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class TemplateController extends Controller
{

	public function getData(Request $request){
        $templates =  Template::latest()->take(6)->get();
        return Response::json($request);
    }

    public function getData1($values){
        $totalSize = Template::latest()->get();
        $size = 10;
        if($values != null){
            if(str_contains($values,",")){
                $comands = explode(",",$values);
                $c_size = sizeof($comands);
                if($c_size > 3){
                    $skip = $size * $comands[0];
                    $condition1 = $comands[1];
                    $condition1token = $comands[2];
                    $operator = $comands[3];
                    $condition2 = $comands[4];
                    $condition2token = $comands[5];
                    $totalSize = DB::select('select * from templates where '. TemplateController::getConditionPart("name",$condition1,$condition1token) . " ".$operator ." ". TemplateController::getConditionPart("name",$condition2,$condition2token));
                    $templates = DB::select('select * from templates where '. TemplateController::getConditionPart("name",$condition1,$condition1token) . " ".$operator ." ". TemplateController::getConditionPart("name",$condition2,$condition2token)." LIMIT ". $size. " OFFSET ". $skip);
                }else{
                    $skip = $size * $comands[0];
                    $condition1 = $comands[1];
                    $condition1token = $comands[2];
                    $totalSize = DB::select('select * from templates where '. TemplateController::getConditionPart("name",$condition1,$condition1token));
                    $query = 'select * from templates where '. TemplateController::getConditionPart("name",$condition1,$condition1token)." LIMIT ". $size. " OFFSET ". $skip;
                    // var_dump($query);
                    // exit;
                    //$templates = DB::select('select * from templates where '. TemplateController::getConditionPart("name",$condition1,$condition1token)." LIMIT ". $skip. " OFFSET ". $size);
                    $templates = DB::select($query);
                }
            }else{
                $skip = $size * $values;
                $templates =  Template::latest()->skip($skip)->take($size)->get();
            }
        }
        //$templates = DB::select('select * from templates where ');
        return Response::json(array(
            'success' =>true,
            'code' => 1,
            'size' => round(sizeof($totalSize)/2),
            'templates' => $templates,
            'message' => 'hi'
        ));
        //return Response::json($templates);
    }

    public function index()
    {
        $body = [];
        $url = 'registrationForm/getAll';

        $result = ParseAPIResponse:: parseResult( CallAPI::postAPI($url, $body));

        $data = json_decode(json_encode($result['data']['data']));

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                    $button = '';
                    if ($data->is_locked == 0) {
                        $button = '<a href="javascript:void(0)" id="edit-template" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }

                    $button .= '<a href="' . route('templateFields', $data->id) . '" id="template-fields" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Fields"><i class="far fa-list-alt"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    if ($data->is_locked == 1) {
                    	if($data->can_unlock == 1){
                            $button .= '<a href="javascript:void(0);" id="unLock-template" data-toggle="tooltip" data-original-title="Unlock" data-id="' . $data->id . '" title="Un-Lock"><i class="fas fa-unlock"></i></a>';
                        }
                    }
                	else {
                        $button .= '<a href="javascript:void(0);" id="lock-template" data-toggle="tooltip" data-original-title="Lock" data-id="' . $data->id . '" title="Lock"><i class="fas fa-lock"></i></a>';
                    }
                    $button .= '&nbsp;&nbsp;';
                    if ($data->status == 1) {
                        $button .= '<a href="javascript:void(0);" id="deActivate-template" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Deactivate"><i class="fas fa-ban"></i></a>';
                    } else {
                        $button .= '<a href="javascript:void(0);" id="activate-template" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Activate"><i class="fas fa-check-circle"></i></a>';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.Template.templates');
    }

    public function store(Request $request)
    {
        $template_id = $request->template_id;
        $url = 'registrationForm/create';

        $body = [
            "name" => $request->name,
            "status" => $request->status
        ];

        if($template_id != ''){
            $body['id'] = $template_id;
            $url = 'registrationForm/update';
        }

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function getById($id)
    {
        $url = 'registrationForm/getByID';

        $body = [
            "id" => $id,
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function changeStatus($id, $status)
    {
        $url = 'registrationForm/enable';

        $body = [
            "id" => $id
        ];

        if($status == 0){
            $url = 'registrationForm/disable';
        }

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function changeLock($id, $is_locked)
    {

        $url = 'registrationForm/lock';

        $body = [
            "id" => $id
        ];

        if($is_locked == 2){
            $url = 'registrationForm/unlock';
        }

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public static function getConditionPart($columnName,$condition,$token){
        $conditionPart = "";
        switch ($condition) {
            case "1":
                $conditionPart = $columnName ." Like " . "'%" . $token . "%'";
                break;
            case "5":
                $conditionPart = $columnName . " Like " . "'" . $token . "%'";
                break;
            case "6":
                $conditionPart = $columnName . " Like " . "'%" . $token . "'";
                break;
            case "3":
                $conditionPart = $columnName . " = " . "'" . $token . "'";
                break;
            case "4":
                $conditionPart = $columnName . " <> " . "'" . $token . "'";
                break;
            case "2":
                $conditionPart = $columnName . " Not Like " . "'%" . $token . "%'";
                break;
        }
        return $conditionPart;
    }
}


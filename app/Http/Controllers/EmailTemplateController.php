<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Traits\CallAPI;

class EmailTemplateController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            //$emailTemplates = DB::select('select * from email_templates_view');
            $body = [];
            $result = CallAPI::postAPI('emailTemplate/getAll',$body);
            $errCode = $result['errCode'];
            $errMsg = $result['errMsg'];
            $data = $result['data'];
            $data = json_decode(json_encode($data));
            return datatables()->of($data->data)
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="edit-email-template" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.Template.email-templates');
    }

    public function store(Request $request)
    {
        $emailTemplateId = $request->email_template_id;

        // $emailTemplate = EmailTemplate::updateOrCreate(['id' => $emailTemplateId],
        //     ['content' => $request->email_template_content,
        //         'subject' => $request->subject
        //     ]);
        // return Response::json($emailTemplate);
        if($emailTemplateId != ''){
            $body = [
                'email_template_id' => $emailTemplateId,
                'subject' => $request->subject,
                'content' => $request->email_template_content
            ];
            $result = CallAPI::postAPI('emailTemplate/edit',$body);
        }else{
            $body = [
                'email_template_id' => $emailTemplateId,
                'subject' => $request->subject,
                'content' => $request->email_template_content
            ];
            $result = CallAPI::postAPI('emailTemplate/edit',$body);
        }
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        return Response::json($data);
    }

    public function edit($emailTemplateId)
    {
        // $where = array('id' => $emailTemplateId);
        // $emailTemplate = EmailTemplate::where($where)->first();
        // return Response::json($emailTemplate);
        $body = [
            'email_template_id' => $emailTemplateId
        ];
        $result = CallAPI::postAPI('emailTemplate/getByID',$body);
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        return Response::json($data->data[0]);
    }

}

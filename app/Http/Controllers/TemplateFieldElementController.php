<?php

namespace App\Http\Controllers;

use App\Http\Traits\CallAPI;
use App\Http\Traits\ParseAPIResponse;
use App\Models\TemplateFieldElement;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Response;


class TemplateFieldElementController extends Controller
{
    public function index($field_id)
    {
        $body = [
            'registration_form_field_id' =>  $field_id
        ];

        $url = 'registrationFormFieldElement/getAll';

        if (request()->ajax()) {
            $result = ParseAPIResponse:: parseResult( CallAPI::postAPI($url, $body));

            $data = json_decode(json_encode($result['data']['data']));

            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                    $button = '';
                    if ($data->can_edit == 1) {
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" id="edit-element" data-id="' . $data->element_id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" id="delete-element"  data-id="' . $data->element_id . '" data-original-title="Delete" title="Delete"><i class="far fa-trash-alt"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));
        $template = [
            "template_id" => $result['data']['registration_form_id'],
            "template_name" => $result['data']['registration_form_name'],
            "field_id" => $field_id,
            "field_name" => $result['data']['registration_form_field_name'],
            "is_locked" => $result['data']['is_locked']
        ];

        return view('pages.Template.template-field-elements')->with('template', json_decode(json_encode($template)));
    }

    public function store(Request $request)
    {
        $element_id = $request->element_id;
        $url = 'registrationFormFieldElement/create';

        $body = [
            "registration_form_field_id" => $request->field_id,
            'value_ar' => $request->value_ar,
            'value_en' => $request->value_en,
            'element_order' => $request->order,
        ];

        if($element_id != ''){
            $body['registration_form_field_element_id'] = $element_id;
            $url = 'registrationFormFieldElement/update';
        }

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function getById($id)
    {
        $url = 'registrationFormFieldElement/getByID';

        $body = [
            "registration_form_field_element_id" => $id,
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function delete($id)
    {

        $url = 'registrationFormFieldElement/delete';

        $body = [
            "registration_form_field_element_id" => $id,
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Traits\CallAPI;
use App\Http\Traits\ParseAPIResponse;
use App\Models\FieldType;
use App\Models\Template;
use App\Models\TemplateField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TemplateFieldController extends Controller
{

    public function index($template_id)
    {
        if (request()->ajax()) {
//            $templateFields = DB::select('select * from template_fields_view v where v.template_id = ?', [$template_id]);


            $body = [
                'registration_form_id' =>  $template_id
            ];

            $url = 'registrationFormField/getAll';

            $result = ParseAPIResponse:: parseResult( CallAPI::postAPI($url, $body));

            $template_name = $result['data']['registration_form_name'];

            $data = json_decode(json_encode($result['data']['data']));

            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                    $button = '';
                    if ($data->can_edit == 1) {
                            $button = '<a href="javascript:void(0)" data-toggle="tooltip" id="edit-field"  data-id="' . $data->id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                            $button .= '&nbsp;&nbsp;';
                            $button .= '<a href="javascript:void(0)" data-toggle="tooltip" id="delete-field"  data-id="' . $data->id . '" data-original-title="Delete" title="Delete"><i class="far fa-trash-alt"></i></a>';
                            $button .= '&nbsp;&nbsp;';
                    }

                    if ($data->details == 1) {
                        $button .= '<a href="' . route('fieldElements', $data->id) . '" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Elements"><i class="far fa-list-alt"></i></a>';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $url = 'registrationFormField/fieldTypeGetAll';
        $body = [
        ];
        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));
        $fieldTypes = $result['data']['data'];


        $url = 'registrationForm/getByID';
        $body = [
            "id" => $template_id,
        ];
        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));
        $template = [
            "id" => $template_id,
            "name" => $result['data']['name'],
            "is_locked" => $result['data']['is_locked']
            ];

        return view('pages.Template.template-fields')->with('template',  json_decode(json_encode($template)))->with('fieldTypes', $fieldTypes);
    }

    public function store(Request $request)
    {

        $field_id = $request->field_id;
        $url = 'registrationFormField/create';

        $body = [
            "registration_form_id" => $request->template_id,
            "label_ar" => $request->label_ar,
            "label_en" => $request->label_en,
            "field_type_id" => $request->field_type,
            "min_char" => isset( $request->min_char ) ? $request->min_char : "0",
            "max_char" => isset( $request->max_char ) ? $request->max_char : "0",
            "order" => isset( $request->order ) ? $request->min_char : "0",
            "is_mandatory" => ($request->has('mandatory') ? "1" : "0"),
        ];

        if($field_id != ''){
            $body['registration_form_field_id'] = $field_id;
            $url = 'registrationFormField/update';
        }

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function getById($id)
    {
        $url = 'registrationFormField/getByID';

        $body = [
            "registration_form_field_id" => $id,
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function delete($id)
    {

        $url = 'registrationFormField/delete';

        $body = [
            "registration_form_field_id" => $id,
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }
}

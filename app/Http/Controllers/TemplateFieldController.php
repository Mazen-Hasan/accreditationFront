<?php

namespace App\Http\Controllers;

use App\Http\Traits\CallAPI;
use App\Models\FieldType;
use App\Models\Template;
use App\Models\TemplateField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TemplateFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($template_id)
    {
        if (request()->ajax()) {
//            $templateFields = DB::select('select * from template_fields_view v where v.template_id = ?', [$template_id]);

            $body = [
                'registration_form_id' =>  $template_id
            ];
            $result = CallAPI::postAPI('registrationFormField/getAll',$body);
            $errCode = $result['errCode'];
            $errMsg = $result['errMsg'];
            $data = $result['data'];
            $data = json_decode(json_encode($data['data']));

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

        $fieldTypes = FieldType::get()->all();

        $where = array('id' => $template_id);
        $template = Template::where($where)->first();

        return view('pages.Template.template-fields')->with('template', $template)->with('fieldTypes', $fieldTypes);
    }

    public function store(Request $request)
    {
        $fieldId = $request->field_id;

        $templateField = TemplateField::updateOrCreate(['id' => $fieldId],
            ['template_id' => $request->template_id,
                'label_ar' => $request->label_ar,
                'label_en' => $request->label_en,
                'mandatory' => $request->has('mandatory'),
                'min_char' => $request->min_char,
                'max_char' => $request->max_char,
                'field_type_id' => $request->field_type,
                'field_order' => $request->field_order
            ]);
        return Response::json($templateField);
    }

    public function edit($fieldId)
    {
        $where = array('id' => $fieldId);
        $templateField = TemplateField::where($where)->first();
        return Response::json($templateField);
    }

    public function destroy($field_id)
    {
        $field = TemplateField::where('id', $field_id)->delete();

        return Response::json($field);
    }
}

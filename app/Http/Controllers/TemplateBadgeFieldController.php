<?php

namespace App\Http\Controllers;

use App\Models\TemplateBadge;
use App\Models\TemplateBadgeFields;
use App\Models\TemplateField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Traits\CallAPI;
use App\Http\Traits\ParseAPIResponse;

class TemplateBadgeFieldController extends Controller
{
    public function index($badge_id)
    {
        $where = array('id' => $badge_id);
        $templateBadge = TemplateBadge::where($where)->get()->first();

        $templateFields = DB::select('select * from template_fields_view v where v.template_id = ?', [$templateBadge->template_id]);

        if (request()->ajax()) {
            $templaeBadgeFileds = DB::select('select * from template_badge_fields_view where  badge_id = ?', [$badge_id]);
            return datatables()->of($templaeBadgeFileds)
                ->addColumn('action', function ($data) {
                    $button = '';
                    if ($data->is_locked == 0) {
                        $button = '<a href="javascript:void(0)" id="edit-field" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" id="delete-field" data-toggle="tooltip" id="delete-field"  data-id="' . $data->id . '" data-original-title="Delete" title="Delete"><i class="far fa-trash-alt"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $where = array('id' => $badge_id);
        $badge = TemplateBadge::where($where)->first();

        return view('pages.Template.template-badge-fields')->with('badge', $badge)->with('templateFields', $templateFields);
    }

    public function store(Request $request)
    {
        $templateFieldId = $request->template_field_id;

        $where = array('id' => $templateFieldId);
        $templateFiled = TemplateField::where($where)->first();

        $text_color = $request->text_color;
        if($request->template_field_id == 14){
            $text_color = '';
        }

        $templateBadgeField = TemplateBadgeFields::updateOrCreate(['id' => $request->field_id],
            ['badge_id' => $request->badge_id,
                'template_field_id' => $request->template_field_id,
                'template_field_name' => $templateFiled->label_en,
                'position_x' => round($request->position_x * 3.7795275591),
                'position_y' => round($request->position_y * 3.7795275591),
                'size' => round($request->size * 3.7795275591),
                'text_color' => $text_color,
                'bg_color' => $request->bg_color,
            ]);
        return Response::json($templateBadgeField);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post = TemplateBadgeFields::where($where)->first();
        return Response::json($post);
    }

    public function destroy($field_id)
    {
        $field = TemplateBadgeFields::where('id', $field_id)->delete();

        return Response::json($field);
    }

    public function designer(){
        $body = [
            'registration_form_id' =>  '955708d3-a1e4-4d1e-a38a-282246028931'
        ];

        $url = 'registrationFormField/getAll';

        $result =  CallAPI::postAPI($url, $body);
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        $registration_form_fields  = $data->data;
        $body = [
            'badge_id' => 'b7b5cd5a-04ef-11ed-902a-acde48001122'
        ];
        $result = CallAPI::postAPI('badge/getByID',$body);
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        $badge_data = $data->data[0]->badge_data;
        $width = $data->data[0]->width;
        $height = $data->data[0]->high;
        $badge_size = $data->data[0]->badge_size;
        $bg_color = $data->data[0]->bg_color;
        $default_bg_image = $data->data[0]->bg_image;
        return view('pages.Template.template-badge-designer')->with('registration_form_fields',$registration_form_fields)->with('badge_id','b7b5cd5a-04ef-11ed-902a-acde48001122')->with('badge_data',$badge_data)->with('width',$width)->with('height',$height)->with('badge_size',$badge_size)->with('bg_color',$bg_color)->with('default_bg_image',$default_bg_image);
    }

    public function saveBadge(Request $request){
        $badge_id = $request->badge_id;
        $badge = $request->badge;
        $width = $request->width;
        $height = $request->height;
        $badge_size =  $request->badge_size;
        $bg_color =  $request->bg_color;
        $default_bg_image =  $request->default_bg_image;
        $body = [
            "badge_id" => $badge_id,
            "badge_data"=> $badge,
            "width" => $width,
            "height" => $height,
            "bg_color" => $bg_color,
            "default_bg_image" => $default_bg_image,
            "badge_size" => $badge_size
        ];
        $result = CallAPI::postAPI('badge/update',$body);
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        return Response::json($data);
    }
}

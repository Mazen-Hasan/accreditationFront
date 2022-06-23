<?php

namespace App\Http\Controllers;

use App\Models\AccreditationCategory;
use App\Models\TemplateBadge;
use App\Models\TemplateBadgeBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
class TemplateBadgeController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {

            $templateBadge = DB::select('select *  from template_badges_view tb');


            return datatables()->of($templateBadge)
                ->addColumn('action', function ($data) {
                    $button = '';
                    if ($data->is_locked == 0) {
                        $button = '<a href="javascript:void(0)" id="edit-badge" data-toggle="tooltip"  data-id="' . $data->id . '" data-templateId="' . $data->template_id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                	$button .= '<a href="' . route('templateBadgeBGs', $data->id) . '" id="template-badge-bgs" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Backgrounds"><i class="far fa-images"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="' . route('templateBadgeFields', $data->id) . '" id="template-badge-fields" data-toggle="tooltip" data-original-title="Delete" data-id="' . $data->id . '" title="Fields"><i class="far fa-list-alt"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    if ($data->is_locked == 1) {
                    	if($data->can_unlock == 1) {
                            $button .= '<a href="javascript:void(0);" id="unLock-badge" data-toggle="tooltip" data-original-title="Unlock" data-id="' . $data->id . '" title="Un-Lock"><i class="fas fa-unlock"></i></a>';
                        }
                    } else {
                        $button .= '<a href="javascript:void(0);" id="lock-badge" data-toggle="tooltip" data-original-title="Lock" data-id="' . $data->id . '" title="Lock"><i class="fas fa-lock"></i></a>';
                    }
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" id="preview-badge" data-toggle="tooltip"  data-id="' . $data->id . '" data-templateId="' . $data->template_id . '" data-original-title="Preview" title="Preview"><i class="far fa-eye"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

//        $templates = DB::select('select * from templates where id not in (select template_id  from template_badges)');
        $templates = DB::select('select * from templates ');
        return view('pages.Template.template-badge')->with('templates', $templates);
    }

   public function store(Request $request)
    {
        $badge_id = $request->badge_id;

        if($badge_id ==  0){
            $sql = "select count(*) as exist from template_badges tb where template_id='". $request->template_id . "'" ;
            $existTemplate = DB::select($sql );
            if($existTemplate[0]->exist <> 0){
                return Response::json(array(
                    "code" => -1,
                    "message" => "This template is already has a badge",
                    "data" => null,
                ), 200);
            }
        }

        $templateBadge = TemplateBadge::updateOrCreate(['id' => $badge_id],
            ['template_id' => $request->template_id,
             	'width' => round($request->width * 3.7795275591),
                'high' => round($request->high * 3.7795275591),
                'bg_image' => $request->bg_image,
                'is_locked' => $request->has('locked'),
                'creator' => Auth::user()->id
            ]);

        if($badge_id ==  0) {
            $accreditationCategories =  AccreditationCategory::all();
            foreach ($accreditationCategories as $accreditationCategory){
                $templateBadgeBackground = TemplateBadgeBackground::updateOrCreate(['id' => 0],
                    ['badge_id' => $templateBadge->id,
                        'accreditation_category_id'  => $accreditationCategory->id,
                        'bg_image' => $templateBadge->bg_image,
                        'creator' => Auth::user()->id,
                    ]);
            }
        }

//        return Response::json($templateBadge);
       return Response::json(array(
           "code" => 1,
           "message" => "Success",
           "data" => null,
       ), 200);
    }

    public function edit($id)
    {
        $templateBadge = DB::select('select * from template_badges_view where id = ?', [$id]);
        return Response::json($templateBadge[0]);
    }

    public function changeLock($id, $is_locked)
    {
        $post = TemplateBadge::updateOrCreate(['id' => $id],
            [
                'is_locked' => $is_locked
            ]);
        return Response::json($post);
    }
}

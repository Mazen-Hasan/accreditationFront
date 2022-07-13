<?php

namespace App\Http\Controllers;

use App\Http\Traits\CallAPI;
use App\Http\Traits\LogTrait;
use App\Http\Traits\ParseAPIResponse;
use App\Models\Event;
use App\Models\EventAdmin;
use App\Models\EventCompany;
use App\Models\EventCompanyDataEntry;
use App\Models\EventSecurityCategory;
use App\Models\EventSecurityOfficer;
use App\Models\EventType;
use App\Models\SecurityCategory;
use App\Models\SelectOption;
use App\Models\Template;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class EventController extends Controller
{
    public function getData($all, $values)
    {
        // $whereStatusCondition = '';
        // if($all == 1){
        //     $whereStatusCondition = 'where 1=1 ';
        // }
        // else{
        //     $whereStatusCondition = ' where e.status < 4';
        // }
        // $totalSize = DB::select('select * from events_view e ' . $whereStatusCondition);
        // $size = 10;

        // $whereCondition = "";
        // if($values != null){
        //     if(str_contains($values,",")){
        //         $comands = explode(",",$values);
        //         $skip = $size * $comands[0];
        //         $c_size = sizeof($comands);
        //         $i = 1;
        //         while($i < sizeof($comands)){
        //             $token = $comands[$i];
        //             $i = $i + 1;
        //             $complexityType = $comands[$i];
        //             if($complexityType == "C"){
        //                 $i = $i + 1;
        //                 $condition1 = $comands[$i];
        //                 $i = $i + 1;
        //                 $condition1token = $comands[$i];
        //                 $i = $i + 1;
        //                 $operator = $comands[$i];
        //                 $i = $i + 1;
        //                 $condition2 = $comands[$i];
        //                 $i = $i + 1;
        //                 $condition2token = $comands[$i];
        //                 $whereCondition =  $whereCondition." and ".ConditionTrait::getConditionPart($token,$condition1,$condition1token) . " ".$operator ." ". ConditionTrait::getConditionPart($token,$condition2,$condition2token);
        //             }else{
        //                 $i = $i + 1;
        //                 $condition1 = $comands[$i];
        //                 $i = $i + 1;
        //                 $condition1token = $comands[$i];
        //                 $whereCondition = $whereCondition." and ".ConditionTrait::getConditionPart($token,$condition1,$condition1token);
        //             }
        //             $i = $i + 1;
        //         }
        //         $totalSize = DB::select('select * from events_view e ' . $whereStatusCondition . $whereCondition);
        //         $events = DB::select('select * from events_view e ' . $whereStatusCondition. $whereCondition." LIMIT ". $size. " OFFSET ". $skip);
        //     }else{
        //         $skip = $size * $values;
        //         $events = DB::select("select * from events_view e " . $whereStatusCondition . " LIMIT ". $size. " OFFSET ". $skip);
        //     }
        // }
        $offset = 0;
        if ($values != null) {
            if (str_contains($values, ",")) {
                $comands = explode(",", $values);
                $offset = $comands[0];
            }
        }
        $body = [
            'offset' => $offset,
            'size' => 10,
            'filters' => $values
        ];
        if ($all == 1) {
            $result = CallAPI::postAPI('event/getAllWithArchived', $body);
        } else {
            $result = CallAPI::postAPI('event/getAll', $body);
        }
        //$result = CallAPI::postAPI('event/getAll',$body);
        $errCode = $result['errCode'];
        $errMsg = $result['errMsg'];
        $data = $result['data'];
        $data = json_decode(json_encode($data));
        // var_dump(json_decode(json_encode($data->data)));
        // exit;
        // while($data == null){

        // }
        return Response::json(array(
            'success' => true,
            'code' => 1,
            'size' => $data->gridcount,
            'events' => $data->data,
            'message' => 'hi'
        ));

//        $whereStatusCondition = '';
//        if($all == 1){
//            $whereStatusCondition = 'where 1=1 ';
//        }
//        else{
//            $whereStatusCondition = ' where e.status < 4';
//        }
//        $totalSize = DB::select('select * from events_view e ' . $whereStatusCondition);
//        $size = 10;
//
//        $whereCondition = "";
//        if($values != null){
//            if(str_contains($values,",")){
//                $comands = explode(",",$values);
//                $skip = $size * $comands[0];
//                $c_size = sizeof($comands);
//                $i = 1;
//                while($i < sizeof($comands)){
//                    $token = $comands[$i];
//                    $i = $i + 1;
//                    $complexityType = $comands[$i];
//                    if($complexityType == "C"){
//                        $i = $i + 1;
//                        $condition1 = $comands[$i];
//                        $i = $i + 1;
//                        $condition1token = $comands[$i];
//                        $i = $i + 1;
//                        $operator = $comands[$i];
//                        $i = $i + 1;
//                        $condition2 = $comands[$i];
//                        $i = $i + 1;
//                        $condition2token = $comands[$i];
//                        $whereCondition =  $whereCondition." and ".ConditionTrait::getConditionPart($token,$condition1,$condition1token) . " ".$operator ." ". ConditionTrait::getConditionPart($token,$condition2,$condition2token);
//                    }else{
//                        $i = $i + 1;
//                        $condition1 = $comands[$i];
//                        $i = $i + 1;
//                        $condition1token = $comands[$i];
//                        $whereCondition = $whereCondition." and ".ConditionTrait::getConditionPart($token,$condition1,$condition1token);
//                    }
//                    $i = $i + 1;
//                }
//                $totalSize = DB::select('select * from events_view e ' . $whereStatusCondition . $whereCondition);
//                $events = DB::select('select * from events_view e ' . $whereStatusCondition. $whereCondition." LIMIT ". $size. " OFFSET ". $skip);
//            }else{
//                $skip = $size * $values;
//                $events = DB::select("select * from events_view e " . $whereStatusCondition . " LIMIT ". $size. " OFFSET ". $skip);
//            }
//        }
//        $pageCount = 2;
//        $pageCount = floor(sizeof($totalSize)/5);
//        if(sizeof($totalSize) % 5 != 0){
//            $pageCount = $pageCount + 1;
//        }
//        return Response::json(array(
//            'success' =>true,
//            'code' => 1,
//            'size' => $pageCount,
//            'events' => $events,
//            'message' => 'hi'
//        ));
    }

    public function index()
    {
        if (request()->ajax()) {
            $events = DB::select('select * from events_view e where e.status < 4');
            return datatables()->of($events)
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('EventController.show', $data->id) . '" data-toggle="tooltip"  id="event-details" data-id="' . $data->id . '" data-original-title="Details" title="Details"><i class="far fa-list-alt"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    if ($data->status < 3) {
                        $button .= '<a href="' . route('eventEdit', $data->id) . '" data-toggle="tooltip"  id="edit-event" data-id="' . $data->id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0);" id="edit-logo" data-toggle="tooltip" data-id="' . $data->id . '" data-name="' . $data->name . '" data-l="' . $data->logo . '" data-original-title="Edit" title="Edit Logo"><i class="far fa-image"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    $button .= '<a href="' . route('eventSecurityCategories', $data->id) . '" data-toggle="tooltip"  id="event-security-categories" data-id="' . $data->id . '" data-original-title="Edit" title="Event security categories"><i class="fas fa-users-cog"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="' . route('eventAdmins', $data->id) . '" data-toggle="tooltip"  id="event-admins" data-id="' . $data->id . '" data-original-title="Edit" title="Event admins"><i class="fas fa-user-cog"></i></a>';
                    if ($data->approval_option != 1) {
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="' . route('eventSecurityOfficers', $data->id) . '" data-toggle="tooltip"  id="event-security-officers" data-id="' . $data->id . '" data-original-title="Edit" title="Event security officers"><i class="fas fa-user-shield"></i></a>';
                    }
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="' . route('eventAccreditationCategories', $data->id) . '" data-toggle="tooltip"  id="event-accreditation-categories" data-id="' . $data->id . '" data-original-title="Edit" title="Event accreditation categories"><i class="fas fa-users"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    if ($data->status == 3) {
                        $button .= '<a href="javascript:void(0);" id="complete-event" data-toggle="tooltip" data-id="' . $data->id . '" data-name="' . $data->name . '" data-original-title="Edit" title="Complete Events"><i class="fas fa-list-alt"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.Event.events');
    }

    public function showAll($status)
    {
        if (request()->ajax()) {
            $events = DB::select('select * from events_view');
            return datatables()->of($events)
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('EventController.show', $data->id) . '" data-toggle="tooltip"  id="event-details" data-id="' . $data->id . '" data-original-title="Details" title="Details"><i class="far fa-list-alt"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    if ($data->status < 3) {
                        $button .= '<a href="' . route('eventEdit', $data->id) . '" data-toggle="tooltip"  id="edit-event" data-id="' . $data->id . '" data-original-title="Edit" title="Edit"><i class="fas fa-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    $button .= '<a href="' . route('eventSecurityCategories', $data->id) . '" data-toggle="tooltip"  id="event-security-categories" data-id="' . $data->id . '" data-original-title="Edit" title="Event security categories"><i class="fas fa-users-cog"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="' . route('eventAdmins', $data->id) . '" data-toggle="tooltip"  id="event-admins" data-id="' . $data->id . '" data-original-title="Edit" title="Event admins"><i class="fas fa-user-cog"></i></a>';
                    if ($data->approval_option != 1) {
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="' . route('eventSecurityOfficers', $data->id) . '" data-toggle="tooltip"  id="event-security-officers" data-id="' . $data->id . '" data-original-title="Edit" title="Event security officers"><i class="fas fa-user-shield"></i></a>';
                    }
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="' . route('eventAccreditationCategories', $data->id) . '" data-toggle="tooltip"  id="event-accreditation-categories" data-id="' . $data->id . '" data-original-title="Edit" title="Event accreditation categories"><i class="fas fa-users"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    if ($data->status == 3) {
                        $button .= '<a href="javascript:void(0);" id="complete-event" data-toggle="tooltip"  data-id="' . $data->id . '" data-name="' . $data->name . '" data-original-title="Edit" title="Complete Events"><i class="fas fa-list-alt"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function eventAdmins($event_id)
    {
        if (request()->ajax()) {

            $body = [
                'event_id' => $event_id
            ];

            $url = 'event/admin/getByEventID';

            $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

            $can_edit = json_decode(json_encode($result['data']['can_edit']));

            $data = json_decode(json_encode($result['data']['data']));

            return datatables()->of($data)
                ->addColumn('action', function ($data) use ($can_edit) {
                    $button = '&nbsp;&nbsp;';
                    if ($can_edit == 1) {
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" id="delete-event-admin"  data-id="' . $data->user_id . '" data-original-title="Delete" title="Delete"><i class="far fa-trash-alt"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $body = [
            'event_id' => $event_id
        ];

        $url = 'event/admin/getAll';

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

        $event_admins = json_decode(json_encode($result['data']['data']));

        $url = 'event/infoGetByID';

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

        $event = json_decode(json_encode($result['data']));


        return view('pages.Event.eventAdmins')->with('event', $event)->with('event_admins', $event_admins);
    }

    public function eventAdminAdd(Request $request)
    {
        $url = 'event/admin/add';

        $body = [
            "event_id" => $request->event_id,
            "event_admin_id" => $request->admin_id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));

//		$event = Event::where(['id' => $request->event_id,])->first();
//        $notification_type = Config::get('enums.notification_types.AEA');
//        NotificationController::sendNotification($notification_type, $event->name, '', $request->admin_id, 0, $event->name . ':' . 'Event assignment',
//            Route('eventCompanies', [$request->event_id]));
    }

    public function eventAdminRemove($event_id, $event_admin_id)
    {
        $url = 'event/admin/remove';

        $body = [
            "event_id" => $event_id,
            "event_admin_id" => $event_admin_id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function eventSecurityOfficers($event_id)
    {
        if (request()->ajax()) {
            $body = [
                'event_id' => $event_id
            ];

            $url = 'event/securityOfficer/getByEventID';

            $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

            $can_edit = json_decode(json_encode($result['data']['can_edit']));

            $data = json_decode(json_encode($result['data']['data']));

            return datatables()->of($data)
                ->addColumn('action', function ($data) use ($can_edit) {
                    $button = '&nbsp;&nbsp;';
                    if ($can_edit == 1) {
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" id="delete-event-security-officer"  data-id="' . $data->user_id . '" data-original-title="Delete" title="Delete"><i class="far fa-trash-alt"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $body = [
            'event_id' => $event_id
        ];

        $url = 'event/securityOfficer/getAll';

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

        $security_officer = json_decode(json_encode($result['data']['data']));

        $url = 'event/infoGetByID';

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

        $event = json_decode(json_encode($result['data']));

        return view('pages.Event.eventSecurityOfficers')->with('event', $event)->with('security_officers', $security_officer);
    }

    public function eventSecurityOfficerAdd(Request $request)
    {
        $url = 'event/securityOfficer/add';

        $body = [
            "event_id" => $request->event_id,
            "security_officer_id" => $request->security_officer_id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));

//        $notification_type = Config::get('enums.notification_types.ASO');
//        NotificationController::sendNotification($notification_type, $event->name, '', $request->security_officer_id, 0, $event->name . ':' . 'Event assignment',
//            Route('securityOfficerCompanies', [$request->event_id]));

    }

    public function eventSecurityOfficerRemove($event_id, $security_officer_id)
    {
        $url = 'event/securityOfficer/remove';

        $body = [
            "event_id" => $event_id,
            "security_officer_id" => $security_officer_id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function eventSecurityCategories($event_id)
    {
        if (request()->ajax()) {
            $body = [
                'event_id' => $event_id
            ];

            $url = 'event/securityCategory/getByEventID';

            $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

            $can_edit = json_decode(json_encode($result['data']['can_edit']));

            $data = json_decode(json_encode($result['data']['data']));

            return datatables()->of($data)
                ->addColumn('action', function ($data) use ($can_edit) {
                    $button = '&nbsp;&nbsp;';
                    if ($can_edit == 1) {
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" id="delete-event-security-category"  data-id="' . $data->security_category_id . '" data-original-title="Delete" title="Delete"><i class="far fa-trash-alt"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $body = [
            'event_id' => $event_id
        ];

        $url = 'event/securityCategory/getAll';

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

        $security_categories = json_decode(json_encode($result['data']['data']));

        $url = 'event/infoGetByID';

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

        $event = json_decode(json_encode($result['data']));

        return view('pages.Event.eventSecurityCategories')->with('event', $event)->with('security_categories', $security_categories);
    }

    public function eventSecurityCategoryAdd(Request $request)
    {
        $url = 'event/securityCategory/add';

        $body = [
            "event_id" => $request->event_id,
            "security_category_id" => $request->security_category_id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function eventSecurityCategoryRemove($event_id, $security_category_id)
    {
        $url = 'event/securityCategory/remove';

        $body = [
            "event_id" => $event_id,
            "security_category_id" => $security_category_id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function eventCheckSameEventOrganizer($organizerId)
    {
        $where = array('organizer' => $organizerId);
        $event = Event::where($where)->get()->first();

        if ($event) {
            return Response()->json([
                "success" => true,
                "exist" => 1
            ]);
        } else {
            return Response()->json([
                "success" => true,
                "exist" => 0
            ]);
        }
    }

    public function store(Request $request)
    {
        $postId = $request->post_id;
        $event_end_date = $request->event_end_date;
        $event_start_date = $request->event_start_date;
        $datetime1 = new DateTime($event_end_date);
        $datetime2 = new DateTime($event_start_date);
        $interval = $datetime1->diff($datetime2);
        $period_days = $interval->format('%a');
        $accreditation_end_date = $request->accreditation_end_date;
        $accreditation_start_date = $request->accreditation_start_date;
        $datetime1 = new DateTime($accreditation_end_date);
        $datetime2 = new DateTime($accreditation_start_date);
        $interval = $datetime1->diff($datetime2);
        $accredition_period_days = $interval->format('%a');

        $event_companies = null;
        $company_accreditation_categories = null;
        if ($postId == null) {
            $where = array('organizer' => $request->organizer);
            $event = Event::where($where)->get()->last();
            if ($event != null) {
                $where = array('event_id' => $event->id);
                $event_companies = EventCompany::where($where)->get()->all();
                $event_company_data_entries = EventCompanyDataEntry::where($where)->get()->all();
            }
        }

        $action_id = Config::get('actionEnum.actions.event-add');

        $action_result = '';
        $params = 'eventName=' . $request->name . ', location=' . $request->location . ', size=' . $request->size .
            ', organizer=' . $request->organizer . ', owner=' . $request->owner . ', event_type=' . $request->event_type .
            ', period=' . $period_days . ', accreditation_period=' . $accredition_period_days . ', status=' . $request->status .
            ', approval_option=' . $request->approval_option . ', event_form=' . $request->event_form .
            ', event_start_date=' . $request->event_start_date . ', event_end_date=' . $request->event_end_date .
            ', accreditation_start_date=' . $request->accreditation_start_date . ', accreditation_end_date=' . $request->accreditation_end_date;

        try {
            if ($postId != null) {
                $mEvent = Event::where(['id' => $postId])->get()->first();
                $eventSize = $mEvent->size;
                if ($eventSize > $request->size) {
                    DB::update('update event_companies set size = 0 where event_id =? ', [$postId]);
                    DB::delete('delete from company_accreditaion_categories where event_id = ?', [$postId]);
                }
            }
            $post = Event::updateOrCreate(['id' => $postId],
                ['name' => $request->name,
                    'location' => $request->location,
                    'size' => $request->size,
                    'organizer' => $request->organizer,
                    'owner' => $request->owner,
                    'event_type' => $request->event_type,
                    'period' => $period_days,
                    'accreditation_period' => $accredition_period_days,
                    'status' => $request->status,
                    'approval_option' => $request->approval_option,
                    'event_form' => $request->event_form,
                    'event_start_date' => $request->event_start_date,
                    'event_end_date' => $request->event_end_date,
                    'accreditation_start_date' => $request->accreditation_start_date,
                    'accreditation_end_date' => $request->accreditation_end_date,
                    'creator' => Auth::user()->id
                ]);

            $action_result = Config::get('resultEnum.results.SUCCESS');
            LogTrait::supperAdminLog($action_id, $action_result, $params, 'No');

        } catch (Exception $e) {
            $action_result = Config::get('resultEnum.results.FAILED');
            LogTrait::supperAdminLog($action_id, $action_result, $params, $e->getMessage());
        }

        if ($postId == null) {
            $counter = 1;
            if ($request->security_categories != null) {
                foreach ($request->security_categories as $security_category) {
                    $help = EventSecurityCategory::updateOrCreate(['id' => $postId],
                        ['event_id' => $post->id,
                            'security_category_id' => $security_category,
                            'order' => $counter,
                            'creator' => $request->creator
                        ]);
                    $counter = $counter + 1;
                }
            }
            if ($request->event_admins != null) {
                foreach ($request->event_admins as $event_admin) {
                    $help = EventAdmin::updateOrCreate(['id' => $postId],
                        ['event_id' => $post->id,
                            'user_id' => $event_admin
                        ]);
                    $event = Event::where(['id' => $post->id])->first();
                    // NotificationController::sendAlertNotification($event_admin, 0, $event->name . ':' . 'Event assignment', Route('eventCompanies' , [$post->id]));

                    $notification_type = Config::get('enums.notification_types.AEA');
                    NotificationController::sendNotification($notification_type, $event->name, '', $event_admin, 0,
                        $event->name . ':' . 'Event assignment', Route('eventCompanies', [$post->id]));
                }
            }
            if ($request->security_officers != null) {
                foreach ($request->security_officers as $security_officer) {
                    $help = EventSecurityOfficer::updateOrCreate(['id' => $postId],
                        ['event_id' => $post->id,
                            'user_id' => $security_officer
                        ]);
                    $event = Event::where(['id' => $post->id])->first();
                    // NotificationController::sendAlertNotification($security_officer, 0, $event->name . ':' . 'Event assignment', Route('securityOfficerCompanies' , [$post->id]));

                    $notification_type = Config::get('enums.notification_types.AEA');
                    NotificationController::sendNotification($notification_type, $event->name, '', $security_officer, 0,
                        $event->name . ':' . 'Event assignment', Route('securityOfficerCompanies', [$post->id]));
                }
            }
            if ($event_companies != null) {
                foreach ($event_companies as $row) {
                    $new_event_company = EventCompany::updateOrCreate(['id' => 0],
                        ['event_id' => $post->id,
                            'company_id' => $row->company_id,
                            'focal_point_id' => $row->focal_point_id,
                            'parent_id' => $row->parent_id,
                            'status' => 1,
                            'size' => 0,
                            'need_management' => 0,
                        ]);

                    foreach ($event_company_data_entries as $row1) {
                        if ($row1->company_id == $row->company_id) {
                            $new_event_company_data_entry = EventCompanyDataEntry::updateOrCreate(['id' => 0],
                                ['event_id' => $post->id,
                                    'company_id' => $row1->company_id,
                                    'event_companies_id' => $new_event_company->id,
                                    'data_entry_id' => $row1->data_entry_id,
                                    'status' => 1,
                                ]);
                        }
                    }
                    // if($company_accreditation_categories != null){
                    // 	foreach ($company_accreditation_categories as $row2) {
                    //     	if ($row2->company_id == $row->company_id) {
                    //         	$new_company_accreditation_category = CompanyAccreditaionCategory::updateOrCreate(['id' => 0],
                    //             	['event_id' => $post->id,
                    //               	  'company_id' => $row2->company_id,
                    //               	  'accredit_cat_id' => $row2->accredit_cat_id,
                    //               	  'parent_id' => $row2->parent_id,
                    //               	  'size' => 0,
                    //               	  'status' => 0,
                    //               	  'event_company_id' => $new_event_company->id,
                    //               	  'inserted' => 0,
                    //             	]);
                    //     	}
                    // 	}
                    // }
                }
            }

        }
        return Response::json($post);
    }

    public function eventAdd()
    {
        $sql = 'select CONCAT(COALESCE(c.name,"")," ",COALESCE(c.middle_name,"")," ",COALESCE(c.last_name,"")) "name" , c.id "id" from contacts c inner join contact_titles ct on c.id = ct.contact_id where ct.title_id = (select id from titles where title_label = "Organizer")';
        $query = $sql;
        $contacts = DB::select($query);
        $organizersSelectOption = array();
        foreach ($contacts as $contact) {
            $organizerSelectOption = new SelectOption($contact->id, $contact->name);
            $organizersSelectOption[] = $organizerSelectOption;
        }

        $securityCategories = SecurityCategory::get()->where('status', '=', '1');
        $securityCategoriesSelectOption = array();
        foreach ($securityCategories as $securityCategory) {
            $securityCategorieSelectOption = new SelectOption($securityCategory->id, $securityCategory->name);
            $securityCategoriesSelectOption[] = $securityCategorieSelectOption;
        }

        $eventTypes = EventType::get()->where('status', '=', '1');
        $eventTypesSelectOption = array();
        foreach ($eventTypes as $eventType) {
            $eventTypeSelectOption = new SelectOption($eventType->id, $eventType->name);
            $eventTypesSelectOption[] = $eventTypeSelectOption;
        }

        $sql = 'SELECT u.id, u.name FROM users u join users_roles ur on u.id = ur.user_id join roles r on ur.role_id = r.id where r.slug = "event-admin"';
        $eventAdminUsers = DB::select($sql);
        $eventAdmins = array();
        foreach ($eventAdminUsers as $eventAdminUser) {
            $eventAdminSelectOption = new SelectOption($eventAdminUser->id, $eventAdminUser->name);
            $eventAdmins[] = $eventAdminSelectOption;
        }

        $sql = 'SELECT u.id, u.name FROM users u join users_roles ur on u.id = ur.user_id join roles r on ur.role_id = r.id where r.slug = "security-officer"';
        $securityOfficerUsers = DB::select($sql);

        $securityOfficers = array();
        foreach ($securityOfficerUsers as $securityOfficerUser) {
            $securityOfficerSelectOption = new SelectOption($securityOfficerUser->id, $securityOfficerUser->name);
            $securityOfficers[] = $securityOfficerSelectOption;
        }

        $approvalOption1 = new SelectOption(1, 'Event Admin Approval');
        $approvalOption2 = new SelectOption(2, 'Security Officer Approval');
        $approvalOption3 = new SelectOption(3, 'Both');
        $approvalOptions = [$approvalOption1, $approvalOption2, $approvalOption3];

        $eventStatus1 = new SelectOption(1, 'Active');
        $eventStatus2 = new SelectOption(2, 'InActive');
        $eventStatuss = [$eventStatus1, $eventStatus2];

        $templates = DB::select('select * from available_templates_view');
        $templatesSelectOption = array();
        foreach ($templates as $template) {
            $templateSelectOption = new SelectOption($template->id, $template->name);
            $templatesSelectOption[] = $templateSelectOption;
        }

        return view('pages.Event.event-add')->with('organizers', $organizersSelectOption)->with('eventAdmins', $eventAdmins)
            ->with('securityOfficers', $securityOfficers)->with('approvalOptions', $approvalOptions)->with('eventTypes', $eventTypesSelectOption)
            ->with('eventStatuss', $eventStatuss)->with('eventForms', $templatesSelectOption)->with('securityCategories', $securityCategoriesSelectOption);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $event = Event::where($where)->first();

        $sql = 'select CONCAT(COALESCE(c.name,"")," ",COALESCE(c.middle_name,"")," ",COALESCE(c.last_name,"")) "name" , c.id "id" from contacts c inner join contact_titles ct on c.id = ct.contact_id where ct.title_id = (select id from titles where title_label = "Organizer")';
        $query = $sql;
        $contacts = DB::select($query);
        $organizersSelectOption = array();
        foreach ($contacts as $contact) {
            $organizerSelectOption = new SelectOption($contact->id, $contact->name);
            $organizersSelectOption[] = $organizerSelectOption;
        }

        $eventTypes = EventType::get()->where('status', '=', '1');
        $eventTypesSelectOption = array();
        foreach ($eventTypes as $eventType) {
            $eventTypeSelectOption = new SelectOption($eventType->id, $eventType->name);
            $eventTypesSelectOption[] = $eventTypeSelectOption;
        }

        $securityCategories = SecurityCategory::get()->where('status', '=', '1');
        $securityCategoriesSelectOption = array();
        foreach ($securityCategories as $securityCategory) {
            $securityCategorieSelectOption = new SelectOption($securityCategory->id, $securityCategory->name);
            $securityCategoriesSelectOption[] = $securityCategorieSelectOption;
        }

        $sql = 'SELECT u.id, u.name FROM users u join users_roles ur on u.id = ur.user_id join roles r on ur.role_id = r.id where r.slug = "event-admin"';
        $eventAdminUsers = DB::select($sql);
        $eventAdmins = array();
        foreach ($eventAdminUsers as $eventAdminUser) {
            $eventAdminSelectOption = new SelectOption($eventAdminUser->id, $eventAdminUser->name);
            $eventAdmins[] = $eventAdminSelectOption;
        }

        $sql = 'SELECT u.id, u.name FROM users u join users_roles ur on u.id = ur.user_id join roles r on ur.role_id = r.id where r.slug = "security-officer"';
        $securityOfficerUsers = DB::select($sql);

        $securityOfficers = array();
        foreach ($securityOfficerUsers as $securityOfficerUser) {
            $securityOfficerSelectOption = new SelectOption($securityOfficerUser->id, $securityOfficerUser->name);
            $securityOfficers[] = $securityOfficerSelectOption;
        }

        $approvalOption1 = new SelectOption(1, 'Event Admin Approval');
        $approvalOption2 = new SelectOption(2, 'Security Officer Approval');
        $approvalOption3 = new SelectOption(3, 'Both');
        $approvalOptions = [$approvalOption1, $approvalOption2, $approvalOption3];

        $eventStatus1 = new SelectOption(1, 'Active');
        $eventStatus2 = new SelectOption(2, 'InActive');
        $eventStatuss = [$eventStatus1, $eventStatus2];


        $templates = Template::get()->where('status', '=', '1');
        $templatesSelectOption = array();
        foreach ($templates as $template) {
            $templateSelectOption = new SelectOption($template->id, $template->name);
            $templatesSelectOption[] = $templateSelectOption;
        }

        if (request()->ajax()) {
            $where = array('event_id' => $id);
            return datatables()->of(EventSecurityCategory::where($where)->get()->all())
                ->addColumn('name', function ($data) {
                    $result = '';
                    $where = array('id' => $data->security_category_id);
                    $securityCategory = SecurityCategory::where($where)->first();
                    $result = $securityCategory->name;
                    return $result;
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-success edit-post" id="remove-event-security-category">Remove</a>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.Event.event-edit')->with('organizers', $organizersSelectOption)->with('eventAdmins', $eventAdmins)
            ->with('securityOfficers', $securityOfficers)->with('approvalOptions', $approvalOptions)->with('eventTypes', $eventTypesSelectOption)
            ->with('eventStatuss', $eventStatuss)->with('eventForms', $templatesSelectOption)->with('event', $event)->with('securityCategories', $securityCategoriesSelectOption);
    }

    public function updateLogo(Request $request)
    {
        $event_id = $request->eventId;
        $logo = $request->logoName;

        $event = Event::updateOrCreate(['id' => $event_id],
            [
                'logo' => $logo
            ]);

        return Response::json($event);
    }

    public function show($id)
    {
        $event = DB::select('select * from event_datals_view where id=?', [$id]);


        $securityCategories = DB::select('select * from  event_security_categories_info_view where event_id=?', [$id]);
        $securityCategoriesSelectOption = array();
        foreach ($securityCategories as $securityCategory) {
            $securityCategorieSelectOption = new SelectOption($securityCategory->id, $securityCategory->name);
            $securityCategoriesSelectOption[] = $securityCategorieSelectOption;
        }

        $eventAdminUsers = DB::select('select * from event_admins_info_view  where event_id=?', [$id]);
        $eventAdmins = array();
        foreach ($eventAdminUsers as $eventAdminUser) {
            $eventAdminSelectOption = new SelectOption($eventAdminUser->id, $eventAdminUser->name);
            $eventAdmins[] = $eventAdminSelectOption;
        }

        $securityOfficerUsers = DB::select('select * from event_security_officers_info_view where event_id=?', [$id]);
        $securityOfficers = array();
        foreach ($securityOfficerUsers as $securityOfficerUser) {
            $securityOfficerSelectOption = new SelectOption($securityOfficerUser->id, $securityOfficerUser->name);
            $securityOfficers[] = $securityOfficerSelectOption;
        }

        return view('pages.Event.event-details')->with('eventAdmins', $eventAdmins)
            ->with('securityOfficers', $securityOfficers)->with('event', $event[0])
            ->with('securityCategories', $securityCategoriesSelectOption);
    }

    public function remove($event_security_category_id)
    {
        $where = array('id' => $event_security_category_id);
        $post = EventSecurityCategory::where($where)->delete();
        return Response::json($post);
    }

    public function destroy($id)
    {
        $post = Event::where('id', $id)->delete();

        return Response::json($post);
    }

    public function eventAccreditationCategories($event_id)
    {
        $where = array('id' => $event_id);
        $event = Event::where($where)->first();
        if (request()->ajax()) {
            $body = [
                'event_id' => $event_id
            ];

            $url = 'event/accreditationCategory/getByEventID';

            $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

            $can_edit = json_decode(json_encode($result['data']['can_edit']));

            $data = json_decode(json_encode($result['data']['data']));

            return datatables()->of($data)
                ->addColumn('action', function ($data) use ($can_edit) {
                    $button = '&nbsp;&nbsp;';
                    if ($can_edit == 1) {
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" id="delete-event-accreditation-category"  data-id="' . $data->accreditation_category_id . '" data-original-title="Delete" title="Delete"><i class="far fa-trash-alt"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $body = [
            'event_id' => $event_id
        ];

        $url = 'event/accreditationCategory/getAll';

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

        $accreditation_category = json_decode(json_encode($result['data']['data']));

        $url = 'event/infoGetByID';

        $result = ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body));

        $event = json_decode(json_encode($result['data']));

        return view('pages.Event.eventAccreditationCategories')->with('event', $event)->with('accreditation_categories', $accreditation_category);
    }

    public function eventAccreditationCategoryAdd(Request $request)
    {
        $url = 'event/accreditationCategory/add';

        $body = [
            "event_id" => $request->event_id,
            "accreditation_category_id" => $request->accreditation_category_id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function eventAccreditationCategoryRemove($event_id, $accreditation_category_id)
    {
        $url = 'event/accreditationCategory/remove';

        $body = [
            "event_id" => $event_id,
            "accreditation_category_id" => $accreditation_category_id
        ];

        return Response::json(ParseAPIResponse:: parseResult(CallAPI::postAPI($url, $body)));
    }

    public function eventComplete($eventId)
    {
        $post = Event::updateOrCreate(['id' => $eventId],
            [
                'status' => 4
            ]);

        // $notification_type = Config::get('enums.notification_types.EIN');
        // NotificationController::sendNotification($notification_type, $event->name, $company->name, $focal_point[0]->account_id, 0,
        //     $event->name . ': ' . $company->name . ': ' . 'Event invitation', Route('companyParticipants' , [$companyId, $eventId]));

        return Response::json($post);
    }
}

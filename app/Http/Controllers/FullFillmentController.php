<?php

namespace App\Http\Controllers;

use App\Http\Traits\ConditionTrait;
use App\Models\Company;
use App\Models\CompanyStaff;
use App\Models\Event;
use App\Models\EventCompany;
use App\Models\SelectOption;
use App\Models\TemplateField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;

class FullFillmentController extends Controller
{
    public function index()
    {
        $eventsSelectOptions = array();
        $companySelectOptions = array();
        $accrediationCategorySelectOptions = array();
        $events = DB::select('select * from event_admins_view e where e.event_admin=? and e.status = 1', [Auth::user()->id]);
        $eventId = 0;
        $count = 0;
        foreach ($events as $event) {
            if ($count == 0) {
                $eventId = $event->id;
                $companies = DB::select('select * from companies_view e where e.event_id=? and e.status=?', [$event->id, 3]);
                $subcount = 0;
                foreach ($companies as $company) {
                    if ($subcount == 0) {
                        $compnaySelectOption = new SelectOption(0, 'All');
                        $companySelectOptions[] = $compnaySelectOption;
                        $subcount = 1;
                    }
                    $compnaySelectOption = new SelectOption($company->id, $company->name);
                    $companySelectOptions[] = $compnaySelectOption;
                }
                $count = 1;
            }
            $eventSelectOption = new SelectOption($event->id, $event->name);
            $eventsSelectOptions[] = $eventSelectOption;
        }

        $where = array('predefined_field_id' => 14);
        //$acrrediationCategories = PreDefinedFieldElement::where($where)->get()->all();
        $acrrediationCategories = DB::select('select * from event_accreditation_categories_view e where e.event_id = ? ', [$eventId]);
        $mycount = 0;
        foreach ($acrrediationCategories as $acrrediationCategory) {
            if ($mycount == 0) {
                $accrediationCategorySelectOption = new SelectOption(0, 'All');
                $accrediationCategorySelectOptions[] = $accrediationCategorySelectOption;
                $mycount = 1;
            }
            //$accrediationCategorySelectOption = new SelectOption($acrrediationCategory->value_id, $acrrediationCategory->value_en);
            $accrediationCategorySelectOption = new SelectOption($acrrediationCategory->accreditation_category_id, $acrrediationCategory->name);
            $accrediationCategorySelectOptions[] = $accrediationCategorySelectOption;
        }
        return view('pages.FullFillment.selections')->with('eventsSelectOptions', $eventsSelectOptions)->with('companySelectOptions', $companySelectOptions)->with('accrediationCategorySelectOptions', $accrediationCategorySelectOptions);
    }

    public function getCompanies($eventId)
    {
        $companies = DB::select('select * from companies_view e where e.event_id=? and e.status=?', [$eventId, 3]);

        $subcount = 0;
        $companySelectOptions = array();
        foreach ($companies as $company) {
            if ($subcount == 0) {
                $compnaySelectOption = new SelectOption(0, 'All');
                $companySelectOptions[] = $compnaySelectOption;
                $subcount = 1;
            }
            $compnaySelectOption = new SelectOption($company->id, $company->name);
            $companySelectOptions[] = $compnaySelectOption;
        }
        return Response::json($companySelectOptions);
    }

    public function getEventACs($eventId)
    {
        $accreditationCategories = DB::select('select * from event_accreditation_categories_view e where e.event_id = ? ', [$eventId]);
        $subcount = 0;
        $acSelectOptions = array();
        foreach ($accreditationCategories as $accreditationCategory) {
            if ($subcount == 0) {
                $acSelectOption = new SelectOption(0, 'All');
                $acSelectOptions[] = $acSelectOption;
                $subcount = 1;
            }
            $acSelectOption = new SelectOption($accreditationCategory->accreditation_category_id, $accreditationCategory->name);
            $acSelectOptions[] = $acSelectOption;
        }
        return Response::json($acSelectOptions);
    }

    public function getEventCompanyACs($eventId, $companyId)
    {
        $accreditationCategories = DB::select('select * from event_company_accrediation_categories_view e where e.event_id=? and company_id = ?', [$eventId, $companyId]);

        $subcount = 0;
        $acSelectOptions = array();
        foreach ($accreditationCategories as $accreditationCategory) {
            if ($subcount == 0) {
                $acSelectOption = new SelectOption(0, 'All');
                $acSelectOptions[] = $acSelectOption;
                $subcount = 1;
            }
            $acSelectOption = new SelectOption($accreditationCategory->accredit_cat_id, $accreditationCategory->name);
            $acSelectOptions[] = $acSelectOption;
        }
        return Response::json($acSelectOptions);
    }

    public function getParticipantsData($companyId, $eventId, $values)
    {
        if ($companyId != 0) {
            $eventcompanies = EventCompany::where(['event_id' => $eventId, 'parent_id' => $companyId])->get()->all();
            $companies = "'" . $companyId . "'";
            if ($eventcompanies != null) {
                foreach ($eventcompanies as $eventcompnay) {
                    $companies = $companies . ",'" . $eventcompnay->company_id . "'";
                }
            }
            $totalSize = DB::select('select t.* , c.* from `temp_' . $eventId . '` t inner join company_staff c on t.id = c.id where c.company_id in (' . $companies . ')');
        } else {
            $totalSize = DB::select('select t.* , c.* from `temp_' . $eventId . '` t inner join company_staff c on t.id = c.id');
        }
        $size = 10;
        $whereCondition = "";
        if ($values != null) {
            if (str_contains($values, ",")) {
                $comands = explode(",", $values);
                $skip = $size * $comands[0];
                $c_size = sizeof($comands);
                $i = 1;
                while ($i < sizeof($comands)) {
                    $token = $comands[$i];
                    $i = $i + 1;
                    $complexityType = $comands[$i];
                    if ($complexityType == "C") {
                        $i = $i + 1;
                        $condition1 = $comands[$i];
                        $i = $i + 1;
                        $condition1token = $comands[$i];
                        $i = $i + 1;
                        $operator = $comands[$i];
                        $i = $i + 1;
                        $condition2 = $comands[$i];
                        $i = $i + 1;
                        $condition2token = $comands[$i];
                        $whereCondition = $whereCondition . " and " . ConditionTrait::getConditionPart($token, $condition1, $condition1token) . " " . $operator . " " . TemplateController::getConditionPart($token, $condition2, $condition2token);
                    } else {
                        $i = $i + 1;
                        $condition1 = $comands[$i];
                        $i = $i + 1;
                        $condition1token = $comands[$i];
                        $whereCondition = $whereCondition . " and " . ConditionTrait::getConditionPart($token, $condition1, $condition1token);
                    }
                    $i = $i + 1;
                }
                if ($companyId != 0) {
                    $eventcompanies = EventCompany::where(['event_id' => $eventId, 'parent_id' => $companyId])->get()->all();
                    $companies = "'" . $companyId . "'";
                    if ($eventcompanies != null) {
                        foreach ($eventcompanies as $eventcompnay) {
                            $companies = $companies . ",'" . $eventcompnay->company_id . "'";
                        }
                    }
                    $totalSize = DB::select('select t.* , c.* from `temp_' . $eventId . '` t inner join company_staff c on t.id = c.id where c.status = 10 and c.company_id in (' . $companies . ')' . $whereCondition);
                    $participants = DB::select('select t.* , c.* from `temp_' . $eventId . '` t inner join company_staff c on t.id = c.id where c.status = 10 and c.company_id in (' . $companies . ')' . $whereCondition . " LIMIT " . $size . " OFFSET " . $skip);
                } else {
                    $totalSize = DB::select('select t.* , c.* from `temp_' . $eventId . '` t inner join company_staff c on t.id = c.id where c.status = 10  ' . $whereCondition);
                    $participants = DB::select('select t.* , c.* from `temp_' . $eventId . '` t inner join company_staff c on t.id = c.id where c.status = 10  ' . $whereCondition . " LIMIT " . $size . " OFFSET " . $skip);
                }
            } else {
                $skip = $size * $values;
                if ($companyId != 0) {
                    $eventcompanies = EventCompany::where(['event_id' => $eventId, 'parent_id' => $companyId])->get()->all();
                    $companies = "'" . $companyId . "'";
                    if ($eventcompanies != null) {
                        foreach ($eventcompanies as $eventcompnay) {
                            $companies = $companies . ",'" . $eventcompnay->company_id . "'";
                        }
                    }
                    $participants = DB::select('select t.* , c.* from `temp_' . $eventId . '` t inner join company_staff c on t.id = c.id where c.status = 10 and c.company_id in (' . $companies . ') LIMIT ' . $size . " OFFSET " . $skip);
                } else {
                    $participants = DB::select('select t.* , c.* from `temp_' . $eventId . '` t inner join company_staff c on t.id = c.id where c.status = 10 LIMIT ' . $size . " OFFSET " . $skip);
                }
            }
        }
        return Response::json(array(
            'success' => true,
            'code' => 1,
            'size' => round(sizeof($totalSize) / 2),
            'templates' => $participants,
            'message' => 'hi'
        ));
    }


    public function getParticipants($eventId, $companyId, $accreditId)
    {
        $result = array();
        $returnedParticipnats = array();
        $printedParticipants = 0;
        $dataTableColumuns = array();
        $where = array('id' => $eventId);
        $event = Event::where($where)->get()->first();

        if ($companyId != 0) {
            $where = array('id' => $companyId);
            $company = Company::where($where)->get()->first();
        }

        $company_admin_id = '_superAdmin_' . Auth::user()->id;

        $where = array('template_id' => $event->event_form);
        $templateFields = TemplateField::where($where)->orderBy('field_order', 'ASC')->get()->all();

        foreach ($templateFields as $templateField) {
            $dataTableColumuns[] = $templateField->label_en;
        }

        if (!Schema::hasTable('temp_' . $eventId)) {
            Schema::create('temp_' . $eventId, function ($table) use ($templateFields) {
                $table->string('id');
                foreach ($templateFields as $templateField) {
                    $dataTableColumuns[] = $templateField->label_en;
                    $table->string(preg_replace('/\s+/', '_', $templateField->label_en));
                }
            });
        }

        if ($accreditId == 'All') {
            if ($companyId != 0) {
                $participants = DB::select("select t.* , c.* from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id where c.company_id = ? and c.status = 9", [$companyId]);
                $printedParticipants = DB::select("select count(*) as p from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id where c.company_id = ? and c.status = 10", [$companyId]);
            } else {
                $participants = DB::select("select t.* , c.* from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id  and c.status = 9");
                $printedParticipants = DB::select("select count(*) as p from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id  and c.status = 10");
            }
        } else {
            if ($companyId != 0) {
                $participants = DB::select("select t.* , c.* from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id where t.Accreditation_category ='" . $accreditId . "' and c.company_id = ?  and c.status = 9", [$companyId]);
                $printedParticipants = DB::select("select count(*) as p from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id where t.Accreditation_category ='" . $accreditId . "' and c.company_id = ?  and c.status = 10", [$companyId]);
            } else {
                $participants = DB::select("select t.* , c.* from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id where t.Accreditation_category ='" . $accreditId . "'  and c.status = 9");
                $printedParticipants = DB::select("select count(*) as p from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id where t.Accreditation_category ='" . $accreditId . "'  and c.status = 10");
            }
        }
        foreach ($participants as $participant) {
            $returnedParticipnats[] = $participant->id;
        }
        $result['selected'] = $returnedParticipnats;
        $result['printed'] = $printedParticipants[0]->p;

        return Response::json($result);
    }

    public function fullFillment(Request $request)
    {
        $staffIDs = $request->get('staff');
        $updateProduct = CompanyStaff::whereIn('id', $staffIDs)
            ->update(['print_status' => '2', 'status' => '10']);
        return Response::json($updateProduct);
    }

    public function allParticipants($eventId, $companyId, $accreditId, $checked)
    {
        $dataTableColumuns = array();
        $where = array('id' => $eventId);
        $event = Event::where($where)->get()->first();

        if ($companyId != 0) {
            $where = array('id' => $companyId);
            $company = Company::where($where)->get()->first();
        }

        $company_admin_id = '_superAdmin_' . Auth::user()->id;

        $where = array('template_id' => $event->event_form);
        $templateFields = TemplateField::where($where)->orderBy('field_order', 'ASC')->get()->all();

        foreach ($templateFields as $templateField) {
            $dataTableColumuns[] = $templateField->label_en;
        }

        // Schema::dropIfExists('temp' . $company_admin_id);
        // Schema::create('temp' . $company_admin_id, function ($table) use ($templateFields, $companyId) {
        //     $table->string('id');
        //     foreach ($templateFields as $templateField) {
        //         $table->string(preg_replace('/\s+/', '_', $templateField->label_en));
        //     }
        // });
        if (!Schema::hasTable('temp_' . $eventId)) {
            Schema::create('temp_' . $eventId, function ($table) use ($templateFields) {
                $table->string('id');
                foreach ($templateFields as $templateField) {
                    $dataTableColumuns[] = $templateField->label_en;
                    $table->string(preg_replace('/\s+/', '_', $templateField->label_en));
                }
            });
        }
        // if ($companyId == 0) {
        //     $where = array('event_id' => $eventId);
        // } else {
        //     $where = array('event_id' => $eventId, 'company_id' => $company->id);
        // }
        // $companyStaffs = CompanyStaff::where($where)->get()->all();
        // $alldata = array();
        // foreach ($companyStaffs as $companyStaff) {
        //     $where = array('staff_id' => $companyStaff->id);
        //     if ($companyId != 0) {
        //         $staffDatas = DB::select('select * from staff_data_template_fields_view where staff_id = ? and template_id = ?', [$companyStaff->id, $event->event_form]);
        //     } else {
        //         $staffDatas = DB::select('select * from event_staff_data_view where staff_id = ? and template_id = ?', [$companyStaff->id, $event->event_form]);
        //     }
        //     $staffDataValues = array();
        //     $staffDataValues[] = $companyStaff->id;
        //     $count = 0;
        //     foreach ($staffDatas as $staffData) {
        //         if ($staffData->slug == 'select') {
        //             $where = array('template_field_id' => $staffData->template_field_id, 'value_id' => $staffData->value);
        //             $value = TemplateFieldElement::where($where)->first();
        //             $staffDataValues[] = $value->value_en;
        //         } else {
        //             $staffDataValues[] = $staffData->value;
        //         }
        //     }
        //     $alldata[] = $staffDataValues;
        // }
        // $query = '';
        // foreach ($alldata as $data) {
        //     $query = '';
        //     if ($companyId == 0) {
        //         $query = $query . 'insert into temp' . $company_admin_id . ' (id';
        //     } else {
        //         $query = $query . 'insert into temp' . $company_admin_id . ' (id';
        //     }
        //     foreach ($templateFields as $templateField) {
        //         $query = $query . ',' . preg_replace('/\s+/', '_', $templateField->label_en);
        //     }
        //     $query = $query . ') values (';
        //     foreach ($data as $staffDataValue) {
        //         $query = $query . '"' . $staffDataValue . '",';
        //     }
        //     $query = substr($query, 0, strlen($query) - 1);
        //     $query = $query . ')';
        //     DB::insert($query);
        // }
        if (request()->ajax()) {
            // if ($accreditId == 'All') {
            //     $participants = DB::select("select t.* , c.* from temp" . $company_admin_id . " t inner join company_staff c on t.id = c.id");
            // } else {
            //     $participants = DB::select("select t.* , c.* from temp" . $company_admin_id . " t inner join company_staff c on t.id = c.id where t.Accreditation_category ='" . $accreditId . "'");
            // }
            if ($accreditId == 'All') {
                if ($companyId != 0) {
                    $participants = DB::select("select t.* , c.* from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id where c.company_id = ? and c.status = 10", [$companyId]);
                } else {
                    $participants = DB::select("select t.* , c.* from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id and c.status = 10");
                }
            } else {
                if ($companyId != 0) {
                    $participants = DB::select("select t.* , c.* from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id where t.Accreditation_category ='" . $accreditId . "' and c.company_id = ? and c.status = 10", [$companyId]);
                } else {
                    $participants = DB::select("select t.* , c.* from `temp_" . $eventId . "` t inner join company_staff c on t.id = c.id where t.Accreditation_category ='" . $accreditId . "' and c.status = 10");
                }
            }
            return datatables()->of($participants)
                ->addColumn('status', function ($data) {
                    $status_value = "initaited";
                    switch ($data->status) {
                        case 0:
                            $status_value = "Initiated";
                            break;
                        case 1:
                            $status_value = "Waiting Security Officer Approval";
                            break;
                        case 2:
                            $status_value = "Waiting Event Admin Approval";
                            break;
                        case 3:
                            $status_value = "Approved by security officer";
                            break;
                        case 4:
                            $status_value = "Rejected by security officer";
                            break;
                        case 5:
                            $status_value = "Rejected by event admin";
                            break;
                        case 6:
                            $status_value = "Approved by event admin";
                            break;
                        case 7:
                            $status_value = "Rejected with correction by security officer";
                            break;
                        case 8:
                            $status_value = "Rejected with correction by event admin";
                            break;
                        case 9:
                            $status_value = "Badge generated";
                            break;
                        case 10:
                            $status_value = "Badge printed";
                            break;
                    }
                    return $status_value;
                })
                ->addColumn('action', function ($data) use ($checked) {
                    $button = '';
                    if ($checked == 1) {
                        $button .= '<input type="checkbox" class="select" data-id="' . $data->id . '" checked />';
                    } else {
                        $button .= '<input type="checkbox" class="select" data-id="' . $data->id . '" />';
                    }
                    return $button;
                })
                ->addColumn('image', function ($data) {
                    $image = '';
                    //$image .= '<a href="' . route('templateFormDetails', $data->id) . '" data-toggle="tooltip"  id="participant-details" data-id="' . $data->id . '" data-original-title="Edit" title="Details"><i class="far fa-list-alt"></i></a>';
                    $image .= '<img src="' . asset('badges/' . $data->Personal_Image) . '" alt="Personal" class="pic-img" style="margin-left:40px">';
                    return $image;
                })
                ->addColumn('identifier', function ($data) {
                    return $data->identifier;
                })
                ->rawColumns(['identifier', 'image', 'status', 'action'])
                ->make(true);
        }
        return view('pages.FullFillment.all-participants')->with('dataTableColumns', $dataTableColumuns)->with('company_id', $companyId)->with('event_id', $eventId)->with('accredit', $accreditId)->with('checked', $checked);
    }
}

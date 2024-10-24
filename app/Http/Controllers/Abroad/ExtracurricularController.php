<?php

namespace App\Http\Controllers\Abroad;

use App\Events\NewExtracurricularCreated;
use App\Http\Controllers\Controller;
use App\Models\AbroadService;
use App\Models\AbroadApplication;
use App\Models\ApplicationFee;
use App\Models\EssayResult;
use App\Models\RecommendationLetter;
use App\Models\CulturalOrientation;
use App\Models\DepositForSchool;
use App\Models\SocialNetwork;
use App\Models\Certifications;
use App\Models\ExtracurricularSchedule;
use App\Models\ExtracurricularActivity;
use App\Models\AbroadApplicationStatus;
use App\Models\AbroadStatus;
use App\Models\Account;
use App\Models\Role;
use App\Models\AbroadApplicationFinishDay;
use App\Models\Extracurricular;
use App\Models\LoTrinhHocThuatChienLuoc;
use App\Models\ApplicationSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


use App\Events\StudentAssignedToTTSK;
use App\Events\TheStudentWasHandedOverForAbroadStaff;
use App\Events\TheStudentWasHandedOverForExtraStaff;
use App\Events\StudentAssignedToTVCL;

use App\Library\Permission;
use App\Models\User;

class ExtracurricularController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $listViewName ='extracurricular.abroad';
        $columns = [
            // ['id' => 'student_id', 'title' => trans('messages.payment.payment_date'), 'checked' => true],
            ['id' => 'name', 'title' => trans('messages.abroad.extracurricular_name'), 'checked' => true],
            ['id' => 'type', 'title' => trans('messages.abroad.type'), 'checked' => true],
            ['id' => 'address', 'title' => trans('messages.abroad.address'), 'checked' => true],
            ['id' => 'coordinator', 'title' => trans('messages.abroad.coordinator'), 'checked' => true],
            ['id' => 'total_revenue', 'title' => trans('messages.abroad.total_revenue'), 'checked' => true],
            ['id' => 'start_at', 'title' => trans('messages.abroad.start_at'), 'checked' => true],
            ['id' => 'end_at', 'title' => trans('messages.abroad.end_at'), 'checked' => true],
            ['id' => 'price', 'title' => trans('messages.abroad.price'), 'checked' => true],
            ['id' => 'expected_costs', 'title' => trans('messages.abroad.expected_costs'), 'checked' => true],
            ['id' => 'actual_costs', 'title' => trans('messages.abroad.actual_costs'), 'checked' => true],
            ['id' => 'profit', 'title' => trans('messages.abroad.profit'), 'checked' => true],
            ['id' => 'study_method', 'title' => trans('messages.abroad.study_method'), 'checked' => true],
            ['id' => 'created_at', 'title' => trans('messages.contact.created_at'), 'checked' => true],
            ['id' => 'student_code', 'title' => trans('messages.abroad.student_code'), 'checked' => true],
            ['id' => 'student_apply', 'title' => trans('messages.abroad.student_apply'), 'checked' => true],
            ['id' => 'min_student', 'title' => trans('messages.abroad.min_student'), 'checked' => true],
            ['id' => 'max_student', 'title' => trans('messages.abroad.max_student'), 'checked' => true],
            ['id' => 'hours_per_week', 'title' => trans('messages.abroad.hours_per_week'), 'checked' => true],
            ['id' => 'weeks_per_year', 'title' => trans('messages.abroad.weeks_per_year'), 'checked' => true],
                
            // ['id' => 'amount', 'title' => trans('messages.payment.created_at'), 'checked' => true],
            // ['id' => 'received_date', 'title' => trans('messages.payment.order_id'), 'checked' => true],
            // ['id' => 'account', 'title' => trans('messages.contact.id'), 'checked' => true],
            // ['id' => 'note', 'title' => trans('messages.contact.name'), 'checked' => true],            
        ];

        //list view  name
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));
        return view('abroad.extracurricular.index', [
            'id'=> $request->id,
            'columns' => $columns,
            'listViewName' => $listViewName,
        ]);
    }

    public function list(Request $request)
    {
        $query = Extracurricular::byBranch(\App\Library\Branch::getCurrentBranch());
       
       
        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->status === 'deputy_director_approved') {
            $query = $query->filterByAbroadStatus($request->status);
        }

        if ($request->has('created_at_from') || $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query = $query->filterByStartAt($created_at_from, $created_at_to);
        }

        if ($request->has('updated_at_from') || $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByEndAt($updated_at_from, $updated_at_to);
        }

        if ($request->abroadStatuses) {
            $query = $query->filterByStatusAbroad($request->abroadStatuses);
        }
        if ($request->status) {
            switch ($request->status) {
                
                case 'finished':
                    $query = $query->finish();
                    break;
                case 'notFinished':
                    $query = $query->notFinished();
                    break;
                   
                case 'finalized':
                    $query = $query->finalized();
                    break;
                
                case 'all':
                    break;

                default:
                    throw new \Exception('Invalid status:' . $request->status);
            }
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';

        $query = $query->orderBy($sortColumn, $sortDirection);

        $abroadApplications = $query->paginate($request->perpage ?? 10);

        return view('abroad.extracurricular.list', [
            'abroadApplications' => $abroadApplications,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    public function create(Request $request)
    {
        return view('abroad.extracurricular.create');
    }

    public function save(Request $request)
    {
        $extracurricular = Extracurricular::newDefault();
        
        $errors = $extracurricular->createExtracurricular($request);
        // $extracurricular = new Extracurricular();
        // $extracurricular->createExtracurricular($request);

        if (!$errors->isEmpty()) {
            return response()->view('abroad.extracurricular.create', [ 
                'extracurricular' => $extracurricular,
                'errors' => $errors,
                
            ], 400);
        }
        // NewExtracurricularCreated::dispatch($extracurricular);
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm mới kế hoạch ngoại khoá thành công'
        ]);
    }

    public function edit(Request $request, $id)
    {
        $extracurricular = Extracurricular::find($id);

        return view('abroad.extracurricular.edit', [
            'extracurricular' => $extracurricular,
        ]);
    }

    public function update(Request $request, $id)
    {
        $extracurricular = Extracurricular::find($id);
        $extracurricular->updateExtracurricular($request);

        return response()->json([
            'message' => 'Cập nhật kế hoạch ngoại khoá thành công'
        ]);
    }

    public function delete(Request $request)
    {
        $extracurricular = Extracurricular::find($request->id);
        $extracurricular->delete();

        return response()->json([
            "status" => "Success",
            "message" => "Xóa ngoại khoá thành công!"
        ]);
    }

    public function details(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);

        return view('abroad.extracurricular.details', [
            'abroadApplication' => $abroadApplication,
        ]);
    }

    public function management(Request $request)
    {
        return view('abroad.extracurricular.management', [
        ]);
    }
    public function extracurricularSchedule(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $extracurricularSchedules = ExtracurricularSchedule::getByAbroadApplication($abroadApplication->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        
        return view('abroad.extracurricular.extracurricularSchedule.extracurricularSchedule', [
            'abroadApplication' => $abroadApplication,
            'extracurricularSchedules' => $extracurricularSchedules,
            'dayFinish' => $dayFinish
        ]);
    }
    
    public function extracurricularPlan(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        
        return view('abroad.extracurricular.extracurricular_plan.content', [
            'abroadApplication' => $abroadApplication,
            'dayFinish' => $dayFinish
        ]);
    }

    public function extracurricularActivity(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $extracurricularActivitys = ExtracurricularActivity::getByAbroadApplication($abroadApplication->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        
        return view('abroad.extracurricular.extracurricularActivity.extracurricularActivity', [
            'abroadApplication' => $abroadApplication,
            'extracurricularActivitys' => $extracurricularActivitys,
            'dayFinish'=>$dayFinish
        ]);
    }

    public function certifications(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $certifications = Certifications::getByAbroadApplication($abroadApplication->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();

        return view('abroad.extracurricular.certifications.certifications', [
            'abroadApplication' => $abroadApplication,
            'certifications' => $certifications,
            'dayFinish' => $dayFinish
        ]);
    }

    public function approval(Request $request)
    {
        $status = $request->status;
        $listViewName ='abroad.appproval';
        $columns = [
            ['id' => 'name', 'title' => trans('messages.abroad.name'), 'checked' => true],
            ['id' => 'birthday', 'title' => trans('messages.contact.birthday'), 'checked' => false],
            ['id' => 'code_student', 'title' => trans('messages.class.code_student'), 'checked' => true],
            ['id' => 'email', 'title' => trans('messages.abroad.email'), 'checked' => true],
            ['id' => 'phone', 'title' => trans('messages.class.phone_number'), 'checked' => false],
            ['id' => 'school', 'title' => trans('messages.contact.school'), 'checked' => false],
            ['id' => 'country', 'title' => trans('messages.contact.country'), 'checked' => false],
            ['id' => 'financial_capability', 'title' => trans('messages.abroad.financial_capability'), 'checked' => false],

           


            
            

            ['id' => 'father_id', 'title' => trans('messages.abroad.father_id'), 'checked' => true],
            ['id' => 'farther_phone', 'title' => trans('messages.abroad.farther_phone'), 'checked' => true],
            ['id' => 'mother_id', 'title' => trans('messages.abroad.mother_id'), 'checked' => true],
            ['id' => 'morther_phone', 'title' => trans('messages.abroad.morther_phone'), 'checked' => true],
            ['id' => 'sale', 'title' => trans('messages.abroad.sale'), 'checked' => true],

            
            ['id' => 'code', 'title' => trans('messages.abroad.code'), 'checked' => true],
            // ['id' => 'manager', 'title' => trans('messages.abroad.manager'), 'checked' => true],
            ['id' => 'status_abroad', 'title' => trans('messages.abroad.status_abroad'), 'checked' => true],
            ['id' => 'apply', 'title' => trans('messages.abroad.apply'), 'checked' => true], 
            ['id' => 'account_manager_extracurricular_id', 'title' => trans('messages.abroad.account_manager_extracurricular_id'), 'checked' => true],
            ['id' => 'nvtvdhcl', 'title' => trans('messages.abroad.nvtvdhcl'), 'checked' => true],
            ['id' => 'nvttsk', 'title' => trans('messages.abroad.nvttsk'), 'checked' => true],
            ['id' => 'top_school', 'title' => trans('messages.abroad.top_school'), 'checked' => true],
            ['id' => 'created_at', 'title' => trans('messages.abroad.created_at'), 'checked' => true],
            ['id' => 'updated_at', 'title' => trans('messages.abroad.updated_at'), 'checked' => true],
            ['id' => 'plan_apply_program_id', 'title' => trans('messages.abroad.plan_apply_program_id'), 'checked' => false],
            ['id' => 'intended_major_id', 'title' => trans('messages.abroad.intended_major_id'), 'checked' => false],
            ['id' => 'estimated_enrollment_time', 'title' => trans('messages.abroad.estimated_enrollment_time'), 'checked' => false],
        ];

        //list view  name
        $columns = \App\Helpers\Functions::columnsFromListView($columns, $request->user()->getListView($listViewName));
        
        return view('abroad.extracurricular.approval', [
            'status' => $status, 
            'columns' => $columns,
            'listViewName' => $listViewName,
            'columns' => $columns,
        ]);
    }

    public function approvalList(Request $request)
    {
        if ($request->user()->can('changeBranch', User::class)) {
            $query = AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch());
        } else {
            $query = $request->user()->account->abroadApplicationExtracurriculars(); 
        }

        $query = $query->extraPort();

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->status === 'assigned-account') {
            $query = $query->filterByAssignedAcountExtracurricular();
        }

        if ($request->status === 'waiting-manager') {
            $query = $query->filterByNotAssignedAcountManagerExtracurricular();
        }

        if ($request->status === 'approval-manager') {
            $query = $query->filterByAssignedAcountManagerExtracurricular();
        }
        
        if ($request->status === 'waiting') {
            $query = $query->filterByWaitingExtracurricular();
        }

        if ($request->status === 'wait_for_approval') {
            $query = $query->filterByWaitForApproval();
        }

        if ($request->status === 'approved') {
            $query = $query->filterByApproved();
        }

        if ($request->status === 'done') {
            $query = $query->filterByDone();
        }
        
        if ($request->abroadStatuses) {
            $query = $query->filterByStatusAbroad($request->abroadStatuses);
        }

        if ($request->account1) {
            $query = $query->filterByAccount1($request->account1);
        }

        if ($request->account2) {
            $query = $query->filterByAccount2($request->account2);
        }

        if ($request->has('created_at_from') ) {
            $created_at_from = $request->input('created_at_from');
            $query = $query->filterByCreatedAtFrom($created_at_from);
        }

        if ($request->has('created_at_to')) {
            $created_at_to = $request->input('created_at_to');
            $query = $query->filterByCreatedAtTo($created_at_to);
        }

        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query = $query->filterByCreatedAt($created_at_from, $created_at_to);
        }


        if ($request->has('updated_at_from')) {
            $updated_at_from = $request->input('updated_at_from');
           
            $query = $query->filterByUpdatedAtFrom($updated_at_from);
        }

        if ( $request->has('updated_at_to')) {
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAtTo( $updated_at_to);
        }
        if ($request->has('salesperson_ids')) {
            
            $query = $query->filterBySalespersonIds($request->input('salesperson_ids'));
        }

        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        if ($request->abroadStatuses) {
            $query = $query->filterByStatusAbroad($request->abroadStatuses);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->sortList($sortColumn, $sortDirection);
        $abroadApplications = $query->paginate($request->perpage ?? 10);
        
        return view('abroad.extracurricular.approvalList', [
            'abroadApplications' => $abroadApplications,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'status' => $request->status,
        ]);
    }

     // Bàn giao 
     public function handover(Request $request, $id)
     {
         $abroadApplication = AbroadApplication::find($id);
 
         return view('abroad.extracurricular.handover', [
             'abroadApplication' => $abroadApplication
         ]);
     }

     public function doneAssignmentAbroadApplication(Request $request, $id)
     {
         $abroadApplication = AbroadApplication::find($request->abroadApplication);

         $abroadApplication->doneAssignmentAbroadApplication($request);
 
        // add note log 
         if(isset($request->account_id_1)){
             $account1 = Account::find($request->account_id_1);
             $abroadApplication->contact->addNoteLog($account1, "Đã bàn giao nhân viên tư vấn du học chiến lược " .  $account1->name . " cho hợp đồng " . $abroadApplication->getOrderCode());
 
             TheStudentWasHandedOverForAbroadStaff::dispatch($abroadApplication, $account1);
             StudentAssignedToTVCL::dispatch($abroadApplication);
         }
 
         if(isset($request->account_id_2)){
             $account2 = Account::find($request->account_id_2);
             
             $abroadApplication->contact->addNoteLog($account2, "Đã bàn giao nhân viên truyền thông & sự kiện  " .  $account2->name . " cho hợp đồng " . $abroadApplication->getOrderCode());
             
             StudentAssignedToTTSK::dispatch($abroadApplication);
             TheStudentWasHandedOverForExtraStaff::dispatch($abroadApplication, $account2);
 
         }
 
         return response()->json([
             'message' => 'Duyệt và bàn giao thành công'
         ]);
     }
    
      // IV.1 Lộ trình học thuật chiến lược
    public function strategicLearningCurriculum(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        $checkFill = LoTrinhHocThuatChienLuoc::isCheckFill($request->id);

        return view('abroad.extracurricular.strategic_learning_curriculum.strategicLearningCurriculum', [
            'abroadApplication' => $abroadApplication,
            'dayFinish' => $dayFinish,
            'checkFill'=>$checkFill
        ]);
    }

    // IV 1
    public function viewStrategicLearningCurriculum(Request $request)
    {
        $loTrinhHocThuatChienLuocDatas = LoTrinhHocThuatChienLuoc::where('abroad_application_id', $request->id);
        $loTrinhHocThuatChienLuoc =config('loTrinhHocThuatChienLuoc');

        return view('abroad.extracurricular.strategic_learning_curriculum.viewStrategicLearningCurriculum', [
            'loTrinhHocThuatChienLuoc'=>$loTrinhHocThuatChienLuoc,
            'loTrinhHocThuatChienLuocDatas'=>$loTrinhHocThuatChienLuocDatas
        ]);
    }

    // Danh sách trường, yêu cầu tuyển sinh
    public function applicationSchool(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        // $socialNetworks = Certifications::getByContactId($abroadApplication->contact_id);
        // $accounts = Account::sales()->get();
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        $checkFill = ApplicationSchool::isCheckFill($request->id);
        
        return view(
            'abroad.extracurricular.applicationSchool.applicationSchool',
            [
                'abroadApplication' => $abroadApplication,
                'dayFinish'=>$dayFinish,
                'checkFill'=>$checkFill,
            ]
        );
    }

    public function applicationSchoolShow(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $applicationSchools = ApplicationSchool::getByAbroadApplication($abroadApplication->id);
        
        return view('abroad.extracurricular.applicationSchool.applicationSchoolShow', [
            'abroadApplication' => $abroadApplication,
            'applicationSchools' => $applicationSchools
        ]);
    }
}

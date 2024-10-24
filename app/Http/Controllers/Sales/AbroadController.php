<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\AbroadService;
use App\Models\AbroadApplication;
use App\Models\ApplicationAdmittedSchool;
use App\Models\ApplicationFee;
use App\Models\ApplicationSubmission;
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
use App\Models\StudentSection;
use App\Models\StudyAbroadApplication;
use App\Models\SupportActivity;
use App\Models\ApplicationSchool;
use App\Models\FlyingStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\ExtracurricularStudent;
use App\Models\LoTrinhHocThuatChienLuoc;
use App\Models\LoTrinhHoatDongNgoaiKhoa;
use App\Models\AbroadApplicationFinishDay;
use App\Models\Contact;

class AbroadController extends Controller
{
    public function index(Request $request)
    {

        $status = $request->status;
        return view('abroad.index', [
            'status' => $status,
            'columns' => [
                ['id' => 'name', 'title' => trans('messages.abroad.name'), 'checked' => true],
                ['id' => 'email', 'title' => trans('messages.abroad.email'), 'checked' => true],
                ['id' => 'father_id', 'title' => trans('messages.abroad.father_id'), 'checked' => true],
                ['id' => 'mother_id', 'title' => trans('messages.abroad.mother_id'), 'checked' => true],
                ['id' => 'code', 'title' => trans('messages.abroad.code'), 'checked' => true],
                ['id' => 'manager', 'title' => trans('messages.abroad.manager'), 'checked' => true],
                ['id' => 'status_abroad', 'title' => trans('messages.abroad.status_abroad'), 'checked' => true],
                ['id' => 'apply', 'title' => trans('messages.abroad.apply'), 'checked' => true], 
                ['id' => 'nvtvdhcl', 'title' => trans('messages.abroad.nvtvdhcl'), 'checked' => true],
                ['id' => 'nvttsk', 'title' => trans('messages.abroad.nvttsk'), 'checked' => true],
                ['id' => 'created_at', 'title' => trans('messages.abroad.created_at'), 'checked' => true],
                ['id' => 'updated_at', 'title' => trans('messages.abroad.updated_at'), 'checked' => true],
            ],
        ]);
    }

    public function list(Request $request)
    {
        $query = AbroadApplication::query();

        if ($request->key) {
            $query = $query->search($request->key);
        }

        if ($request->status === 'assigned-account') {
            $query = $query->filterByAssignedAcount();
        }

        if ($request->status === 'waiting') {
            $query = $query->filterByWaiting();
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

        if ($request->has('created_at_from') && $request->has('created_at_to')) {
            $created_at_from = $request->input('created_at_from');
            $created_at_to = $request->input('created_at_to');
            $query = $query->filterByCreatedAt($created_at_from, $created_at_to);
        }

        if ($request->has('updated_at_from') && $request->has('updated_at_to')) {
            $updated_at_from = $request->input('updated_at_from');
            $updated_at_to = $request->input('updated_at_to');
            $query = $query->filterByUpdatedAt($updated_at_from, $updated_at_to);
        }

        if ($request->abroadStatuses) {
            $query = $query->filterByAbroadStatus($request->abroadStatuses);
        }

        $sortColumn = $request->sort_by ?? 'updated_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query = $query->sortList($sortColumn, $sortDirection);
        $abroadApplications = $query->paginate($request->perpage ?? 10);

        return view('abroad.list', [
            'abroadApplications' => $abroadApplications,
            'columns' => $request->columns ?? [],
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
            'status' => $request->status
        ]);
    }

    public function getServicesByType(Request $request)
    {
        return AbroadService::getServiceByType($request->type);
    }

    public function general(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $accounts = Account::sales()->get();

        return view('abroad.general', [
            'abroadApplication' => $abroadApplication,
            'accounts' => $accounts,
        ]);
    }

    public function essay(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $accounts = Account::sales()->get();

        return view('abroad.essay', [
            'abroadApplication' => $abroadApplication,
            'accounts' => $accounts,
        ]);
    }

    public function deleteAll(Request $request)
    {
        if (!empty($request->items)) {
            AbroadApplication::destroyAll($request->items);

            return response()->json([
                'status' => 'success',
                'messages' => 'Xóa thành công các hồ sơ!',
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'messages' => 'Xóa các hồ sơ thất bại!'
        ]);
    }

    // IV.1 Lộ trình học thuật chiến lược
    public function strategicLearningCurriculum(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        $checkFill = LoTrinhHocThuatChienLuoc::isCheckFill($request->id);

        return view('sales.customers.abroad_applications.applicationParts.strategic_learning_curriculum.strategicLearningCurriculum', [
            'abroadApplication' => $abroadApplication,
            'dayFinish' => $dayFinish,
            'checkFill'=>$checkFill
        ]);
    }

    // IV Lộ trình học thuật chiến lược
    public function declareStrategicLearningCurriculum(Request $request)
    {
        $loTrinhHocThuatChienLuocDatas = LoTrinhHocThuatChienLuoc::where('abroad_application_id', $request->id);
        $abroadApplication = AbroadApplication::find($request->id);
        $loTrinhHocThuatChienLuoc =config('loTrinhHocThuatChienLuoc');

        return view('sales.customers.abroad_applications.applicationParts.strategic_learning_curriculum.declareStrategicLearningCurriculum',
        [
            'abroadApplication'=> $abroadApplication,
            'loTrinhHocThuatChienLuoc'=>$loTrinhHocThuatChienLuoc,
            'loTrinhHocThuatChienLuocDatas'=>$loTrinhHocThuatChienLuocDatas
        ]);
    }

    // IV 1
    public function viewStrategicLearningCurriculum(Request $request)
    {
        $loTrinhHocThuatChienLuocDatas = LoTrinhHocThuatChienLuoc::where('abroad_application_id', $request->id);
        $loTrinhHocThuatChienLuoc =config('loTrinhHocThuatChienLuoc');

        return view('sales.customers.abroad_applications.applicationParts.strategic_learning_curriculum.viewStrategicLearningCurriculum', [
            'loTrinhHocThuatChienLuoc'=>$loTrinhHocThuatChienLuoc,
            'loTrinhHocThuatChienLuocDatas'=>$loTrinhHocThuatChienLuocDatas
        ]);
    }

    // IV.2 Lộ trình hoạt động ngoại khoá
    public function extracurricularPlan(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        $checkFill = LoTrinhHoatDongNgoaiKhoa::isCheckFill($request->id);
        return view('sales.customers.abroad_applications.applicationParts.extracurricular_plan.content', [
            'abroadApplication' => $abroadApplication,
            'dayFinish' => $dayFinish,
            'checkFill'=> $checkFill
        ]);
    }
   
    public function declareExtracurricularPlan(Request $request)
    {
        $loTrinhHoatDongNgoaiKhoaDatas = LoTrinhHoatDongNgoaiKhoa::where('abroad_application_id', $request->id);
        $abroadApplication = AbroadApplication::find($request->id);
        $loTrinhHoatDongNgoaiKhoa =config('loTrinhHoatDongNgoaiKhoa');

        return view('sales.customers.abroad_applications.applicationParts.extracurricular_plan.declare', 
        [
            'abroadApplication'=> $abroadApplication,
            'loTrinhHoatDongNgoaiKhoa'=>$loTrinhHoatDongNgoaiKhoa,
            'loTrinhHoatDongNgoaiKhoaDatas'=>$loTrinhHoatDongNgoaiKhoaDatas
        ]);
    }

    public function viewExtracurricularPlanDeclaration(Request $request)
    {
        $loTrinhHoatDongNgoaiKhoaDatas = LoTrinhHoatDongNgoaiKhoa::where('abroad_application_id', $request->id);
        $abroadApplication = AbroadApplication::find($request->id);
        $loTrinhHoatDongNgoaiKhoa =config('loTrinhHoatDongNgoaiKhoa');

        return view('sales.customers.abroad_applications.applicationParts.extracurricular_plan.view_declaration', [
            'abroadApplication'=> $abroadApplication,
            'loTrinhHoatDongNgoaiKhoa'=>$loTrinhHoatDongNgoaiKhoa,
            'loTrinhHoatDongNgoaiKhoaDatas'=>$loTrinhHoatDongNgoaiKhoaDatas
        ]);
    }

    // IV.7 Show recommendation letter
    public function recommendationLetter(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $draftPaths = $abroadApplication->getAllRecommendationLetterFiles(RecommendationLetter::STATUS_DRAFT);
        $activePaths = $abroadApplication->getAllRecommendationLetterFiles(RecommendationLetter::STATUS_ACTIVE);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();

        return view('sales.customers.abroad_applications.applicationParts.recommendation_letter.content', [
            'abroadApplication' => $abroadApplication,
            'draftPaths' => $draftPaths,
            'activePaths' => $activePaths,
            'dayFinish' => $dayFinish
        ]);
    }

    // IV.7 Create
    public function createRecommendationLetter(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $account = $request->user()->account;

        return view('sales.customers.abroad_applications.applicationParts.recommendation_letter.create', [
            'abroadApplication' => $abroadApplication,
            'account' => $account,
        ]);
    }

    // IV.7 Edit
    public function editRecommendationLetter(Request $request)
    {
        $recommendationLetter = RecommendationLetter::find($request->id);
        $abroadApplication = $recommendationLetter->abroadApplication;
        $account = $request->user()->account;

        return view('sales.customers.abroad_applications.applicationParts.recommendation_letter.edit', [
            'recommendationLetter' => $recommendationLetter,
            'abroadApplication' => $abroadApplication,
            'account' => $account,
        ]);
    }

    // IV.7 Update
    public function updateRecommendationLetter(Request $request)
    {
        $recommendationLetter = RecommendationLetter::find($request->id);
        $abroadApplication = $recommendationLetter->abroadApplication;
        $account = $request->user()->account;

        if (!$recommendationLetter) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy thư giới thiệu này trong dữ liệu!'
            ], 404);
        }

        $errors = $recommendationLetter->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.customers.abroad_applications.applicationParts.recommendation_letter.edit', [
                'recommendationLetter' => $recommendationLetter,
                'abroadApplication' => $abroadApplication,
                'account' => $account,
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Cập nhật thư giới thiệu thành công!'
        ], 200);
    }

    // IV.7 Delete
    public function deleteRecommendationLetter(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        if (!$abroadApplication) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy hồ sơ này trong dữ liệu!'
            ], 404);
        }

        $errors = $abroadApplication->deleteRecommendationLetterFileFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa thư thành công!'
        ], 200);
    }

    // IV.7 Show detail recommendation letter
    public function showDetailRecommendationLetter(Request $request)
    {
        $recommendationLetter = RecommendationLetter::find($request->id);

        return view('sales.customers.abroad_applications.applicationParts.recommendation_letter.show', [
            'recommendationLetter' => $recommendationLetter
        ]);
    }

    // IV.7 Store
    public function storeRecommendationLetter(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $account = $request->user()->account;
        $errors = $abroadApplication->uploadRecommendationLetterFileFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Tạo mới thư giới thiệu thành công!'
        ], 201);
    }

    public function completeRecommendationLetter(Request $request)
    {
        $recommendationLetter = RecommendationLetter::find($request->id);

        if ($recommendationLetter) {
            $recommendationLetter->complete();

            return response()->json([
                'status' => "success",
                'messages' => "Đã đánh dấu hoàn thành"
            ], 200);
        }

        return response()->json([
            'status' => "fail",
            'messages' => "Không tìm thấy dữ liệu của thư giới thiệu này!"
        ], 400);
    }

    // IV.8 Show essay result 
    public function essayResult(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $essayResults = EssayResult::getByAbroadApplicationId($abroadApplication->id);
        $paths = $abroadApplication->getAllEssayResultFiles();
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        $checkFill = EssayResult::isCheckFill($request->id);
        return view('sales.customers.abroad_applications.applicationParts.essay_result.content', [
            'abroadApplication' => $abroadApplication,
            'paths' => $paths,
            'essayResults' => $essayResults,
            'dayFinish' => $dayFinish,
            'checkFill'=>$checkFill

        ]);
    }

    // IV.8 Create
    public function createEssayResult(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        return view('sales.customers.abroad_applications.applicationParts.essay_result.create', [
            'abroadApplication' => $abroadApplication,
        ]);
    }

    // IV.8 Store
    public function storeEssayResult(Request $request)
    {
        $essayResult = EssayResult::newDefault();
        $errors = $essayResult->saveFromRequest($request);
        
        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $errors->all(),
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Tạo mới kết quả chấm luận thành công!'
        ], 201);
    }

    // IV.8 Show 
    public function showEssayResult(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $essayResults = EssayResult::getByAbroadApplicationId($abroadApplication->id);

        return view('sales.customers.abroad_applications.applicationParts.essay_result.show', [
            'essayResults' => $essayResults
        ]);
    }

    // IV.8 Delete
    public function deleteEssayResult(Request $request, $id)
    {
        $essayResult = EssayResult::find($id);
        $essayResult->deleteWithFile();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa kết quả thành công',
        ]);
    }

    public function deleteEssayResultFile(Request $request)
    { 
        $essayResult = EssayResult::find($request->id);
        $essayResult->deleteFile();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa kết quả thành công',
        ]);
    }

    // IV.8 Edit
    public function editEssayResult(Request $request, $id)
    {
        $essayResult = EssayResult::find($id);
        $abroadApplication = $essayResult->abroadApplication;

        return view('sales.customers.abroad_applications.applicationParts.essay_result.edit', [
            'essayResult' => $essayResult,
            'abroadApplication' => $abroadApplication,
        ]);
    }

    // IV.8 Update
    public function updateEssayResult(Request $request, $id)
    {
        $essayResult = EssayResult::find($id);
        $abroadApplication = $essayResult->abroadApplication;
      
        if (!$essayResult) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy kết quả này trong dữ liệu!'
            ], 404);
        }
        
        $errors = $essayResult->updateFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.customers.abroad_applications.applicationParts.essay_result.edit', [
                'essayResult' => $essayResult,
                'abroadApplication' => $abroadApplication,
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Cập nhật thư giới thiệu thành công!'
        ], 200);
    }

    // IV.8 Mạng xã hội 
    public function socialNetwork(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $socialNetworks = SocialNetwork::getByAbroadApplication($abroadApplication->id);
        $accounts = Account::sales()->get();
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        $checkFill = SocialNetwork::isCheckFill($request->id);
        return view('sales.customers.abroad_applications.applicationParts.socialNetwork.socialNetwork', [
            'accounts' => $accounts,
            'abroadApplication' => $abroadApplication,
            'socialNetworks' => $socialNetworks,
            'dayFinish' => $dayFinish,
            'checkFill'=>$checkFill
        ]);
    }

    public function socialNetworkDeclaration(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $socialNetworks = SocialNetwork::getByAbroadApplication($abroadApplication->id);
        
        return view('sales.customers.abroad_applications.applicationParts.socialNetwork.socialNetworkDeclaration', [
            'abroadApplication' => $abroadApplication,
            'socialNetworks' => $socialNetworks
        ]);
    }

    public function updateSocialNetwork(Request $request, $id)
    {
        $socialNetwork = SocialNetwork::find($id);

        return view('sales.customers.abroad_applications.applicationParts.socialNetwork.updateSocialNetwork', [
            'socialNetwork' => $socialNetwork
        ]);
    }

    public function doneUpdateSocialNetwork(Request $request, $id)
    {
        $socialNetwork = SocialNetwork::find($id);
        $socialNetwork->updateSocialNetworkLink($request->link);

        return response()->json([
            'message' => 'Cập nhật Mạng xã hội thành công'
        ]);
    }

    public function createSocialNetwork(Request $request, $id)
    {
        return view('sales.customers.abroad_applications.applicationParts.socialNetwork.createSocialNetwork', [
            'id' => $id,
        ]);
    }

    public function doneCreateSocialNetwork(Request $request)
    {
        SocialNetwork::createSocialNetworkLink($request);

        return response()->json([
            'message' => 'Thêm mới Mạng xã hội thành công'
        ]);
    }

    public function updateActiveSocialNetwork(Request $request)
    {
        $socialNetwork = new SocialNetwork();
        $socialNetwork->updateActiveSocialNetwork();

        return response()->json([
            'message' => 'Hoàn thành mạng xã hội'
        ]);
    }

    public function socialNetworkShow(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $socialNetworks = SocialNetwork::getByAbroadApplication($abroadApplication->id);
        
        return view('sales.customers.abroad_applications.applicationParts.socialNetwork.socialNetworkShow', [
            'abroadApplication' => $abroadApplication,
            'socialNetworks' => $socialNetworks
        ]);
    }

    // Hồ sơ du học
    public function studyAbroadApplication(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        $checkFill = StudyAbroadApplication::isCheckFill($request->id);
        return view('sales.customers.abroad_applications.applicationParts.studyAbroadApplication.content', [
            'abroadApplication' => $abroadApplication,
            'dayFinish'=>$dayFinish,
            'checkFill'=>$checkFill
        ]);
    }

    public function showStudyAbroadApplication(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $studyAbroadApplications = StudyAbroadApplication::getByAbroadApplicationId($abroadApplication->id);

        return view('sales.customers.abroad_applications.applicationParts.studyAbroadApplication.show', [
            'abroadApplication' => $abroadApplication,
            'studyAbroadApplications' => $studyAbroadApplications,
        ]);
    }

    public function storeFileStudyAbroadApplication(Request $request)
    {
        $applicationSchool = ApplicationSchool::find($request->id);
       
        if (!$applicationSchool) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Application school not found'
            ], 404);
        }
        
        $errors = $applicationSchool->uploadStudyAbroadApplicationFile($request);

        if (empty($errors)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Upload file hồ sơ du học thành công!'
            ], 201);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => $errors
            ], 400);
        }
    }

    public function deleteFileStudyAbroadApplication(Request $request)
    {
        $applicationSchool = ApplicationSchool::find($request->id);
    
        if (!$applicationSchool) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy hồ sơ này trong dữ liệu!'
            ], 404);
        }

        $applicationSchool->deleteFileStudyAbroadApplication(); 
        
        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa file xác nhận học bổng thành công!'
        ], 200);
    }
   

    public function createStudyAbroadApplication(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $studyAbroadApplications = StudyAbroadApplication::getByAbroadApplicationId($abroadApplication->id);
        $applicationSchools = ApplicationSchool::getByAbroadApplication($abroadApplication->id);

         return view('sales.customers.abroad_applications.applicationParts.studyAbroadApplication.create', [
            'abroadApplication' => $abroadApplication,
            'applicationSchools' => $applicationSchools,
            'studyAbroadApplications' => $studyAbroadApplications,
        ]);
    }


    public function createStudyAbroadApplicationPopup(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        return view('sales.customers.abroad_applications.applicationParts.studyAbroadApplication.createStudyAbroadApplicationPopup', [
            'abroadApplication' => $abroadApplication,
        ]);
    }

    public function saveStudyAbroadApplication(Request $request)
    {
        $studyAbroadApplication = StudyAbroadApplication::newDefault();
        $errors = $studyAbroadApplication->saveFromRequest($request);
        
        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $errors->all(),
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Tạo mới hồ sơ du học thành công!'
        ], 201);
    }

    public function updateStatusStudyAbroadApplicationAll(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            StudyAbroadApplication::where('abroad_application_id', $id)->update(['status' => 'active']);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật trạng thái thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái!'
            ]);
        }
    }
   
    public function editStudyAbroadApplicationPopup(Request $request, $id)
    {
        $studyAbroadApplication = StudyAbroadApplication::find($id);

        return view('sales.customers.abroad_applications.applicationParts.studyAbroadApplication.editStudyAbroadApplicationPopup', [
            'studyAbroadApplication' => $studyAbroadApplication
        ]);
    }
 
    public function updateStudyAbroadApplication(Request $request, $id)
    {
        $studyAbroadApplication = StudyAbroadApplication::find($id);
        $abroadApplication = $studyAbroadApplication->abroadApplication;
        
        if (!$studyAbroadApplication) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy kết quả này trong dữ liệu!'
            ], 404);
        }

        $errors = $studyAbroadApplication->saveFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.customers.abroad_applications.applicationParts.essay_result.edit', [
                'studyAbroadApplication' => $studyAbroadApplication,
                'abroadApplication' => $abroadApplication,
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Cập nhật hồ sơ thành công!'
        ], 200);
    }

    public function completeStatusActive(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $application = StudyAbroadApplication::findOrFail($id);
            $application->update(['status' => 'active']);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật trạng thái thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái!'
            ]);
        }
    }
    
    // public function storeFileFeePaid(Request $request)
    // {
    //     $applicationSchool = ApplicationSchool::find($request->id);
       
    //     if (!$applicationSchool) {
    //         return response()->json([
    //             'status' => 'fail',
    //             'message' => 'Application school not found'
    //         ], 404);
    //     }
        
    //     $errors = $applicationSchool->uploadFeePaidFileFromRequest($request);

    //     if (empty($errors)) {
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Upload file đóng phí hồ sơ thành công!'
    //         ], 201);
    //     } else {
    //         return response()->json([
    //             'status' => 'fail',
    //             'message' => $errors
    //         ], 400);
    //     }
    // }

    // public function deleteFileComfirmation(Request $request)
    // {
    //     $applicationSchool = ApplicationSchool::find($request->id);
        
    //     if (!$applicationSchool) {
    //         return response()->json([
    //             'status' => 'not found!',
    //             'messages' => 'Không tìm thấy hồ sơ này trong dữ liệu!'
    //         ], 404);
    //     }

    //     $applicationSchool->deleteFileComfirmationFromRequest(); 
    //     return response()->json([
    //         'status' => 'success',
    //         'messages' => 'Xóa xác nhận dự tuyển thành công!'
    //     ], 200);
    // }

    // IV.11 Student CV
    public function studentCV(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $paths = $abroadApplication->getAllCVFiles();
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();

        return view('sales.customers.abroad_applications.applicationParts.student_cv.content', [
            'abroadApplication' => $abroadApplication,
            'paths' => $paths,
            'dayFinish'=>$dayFinish
        ]);
    }

    // IV.11 Create
    public function createCV(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $account = $request->user()->account;

        return view('sales.customers.abroad_applications.applicationParts.student_cv.create', [
            'abroadApplication' => $abroadApplication,
            'account' => $account,
        ]);
    }

    // IV.11 Store
    public function storeCV(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $account = $request->user()->account;
        $errors = $abroadApplication->uploadCVFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Upload CV thành công!'
        ], 201);
    }

    // IV.11 Delete
    public function deleteCV(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        if (!$abroadApplication) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy hồ sơ này trong dữ liệu!'
            ], 404);
        }

        $errors = $abroadApplication->deleteCVFileFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa CV thành công!'
        ], 200);
    }

    ///Hồ sơ dự tuyển
    public function hsdt(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        
        return view('sales.customers.abroad_applications.applicationParts.hsdt.hsdt', [
            'abroadApplication' => $abroadApplication, 
        ]);
    }
    public function requestApprovalHSDT(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $abroadApplication->requestApproval();

        return response()->json([
            'status' => 'success',
            'message' => 'Hồ sơ đã được yêu cầu duyệt thành công',
        ]);
    }

    public function approveHSDT(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);

        $abroadApplication->duyetHoSoDuTuyen();

        return response()->json([
            'status' => 'success',
            'message' => 'Hồ sơ đã được duyệt thành công',
        ]);
    }

    public function rejectHSDT(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);

        $abroadApplication->rejectHSDT(); 

        return response()->json([
            'status' => 'success',
            'message' => 'Hồ sơ đã được từ chối thành công',
        ]);
    }

    // Hồ sơ hoàn chỉnh
    public function completeFile(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $paths = $abroadApplication->getAllCompleteFiles();
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();

        return view('sales.customers.abroad_applications.applicationParts.completeFile.completeFile', [
            'abroadApplication' => $abroadApplication,
            'paths' => $paths,
            'dayFinish'=>$dayFinish,
        ]);
    }

    public function storeCompleteFile(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $account = $request->user()->account;
        $errors = $abroadApplication->uploadCompleteFileFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Upload file thành công!'
        ], 201);
    }

    public function deleteCompleteFile(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        if (!$abroadApplication) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy hồ sơ này trong dữ liệu!'
            ], 404);
        }

        $errors = $abroadApplication->deleteCompleteFile($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa file thành công!'
        ], 200);
    }

    // V.1
    public function honorThesis(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $courses = $abroadApplication->getCoursesWithAbroadService('Luận');
        $studentSections = collect();

        foreach ($courses as $course) { 
            foreach ($course->sections as $section) {
                $studentSections = $studentSections->merge($section->studentSections);
            }
        }

        $presentSessionsCount = $studentSections->where('status', StudentSection::STATUS_PRESENT)->count();
        $cancelSessionsCount = $studentSections->whereIn('status', [StudentSection::STATUS_RESERVE])->count();
         
        return view('sales.customers.abroad_applications.activities.honor_thesis.honorThesis', [
            'studentSections' => $studentSections,
            'presentSessionsCount' => $presentSessionsCount,
            'cancelSessionsCount' => $cancelSessionsCount
        ]);
    }

    // V.2 Sửa Luận
    public function editThesis(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $courses = $abroadApplication->getCoursesWithAbroadService('Edits');
        $studentSections = collect();

        foreach ($courses as $course) { 
            foreach ($course->sections as $section) {
                $studentSections = $studentSections->merge($section->studentSections);
            }
        }

        $presentSessionsCount = $studentSections->where('status', StudentSection::STATUS_PRESENT)->count();
        $cancelSessionsCount = $studentSections->whereIn('status', [StudentSection::STATUS_RESERVE])->count();

        return view('sales.customers.abroad_applications.activities.edit_thesis.editThesis', [
            'studentSections' => $studentSections,
            'presentSessionsCount' => $presentSessionsCount,
            'cancelSessionsCount' => $cancelSessionsCount
        ]);
    }

    // V.5 Luyện phỏng vấn
    public function interviewPractice(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $courses = $abroadApplication->getCoursesWithAbroadService('Interview');
        $studentSections = collect();

        foreach ($courses as $course) { 
            foreach ($course->sections as $section) {
                $studentSections = $studentSections->merge($section->studentSections);
            }
        }

        $presentSessionsCount = $studentSections->where('status', StudentSection::STATUS_PRESENT)->count();
        $cancelSessionsCount = $studentSections->whereIn('status', [StudentSection::STATUS_RESERVE])->count();

        return view('sales.customers.abroad_applications.activities.interview_practice.interviewPractice', [
            'studentSections' => $studentSections,
            'presentSessionsCount' => $presentSessionsCount,
            'cancelSessionsCount' => $cancelSessionsCount
        ]);
    }

    // VI.6 Thời điểm học viên lên đường
    public function flyingStudent(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $flyingStudents = FlyingStudent::getByAbroadApplicationId($abroadApplication->id);

        return view('sales.customers.abroad_applications.activities.flying_student.flyingStudent', [
            'abroadApplication' => $abroadApplication,
            'flyingStudents' => $flyingStudents,
        ]);
    }

    public function createFlyingStudent(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        return view('sales.customers.abroad_applications.activities.flying_student.createFlyingStudent', [
            'abroadApplication' => $abroadApplication,
        ]);
    }

    public function doneCreateFlyingStudent(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $flyingStudent = FlyingStudent::newDefault();    
        $errors = $flyingStudent->saveFlyingStudent($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'abroadApplication' => $abroadApplication,
                'status' => 'fail',
                'errors' => $errors->all(),
            ], 400);
        }

        return response()->json([
            'message' => 'Cập nhật thành công'
        ]);
    }

    public function updateFlyingStudent(Request $request, $id)
    {
        $flyingStudent = FlyingStudent::find($id);
        $abroadApplication = $flyingStudent->abroadApplication;

        return view('sales.customers.abroad_applications.activities.flying_student.updateFlyingStudent', [
            'flyingStudent' => $flyingStudent,
            'abroadApplication' => $abroadApplication,
        ]);
    }

    public function doneUpdateFlyingStudent(Request $request, $id)
    {
        $flyingStudent = FlyingStudent::find($id);
        $abroadApplication = $flyingStudent->abroadApplication;
       
        if (!$flyingStudent) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy kết quả này trong dữ liệu!'
            ], 404);
        }

        $errors = $flyingStudent->saveFlyingStudent($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.customers.abroad_applications.activities.flying_student.updateFlyingStudent', [
                'flyingStudent' => $flyingStudent,
                'abroadApplication' => $abroadApplication,
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Cập nhật thành công!'
        ], 200);
    }

    // V.2 applicationFee
    public function applicationFee(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $applicationFees = ApplicationFee::getByAbroadApplicationId($abroadApplication->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        $checkFill = ApplicationSchool::isCheckFillApplicationFee($request->id);
        return view('sales.customers.abroad_applications.activities.applicationFee.applicationFee', [
            'abroadApplication' => $abroadApplication,
            'applicationFees' => $applicationFees,
            'dayFinish'=>$dayFinish,
            'checkFill'=>$checkFill
        ]);
    }

    public function showPayAndConfirm(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $applicationSchools = ApplicationSchool::getByAbroadApplication($abroadApplication->id);
        
        return view('sales.customers.abroad_applications.activities.applicationFee.showPayAndConfirm', [
            'abroadApplication' => $abroadApplication,
            'applicationSchools' => $applicationSchools
        ]);
    }

    public function payAndConfirm(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $applicationSchools = ApplicationSchool::getByAbroadApplication($abroadApplication->id);
        
        return view('sales.customers.abroad_applications.activities.applicationFee.payAndConfirm', [
            'abroadApplication' => $abroadApplication,
            'applicationSchools' => $applicationSchools
        ]);
    }

    public function storeFileConfirmation(Request $request)
    {
        $applicationSchool = ApplicationSchool::find($request->id);
        
        if (!$applicationSchool) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Application school not found'
            ], 404);
        }
        
        $errors = $applicationSchool->uploadConfirmationFileFromRequest($request);

        if (empty($errors)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Upload file hồ sơ xác nhận dự tuyển thành công!'
            ], 201);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => $errors
            ], 400);
        }
    }

    public function storeFileFeePaid(Request $request)
    {
        $applicationSchool = ApplicationSchool::find($request->id);
       
        if (!$applicationSchool) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Application school not found'
            ], 404);
        }
        
        $errors = $applicationSchool->uploadFeePaidFileFromRequest($request);

        if (empty($errors)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Upload file đóng phí hồ sơ thành công!'
            ], 201);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => $errors
            ], 400);
        }
    }

    public function deleteFileComfirmation(Request $request)
    {
        $applicationSchool = ApplicationSchool::find($request->id);
        
        if (!$applicationSchool) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy hồ sơ này trong dữ liệu!'
            ], 404);
        }

        $applicationSchool->deleteFileComfirmationFromRequest(); 
        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa xác nhận dự tuyển thành công!'
        ], 200);
    }

    public function deleteFileFeePaid(Request $request)
    {
        $applicationSchool = ApplicationSchool::find($request->id);
    
        if (!$applicationSchool) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy hồ sơ này trong dữ liệu!'
            ], 404);
        }

        $applicationSchool->deleteFileFeePaidFromRequest(); 
        
        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa file đóng phí hồ sơ thành công!'
        ], 200);
    }

    public function createApplicationFee(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        
        return view('sales.customers.abroad_applications.activities.applicationFee.create', [
            'abroadApplication' => $abroadApplication,
        ]);
    }

    public function doneCreateApplicationFee(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $applicationFee = ApplicationFee::newDefault();
        $errors = $applicationFee->saveApplicationFee($request);
        
        if (!$errors->isEmpty()) {
            return response()->json([
                'abroadApplication' => $abroadApplication,
                'status' => 'fail',
                'errors' => $errors->all(),
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Tạo phiếu đóng phí hồ sơ thành công!'
        ], 201);
    }

    public function editApplicationFee(Request $request, $id)
    {
        $applicationFee = ApplicationFee::find($id);
        $abroadApplication = $applicationFee->abroadApplication;

        return view('sales.customers.abroad_applications.activities.applicationFee.edit', [
            'applicationFee' => $applicationFee,
            'abroadApplication' => $abroadApplication,
        ]);
    }

    // V.2 Update
    public function updateApplicationFee(Request $request, $id)
    {
        $applicationFee = ApplicationFee::find($id);
        $abroadApplication = $applicationFee->abroadApplication;
        
        if (!$applicationFee) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy kết quả này trong dữ liệu!'
            ], 404);
        }

        $errors = $applicationFee->saveApplicationFee($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.customers.abroad_applications.activities.applicationFee.edit', [
                'applicationFee' => $applicationFee,
                'abroadApplication' => $abroadApplication,
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Cập nhật đóng phí hồ sơ thành công!'
        ], 200);
    }

    // V.3 submit application
    public function applicationSubmission(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $applicationSubmissions = ApplicationSubmission::getByAbroadApplicationId($abroadApplication->id);

        return view('sales.customers.abroad_applications.activities.applicationSubmission.applicationSubmission', [
            'abroadApplication' => $abroadApplication,
            'applicationSubmissions' => $applicationSubmissions
        ]);
    }

    public function createApplicationSubmission(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        
        return view('sales.customers.abroad_applications.activities.applicationSubmission.create', [
            'abroadApplication' => $abroadApplication,
        ]);
    }

    public function doneApplicationSubmission(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $applicationFee = ApplicationSubmission::newDefault();
        $errors = $applicationFee->saveApplicationSubmission($request);
        
        if (!$errors->isEmpty()) {
            return response()->json([
                'abroadApplication' => $abroadApplication,
                'status' => 'fail',
                'errors' => $errors->all(),
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Nộp hồ sơ thành công!'
        ], 201);
    }

    public function editApplicationSubmission(Request $request, $id)
    {
        $applicationSubmission = ApplicationSubmission::find($id);
        $abroadApplication = $applicationSubmission->abroadApplication;

        return view('sales.customers.abroad_applications.activities.applicationSubmission.edit', [
            'applicationSubmission' => $applicationSubmission,
            'abroadApplication' => $abroadApplication,
        ]);
    }

    // V.2 Update
    public function updateApplicationSubmission(Request $request, $id)
    {
        $applicationSubmission = ApplicationSubmission::find($id);
        $abroadApplication = $applicationSubmission->abroadApplication;
        
        if (!$applicationSubmission) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy kết quả này trong dữ liệu!'
            ], 404);
        }

        $errors = $applicationSubmission->saveApplicationSubmission($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.customers.abroad_applications.activities.applicationSubmission.edit', [
                'applicationSubmission' => $applicationSubmission,
                'abroadApplication' => $abroadApplication,
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Cập nhật hồ sơ thành công!'
        ], 200);
    }

    // V.5
    public function applicationAdmittedSchool(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $applicationAdmittedSchools = $abroadApplication->applicationSchool()->study()->get();
        
        return view('sales.customers.abroad_applications.activities.applicationAdmittedSchool.applicationAdmittedSchool', [
            'abroadApplication' => $abroadApplication,
            'applicationAdmittedSchools' => $applicationAdmittedSchools
        ]);
    }

    public function createApplicationAdmittedSchool(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        
        return view('sales.customers.abroad_applications.activities.applicationAdmittedSchool.create', [
            'abroadApplication' => $abroadApplication,
        ]);
    }

    public function doneApplicationAdmittedSchool(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $applicationAdmittedSchool = ApplicationAdmittedSchool::newDefault();
        $errors = $applicationAdmittedSchool->saveApplicationAdmittedSchool($request);
        
        if (!$errors->isEmpty()) {
            return response()->json([
                'abroadApplication' => $abroadApplication,
                'status' => 'fail',
                'errors' => $errors->all(),
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Nộp hồ sơ thành công!'
        ], 201);
    }

    public function saveSchoolSelected(Request $request, $id)
    {
        $applicationAdmittedSchool = ApplicationAdmittedSchool::find($id);

        if ($request->selected) {
            $applicationAdmittedSchool->updateSchoolSelected($request->selected);
        }

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function editApplicationAdmittedSchool(Request $request, $id)
    {
        $applicationAdmittedSchool = ApplicationAdmittedSchool::find($id);
        $abroadApplication = $applicationAdmittedSchool->abroadApplication;

        return view('sales.customers.abroad_applications.activities.applicationAdmittedSchool.edit', [
            'applicationAdmittedSchool' => $applicationAdmittedSchool,
            'abroadApplication' => $abroadApplication,
        ]);
    }

    // V.2 Update
    public function updateApplicationAdmittedSchool(Request $request, $id)
    {
        $applicationAdmittedSchool = ApplicationAdmittedSchool::find($id);
        $abroadApplication = $applicationAdmittedSchool->abroadApplication;
        
        if (!$applicationAdmittedSchool) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy kết quả này trong dữ liệu!'
            ], 404);
        }

        $errors = $applicationAdmittedSchool->saveApplicationAdmittedSchool($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.customers.abroad_applications.activities.applicationAdmittedSchool.edit', [
                'applicationAdmittedSchool' => $applicationAdmittedSchool,
                'abroadApplication' => $abroadApplication,
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Cập nhật trường thành công!'
        ], 200);
    }

    // V.6
    public function depositTuitionFee(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $paths = $abroadApplication->getAllDepositFiles();

        return view('sales.customers.abroad_applications.activities.deposit_tuition_fee.content', [
            'abroadApplication' => $abroadApplication,
            'paths' => $paths,
        ]);
    }

    public function updateDepositData(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $paths = $abroadApplication->getAllDepositFiles();
        $errors = $abroadApplication->saveDepositDataFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->view('sales.customers.abroad_applications.activities.deposit_tuition_fee.content', [
                'abroadApplication' => $abroadApplication,
                'paths' => $paths,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Update thành công!'
        ], 200);
    }

    // V.6 Store deposit file
    public function storeDepositFile(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $account = $request->user()->account;
        $errors = $abroadApplication->uploadDepositFileFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Upload CV thành công!'
        ], 201);
    }

    // V.6 Delete deposit file
    public function deleteDepositFile(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        if (!$abroadApplication) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy hồ sơ du học này trong dữ liệu!'
            ], 404);
        }

        $errors = $abroadApplication->deleteDepositFileFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa phiếu đặt cọc thành công!'
        ], 200);
    }

    // VI.2 Deposit for school
    public function depositForSchool(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $paths = $abroadApplication->getAllDepositSchools();
        
        return view('sales.customers.abroad_applications.activities.depositForSchool.depositForSchool', [
            'abroadApplication' => $abroadApplication,
            'paths' => $paths,
        ]);
    }

    public function updateDepositForSchool(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $paths = $abroadApplication->getAllDepositSchools();
        $errors = $abroadApplication->saveDepositForSchoolFromRequest($request);
        
        if (!$errors->isEmpty()) {
            return response()->view('sales.customers.abroad_applications.activities.depositForSchool.depositForSchool', [
                'abroadApplication' => $abroadApplication,
                'paths' => $paths,
                'errors' => $errors,
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Update thành công!'
        ], 200);
    }

    // VI.2 Store deposit for school
    public function storeDepositForSchool(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $errors = $abroadApplication->uploadDepositForSchoolFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Upload CV thành công!'
        ], 201);
    }

    // VI.2 Delete deposit for school
    public function deleteDepositForSchool(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        if (!$abroadApplication) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy hồ sơ du học này trong dữ liệu!'
            ], 404);
        }

        $errors = $abroadApplication->deleteDepositForSchoolFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa phiếu đặt cọc thành công!'
        ], 200);
    }

    // V.9
    public function culturalOrientations(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $culturalOrientation = CulturalOrientation::getByAbroadApplicationId($abroadApplication->id);

        return view('sales.customers.abroad_applications.activities.culturalOrientations.culturalOrientations', [
            'abroadApplication' => $abroadApplication,
            'culturalOrientation' => $culturalOrientation
        ]);
    }

    public function updateCulturalOrientation(Request $request, $id)
    {
        $culturalOrientation = CulturalOrientation::find($id);

        return view('sales.customers.abroad_applications.activities.culturalOrientations.updateCulturalOrientation', [
            'culturalOrientation' => $culturalOrientation
        ]);
    }

    public function doneUpdateCulturalOrientation(Request $request, $id)
    {
        $culturalOrientation = CulturalOrientation::find($id);

        $culturalOrientation->updateCulturalOrientation($request);

        return response()->json([
            'message' => 'Cập nhật định hướng văn hóa thành công'
        ]);
    }

    public function createCulturalOrientation(Request $request, $id)
    {
        return view('sales.customers.abroad_applications.activities.culturalOrientations.createCulturalOrientation', [
            'id' => $id,
        ]);
    }

    public function doneCreateCulturalOrientation(Request $request)
    {
        CulturalOrientation::createCulturalOrientation($request);

        return response()->json([
            'message' => 'Cập nhật định hướng văn hóa thành công'
        ]);
    }

    // V.10
    public function supportActivities(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $supportActivities = SupportActivity::getByAbroadApplicationId($abroadApplication->id);

        return view('sales.customers.abroad_applications.activities.supportActivities.supportActivities', [
            'abroadApplication' => $abroadApplication,
            'supportActivities' => $supportActivities
        ]);
    }

    public function updateSupportActivity(Request $request, $id)
    {
        $supportActivity = SupportActivity::find($id);

        return view('sales.customers.abroad_applications.activities.supportActivities.updateSupportActivity', [
            'supportActivity' => $supportActivity
        ]);
    }

    public function doneUpdateSupportActivity(Request $request, $id)
    {
        $supportActivity = SupportActivity::find($id);

        $supportActivity->updateSupportActivity($request);

        return response()->json([
            'message' => 'Cập nhật hoạt động hỗ trợ thành công'
        ]);
    }

    public function createSupportActivity(Request $request, $id)
    {
        return view('sales.customers.abroad_applications.activities.supportActivities.createSupportActivity', [
            'id' => $id,
        ]);
    }

    public function doneCreateSupportActivity(Request $request)
    {
        SupportActivity::createSupportActivity($request);

        return response()->json([
            'message' => 'Cập nhật hoạt động hỗ trợ thành công'
        ]);
    }

    // VI.7 
    public function completeApplication(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        return view('sales.customers.abroad_applications.activities.completeApplication.completeApplication', [
            'abroadApplication' => $abroadApplication, 
        ]);
    }

    public function requestApprovalCompleteApplication(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $abroadApplication->requestApprovalCompleteApplication();

        return response()->json([
            'status' => 'success',
            'message' => 'Hồ sơ đã được yêu cầu duyệt thành công',
        ]);
    }

    public function approveCompleteApplication(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);

        $abroadApplication->approveCompleteApplication();

        return response()->json([
            'status' => 'success',
            'message' => 'Hồ sơ đã được duyệt thành công',
        ]);
    }

    public function rejectCompleteApplication(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);

        $abroadApplication->rejectCompleteApplication(); 
        
        return response()->json([
            'status' => 'success',
            'message' => 'Hồ sơ đã được từ chối thành công',
        ]);
    }

    ///Kế hoạch ngoại khoá
    public function extracurricularSchedule(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $extracurricularSchedules = ExtracurricularSchedule::getByAbroadApplication($abroadApplication->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        $checkFill = ExtracurricularSchedule::isCheckFill($request->id);
        return view('sales.customers.abroad_applications.applicationParts.extracurricularSchedule.extracurricularSchedule', [
            'abroadApplication' => $abroadApplication,
            'extracurricularSchedules' => $extracurricularSchedules,
            'dayFinish' => $dayFinish,
            'checkFill' => $checkFill
        ]);
    }

    public function createExtracurricularSchedule(Request $request, $id)
    {
        return view('sales.customers.abroad_applications.applicationParts.extracurricularSchedule.createExtracurricularSchedule', [
            'id' => $id,
        ]);
    }

    public function doneCreateExtracurricularSchedule(Request $request)
    {
        ExtracurricularSchedule::createCreateExtracurricularSchedule($request);

        // $note->save();

        return response()->json([
            'message' => 'Thêm kế hoạch ngoại khoá thành công'
        ]);
    }

    public function updateExtracurricularSchedule(Request $request, $id)
    {
        $extracurricularSchedule = ExtracurricularSchedule::find($id);

        return view('sales.customers.abroad_applications.applicationParts.extracurricularSchedule.updateExtracurricularSchedule', [
            'extracurricularSchedule' => $extracurricularSchedule
        ]);
    }

    public function doneUpdateExtracurricularSchedule(Request $request, $id)
    {
        $extracurricularSchedule = ExtracurricularSchedule::find($id);
        $extracurricularSchedule->updateExtracurricularSchedule($request);

        return response()->json([
            'message' => 'Cập nhật kế hoạch thành công'
        ]);
    }

    public function extracurricularScheduleDeclaration(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $extracurricularSchedules = ExtracurricularSchedule::getByAbroadApplication($abroadApplication->id);
        
        return view('sales.customers.abroad_applications.applicationParts.extracurricularSchedule.extracurricularScheduleDeclaration', [
            'abroadApplication' => $abroadApplication,
            'extracurricularSchedules' => $extracurricularSchedules
        ]);
    }

    public function extracurricularScheduleShow(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $extracurricularSchedules = ExtracurricularSchedule::getByAbroadApplication($abroadApplication->id);
        
        return view('sales.customers.abroad_applications.applicationParts.extracurricularSchedule.extracurricularScheduleShow', [
            'abroadApplication' => $abroadApplication,
            'extracurricularSchedules' => $extracurricularSchedules
        ]);
    }

    public function updateActiveExtracurricularSchedule(Request $request)
    {
        $extracurricularSchedule = new ExtracurricularSchedule();
        $extracurricularSchedule->updateActiveExtracurricularSchedule();

        return response()->json([
            'message' => 'Kế hoạch ngoại khoá hoàn thành'
        ]);
    }

    public function updateDraftExtracurricularSchedule(Request $request)
    {
        $extracurricularSchedule = new ExtracurricularSchedule();
        $extracurricularSchedule->updateDraftExtracurricularSchedule();

        return response()->json([
            'message' => 'Đã lưu tạm kế hoạch ngoại khoá'
        ]);
    }

    ///Hoạt động ngoại khoá
    public function extracurricularActivity(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $extracurricularActivitys = ExtracurricularActivity::getByAbroadApplication($abroadApplication->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        
        return view('sales.customers.abroad_applications.applicationParts.extracurricularActivity.extracurricularActivity', [
            'abroadApplication' => $abroadApplication,
            'extracurricularActivitys' => $extracurricularActivitys,
            'dayFinish'=>$dayFinish
        ]);
    }

    public function createExtracurricularActivity(Request $request, $id)
    {
        return view('sales.customers.abroad_applications.applicationParts.extracurricularActivity.createExtracurricularActivity', [
            'id' => $id,
        ]);
    }

    public function doneCreateExtracurricularActivity(Request $request)
    {
        ExtracurricularActivity::createExtracurricularActivity($request);

        // $note->save();

        return response()->json([
            'message' => 'Thêm hoạt động ngoại khoá thành công'
        ]);
    }

    public function updateExtracurricularActivity(Request $request, $id)
    {
        $extracurricularActivity = ExtracurricularActivity::find($id);

        return view('sales.customers.abroad_applications.applicationParts.extracurricularActivity.updateExtracurricularActivity', [
            'extracurricularActivity' => $extracurricularActivity
        ]);
    }

    public function doneUpdateExtracurricularActivity(Request $request, $id)
    {
        $extracurricularActivity = ExtracurricularActivity::find($id);
        $extracurricularActivity->updateExtracurricularActivity($request);

        return response()->json([
            'message' => 'Cập nhật hoạt động ngoại khoá thành công'
        ]);
    }

    public function extracurricularActivityDeclaration(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $extracurricularActivitys = ExtracurricularActivity::getByAbroadApplication($abroadApplication->id);
        
        return view('sales.customers.abroad_applications.applicationParts.extracurricularActivity.extracurricularActivityDeclaration', [
            'abroadApplication' => $abroadApplication,
            'extracurricularActivitys' => $extracurricularActivitys
        ]);
    }
    public function extracurricularActivityShow(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        // $extracurricularActivitys = ExtracurricularActivity::getByAbroadApplication($abroadApplication->id);
        $extracurricularStudents =ExtracurricularStudent::getByContact($abroadApplication->contact_id);
       
        return view('sales.customers.abroad_applications.applicationParts.extracurricularActivity.extracurricularActivityShow', [
            'abroadApplication' => $abroadApplication,
            'extracurricularStudents' => $extracurricularStudents
        ]);
    }

    public function updateActiveExtracurricularActivity(Request $request)
    {
        $extracurricularActivity = new ExtracurricularActivity();
        $extracurricularActivity->updateActiveExtracurricularActivity();

        return response()->json([
            'message' => 'Hoạt động ngoại khoá hoàn thành'
        ]);
    }

    public function updateDraftExtracurricularActivity(Request $request)
    {
        $extracurricularActivity = new ExtracurricularActivity();
        $extracurricularActivity->updateDraftExtracurricularActivity();

        return response()->json([
            'message' => 'Đã lưu tạm hoạt động ngoại khoá'
        ]);
    }

    // public function extracurricularActivity(Request $request, $id)
    // {
    //     $abroadApplication = AbroadApplication::find($id);
    //     $extracurricularActivitys = ExtracurricularActivity::getByAbroadApplication($abroadApplication->id);
    //     
    //     return view('abroad.extracurricularActivity', [
    //         'abroadApplication' => $abroadApplication,
    //         'extracurricularActivitys' => $extracurricularActivitys
    //     ]);
    // }

    // public function createExtracurricularActivity(Request $request, $id)
    // {
    //     return view('abroad.createExtracurricularActivity', [
    //         'id' => $id,
    //     ]);
    // }

    // public function doneCreateExtracurricularActivity(Request $request)
    // {
    //     ExtracurricularActivity::createExtracurricularActivity($request);

    //     return response()->json([
    //         'message' => 'Thêm hoạt động ngoại khoá thành công'
    //     ]);
    // }

    // public function updateExtracurricularActivity(Request $request, $id)
    // {
    //     $extracurricularActivity = ExtracurricularActivity::find($id);

    //     return view('abroad.updateExtracurricularActivity', [
    //         'extracurricularActivity' => $extracurricularActivity
    //     ]);
    // }

    // public function doneUpdateExtracurricularActivity(Request $request, $id)
    // {
    //     $extracurricularActivity = ExtracurricularActivity::find($id);

    //     $extracurricularActivity->updateExtracurricularActivity($request);

    //     // $note->save();

    //     return response()->json([
    //         'message' => 'Cập nhật ngoại khoá thành công'
    //     ]);
    // }

    ///Chứng chỉ
    public function certifications(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $certifications = Certifications::getByAbroadApplication($abroadApplication->id);
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        $checkFill = Certifications::isCheckFill($request->id);
        return view('sales.customers.abroad_applications.applicationParts.certifications.certifications', [
            'abroadApplication' => $abroadApplication,
            'certifications' => $certifications,
            'dayFinish' => $dayFinish,
            'checkFill'=>$checkFill
        ]);
    }

    public function createCertifications(Request $request, $id)
    {
        return view('sales.customers.abroad_applications.applicationParts.certifications.createCertifications', [
            'id' => $id,
        ]);
    }

    public function doneCreateCertification(Request $request)
    {
        Certifications::createCertification($request);

        return response()->json([
            'message' => 'Thêm mới chứng chỉ thành công'
        ]);
    }

    public function updateCertification(Request $request, $id)
    {
        $certification = Certifications::find($id);

        return view('sales.customers.abroad_applications.applicationParts.certifications.updateCertification', [
            'certification' => $certification
        ]);
    }

    public function doneUpdateCertification(Request $request, $id)
    {
        $certification = Certifications::find($id);

        $certification->updateCertification($request);
        // $note->save();

        return response()->json([
            'message' => 'Cập nhật chứng chỉ thành công'
        ]);
    }

    public function certificationDeclaration(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $certifications = Certifications::getByAbroadApplication($abroadApplication->id);
        
        return view('sales.customers.abroad_applications.applicationParts.certifications.certificationDeclaration', [
            'abroadApplication' => $abroadApplication,
            'certifications' => $certifications
        ]);
    }

    public function certificationShow(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $certifications = Certifications::getByAbroadApplication($abroadApplication->id);
        
        return view('sales.customers.abroad_applications.applicationParts.certifications.certificationShow', [
            'abroadApplication' => $abroadApplication,
            'certifications' => $certifications
        ]);
    }

    public function updateActiveCertification(Request $request)
    {
        $certification = new Certifications();
        $certification->updateActiveCertification();

        return response()->json([
            'message' => 'Hoàn thành chứng chỉ'
        ]);
    }

    public function details(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);

        return view('abroad.details', [
            'abroadApplication' => $abroadApplication,
        ]);
    }

    ///Kết quả dự tuyển
    public function admissionLetter(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $paths = $abroadApplication->getAllAdmissionLetters();
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();
        $checkFill = ApplicationSchool::isCheckFillKQDT($request->id);
        return view('sales.customers.abroad_applications.applicationParts.admissionLetter.admissionLetter', [
            'abroadApplication' => $abroadApplication,
            'paths' => $paths,
            'dayFinish'=>$dayFinish,
            'checkFill'=>$checkFill,
        ]);
    }

    public function createAdmissionLetter(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $studyAbroadApplications = StudyAbroadApplication::getByAbroadApplicationId($abroadApplication->id);
        $applicationSchools = ApplicationSchool::getByAbroadApplication($abroadApplication->id);

        return view('sales.customers.abroad_applications.applicationParts.admissionLetter.create', [
            'abroadApplication' => $abroadApplication,
            'applicationSchools' => $applicationSchools,
            'studyAbroadApplications' => $studyAbroadApplications,

        ]);
    }

    public function deleteScholarshipFile(Request $request)
    {
        $applicationSchool = ApplicationSchool::find($request->id);
    
        if (!$applicationSchool) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy hồ sơ này trong dữ liệu!'
            ], 404);
        }

        $applicationSchool->deleteScholarshipFile(); 
        
        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa file xác nhận học bổng thành công!'
        ], 200);
    }

    public function storeScholarshipFile(Request $request)
    {
        $applicationSchool = ApplicationSchool::find($request->id);
       
        if (!$applicationSchool) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Application school not found'
            ], 404);
        }
        
        $errors = $applicationSchool->uploadScholarshipFileFromRequest($request);

        if (empty($errors)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Upload file xác nhận học bổng thành công!'
            ], 201);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => $errors
            ], 400);
        }
    }

    public function doneCreateRecruitmentResults(Request $request)
    {
        $applicationSchool = ApplicationSchool::find($request->applicationSchool);
        $applicationSchool->doneCreateRecruitmentResults($request);

        return response()->json([
            'message' => 'Hoàn thành lưu tạm'
        ]);
    }

    public function updateActiveRecruitmentResults(Request $request)
    {
        $certification = new ApplicationSchool();
        $certification->updateActiveRecruitmentResults();

        return response()->json([
            'message' => 'Hoàn thành kết quả dự tuyển'
        ]);
    }

    public function showRecruitmentResults(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $studyAbroadApplications = StudyAbroadApplication::getByAbroadApplicationId($abroadApplication->id);
        $applicationSchools = ApplicationSchool::getByAbroadApplication($abroadApplication->id);

        return view('sales.customers.abroad_applications.applicationParts.admissionLetter.show', [
            'abroadApplication' => $abroadApplication,
            'applicationSchools' => $applicationSchools,
            'studyAbroadApplications' => $studyAbroadApplications,
        ]);
    }

    // public function createStudyAbroadApplicationPopup(Request $request)
    // {
    //     $abroadApplication = AbroadApplication::find($request->id);

    //     return view('sales.customers.abroad_applications.applicationParts.studyAbroadApplication.createStudyAbroadApplicationPopup', [
    //         'abroadApplication' => $abroadApplication,
    //     ]);
    // }

    public function storeAdmissionLetter(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $account = $request->user()->account;
        $errors = $abroadApplication->uploadAdmissionLetterFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Upload kết quả dự tuyển thành công!'
        ], 201);
    }

    public function deleteAdmissionLetter(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        if (!$abroadApplication) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy kết quả dự tuyển này trong dữ liệu!'
            ], 404);
        }

        $errors = $abroadApplication->deleteAdmissionLetterFile($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa kết quả dự tuyển thành công!'
        ], 200);
    }

    ///Hồ sơ tài chính
    public function financialDocument(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $paths = $abroadApplication->getAllFinancialDocuments();
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();

        return view('sales.customers.abroad_applications.applicationParts.financialDocument.financialDocument', [
            'abroadApplication' => $abroadApplication,
            'paths' => $paths,
            'dayFinish' => $dayFinish
        ]);
    }

    public function storeFinancialDocument(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $account = $request->user()->account;
        $errors = $abroadApplication->uploadFinancialDocumentFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Upload file thành công!'
        ], 201);
    }

    public function deleteFinancialDocument(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        if (!$abroadApplication) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy hồ sơ này trong dữ liệu!'
            ], 404);
        }

        $errors = $abroadApplication->deleteFinancialDocument($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa file thành công!'
        ], 200);
    }

    // Bản scan thông tin cá nhân
    public function scanOfInformation(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $paths = $abroadApplication->getAllScanOfInformation();
        $dayFinish = AbroadApplicationFinishDay::where('abroad_application_id',$abroadApplication->id)->first();

        return view('sales.customers.abroad_applications.applicationParts.scanOfInformation.scanOfInformation', [
            'abroadApplication' => $abroadApplication,
            'paths' => $paths,
            'dayFinish' => $dayFinish
        ]);
    }

    public function storeScanOfInformation(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $account = $request->user()->account;
        $errors = $abroadApplication->uploadScanOfInformationFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Upload kết quả dự tuyển thành công!'
        ], 201);
    }

    public function deleteScanOfInformation(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        if (!$abroadApplication) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy kết quả dự tuyển này trong dữ liệu!'
            ], 404);
        }

        $errors = $abroadApplication->deleteScanOfInformationFile($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa kết quả dự tuyển thành công!'
        ], 200);
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
            'sales.customers.abroad_applications.applicationParts.applicationSchool.applicationSchool',
            [
                'abroadApplication' => $abroadApplication,
                'dayFinish'=>$dayFinish,
                'checkFill'=>$checkFill,
            ]
        );
    }

    public function applicationSchoolDeclaration(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $applicationSchools = ApplicationSchool::getByAbroadApplication($abroadApplication->id);
        
        return view('sales.customers.abroad_applications.applicationParts.applicationSchool.applicationSchoolDeclaration', [
            'abroadApplication' => $abroadApplication,
            'applicationSchools' => $applicationSchools
        ]);
    }
  
    public function createApplicationSchool(Request $request, $id)
    {
        return view('sales.customers.abroad_applications.applicationParts.applicationSchool.createApplicationSchool', [
            'id' => $id,
        ]);
    }

    public function doneCreateApplicationSchool(Request $request)
    {
        ApplicationSchool::createApplicationSchool($request);

        return response()->json([
            'message' => 'Thêm mới Trường yêu cầu tuyển sinh thành công'
        ]);
    }
    
    public function updateApplicationSchool(Request $request, $id)
    {
        $applicationSchool = ApplicationSchool::find($id);

        return view('sales.customers.abroad_applications.applicationParts.applicationSchool.updateApplicationSchool', [
            'applicationSchool' => $applicationSchool
        ]);
    }

    public function doneUpdateApplicationSchool(Request $request, $id)
    {
        $applicationSchool = ApplicationSchool::find($id);

        $applicationSchool->updateApplicationSchool($request);
        // $note->save();

        return response()->json([
            'message' => 'Cập nhật Trường yêu cầu tuyển sinh thành công'
        ]);
    }

    public function applicationSchoolShow(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $applicationSchools = ApplicationSchool::getByAbroadApplication($abroadApplication->id);
        
        return view('sales.customers.abroad_applications.applicationParts.applicationSchool.applicationSchoolShow', [
            'abroadApplication' => $abroadApplication,
            'applicationSchools' => $applicationSchools
        ]);
    }

    public function updateActiveApplicationSchool(Request $request)
    {
        $certification = new ApplicationSchool();
        $certification->updateActiveApplicationSchool();

        return response()->json([
            'message' => 'Hoàn thành danh sách trường yêu cầu tuyển sinh'
        ]);
    }

    ///Visa cho học sinh
    public function studentVisa(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $paths = $abroadApplication->getAllStudentVisaFiles();

        return view('sales.customers.abroad_applications.activities.studentVisa.sudentVisa', [
            'abroadApplication' => $abroadApplication,
            'paths' => $paths,
        ]);
    }

    public function updateStudentVisaData(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $paths = $abroadApplication->getAllStudentVisaFiles();
        $errors = $abroadApplication->saveVisaStudentDataFromRequest($request);

        return response()->json([
            'status' => 'success',
            'messages' => 'Update thành công!'
        ], 200);
    }

    public function storeStudentVisaFile(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);
        $account = $request->user()->account;
        $errors = $abroadApplication->uploadStudentVisaFileFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Upload bản scan visa thành công!'
        ], 201);
    }

    public function deleteStudentVisaFile(Request $request)
    {
        $abroadApplication = AbroadApplication::find($request->id);

        if (!$abroadApplication) {
            return response()->json([
                'status' => 'not found!',
                'messages' => 'Không tìm thấy visa này trong dữ liệu!'
            ], 404);
        }

        $errors = $abroadApplication->deleteStudentVisaFileFromRequest($request);

        if (!$errors->isEmpty()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $errors->first('file')
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'messages' => 'Xóa file visa thành công!'
        ], 200);
    }

    //Bàn giao 
    public function updateStatusAbroadApplication(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);

        return view('sales.customers.abroad_applications.updateStatusAbroadApplication', [
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
            $abroadApplication->contact->addNoteLog($account1, "Đã bàn giao nhân viên tư vấn du học chiến lược cho hợp đồng" . $abroadApplication->getOrderCode());
           
        }  
        if(isset($request->account_id_2)){
            $account2 = Account::find($request->account_id_2);
            
            $abroadApplication->contact->addNoteLog($account2, "Đã bàn giao nhân viên truyền thông & sự kiện cho hợp đồng" . $abroadApplication->getOrderCode());
        }   
        return response()->json([
            'message' => 'Duyệt và bàn giao thành công'
        ]);
    }
}


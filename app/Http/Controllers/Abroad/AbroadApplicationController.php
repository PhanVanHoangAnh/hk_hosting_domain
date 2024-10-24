<?php

namespace App\Http\Controllers\Abroad;

use App\Http\Controllers\Controller;
use App\Models\AbroadService;
use App\Models\AbroadApplication;
use App\Models\SocialNetwork;
use App\Models\Certifications;
use App\Models\Role;
use App\Models\AbroadApplicationStatus;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;


use App\Library\Permission;

class AbroadApplicationController extends Controller
{
    public function details(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $abroadApplicationStatus = AbroadApplicationStatus::where('abroad_application_id',$id)->first();
        
        return view('abroad.abroad_applications.details', [
            'abroadApplication' => $abroadApplication,
            'abroadApplicationStatus'=>$abroadApplicationStatus
        ]);
    }
    public function detailsExtra(Request $request, $id)
    {
        $abroadApplication = AbroadApplication::find($id);
        $abroadApplicationStatus = AbroadApplicationStatus::where('abroad_application_id',$id)->first();
        
        return view('abroad.extracurricular.details', [
            'abroadApplication' => $abroadApplication,
            'abroadApplicationStatus'=>$abroadApplicationStatus
        ]);
    }
    

    public function abroadApplicationIndex()
    {
        return view('abroad.abroad_applications.abroadApplicationIndex', []);
    }

    public function select2(Request $request)
    {
        return response()->json(AbroadApplication::select2($request));
    }

    public function select2ForAbroad(Request $request)
    {
        if ($request->user()->can('changeBranch', User::class)) {
            return response()->json(AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->select2($request));
        } else if( $request->user()->isAlias(Role::ALIAS_ABROAD_LEADER)) {
            $accountIds = $request->user()->account->accountGroup->members->pluck('id');
            $abroadApplications = AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch()) ->whereIn('account_1', $accountIds) ; 
            return response()->json($abroadApplications->select2($request));
        }else {
            $abroadApplications = $request->user()->account->abroadApplications();
            return response()->json($abroadApplications->select2($request));

        }
    }
    public function select2ForExtracurricular(Request $request)
    {
        if ($request->user()->can('changeBranch', User::class)) {
            
            return response()->json(AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->select2($request));
        }else if( $request->user()->isAlias(Role::ALIAS_EXTRACURRICULAR_MANAGER)) {
            $accountIds = $request->user()->account->accountGroup->members->pluck('id');
            $abroadApplications = AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch()) ->whereIn('account_2', $accountIds) ; 
            return response()->json($abroadApplications->select2($request));
        } else {
            $abroadApplications = $request->user()->account->abroadApplicationExtracurriculars();
            return response()->json($abroadApplications->select2($request));

        }
    }
}

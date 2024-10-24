<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AbroadService;
use App\Models\AbroadApplication;
use App\Models\SocialNetwork;
use App\Models\Certifications;

use App\Models\Account;
use Illuminate\Http\Request;

class AbroadApplicationController extends Controller
{
    // public function details(Request $request, $id)
    // {
    //     $abroadApplication = AbroadApplication::find($id);

    //     return view('student.abroad_applications.details', [
    //         'abroadApplication' => $abroadApplication,
    //     ]);
    // }
    public function detail(Request $request)
    {
        $contact = $request->user()->getStudent();
        if ($contact) {
            $abroadApplication = $contact->abroadApplications()->first();
        } else {
            $abroadApplication = null;
        }
        return view('student.abroad_applications.details', [
            'abroadApplication' => $abroadApplication,
        ]);
    }


    public function abroadApplicationIndex()
    {

        return view('student.abroad_applications.abroadApplicationIndex', []);
    }


    public function select2(Request $request)
    {
        return response()->json(AbroadApplication::select2($request));
    }
}

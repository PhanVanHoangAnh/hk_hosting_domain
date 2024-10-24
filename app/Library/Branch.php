<?php

namespace App\Library;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Branch
{
    public const BRANCH_HN = 'HN';
    public const BRANCH_SG = 'SG';
    public const BRANCH_ALL = 'all';

    // public static function setBranchFromRequest($request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'branch' => 'string|required'
    //     ]);

    //     $validator->after(function($validator) use ($request) {
    //         if (!in_array($request->branch, self::getAllBranch())) {
    //             $branch->errors()->add('branch_errors', 'Branch invalid!');
    //         }
    //     });

    //     if ($validator->fails()) return $validator->errors();

    //     Session::put('selectedBranch', $request->branch);
        
    //     \Log::info('Session selectedBranch: ' . Session::get('selectedBranch'));
    //     return $validator->errors();
    // }

    // public static function getCurrentBranch()
    // {
    //     return $_COOKIE['selectedBranch'] ?? \Auth::user()->account->branch;
    //     // return Session::get('selectedBranch', \Auth::user()->account->branch);
    // }

    public static function setBranchFromRequest($request)
    {
        $user = $request->user();
        $user->setSelectedBranch($request->branch);
    }

    public static function getCurrentBranch()
    {
        return Auth::user()->getCurrentBranch() ?? self::getDefaultBranch();
    }
   
    public static function getBranchOfUser()
    {
        return \Auth::user()->account->branch ?? $_COOKIE['selectedBranch'];
        // return \Auth::user()->account->branch ?? Session::get('selectedBranch');
    }

    public static function getAllBranch()
    {
        return [
            self::BRANCH_HN,
            self::BRANCH_SG,
            self::BRANCH_ALL,
        ];
    }

    public static function getDefaultBranch()
    {
        return self::BRANCH_HN;
    }
}
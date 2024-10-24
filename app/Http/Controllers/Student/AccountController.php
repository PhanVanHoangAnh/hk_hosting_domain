<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

use App\Events\NewUserCreated;

class AccountController extends Controller
{
    public function setupStudent(Request $request)
    {
        $user = $request->user();
        $sameEmailContacts = Contact::where('email', '=', $user->email);

        return view('student.account.setupStudent', [
            'sameEmailContacts' => $sameEmailContacts,
        ]);
    }

    public function setupStudentSave(Request $request)
    {
        if ($request->contact_id == 'new') {
            $contact = $request->user()->account->createNewDefaultContact($request->name, $request->user()->email);
        } else {
            $contact = Contact::find($request->contact_id);
        }

        $request->user()->account->setStudent($contact);

        // Events
        NewUserCreated::dispatch($contact);

        return redirect()->action([\App\Http\Controllers\Student\DashboardController::class, 'index']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->action([\App\Http\Controllers\Student\DashboardController::class, 'index']);
    }
}


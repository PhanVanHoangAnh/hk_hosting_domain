<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Student\DashboardController;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class AuthController extends Controller
{
    public static function login()
    {
        return view('student.auth.login');
    }

    public function loginSave(LoginRequest $request)
    {
        if ($request->email) {
            $contact = Contact::where('email', $request->email)->first();
            $user = User::where('email', $request->email)->first();
            
            if ($contact) {
                if ($request->password == '123456') {
                    // if there is contact that have the email thì tạo cho nó tài khoản sinh viên luôn
                    $isNew = false;
                    
                    if (!$user) {
                        //
                        $user = new User([
                            'name' => $contact->name,
                            'email' => $request->email,
                            'phone' => \App\Library\Tool::extractPhoneNumber($contact->phone),
                            // 'password' => Hash::make($request->password),
                        ]);
                        $user->password = Hash::make($request->password);
                        $user->status =  User::STATUS_ACTIVE;
                        $user->save();
                        
                        $isNew = true;
                    }
            
                    // event(new Registered($user));
                    
            
                    // default account. QUy ước: user thì phải luôn có 1 account tương ứng
                    $user->createDefaultAccount();
            
                    // add student role. Cứ đăng ký public vào hệ thống là học viên hết
                    $user->addStudentRole();

                    //
                    $user->account->setStudent($contact);

                    if ($isNew) {
                        // send welcom message
                        $user->notify(new \App\Notifications\StudentWelcomeNewAccount($user));
                    }

                    //
                    \Auth::login($user);

                    //
                    return redirect()->intended(RouteServiceProvider::HOME);
                }
            }
            
        }

        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
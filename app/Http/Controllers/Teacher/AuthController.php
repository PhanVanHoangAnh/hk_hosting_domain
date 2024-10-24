<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Teacher\DashboardController;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class AuthController extends Controller
{
    public static function login()
    {
        return view('teacher.auth.login');
    }

    public function loginSave(LoginRequest $request)
    {
        if ($request->email) {
            $teacher = Teacher::where('email', $request->email)->first();
            $user = User::where('email', $request->email)->first();
            
            if ($teacher) {
                if ($request->password == '123456') {
                    // if there is teacher that have the email thì tạo cho nó tài khoản sinh viên luôn
                    $isNew = false;
                    
                    if (!$user) {
                        //
                        $user = User::create([
                            'name' => $teacher->name,
                            'email' => $request->email,
                            'phone' => $teacher->phone,
                            'password' => Hash::make($request->password),
                        ]);

                        $isNew = true;
                    }
            
                    // event(new Registered($user));
                    
            
                    // default account. QUy ước: user thì phải luôn có 1 account tương ứng
                    $user->createDefaultAccount();
            
                    // add teacher role.
                    $roleTeacher = \App\Models\Role::where('name', 'Giảng viên')->first();
                    $user->addRole($roleTeacher);

                    //
                    $user->account->setTeacher($teacher);

                    if ($isNew) {
                        // send welcom message
                        $user->notify(new \App\Notifications\SalesWelcomeNewAccount($user));
                    }

                    //
                    \Auth::login($user);

                    //
                    return redirect()->intended(RouteServiceProvider::HOME_TEACHER);
                }
            }
            
        }

        $request->authenticate();
        $request->session()->regenerate();

        // User is inactive
        if ($request->user()->isOutOfJob()) {
            \Auth::logout();
            return $this->sendInactiveUserResponse($request);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    protected function sendInactiveUserResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Người dùng đã ngưng hoạt động trên ASMS.',
            ]);
    }
}
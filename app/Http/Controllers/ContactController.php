<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Arr;

class ContactController extends Controller
{
    public function json(Request $request)
    {
        $contact = Contact::find($request->id);
        $attributes = $contact->toArray();

        // more attributes
        $attributes = array_merge($attributes, [
            'selectedText' => $contact->getSelect2Text(),
        ]);
        
        $attributes = Arr::except($attributes, ['source_type']);
        $attributes = Arr::except($attributes, ['demand']);

        return response()->json($attributes);
    }

    public function account(Request $request, $id)
    {
        $contact = Contact::find($id);  
        $user = $contact->findOrNewUser();

        if (!$request->user()->can('userAccount', $contact)) {
            abort(403);
        }

        if ($request->isMethod('post')) {
            // validate
            list($user, $errors) = $contact->saveUserAccountFromRequest($request);

            if (!$errors->isEmpty()) {
                return response()->view('contacts.account', [
                    'contact' => $contact,
                    'user' => $user,
                    'errors' => $errors,
                ], 400);
            }

            // add student role
            $user->addStudentRole();

            return response()->json([
                'status' => 'success',
                'message' => 'Đã tạo tài khoản học viên thành công',
            ]);
        }

        return view('contacts.account', [
            'contact' => $contact,
            'user' => $user,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Relationship;

use Illuminate\Http\Request;

class RelationshipController extends Controller
{
    public function box(Request $request)
    {
        $contact = Contact::find($request->contact_id);
        $toContact = Contact::find($request->to_contact_id);

        $relationship = $contact->findRelationshipTo($toContact);

        if (!$relationship) {
            $relationship = $toContact->findRelationshipTo($contact);

            if ($relationship) {
                $contact = Contact::find($request->to_contact_id);
                $toContact = Contact::find($request->contact_id);
            }
        }

        return view('relationships.box', [
            'relationship' => $relationship,
            'contact' => $contact,
            'toContact' => $toContact,
        ]);
    }

    public function save(Request $request)
    {
        $contact = Contact::find($request->contact_id);
        $toContact = Contact::find($request->to_contact_id);
        $relationship = $contact->findRelationshipTo($toContact);
        
        $errors = $contact->updateRelationship($toContact, $request->relationship_type, $request->relationship_other);

        if (!$errors->isEmpty()) {
            return response()->view('relationships.box', [
                'relationship' => $relationship,
                'contact' => $contact,
                'toContact' => $toContact,
                'errors' => $errors,
            ], 400);
        }
    }
}

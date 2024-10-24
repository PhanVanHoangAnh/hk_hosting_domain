<?php

namespace App\Library;

use App\Models\Contact;
use App\Models\ContactRequest;

class ImportedContactCleaner
{
    public function run()
    {
        // clean contacts
        $this->cleanupContacts();

        // clean contactRequest
        $this->cleanupContactRequests();
    }


    // CONTACT REQUEST
    public function cleanupContactRequests()
    {   
        // All other contacts that do not have import_id
        $contacts = Contact::where('import_id', '!=', null)->orderBy('updated_at', 'desc')->get();
        foreach ($contacts as $index => $contact)
        {
            // merge duplicates
            $this->cleanupContactRequestsByContact($contact, $index);
        }
    }

    public function cleanupContactRequestsByContact($contact, $index)
    {
        $contactRequests = $contact->contactRequests()->orderBy('updated_at', 'desc')->get();
        $contact->created_at = $contactRequests->count() ? $contactRequests->first()->created_at : $contact->created_at;
        $contact->created_at = $contact->created_at ?? \Carbon\Carbon::now();
        $contact->latest_activity_date = $contactRequests->count() ? $contactRequests->last()->created_at : $contact->updated_at;

        // save dates
        $contact->save();

        // log
        echo "$index : " . $contact->name . " - "
            . $contact->phone . " - "
            . "createdAt: " . ($contact->created_at ? $contact->created_at->format('Y-m-d') : '') . " - "
            . "latestActivityDate: " . $contact->latest_activity_date->format('Y-m-d') . " - "
            . $contactRequests->count() . "\n";

        foreach ($contactRequests as $contactRequest) {
            $this->removeDupRequests($contactRequest);
        }
    }

    public function findRelatedContactRequests($contactRequest)
    {
        return $contactRequest->contact->contactRequests()
            ->where('import_id', '!=', null)
            ->where('import_id', '=', $contactRequest->import_id)
            ->whereNot('id', $contactRequest->id)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function removeDupRequests($contactRequest)
    {
        // already removed
        if (!ContactRequest::where('id', $contactRequest->id)->count()) {
            return;
        }

        // related requests
        $dupRequests = $this->findRelatedContactRequests($contactRequest);
        $contactRequest->created_at = $dupRequests->first() ? $dupRequests->first()->created_at : $contactRequest->created_at;
        $contactRequest->created_at = $contactRequest->created_at ?? \Carbon\Carbon::now();
        $contactRequest->latest_activity_date = $contactRequest->created_at;

        // save dates
        $contactRequest->save();

        // log
        echo "--------------- {$contactRequest->id} : " . $contactRequest->phone . " - "
        . $contactRequest->demand . " - "
        . $contactRequest->created_at->format('Y-m-d') . " - "
        . "createdAt: " . $contactRequest->created_at->format('Y-m-d') . " - "
        . "latestActivityDate: " . $contactRequest->latest_activity_date->format('Y-m-d') . " - "
        . $contactRequest->name . "-\n";


        foreach ($dupRequests as $dupRequest) {
            // log
            echo "----------------------------- {$dupRequest->id} : " . $dupRequest->phone . " - "
            . $dupRequest->demand . " - "
            . $dupRequest->created_at->format('Y-m-d') . " - "
            . $dupRequest->name . "-\n";

            // attributes
            if (!$contactRequest->account_id && $dupRequest->account_id) {
                $contactRequest->account_id = $dupRequest->account_id;
            }
            if (!$contactRequest->source_type && $dupRequest->source_type) {
                $contactRequest->source_type = $dupRequest->source_type;
            }
            if (!$contactRequest->channel && $dupRequest->channel) {
                $contactRequest->channel = $dupRequest->channel;
            }
            if (!$contactRequest->sub_channel && $dupRequest->sub_channel) {
                $contactRequest->sub_channel = $dupRequest->sub_channel;
            }
            if (!$contactRequest->lead_status && $dupRequest->lead_status) {
                $contactRequest->lead_status = $dupRequest->lead_status;
            }
            if (!$contactRequest->lifecycle_stage && $dupRequest->lifecycle_stage) {
                $contactRequest->lifecycle_stage = $dupRequest->lifecycle_stage;
            }
            if (!$contactRequest->assigned_expired_at && $dupRequest->assigned_expired_at) {
                $contactRequest->assigned_expired_at = $dupRequest->assigned_expired_at;
            }
            if (!$contactRequest->assigned_expired_at && $dupRequest->assigned_expired_at) {
                $contactRequest->assigned_expired_at = $dupRequest->assigned_expired_at;
            }
            if (!$contactRequest->assigned_at && $dupRequest->assigned_at) {
                $contactRequest->assigned_at = $dupRequest->assigned_at;
            }
            if (!$contactRequest->account_id && $dupRequest->account_id) {
                $contactRequest->account_id = $dupRequest->account_id;
            }
            if (!$contactRequest->latest_activity_date && $dupRequest->latest_activity_date) {
                $contactRequest->latest_activity_date = $dupRequest->latest_activity_date;
            }

            $contactRequest->save();

            
            // - free_time_records
            $records = \DB::table('free_time_records')
                ->where('contact_request_id', $dupRequest->id);
            $records->update(['contact_request_id' => $contactRequest->id]);
            echo "---------- move free_time_records ------ : " . $records->count() . "\n";

            // - note_logs
            $records = \DB::table('note_logs')
                ->where('contact_request_id', $dupRequest->id);
            $records->update(['contact_request_id' => $contactRequest->id]);
            echo "---------- move note_logs ------ : " . $records->count() . "\n";

            // - orders
            $records = \DB::table('orders')
                ->where('contact_request_id', $dupRequest->id);
            $records->update(['contact_request_id' => $contactRequest->id]);
            echo "---------- move orders ------ : " . $records->count() . "\n";

            // - free_time_records
            $records = \DB::table('free_time_records')
                ->where('contact_request_id', $dupRequest->id);
            $records->update(['contact_request_id' => $contactRequest->id]);
            echo "---------- move free_time_records ------ : " . $records->count() . "\n";

            //
            $dupRequest->delete();
        }
    }







    // CONTACT
    public function cleanupContacts()
    {
        // All other contacts that do not have import_id
        $contacts = Contact::where('import_id', '!=', null)->orderBy('updated_at', 'desc')->get();
        foreach ($contacts as $index => $contact)
        {
            // cleanup duplicates
            $this->cleanupDuplicatedContact($contact, $index);
        }
    }

    public function findRelatedContactsByPhoneOnly($contact)
    {
        return Contact::active()
            ->where('import_id', '=', $contact->import_id)
            ->where('import_id', '!=', null)
            ->whereNot('id', $contact->id)
            ->get();
    }

    public function cleanupDuplicatedContact($contact, $index)
    {
        // already removed
        if (!Contact::where('id', $contact->id)->count()) {
            return;
        }

        $duplicatedContacts = $this->findRelatedContactsByPhoneOnly($contact);

        // log
        echo "$index : " . $contact->name . " - "
            . $contact->phone . " - "
            . $duplicatedContacts->count() . "\n";

        foreach ($duplicatedContacts as $duplicatedContact) {
            // log
            echo "-----" . $duplicatedContact->name . " - "
            . $duplicatedContact->phone . "-\n";

            // 'source_type',
            // 'channel',
            // 'sub_channel',
            // 'lead_status',
            // 'lifecycle_stage',
            // assigned_expired_at
            // assigned_at

            // attributes
            if (!$contact->account_id && $duplicatedContact->account_id) {
                $contact->account_id = $duplicatedContact->account_id;
            }
            if (!$contact->source_type && $duplicatedContact->source_type) {
                $contact->source_type = $duplicatedContact->source_type;
            }
            if (!$contact->channel && $duplicatedContact->channel) {
                $contact->channel = $duplicatedContact->channel;
            }
            if (!$contact->sub_channel && $duplicatedContact->sub_channel) {
                $contact->sub_channel = $duplicatedContact->sub_channel;
            }
            if (!$contact->lead_status && $duplicatedContact->lead_status) {
                $contact->lead_status = $duplicatedContact->lead_status;
            }
            if (!$contact->lifecycle_stage && $duplicatedContact->lifecycle_stage) {
                $contact->lifecycle_stage = $duplicatedContact->lifecycle_stage;
            }
            if (!$contact->assigned_expired_at && $duplicatedContact->assigned_expired_at) {
                $contact->assigned_expired_at = $duplicatedContact->assigned_expired_at;
            }
            if (!$contact->assigned_expired_at && $duplicatedContact->assigned_expired_at) {
                $contact->assigned_expired_at = $duplicatedContact->assigned_expired_at;
            }
            if (!$contact->assigned_at && $duplicatedContact->assigned_at) {
                $contact->assigned_at = $duplicatedContact->assigned_at;
            }
            if (!$contact->account_id && $duplicatedContact->account_id) {
                $contact->account_id = $duplicatedContact->account_id;
            }
            if (!$contact->latest_activity_date && $duplicatedContact->latest_activity_date) {
                $contact->latest_activity_date = $duplicatedContact->latest_activity_date;
            }

            $contact->save();


            // - note_logs
            $records = \DB::table('note_logs')
                ->where('contact_id', $duplicatedContact->id);
            $records->update(['contact_id' => $contact->id]);
            echo "---------- move note_logs ------ : " . $records->count() . "\n";

            // - contact_tag
            $records = \DB::table('contact_tag')
                ->where('contact_id', $duplicatedContact->id);
            $records->update(['contact_id' => $contact->id]);
            echo "---------- move contact_tag ------ : " . $records->count() . "\n";

            // - orders
            $records = \DB::table('orders')
                ->where('contact_id', $duplicatedContact->id);
            $records->update(['contact_id' => $contact->id]);
            echo "---------- move orders ------ : " . $records->count() . "\n";

            // - payment_records
            $records = \DB::table('payment_records')
                ->where('contact_id', $duplicatedContact->id);
            $records->update(['contact_id' => $contact->id]);
            echo "---------- move payment_records ------ : " . $records->count() . "\n";

            // - contact_requests
            $records = \DB::table('contact_requests')
                ->where('contact_id', $duplicatedContact->id);
            $records->update(['contact_id' => $contact->id]);
            echo "---------- move contact_requests ------ : " . $records->count() . "\n";

            // - account_kpi_notes
            $records = \DB::table('account_kpi_notes')
                ->where('contact_id', $duplicatedContact->id);
            $records->update(['contact_id' => $contact->id]);
            echo "---------- move account_kpi_notes ------ : " . $records->count() . "\n";

            // - relationships
            $records = \DB::table('note_logs')
                ->where('contact_id', $duplicatedContact->id);
            $records->update(['contact_id' => $contact->id]);
            echo "---------- move note_logs ------ : " . $records->count() . "\n";

            // - abroad_applications
            $records = \DB::table('abroad_applications')
                ->where('contact_id', $duplicatedContact->id);
            $records->update(['contact_id' => $contact->id]);
            echo "---------- move abroad_applications ------ : " . $records->count() . "\n";

            // - free_times
            $records = \DB::table('free_times')
                ->where('contact_id', $duplicatedContact->id);
            $records->update(['contact_id' => $contact->id]);
            echo "---------- move free_times ------ : " . $records->count() . "\n";

            // - course_student : student_id
            $records = \DB::table('course_student')
                ->where('student_id', $duplicatedContact->id);
            $records->update(['student_id' => $contact->id]);
            echo "---------- move course_student ------ : " . $records->count() . "\n";

            // - attendances : student_id
            $records = \DB::table('attendances')
                ->where('student_id', $duplicatedContact->id);
            $records->update(['student_id' => $contact->id]);
            echo "---------- move attendances ------ : " . $records->count() . "\n";

            // - reserve : student_id
            $records = \DB::table('reserve')
                ->where('student_id', $duplicatedContact->id);
            $records->update(['student_id' => $contact->id]);
            echo "---------- move reserve ------ : " . $records->count() . "\n";

            // - student_section : student_id
            $records = \DB::table('student_section')
                ->where('student_id', $duplicatedContact->id);
            $records->update(['student_id' => $contact->id]);
            echo "---------- move student_section ------ : " . $records->count() . "\n";

            // - section_reports : student_id
            $records = \DB::table('section_reports')
                ->where('student_id', $duplicatedContact->id);
            $records->update(['student_id' => $contact->id]);
            echo "---------- move section_reports ------ : " . $records->count() . "\n";

            // - refund_requests : student_id
            $records = \DB::table('refund_requests')
                ->where('student_id', $duplicatedContact->id);
            $records->update(['student_id' => $contact->id]);
            echo "---------- move refund_requests ------ : " . $records->count() . "\n";

            // - extracurricular_students : student_id
            $records = \DB::table('extracurricular_students')
                ->where('student_id', $duplicatedContact->id);
            $records->update(['student_id' => $contact->id]);
            echo "---------- move extracurricular_students ------ : " . $records->count() . "\n";

            // - accounts : student_id
            $records = \DB::table('accounts')
                ->where('student_id', $duplicatedContact->id);
            $records->update(['student_id' => $contact->id]);
            echo "---------- move accounts ------ : " . $records->count() . "\n";

            // - abroad_applications : student_id
            $records = \DB::table('abroad_applications')
                ->where('student_id', $duplicatedContact->id);
            $records->update(['student_id' => $contact->id]);
            echo "---------- move abroad_applications ------ : " . $records->count() . "\n";

            //
            $duplicatedContact->delete();
        }
    }
}
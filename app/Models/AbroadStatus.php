<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbroadStatus extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_SALE_HAS_HANDED_OVER = 'sale_has_handed_over';
    public const STATUS_DEPUTY_DIRECTOR_APPROVED = 'deputy_director_approved';
    public const STATUS_STRATEGY_AND_COMMUNICATION_STAFFS_HAVE_RECEIVED = 'strategy_and_communication_staffs_have_received';
    public const STATUS_ROADMAP_DEVELOPMENT_MEETING_COMPLETED = 'roadmap_development_meeting_completed';
    public const STATUS_COMPLETED_SCHOOLS_LIST_AND_ADMISSION_REQUEST_AND_EXTRACURRICULAR_ACTIVITY_PLAN = 'completed_schools_list_and_admission_request_and_extracurricular_activity_plan';
    public const STATUS_GUIDE_CERTIFICATION_EXAMS_AND_SUPERVISE_EXTRACURRICULAR_ACTIVITIES = 'guide_certification_exams_and_supervise_extracurricular_activities';
    public const STATUS_INTRODUCTORY_LETTER_AND_SOCIAL_MEDIA_HANDLED = 'introductory_letter_and_social_media_handled';
    public const STATUS_ESSAY_WRITING_INSTRUCTIONS_PROVIDED_AND_PHOTO_COLLECTION_AND_CERTIFICATES_GATHERED = 'essay_writing_instructions_provided_and_photo_collection_and_certificates_gathered';
    public const STATUS_COMPLETED_THE_DOSSIER = 'completed_the_dossier';
    public const STATUS_BOARD_OF_DIRECTORS_HAS_APPROVED_THE_ENTIRED_DOSSIER = 'board_of_directors_has_approved_the_entired_dossier';
    public const STATUS_SUBMITTED_DOCUMENTS_AND_PARENTS_HAVE_CONFIRMED = 'submitted_documents_and_parents_have_confirmed';
    public const STATUS_APPLY_FEE_HAS_BEEN_PAID = 'apply_fee_has_been_paid';
    public const STATUS_APPLIED_APPLICATION = 'applied_application';
    public const STATUS_INTERVIEW_HAS_BEEN_PRACTICED = 'interview_has_been_practiced';
    public const STATUS_SCHOOL_SELECTION_CONSULTATION_BASE_ON_RESULTS = 'school_selection_consultation_base_on_results';
    public const STATUS_THE_ENROLLMENT_DEPOSIT_FEE_HAS_BEEN_COLLECTED = 'the_enrollment_deposit_fee_has_been_collected';
    public const STATUS_DEPOSITS_HAVE_BEEN_PLACED_FOR_SCHOOL = 'deposits_have_been_placed_for_school';
    public const STATUS_APPLYING_FOR_STUDENT_VISAS = 'applying_for_student_visas';
    public const STATUS_STUDY_ABROAD_ORIENTATION = 'study_abroad_orientation';
    public const STATUS_FOUND_GUARDIAN_AND_ARRANGING_FLIGHTS_ORGANIZED = 'found_guardian_and_arranging_flights_organized';
    public const STATUS_EMBARKED_ON_JOURNEY = 'embarked_on_journey';

    protected $fillable = [
        'name'
    ];

    public static function getAllStatuses()
    {
        return [
            self::STATUS_NEW,
            self::STATUS_SALE_HAS_HANDED_OVER,
            self::STATUS_DEPUTY_DIRECTOR_APPROVED,
            self::STATUS_STRATEGY_AND_COMMUNICATION_STAFFS_HAVE_RECEIVED,
            self::STATUS_ROADMAP_DEVELOPMENT_MEETING_COMPLETED,
            self::STATUS_COMPLETED_SCHOOLS_LIST_AND_ADMISSION_REQUEST_AND_EXTRACURRICULAR_ACTIVITY_PLAN,
            self::STATUS_GUIDE_CERTIFICATION_EXAMS_AND_SUPERVISE_EXTRACURRICULAR_ACTIVITIES,
            self::STATUS_SUBMITTED_DOCUMENTS_AND_PARENTS_HAVE_CONFIRMED,
            self::STATUS_BOARD_OF_DIRECTORS_HAS_APPROVED_THE_ENTIRED_DOSSIER,
            self::STATUS_COMPLETED_THE_DOSSIER,
            self::STATUS_ESSAY_WRITING_INSTRUCTIONS_PROVIDED_AND_PHOTO_COLLECTION_AND_CERTIFICATES_GATHERED,
            self::STATUS_INTRODUCTORY_LETTER_AND_SOCIAL_MEDIA_HANDLED,
            self::STATUS_APPLY_FEE_HAS_BEEN_PAID,
            self::STATUS_APPLIED_APPLICATION,
            self::STATUS_INTERVIEW_HAS_BEEN_PRACTICED,
            self::STATUS_SCHOOL_SELECTION_CONSULTATION_BASE_ON_RESULTS,
            self::STATUS_THE_ENROLLMENT_DEPOSIT_FEE_HAS_BEEN_COLLECTED,
            self::STATUS_DEPOSITS_HAVE_BEEN_PLACED_FOR_SCHOOL,
            self::STATUS_APPLYING_FOR_STUDENT_VISAS,
            self::STATUS_STUDY_ABROAD_ORIENTATION,
            self::STATUS_FOUND_GUARDIAN_AND_ARRANGING_FLIGHTS_ORGANIZED,
            self::STATUS_EMBARKED_ON_JOURNEY
        ];
    }

    public static function new()
    {
        return self::where('name', '=', self::STATUS_NEW)->first();
    }
}

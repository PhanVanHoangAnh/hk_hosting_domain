<?php
return [
    // \App\Models\ContactRequest::LS_CONTACT => 'Contact',
    // \App\Models\ContactRequest::LS_NOT_CALL_YET => 'Lead',
    // \App\Models\ContactRequest::LS_NO_NEED => 'Lead',
    // \App\Models\ContactRequest::LS_NOT_PICK_UP => 'Lead',
    // \App\Models\ContactRequest::LS_ERROR => 'Lead',
    // \App\Models\ContactRequest::LS_NO_REQUEST => 'Lead',
    // \App\Models\ContactRequest::LS_HAS_REQUEST => 'Marketing Qualified Lead',
    // \App\Models\ContactRequest::LS_FOLLOW => 'Marketing Qualified Lead',
    // \App\Models\ContactRequest::LS_POTENTIAL => 'Sale Qualified Lead',
    // \App\Models\ContactRequest::LS_DEPOSITED => 'Customer',
    // \App\Models\ContactRequest::LS_HAS_CONSTRACT => 'Customer',
    // // \App\Models\ContactRequest::LS_HAS_CONSTRACT_OUTSIDE_SYSTEM => 'Customer',
    // \App\Models\ContactRequest::LS_MAKING_CONSTRACT => 'Customer',
    // // \App\Models\ContactRequest::LS_IS_REFERRER => 'VIP Customer',


    \App\Models\ContactRequest::LS_ERROR => 'Lead',
    \App\Models\ContactRequest::LS_NOT_PICK_UP => 'Lead',
    \App\Models\ContactRequest::LS_NOT_PICK_UP_MANY_TIMES => 'Lead',
    \App\Models\ContactRequest::LS_DUPLICATE_DATA => 'Lead',
    \App\Models\ContactRequest::LS_NOT_POTENTIAL => 'Lead',
    \App\Models\ContactRequest::LS_HAS_REQUEST => 'Marketing Qualified Lead',
    \App\Models\ContactRequest::LS_FOLLOW => 'Marketing Qualified Lead',
    \App\Models\ContactRequest::LS_POTENTIAL => 'Sale Qualified Lead',
    \App\Models\ContactRequest::LS_HAS_CONSTRACT => 'Customer',
    \App\Models\ContactRequest::LS_NA => 'N/A',
];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute field must be accepted.',
    'accepted_if' => 'The :attribute field must be accepted when :other is :value.',
    'active_url' => 'The :attribute field must be a valid URL.',
    'after' => 'The :attribute field must be a date after :date.',
    'after_or_equal' => 'The :attribute field must be a date after or equal to :date.',
    'alpha' => 'The :attribute field must only contain letters.',
    'alpha_dash' => 'The :attribute field must only contain letters, numbers, dashes, and underscores.',
    'alpha_num' => 'The :attribute field must only contain letters and numbers.',
    'array' => 'The :attribute field must be an array.',
    'ascii' => 'The :attribute field must only contain single-byte alphanumeric characters and symbols.',
    'before' => 'The :attribute field must be a date before :date.',
    'before_or_equal' => 'The :attribute field must be a date before or equal to :date.',
    'between' => [
        'array' => 'The :attribute field must have between :min and :max items.',
        'file' => 'The :attribute field must be between :min and :max kilobytes.',
        'numeric' => 'The :attribute field must be between :min and :max.',
        'string' => 'The :attribute field must be between :min and :max characters.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'can' => 'The :attribute field contains an unauthorized value.',
    'confirmed' => 'The :attribute field confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute field must be a valid date.',
    'date_equals' => 'The :attribute field must be a date equal to :date.',
    'date_format' => 'The :attribute field must match the format :format.',
    'decimal' => 'The :attribute field must have :decimal decimal places.',
    'declined' => 'The :attribute field must be declined.',
    'declined_if' => 'The :attribute field must be declined when :other is :value.',
    'different' => 'The :attribute field and :other must be different.',
    'digits' => 'The :attribute field must be :digits digits.',
    'digits_between' => 'The :attribute field must be between :min and :max digits.',
    'dimensions' => 'The :attribute field has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'doesnt_end_with' => 'The :attribute field must not end with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute field must not start with one of the following: :values.',
    'email' => 'The :attribute field must be a valid email address.',
    'ends_with' => 'The :attribute field must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute field must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'array' => 'The :attribute field must have more than :value items.',
        'file' => ':attribute phải lớn hơn :value kilobytes.',
        'numeric' => ':attribute phải lớn hơn :value.',
        'string' => ':attribute phải lớn hơn :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute field must have :value items or more.',
        'file' => ':attribute phải lớn hơn or equal to :value kilobytes.',
        'numeric' => ':attribute phải lớn hơn or equal to :value.',
        'string' => ':attribute phải lớn hơn or equal to :value characters.',
    ],
    'image' => 'The :attribute field must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field must exist in :other.',
    'integer' => 'The :attribute field must be an integer.',
    'ip' => 'The :attribute field must be a valid IP address.',
    'ipv4' => 'The :attribute field must be a valid IPv4 address.',
    'ipv6' => 'The :attribute field must be a valid IPv6 address.',
    'json' => 'The :attribute field must be a valid JSON string.',
    'lowercase' => 'The :attribute field must be lowercase.',
    'lt' => [
        'array' => 'The :attribute field must have less than :value items.',
        'file' => 'The :attribute field must be less than :value kilobytes.',
        'numeric' => 'The :attribute field must be less than :value.',
        'string' => 'The :attribute field must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute field must not have more than :value items.',
        'file' => 'The :attribute field must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be less than or equal to :value.',
        'string' => 'The :attribute field must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :attribute field must be a valid MAC address.',
    'max' => [
        'array' => 'The :attribute field must not have more than :max items.',
        'file' => 'The :attribute field must not be greater than :max kilobytes.',
        'numeric' => 'The :attribute field must not be greater than :max.',
        'string' => 'The :attribute field must not be greater than :max characters.',
    ],
    'max_digits' => 'The :attribute field must not have more than :max digits.',
    'mimes' => ':attribute phải có định dạng :values.',
    'mimetypes' => 'The :attribute field must be a file of type: :values.',
    'min' => [
        'array' => 'The :attribute field must have at least :min items.',
        'file' => 'The :attribute field must be at least :min kilobytes.',
        'numeric' => ':attribute phải lớn hơn hoặc bằng :min.',
        'string' => 'The :attribute field must be at least :min characters.',
    ],
    'min_digits' => 'The :attribute field must have at least :min digits.',
    'missing' => 'The :attribute field must be missing.',
    'missing_if' => 'The :attribute field must be missing when :other is :value.',
    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
    'missing_with' => 'The :attribute field must be missing when :values is present.',
    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    'multiple_of' => 'The :attribute field must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute field format is invalid.',
    'numeric' => ':attribute phải là số.',
    'password' => [
        'letters' => 'The :attribute field must contain at least one letter.',
        'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute field must contain at least one number.',
        'symbols' => 'The :attribute field must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => ':attribute không hợp lệ.',
    'required' => 'Chưa nhập :attribute',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute field must match :other.',
    'size' => [
        'array' => 'The :attribute field must contain :size items.',
        'file' => 'The :attribute field must be :size kilobytes.',
        'numeric' => 'The :attribute field must be :size.',
        'string' => 'The :attribute field must be :size characters.',
    ],
    'starts_with' => 'The :attribute field must start with one of the following: :values.',
    'string' => 'The :attribute field must be a string.',
    'timezone' => 'The :attribute field must be a valid timezone.',
    'unique' => 'Thông tin :attribute đã được sử dụng.',
    'uploaded' => 'The :attribute failed to upload.',
    'uppercase' => 'The :attribute field must be uppercase.',
    'url' => 'The :attribute field must be a valid URL.',
    'ulid' => 'The :attribute field must be a valid ULID.',
    'uuid' => 'The :attribute field must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'phone_vietnam' => [
            'regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại hợp lệ.',
        ],
        'email' => [
            'unique' => 'Email đã được sử dụng. Vui lòng tìm chọn liên hệ/khách hàng đã có.',
        ],
        'phone' => [
            'unique' => 'Số điện thoại đã được sử dụng. Vui lòng tìm chọn liên hệ/khách hàng đã có.',
        ],
        'contact_request_id' => [
            'required' => 'Bạn phải chọn đơn hàng',
        ],
        'relationship_other' => [
            'required' => 'Bạn phải nhập quan hệ khác',
        ],
        'account_id' => [
            'required' => 'Chưa chọn tài khoản nhân viên',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'phone' => 'số điện thoại',
        'name' => 'Tên',
        'contact_id' => 'tên khách hàng',
        'contactId' => 'khách hàng',
        'content' => 'nội dung',
        'fullname' => 'họ và tên',
        'birthday' => 'ngày sinh',
        'parent_fullname' => 'họ và tên phụ huynh',
        'parent_phone' => 'số điện thoại phụ huynh',
        'parent_email' => 'email của phụ huynh',
        'train_product' => 'dịch vụ đào tạo',
        'price' => 'giá',
        'level' => 'trình độ',
        'class_type' => 'loại hình lớp',
        'home_room' => 'chủ nhiệm',
        'study_type' => 'hình thức học',
        'branch' => 'chi nhánh đào tạo',
        'duration' => 'thời lượng đào tạo',
        'unit' => 'đơn vị của thời lượng',
        'abroad_product' => 'dịch vụ du học',
        'apply_time' => 'thời điểm nộp đơn',
        'estimated_enrollment_time' => 'thời gian dự kiến nhập học',
        'gender' => 'giới tính',
        'GPA' => 'GPA',
        'std_score' => 'điểm thi chuẩn hóa',
        'eng_score' => 'điểm thi tiếng anh',
        'plan_apply' => 'chương trình dự kiến',
        'financial_capability' => 'khả năng chi trả',
        'teacher' => 'giáo viên',
        'num_of_student' => 'số lượng học viên',
        'train_hours' => 'số giờ đào tạo',
        'vietnam_teacher' => 'giáo viên Việt Nam',
        'foreign_teacher' => 'giáo viên nước ngoài',
        'tutor_teacher' => 'gia sư',
        'order_type' => 'phân loại',
        'service' => 'dịch vụ',
        'contact' => 'liên hệ',
        'type' => 'loại',

        'num_of_vn_teacher_sections' => 'số buổi của giảng viên Việt Nam',
        'num_of_foreign_teacher_sections' => 'số buổi của giảng viên nước ngoài',
        'num_of_tutor_sections' => 'Số buổi của gia sư',
        'vietnam_teacher_minutes_per_section' => 'thời lượng mỗi buổi tính theo phút của giảng viên Việt Nam',
        'foreign_teacher_minutes_per_section' => 'thời lượng mỗi buổi tính theo phút của giảng viên nước ngoài',
        'tutor_minutes_per_section' => 'thời lượng mỗi buổi tính theo phút của gia sư',

        // Accounting
        'rejected_reason' => 'lí do từ chối',
        'amount' => 'số tiền',

        // Course
        'subject_id' => 'môn học',
        'teacher_id' => 'giáo viên chủ nhiệm',
        'start_at' => 'thời gian bắt đầu',
        'end_at' => 'thời gian kết thúc',
        'duration_each_lesson' => 'thời lượng mỗi buổi học',
        'total_hours' => 'tổng số giờ cần học',
        'test_hours' => 'tổng số giờ kiểm tra',
        'study_method' => 'hình thức học',
        'min_students' => 'số học viên tối thiểu',
        'max_students' => 'số học viên tối đa',
        'vn_teacher_from' => 'thời gian bắt đầu',
        'vn_teacher_to' => 'thời gian kết thúc',
        'foreign_teacher_from' => 'thời gian bắt đầu',
        'foreign_teacher_to' => 'thời gian kết thúc',
        'tutor_from' => 'thời gian bắt đầu',
        'tutor_to' => 'thời gian kết thúc',
        'assistant_from' => 'thời gian bắt đầu',
        'assistant_to' => 'thời gian kết thúc',
        'vn_teacher' => 'giáo viên Việt Nam',
        'foreign_teacher' => 'giáo viên nước ngoài',
        'tutor' => 'gia sư',
        'assistant' => 'trợ giảng',
        'time_to_change_schedule' => 'thời gian bắt đầu đổi lịch',
        'zoom_join_link' => 'thông tin lớp học zoom',
        'order_item' => 'dịch vụ du học',

        'abroad_branch' => 'chi nhánh',

        // Recommendation letter
        'status' => 'trạng thái',
        'date' => 'ngày tạo thư mời',

        //Refund Request
        'reject_reason' => 'lí do từ chối',

        'payment_account_id' => 'tài khoản thanh toán',

        //Section Report
        'section_id' => 'buổi học',
        'student_id' => 'học viên',
        'tinh_dung_gio' => 'tính đúng giờ',
        'muc_do_tap_trung' => 'mức độ tập trung',
        'muc_do_hieu_bai' => 'mức độ hiểu bài',
        'muc_do_tuong_tac' => 'mức độ tương tác',
        'tu_hoc_va_giai_quyet_van_de' => 'tự học và giải quyết vấn đề',
        'tu_tin_trach_nhiem' => 'tự tin trách nhiệm',
        'trung_thuc_ky_luat' => 'trung thực kỷ luật',
        'ket_qua_tren_lop' => 'kết quả trên lớp',
        'teacher_comment' => 'nhận xét của giáo viên',

        //Staff
        'busy_schedule' => 'lịch rảnh',

        // Payrates
        'training_location_id' => 'địa điểm học',
        'study_method' => 'phương thức học',
        'class_status' => 'trạng thái lớp học',
        'class_size' => 'quy mô lớp học',

        // Orders
        'abroad_service_type' => 'loại dịch vụ',
        'abroad_service_id' => 'dịch vụ',
        'subject_type' => 'loại môn học',

        // Payment record
        'method' => 'phương thức thanh toán',
        'payment_date' => 'ngày thanh toán',
        'amount' => 'số tiền thanh toán',

        'extracurricular_id' => "loại hoạt động ngoại khóa",
        'plan_apply_program_id' => "chương trình dự kiến apply",
        'current_program_id' => "chương trình đang học",

        'demand' => "đơn hàng",
        'source_type' => "phân loại nguồn",

        'order_item_id' => 'thông tin học viên'
    ],
];

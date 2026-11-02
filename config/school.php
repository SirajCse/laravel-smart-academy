<?php

/**
 * Smart Academy school settings.
 *
 * Replaces the CI3 `sch_settings` table-driven configuration. The DB table
 * is still the source of truth at runtime; these are defaults loaded before
 * the database is available (e.g. during install / first boot).
 */

return [

    'defaults' => [
        'school_name'        => env('APP_NAME', 'Smart Academy'),
        'session'            => date('Y') . '-' . (date('Y') + 1),
        'default_language'   => 'english',
        'rtl_mode'           => false,
        'theme'              => 'default',
        'currency'           => 'USD',
        'currency_symbol'    => '$',
        'currency_place'     => 'before',
        'timezone'           => env('APP_TIMEZONE', 'Asia/Dhaka'),
        'date_format'        => 'd-m-Y',
        'start_week'         => 'monday',
        'student_login'      => 1,
        'parent_login'       => 1,
        'staff_login'        => 1,
        'admin_login'        => 1,
        'super_admin_login'  => 1,
        'is_rtl'             => false,
        'marksheet'          => 'middle',
        'student_profile_edit' => 0,
        'student_profile_edit_fields' => 'firstname,lastname,email,phone,address',
    ],

    'file_uploads' => [
        'disk'              => env('FILESYSTEM_DISK', 'public'),
        'max_upload_mb'     => env('FILESYSTEM_MAX_UPLOAD_MB', 20),
        'allowed_images'    => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'allowed_documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'zip'],
        'student_photo_path'   => 'student_images/',
        'staff_photo_path'     => 'staff_images/',
        'fee_receipt_path'     => 'fee_receipts/',
        'homework_path'        => 'homework/',
        'syllabus_path'       => 'syllabus/',
        'certificate_path'    => 'certificates/',
    ],

    'payment_modes' => [
        'cash', 'cheque', 'dd', 'bank_transfer', 'online',
    ],

    'gender' => ['male', 'female'],

    'blood_groups' => ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'],

    'attendance_status' => ['present', 'absent', 'late', 'half_day', 'holiday'],

    'session_period' => [
        'start_month' => 4, // April default
    ],
];

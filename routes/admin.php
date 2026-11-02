<?php

/**
 * Admin panel routes — every admin controller becomes a resource.
 * Replaces 97 CI3 admin controllers with RESTful Laravel resources.
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    DashboardController,
    StudentController,
    StudentSessionController,
    ClassController,
    SectionController,
    ClassSectionController,
    SessionController,
    CategoryController,
    SubjectController,
    SubjectGroupController,
    TeacherSubjectController,
    ClassTeacherController,
    ClassSectionTimeController,
    TimetableController,
    StaffController,
    StaffRoleController,
    DepartmentController,
    DesignationController,
    RoleController,
    PermissionController,
    RolePermissionController,
    SchSettingController,
    LanguageController,
    CurrencyController,
    EmailConfigController,
    SmsConfigController,
    FeecategoryController,
    FeetypeController,
    FeegroupController,
    FeesessiongroupController,
    FeemasterController,
    FeediscountController,
    FeereminderController,
    StudentfeeController,
    StudentFeesMasterController,
    StudentFeesDiscountController,
    FeeInstallmentController,
    AttendenceReportController,
    AttendencetypeController,
    StudentAttendenceController,
    StaffAttendenceController,
    HolidayController,
    HomeworkController,
    HomeworkEvaluationController,
    ExamgroupController,
    ExamController,
    ExamscheduleController,
    ExamresultController,
    ExamstudentController,
    ExamsubjectController,
    GradeController,
    AdmitcardController,
    CertificateController,
    GeneratecertificateController,
    GenerateidcardController,
    GeneratestaffidcardController,
    BookController,
    BookissueController,
    LibraryMemberController,
    IncomeController,
    ExpenseController,
    ExpenseheadController,
    IncomeheadController,
    EnquiryController,
    ComplaintController,
    ComplaintTypeController,
    GeneralCallController,
    ApplyLeaveController,
    DisableReasonController,
    AlumniController,
    InventoryController,
    InventoryItemController,
    InventoryIssueController,
    TransportRouteController,
    TransportVehicleController,
    TransportMemberController,
    HostelController,
    HostelRoomController,
    HostelMemberController,
    FrontcmsSettingController,
    FrontcmsMenuController,
    FrontcmsPageController,
    FrontcmsMediaController,
    FrontcmsProgramController,
    CustomfieldController,
    ContentController,
    ContenttypeController,
    FiletypeController,
    SendNotificationController,
    ChatController,
    AuditController,
    AddonsController,
    BiometricController,
    MigrateController,
    ReportController,
    FinanceReportController,
    CronController,
    WebhooksController,
};

// ─── Dashboard / landing ────────────────────────────────────────────
Route::get('/dashboard',                              [DashboardController::class, 'index'])->name('dashboard');

// Admin profile
Route::get('/profile',                                [DashboardController::class, 'profile'])->name('profile');

// ─── School settings ───────────────────────────────────────────────
Route::get('/schsettings',                            [SchSettingController::class, 'index'])->name('schsettings.index');
Route::post('/schsettings',                           [SchSettingController::class, 'update'])->name('schsettings.update');
Route::post('/schsettings/logo',                      [SchSettingController::class, 'uploadLogo'])->name('schsettings.logo');
Route::post('/schsettings/sidebar',                   [SchSettingController::class, 'uploadSidebar'])->name('schsettings.sidebar');
Route::get('/schsettings/audit',                      [SchSettingController::class, 'audit'])->name('schsettings.audit');
Route::get('/schsettings/backup',                     [SchSettingController::class, 'backup'])->name('schsettings.backup');
Route::post('/schsettings/backup',                   [SchSettingController::class, 'runBackup'])->name('schsettings.runBackup');
Route::post('/schsettings/restore',                   [SchSettingController::class, 'restoreBackup'])->name('schsettings.restore');

// ─── Students ──────────────────────────────────────────────────────
Route::resource('student',                            StudentController::class);
Route::get('student/import/sample',                   [StudentController::class, 'sampleImport'])->name('student.import.sample');
Route::post('student/import',                         [StudentController::class, 'import'])->name('student.import');
Route::post('student/{id}/disable',                  [StudentController::class, 'disable']);
Route::post('student/{id}/enable',                   [StudentController::class, 'enable']);
Route::get('student/{id}/profile',                    [StudentController::class, 'profile']);
Route::get('student/{id}/print',                      [StudentController::class, 'print']);
Route::post('student/{id}/guardian',                 [StudentController::class, 'updateGuardian']);
Route::get('student/{id}/fees',                       [StudentController::class, 'fees']);
Route::get('student/{id}/attendance',                [StudentController::class, 'attendance']);
Route::get('student/{id}/exam-result',               [StudentController::class, 'examResult']);
Route::post('student/{id}/photo',                     [StudentController::class, 'uploadPhoto']);

// ─── Classes / Sections ────────────────────────────────────────────
Route::resource('class',                              ClassController::class);
Route::resource('section',                            SectionController::class);
Route::resource('class-section',                      ClassSectionController::class);
Route::get('class/{class}/sections',                 [ClassController::class, 'sectionsByClass'])->name('class.sectionsByClass');
Route::resource('session',                            SessionController::class);
Route::resource('category',                           CategoryController::class);
Route::resource('subject',                            SubjectController::class);
Route::resource('subject-group',                     SubjectGroupController::class);
Route::resource('teacher-subject',                   TeacherSubjectController::class);
Route::resource('class-teacher',                     ClassTeacherController::class);
Route::resource('class-section-time',                 ClassSectionTimeController::class);
Route::resource('timetable',                          TimetableController::class);

// ─── Staff ─────────────────────────────────────────────────────────
Route::resource('staff',                              StaffController::class);
Route::resource('staff-role',                         StaffRoleController::class);
Route::resource('department',                         DepartmentController::class);
Route::resource('designation',                        DesignationController::class);
Route::resource('role',                               RoleController::class);
Route::resource('permission',                         PermissionController::class);
Route::resource('role-permission',                    RolePermissionController::class);

// ─── Languages / Currencies ───────────────────────────────────────
Route::resource('language',                           LanguageController::class);
Route::resource('currency',                           CurrencyController::class);

// ─── Email & SMS Config ───────────────────────────────────────────
Route::resource('emailconfig',                        EmailConfigController::class);
Route::post('emailconfig/test',                       [EmailConfigController::class, 'sendTest']);
Route::resource('smsconfig',                          SmsConfigController::class);
Route::post('smsconfig/test',                         [SmsConfigController::class, 'sendTest']);

// ─── Fees module ──────────────────────────────────────────────────
Route::resource('feecategory',                        FeecategoryController::class);
Route::resource('feetype',                            FeetypeController::class);
Route::resource('feegroup',                           FeegroupController::class);
Route::resource('feesessiongroup',                    FeesessiongroupController::class);
Route::resource('feemaster',                          FeemasterController::class);
Route::resource('feediscount',                       FeediscountController::class);
Route::get('fees-discount',                            [FeediscountController::class, 'index'])->name('fees-discount.index');
Route::get('fees-discount/create',                     [FeediscountController::class, 'create'])->name('fees-discount.create');
Route::post('fees-discount',                           [FeediscountController::class, 'store'])->name('fees-discount.store');
Route::get('fees-discount/{record}',                   [FeediscountController::class, 'show'])->name('fees-discount.show');
Route::get('fees-discount/{record}/edit',              [FeediscountController::class, 'edit'])->name('fees-discount.edit');
Route::put('fees-discount/{record}',                   [FeediscountController::class, 'update'])->name('fees-discount.update');
Route::delete('fees-discount/{record}',                [FeediscountController::class, 'destroy'])->name('fees-discount.destroy');
Route::resource('feereminder',                       FeereminderController::class);
Route::resource('student-fee',                        StudentfeeController::class);
Route::post('student-fee/{id}/collect',               [StudentfeeController::class, 'collect']);
Route::post('student-fee/{id}/refund',                [StudentfeeController::class, 'refund']);
Route::get('student-fee/{id}/receipt',               [StudentfeeController::class, 'receipt']);
Route::resource('student-fees-master',                StudentFeesMasterController::class);
Route::resource('student-fees-discount',              StudentFeesDiscountController::class);
Route::resource('fee-installment',                    FeeInstallmentController::class);

// ─── Attendance ───────────────────────────────────────────────────
Route::resource('attendence-report',                  AttendenceReportController::class);
Route::resource('attendence-type',                    AttendencetypeController::class);
Route::resource('student-attendence',                 StudentAttendenceController::class);
Route::post('student-attendence/save',                [StudentAttendenceController::class, 'save']);
Route::resource('staff-attendence',                   StaffAttendenceController::class);
Route::resource('holiday',                            HolidayController::class);

// ─── Homework ─────────────────────────────────────────────────────
Route::resource('homework',                           HomeworkController::class);
Route::resource('homework-evaluation',                HomeworkEvaluationController::class);
Route::post('homework/{id}/evaluation',               [HomeworkController::class, 'saveEvaluation']);

// ─── Exams ────────────────────────────────────────────────────────
Route::resource('examgroup',                          ExamgroupController::class);
Route::resource('exam',                               ExamController::class);
Route::resource('examschedule',                       ExamscheduleController::class);
Route::resource('examresult',                         ExamresultController::class);
Route::resource('examstudent',                        ExamstudentController::class);
Route::resource('examsubject',                        ExamsubjectController::class);
Route::resource('grade',                              GradeController::class);
Route::resource('admitcard',                          AdmitcardController::class);
Route::resource('certificate',                       CertificateController::class);
Route::resource('generate-certificate',              GeneratecertificateController::class);
Route::resource('generate-idcard',                   GenerateidcardController::class);
Route::resource('generate-staffidcard',              GeneratestaffidcardController::class);

// ─── Library ──────────────────────────────────────────────────────
Route::resource('book',                               BookController::class);
Route::resource('book-issue',                         BookissueController::class);
Route::resource('library-member',                     LibraryMemberController::class);

// ─── Income / Expense ─────────────────────────────────────────────
Route::resource('income',                             IncomeController::class);
Route::resource('expense',                            ExpenseController::class);
Route::resource('expense-head',                       ExpenseheadController::class);
Route::resource('income-head',                        IncomeheadController::class);

// ─── Front office ─────────────────────────────────────────────────
Route::resource('enquiry',                            EnquiryController::class);
Route::resource('complaint',                         ComplaintController::class);
Route::resource('complaint-type',                     ComplaintTypeController::class);
Route::resource('general-call',                       GeneralCallController::class);
Route::resource('apply-leave',                        ApplyLeaveController::class);
Route::resource('disable-reason',                    DisableReasonController::class);
Route::resource('alumni',                             AlumniController::class);

// ─── Inventory ────────────────────────────────────────────────────
Route::resource('inventory',                          InventoryController::class);
Route::resource('inventory-item',                     InventoryItemController::class);
Route::resource('inventory-issue',                    InventoryIssueController::class);

// ─── Transport ────────────────────────────────────────────────────
Route::resource('transport-route',                    TransportRouteController::class);
Route::resource('transport-vehicle',                  TransportVehicleController::class);
Route::resource('transport-member',                   TransportMemberController::class);

// ─── Hostel ───────────────────────────────────────────────────────
Route::resource('hostel',                             HostelController::class);
Route::resource('hostel-room',                        HostelRoomController::class);
Route::resource('hostel-member',                      HostelMemberController::class);

// ─── Front-CMS ────────────────────────────────────────────────────
Route::resource('frontcms-setting',                   FrontcmsSettingController::class);
Route::resource('frontcms-menu',                     FrontcmsMenuController::class);
Route::resource('frontcms-page',                     FrontcmsPageController::class);
Route::resource('frontcms-media',                    FrontcmsMediaController::class);
Route::resource('frontcms-program',                   FrontcmsProgramController::class);

// ─── Custom fields ────────────────────────────────────────────────
Route::resource('customfield',                        CustomfieldController::class);

// ─── Content / CMS ────────────────────────────────────────────────
Route::resource('content',                           ContentController::class);
Route::resource('content-type',                       ContenttypeController::class);
Route::resource('file-type',                         FiletypeController::class);

// ─── Notifications & chat ─────────────────────────────────────────
Route::resource('send-notification',                  SendNotificationController::class);
Route::resource('chat',                              ChatController::class);
Route::post('chat/send',                             [ChatController::class, 'send']);
Route::get('chat/{id}/messages',                     [ChatController::class, 'messages']);

// ─── Audit ────────────────────────────────────────────────────────
Route::resource('audit',                              AuditController::class);

// ─── Addons / modules ─────────────────────────────────────────────
Route::resource('addons',                            AddonsController::class);
Route::post('addons/{id}/install',                   [AddonsController::class, 'install']);
Route::post('addons/{id}/uninstall',                 [AddonsController::class, 'uninstall']);
Route::post('addons/{id}/activate',                  [AddonsController::class, 'activate']);
Route::post('addons/{id}/deactivate',                [AddonsController::class, 'deactivate']);

// ─── Biometric ────────────────────────────────────────────────────
Route::resource('biometric',                         BiometricController::class);
Route::post('biometric/sync',                         [BiometricController::class, 'sync']);

// ─── Migration tool ───────────────────────────────────────────────
Route::get('migrate',                                [MigrateController::class, 'index']);
Route::post('migrate/run',                           [MigrateController::class, 'run']);

// ─── Reports ───────────────────────────────────────────────────────
Route::get('reports/student',                        [ReportController::class, 'student'])->name('reports.student');
Route::get('reports/fee',                            [ReportController::class, 'fee'])->name('reports.fee');
Route::get('reports/attendance',                     [ReportController::class, 'attendance'])->name('reports.attendance');
Route::get('reports/exam',                           [ReportController::class, 'exam'])->name('reports.exam');
Route::get('reports/income',                         [FinanceReportController::class, 'income'])->name('reports.income');
Route::get('reports/expense',                        [FinanceReportController::class, 'expense'])->name('reports.expense');
Route::get('reports/balance',                        [FinanceReportController::class, 'balance'])->name('reports.balance');
Route::get('reports/library',                        [ReportController::class, 'library'])->name('reports.library');
Route::get('reports/inventory',                      [ReportController::class, 'inventory'])->name('reports.inventory');
Route::get('reports/alumni',                         [ReportController::class, 'alumni'])->name('reports.alumni');

// Cron & webhooks admin views
Route::resource('cron',                              CronController::class);
Route::resource('webhooks',                         WebhooksController::class);

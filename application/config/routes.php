<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
/////////////// ADMIN PAGES ////////////////

$route['admin'] = "login";
$route['admin/logout'] = "login/logout";
$route['admin/(:any)'] = "$1/$1";
///////////// FRONT PAGES ///////////////////////
$route['default_controller'] = "front";
/*-------API ROUTES -----------*/
$route['institutes'] = "front/get_institutes";
$route['user-login'] = "front/get_user_login";
$route['user-logout'] = "front/get_user_logout";
$route['login-validation'] = "front/get_user_login_validation";
$route['apply-leave'] = "front/apply_leave";
$route['children-list'] = "front/get_children_list";
$route['teacher-subject-list'] = "front/get_teacher_subject_list";
$route['announcement-list'] = "front/get_announcement_list";
$route['announcement-detail'] = "front/get_announcement_detail";
$route['subject-detail'] = "front/get_subject_detail";
$route['student-list'] = "front/get_student_list";
$route['take-attendance'] = "front/take_attendance";
$route['parent-leave-history'] = "front/get_parent_leave_history";
$route['parent-leave-detail'] = "front/get_parent_leave_detail";
$route['attendance-list'] = "front/get_attendance_list";
$route['attendance-detail'] = "front/get_attendance_detail";
$route['student-attendance-detail'] = "front/get_student_attendance_detail";
$route['user-profile'] = "front/get_user_profile";
$route['student-subject'] = "front/get_student_subject_list";
$route['teacher-list'] = "front/get_student_teacher_list";
$route['check-attendance'] = "front/check_attendance";
$route['get-student-test'] = "front/get_student_test";
$route['submit-test'] = "front/submit_test";
$route['teacher-test-list'] = "front/get_teacher_test_list";
$route['parent-test-list'] = "front/get_parent_test_list";
$route['teacher-test-detail'] = "front/get_teacher_test_detail";
$route['parent-test-detail'] = "front/get_parent_test_detail";
$route['submit-test-marks'] = "front/submit_test_marks";
$route['edit-test-marks'] = "front/edit_test_marks";
$route['promotion-banner'] = "front/get_promotion_banner";
$route['edit-test-detail'] = "front/edit_test_detail";
$route['parent-exam-list'] = "front/get_parent_exam_list";
$route['parent-exam-detail'] = "front/get_parent_exam_detail";
$route['teacher-exam-class-list'] = "front/get_teacher_exam_class_list";
$route['teacher-exam-list'] = "front/get_teacher_exam_list";
$route['teacher-class-student-list'] = "front/get_teacher_class_student_list";
$route['teacher-leave-history'] = "front/get_teacher_leave_history";
$route['teacher-leave-detail'] = "front/get_teacher_leave_detail";
$route['leave-status-change'] = "front/change_leave_status";
$route['get-timetable'] = "front/get_section_timetable";
$route['exam-datesheet'] = "front/get_exam_datesheet";
$route['all-classes'] = "front/get_all_classes";
$route['all-sections'] = "front/get_all_sections";

$route['insert-feedback'] = "front/insert_feedback";
$route['feedback-list'] = "front/get_feedback_list";
$route['insert-feedback-reply'] = "front/insert_feedback_reply";
$route['feedback-detail'] = "front/get_feedback_detail";

$route['voucher-year'] = "front/get_voucher_year";
$route['fee-voucher-list'] = "front/get_fee_voucher_list";
$route['get-fee-voucher'] = "front/get_std_fee_voucher";
$route['pay-fee-voucher'] = "front/pay_std_fee_voucher";

$route['send-notification'] = "front/send_notification";
$route['update-fcm-token'] = "front/update_fcm_token";
$route['teacher-notification-list'] = "front/teacher_notification_list";
$route['notification-list'] = "front/notification_list";
$route['change-notification-status'] = "front/change_notification_status";
$route['count-unread-notification'] = "front/count_unread_notification";


$route['404_override'] = '';
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Front extends MX_Controller {
protected $data = '';
function __construct() {
parent::__construct();
$this->load->library("pagination");
$this->load->helper("url");
}
////////////////////////// FOR HOME PAGE /////////////////////
function index() {
    $this->load->module('template');
    $data['header_file'] = 'header';
    $data['page_title'] = 'Home';
    $data['view_file'] = 'home_page';
    $this->template->front($data);
}
function send_notification($token, $title, $description){
    require_once STATIC_FRONT_NOTIFICATION.'google-api-php-client/vendor/autoload.php';
    foreach ($token as $key => $value) {
        $this->send_notification_fn($value['fcm_token'], $title,$description);
    }
    $this->send_notification_fn('fVhlVO2mLxM:APA91bEX5ctt8hjUNYxmI9FrAfDGdXhOpK4rL_Uzt3UEIqSzv8VH_WDbJ5Bo24NT47Zjm97E_zkd_FI_c1ZgdUyjgkNa4-Tge4xta01fQnTeXmgqvday_vIdjph7s5ICxAUSIORTuWJm', 'title', 'description');
}
function send_notification_fn($to, $title,$description) {
    date_default_timezone_set("Asia/Karachi");
    $file_name = STATIC_FRONT_NOTIFICATION.'xpertatendy-firebase-adminsdk-crvvw-6dcb55a422.json';
    putenv('GOOGLE_APPLICATION_CREDENTIALS='.$file_name);
    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    $httpClient = $client->authorize();
    $project = "xpertatendy";
    // Creates a notification for subscribers to the debug topic
    $message = [
        "message" => [
            "token" => $to,
            "data" => [
                'title' => $title,
                'message' => $description,
            ],
        ]
    ];
    $response = $httpClient->post("https://fcm.googleapis.com/v1/projects/{$project}/messages:send", ['json' => $message]);
    "<br><br>";
 // print_r($response);
}

function update_fcm_token(){
    $api = $this->input->post('api');
    $status='';
    if($api == 'true'){
        $user_id = $this->input->post('userId');
        $fcm_token = $this->input->post('fcmToken');
        $org_id = $this->input->post('orgId');
        $check = $this->_update_fcm_token($user_id,$fcm_token,$org_id);
        
        if($check==1){
            $status = true;
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}


function get_institutes (){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $institutes = $this->_get_institutes()->result_array();
        if(isset($institutes) && !empty($institutes)){
            $status = true;
            $data = $institutes;
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}
function get_user_login(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $inst_id = $this->input->post('instId');
        $username = $this->input->post('number');
        $password = $this->input->post('password');
        $imei = $this->input->post('imei');
        $device_name = $this->input->post('deviceName');
        date_default_timezone_set("Asia/Karachi");
        $currentDateTime = date('Y-m-d H:i:s');

        if(empty($imei)){
            $status = false;
            $message = 'Allow Phone Permissions First';
            $data = '';
            header('Content-Type: application/json');
            echo json_encode(array('status'=>$status, 'message' => $message,  'data'=>$data));
            exit();
        }

        $login_data = $this->_get_user_login($inst_id, $username, $password)->result_array();
        // print_r($login_data);exit();
        if(isset($login_data) && !empty($login_data)){
            foreach ($login_data as $key => $value) {
                $check_session = $this->_check_session($value['userId'],$value['phone'],$value['orgId'])->result_array();
                if(isset($check_session) && !empty($check_session)){
                    if($check_session[0]['login_status'] == 0 && $check_session[0]['imei'] != $imei){
                        $data['user_id'] = $value['userId'];
                        $data['username'] = $value['phone'];
                        $data['imei'] = $imei;
                        $data['device_name'] = $device_name;
                        $data['login_date_time'] = $currentDateTime;
                        $data['org_id'] = $value['orgId'];
                        $confirm = $this->_create_session($data);
                        if($confirm != 0){
                            $status = true;
                            $message = 'login successful';
                            $data = $login_data;
                        }
                        else{
                            $status = false;
                            $message = 'login unsuccessful';
                            $data = '';
                        }
                    }
                    elseif ($check_session[0]['login_status'] == 1) {
                        $logout = $this->_logout($currentDateTime,$value['userId'],$username,$inst_id);
                        $data['user_id'] = $value['userId'];
                        $data['username'] = $value['phone'];
                        $data['imei'] = $imei;
                        $data['device_name'] = $device_name;
                        $data['login_date_time'] = $currentDateTime;
                        $data['org_id'] = $value['orgId'];
                        $confirm = $this->_create_session($data);
                        if($confirm != 0){
                            $status = true;
                            $message = 'login successful';
                            $data = $login_data;
                        }
                        else{
                            $status = false;
                            $message = 'login unsuccessful';
                            $data = '';
                        }
                    }
                    else{
                        $data='';
                        $message = 'User Already Logged in';
                    }
                }
                else
                {
                    $data['user_id'] = $value['userId'];
                    $data['username'] = $value['phone'];
                    $data['imei'] = $imei;
                    $data['device_name'] = $device_name;
                    $data['login_date_time'] = $currentDateTime;
                    $data['org_id'] = $value['orgId'];
                    $confirm = $this->_create_session($data);
                    if($confirm != 0){
                        $status = true;
                        $message = 'Logged in successfully';
                        $data = $login_data;
                    }
                    else{
                        $status = false;
                        $message = 'login unsuccessful';
                        $data = '';
                    }
                }
            }
        }
        else{
            $status = false;
            $data='';
            $message = 'Invalid Username or Password';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'message' => $message,  'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_user_logout(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message ='';
        $inst_id = $this->input->post('orgId');
        $username = $this->input->post('number');
        $user_id = $this->input->post('userId');
        date_default_timezone_set("Asia/Karachi");
        $currentDateTime = date('Y-m-d H:i:s');

        $logout = $this->_logout($currentDateTime,$user_id,$username,$inst_id);
        if(isset($logout) && !empty($logout)){
            $status = true;
            $message = 'Logout successful';
        }
        else{
            $status = true;
            $message = 'successful';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'message' => $message));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function login_validation($user_id,$username,$imei,$org_id){
    $api = $this->input->post('api');
    if($api == 'true'){
        $check_session = $this->_login_validation($user_id,$username,$imei,$org_id)->result_array();
        if(isset($check_session) && !empty($check_session)){
            $status = 'true';
            return $status;
        }
        else{
            $status = 'false';
            return $status;
        }
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_user_login_validation(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = '';
        $message ='';
        $org_id = $this->input->post('orgId');
        $username = $this->input->post('number');
        $user_id = $this->input->post('userId');
        $imei = $this->input->post('imei');

        $check = $this->login_validation($user_id,$username,$imei,$org_id);
        if($check == 'true'){
            $status = true;
            $message = '';
        }
        elseif($check == 'false'){
            $status = false;
            $message = 'This user is already Logged in from other Deive';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'message' => $message));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}


function get_teacher_subject_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = 'Subject Not Found';
        $teacher_id = $this->input->post('teacherId');
        $org_id = $this->input->post('orgId');
        $page_no = $this->input->post('page_no');
        $limit = 20;
        $subjects_data = $this->_get_teacher_subject_list($teacher_id, $org_id, $page_no, $limit);
        foreach ($subjects_data['all_data'] as $key => $value) {
            $finalData['subId'] = $value['subId'];
            $finalData['subName'] = $value['subName'];
            $finalData['subjectType'] = $value['subjectType'];
            $finalData['time'] = $value['time'];
            $finalData['sectionId'] = $value['section_id'];
            $sectionData = $this->_get_teacher_sections($value['section_id'], $value['class_id'],$org_id)->result_array();

            if(isset($sectionData) && !empty($sectionData))
                $finalData['sectionName'] = $sectionData[0]['sectionName'];

            $finalData['classId'] = $value['class_id'];
            $classData = $this->_get_teacher_classes($value['class_id'],$org_id)->result_array();

            if(isset($classData) && !empty($classData))
                $finalData['className'] = $classData[0]['className'];

            $finalData['totalStds'] = $this->_get_total_num_of_stds($value['subjectType'],$value['subId'],$value['section_id'],$value['class_id'],$org_id)->num_rows();
            $finalData2[] = $finalData;
        }

        if(isset($finalData2) && !empty($finalData2)){
            $status = true;
            $data = $finalData2;
        }
        else{
            $data='';
            $message='Subject not Found';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data,'message'=>$message, 'total_pages'=>ceil($subjects_data['count_data']/$limit)));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_student_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $section_id = $this->input->post('sectionId');
        $subject_id = $this->input->post('subjectId');
        $subject_type = $this->input->post('subjectType');
        $org_id = $this->input->post('orgId');

        $student_list = $this->_get_student_list($section_id, $org_id, $subject_id, $subject_type)->result_array();
        if(isset($student_list) && !empty($student_list)){
            foreach ($student_list as $key => $value) {
                if(isset($value['image']) && !empty($value['image'])){
                    $finalData['stdImage'] = BASE_URL.SMALL_STUDENT_IMAGE_PATH.$value['image'];
                }
                else{
                    if ($value['gender'] == 'Female') {
                        $finalData['stdImage'] = STATIC_FRONT_IMAGE.'static-female.png';
                    }
                    else{
                        $finalData['stdImage'] = STATIC_FRONT_IMAGE.'static-male.png';
                    }
                }
                $data['stdId'] = $value['stdId'];
                $data['stdRollNo'] = $value['stdRollNo'];
                $data['stdName'] = $value['stdName'];
                $data['stdMarks'] = '';
                $data['attendStatus'] = '';
                $data2[] = $data;
            }
            $status = true;
        }
        else{
            $message = 'Record not found';
            $data2 = '';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data2, 'message'=>$message));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_announcement_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $org_id = $this->input->post('orgId');
        $page_no = $this->input->post('page_no');
        $limit = 20;
        $announcement_list = $this->_get_announcement_list($org_id, $page_no, $limit);
        
        if(isset($announcement_list['limit_data']) && !empty($announcement_list['limit_data'])){
            $status = true;
            foreach ($announcement_list['limit_data'] as $key => $value) {
                $anc_data['ancmntId'] = $value['ancmntId'];
                $anc_data['title'] = $value['title'];
                $anc_data['image'] = BASE_URL.MEDIUM_ANNOUNCEMENT_IMAGE_PATH.$value['image'];
                $anc_data['startDate'] = $value['startDate'];
                $anc_data['endDate'] = $value['endDate'];
                $anc_data['description'] = $value['description'];
                $data[] = $anc_data;
            }
        }
        if(isset($data) && !empty($data)){
        $status = true;
        $data = $data;
        }
        else{
            $data = '';
            $message = 'No Announcements';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data, 'total_pages'=>ceil($announcement_list['count_data']/$limit)));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_announcement_detail(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $ancmntId = $this->input->post('ancmntId');
        $org_id = $this->input->post('orgId');
        $announcement_detail = $this->_get_announcement_detail($ancmntId,$org_id)->result_array();
        if(isset($announcement_detail) && !empty($announcement_detail)){
            $status = true;
            foreach ($announcement_detail as $key => $value) {
                $anc_data['title'] = $value['title'];
                $anc_data['image'] = BASE_URL.ACTUAL_ANNOUNCEMENT_IMAGE_PATH.$value['image'];
                $anc_data['startDate'] = $value['startDate'];
                $anc_data['endDate'] = $value['endDate'];
                $anc_data['description'] = $value['description'];
                $data[] = $anc_data;
            }
        }
        if(isset($data) && !empty($data)){
            $status = true;
            $data = $data;
            }
            else{
                $message = 'Record not found';
                $data = '';
            }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_children_list() {
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message="";
        $parent_id = $this->input->post('parentId');
        $org_id = $this->input->post('orgId');
        $children_list = $this->_get_children_list($parent_id,$org_id)->result_array();
        foreach ($children_list as $key => $value) {
            $finalData['stdId'] = $value['stdId'];
            if(isset($value['image']) && !empty($value['image'])){
                $finalData['stdImage'] = BASE_URL.SMALL_STUDENT_IMAGE_PATH.$value['image'];
            }
            else{
                if ($value['gender'] == 'Female') {
                    $finalData['stdImage'] = STATIC_FRONT_IMAGE.'static-female.png';
                }
                else{
                    $finalData['stdImage'] = STATIC_FRONT_IMAGE.'static-male.png';
                }
            }
            $finalData['stdName'] = $value['stdName'];
            $finalData['stdRollNo'] = $value['stdRollNo'];
            $finalData['sectionId'] = $value['section_id'];
            $sectionData = $this->_get_teacher_sections($value['section_id'], $value['class_id'],$org_id)->result_array();
            if(isset($sectionData) && !empty($sectionData))
                $finalData['sectionName'] = $sectionData[0]['sectionName'];
            $finalData['classId'] = $value['class_id'];
            $classData = $this->_get_teacher_classes($value['class_id'],$org_id)->result_array();
            if(isset($classData) && !empty($classData))
                $finalData['className'] = $classData[0]['className'];
            $record = $this->_get_overall_student_attendence($value['stdRollNo'],$value['stdId'])->result_array();
            // print_r($record);
            if (isset($record) && !empty($record)) {
                $present=0;$absent=0;$leave=0;$percent=0;
                foreach ($record as $key => $value) {
                    if ($value['attend_status']=='present') {
                        $present++;
                    }
                    elseif ($value['attend_status']=='absent') {
                        $absent++;
                    }
                    elseif ($value['attend_status']=='leave') {
                        $leave++;
                    }
                    if($present != 0 || $absent != 0 || $leave != 0){
                        $presentPercent=($present/($present+$absent+$leave))*100;
                        $absentPercent=($absent/($present+$absent+$leave))*100;
                        $leavePercent=($leave/($present+$absent+$leave))*100;
                        if(isset($presentPercent)){
                            $finalData['presentPercent']=round($presentPercent,2);
                        }
                        else{
                            $finalData['presentPercent'] = 0;
                        }
                        if(isset($absentPercent)){
                            $finalData['absentPercent']=round($absentPercent,2);
                        }
                        else{
                            $finalData['absentPercent'] = 0;
                        }

                        if(isset($leavePercent)){
                            $finalData['leavePercent']=round($leavePercent,2);
                        }
                        else{
                            $finalData['leavePercent'] = 0;
                        }
                    }
                }
            }
            else{
                    $finalData['presentPercent'] = 0;
                    $finalData['absentPercent'] = 0;
                    $finalData['leavePercent'] = 0;
                }
            $finalData2[] = $finalData;
        }
        if(isset($finalData2) && !empty($finalData2)){
            $status = true;
            $data = $finalData2;
        }
        else{
            $data="";
            $message="Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function check_attendance(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message="";
        $attend_date = $this->input->post('attendDate');
        $org_id = $this->input->post('orgId');
        $subject_id = $this->input->post('subjectId');
        $rows = $this->_check_attendance($attend_date,$subject_id,$org_id)->num_rows();
        if($rows>0){
            $status=true;
            $message="Attendance Already Submitted";
        }
        else{
            $status=false;
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function take_attendance(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $studentAttendance = $this->input->post('studentAttendance');
        $data['subject_id'] = $this->input->post('subjectId');
        $data['section_id'] = $this->input->post('sectionId');
        $data['class_id'] = $this->input->post('classId');
        $data['teacher_id'] = $this->input->post('teacherId');
        $data['attend_date'] = $this->input->post('attendDate');
        $data['org_id'] = $this->input->post('orgId');
        $id = $this->_insert_attend_data($data);
        $someArray = json_decode($studentAttendance, true);
        if(isset($someArray) && !empty($someArray))
        foreach($someArray as $value){
            $data2['attend_id'] = $id;
            $data2['student_id'] = $value['stdId'];
            $data2['roll_no'] = $value['stdRollNo'];
            $data2['student_name'] = $value['stdName'];
            $data2['attend_status'] = $value['attendStatus'];
            $data2['attend_date'] = $this->input->post('attendDate');
            $return_id = $this->_insert_student_attend_data($data2);
        }
        if($return_id == 1){
            header('Content-Type: application/json');
            echo json_encode(array("status" => true, "message"=> "attendance submitted successfully"));   
        }
        else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => false, "message"=> "Something went wrong"));
        }
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_subject_detail(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $subject_id = $this->input->post('subjectId');
        $org_id = $this->input->post('orgId');
        $subject_detail = $this->_get_subject_detail($subject_id, $org_id)->result_array();
        foreach ($subject_detail as $key => $value) {
            $classData = $this->_get_teacher_classes($value['class_id'],$org_id)->result_array();
            $finalData['classId'] = $value['class_id'];
            $finalData['className'] = $classData[0]['className'];
            $finalData['subjectName'] = $value['name'];
            $finalData['sectionId'] = $value['section_id'];
            $finalData['subjectType'] = $value['s_type'];
            $sectionData = $this->_get_teacher_sections($value['section_id'], $value['class_id'],$org_id)->result_array();
            if(isset($sectionData) && !empty($sectionData))
                $finalData['sectionName'] = $sectionData[0]['sectionName'];
            $finalData['noOfStudents'] = $this->_get_total_num_of_stds($value['s_type'],$subject_id,$value['section_id'],$value['class_id'],$org_id)->num_rows();
        }
        $attend_id = $this->_get_attendance_id($subject_id, $org_id)->result_array();
        $present=0;$absent=0;$leave=0;$percent=0;
        $finalData['leavePercent'] = 0;
        $finalData['presentPercent'] = 0;
        $finalData['absentPercent'] = 0;
        foreach($attend_id as $key => $value) {
            $attend_list = $this->_get_attendance_list($value['attend_id'], $value['attend_date'])->result_array();
            
            if($attend_list!=null){

                foreach ($attend_list as $key => $value) {

                    if($value['attend_status']=='present'){
                        $present++;
                    }
                    elseif($value['attend_status']=='absent'){
                        $absent++;
                    }
                    elseif($value['attend_status']=='leave'){
                        $leave++;
                    }
                }
            }

            if($present != 0 || $absent != 0 || $leave != 0){
                $presentPercent=($present/($present+$absent+$leave))*100;
                $absentPercent=($absent/($present+$absent+$leave))*100;
                $leavePercent=($leave/($present+$absent+$leave))*100;
                if(isset($presentPercent)){
                    $finalData['presentPercent']=round($presentPercent,2);
                }
                if(isset($absentPercent)){
                    $finalData['absentPercent']=round($absentPercent,2);
                }
                if(isset($leavePercent)){
                    $finalData['leavePercent']=round($leavePercent,2);
                }
            }
            }
        if(isset($finalData) && !empty($finalData)){
            $status = true;
            $data = $finalData;
        }

        else{
            $data = '';
            $status = false;
            $message = 'Record not Found';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_attendance_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $subject_id = $this->input->post('subjetId');
        $org_id = $this->input->post('orgId');
        // $subject_id = 5;
        // $org_id = 10;
        $attend_data = $this->_get_attendance_id($subject_id, $org_id)->result_array();
        foreach ($attend_data as $key => $value) {
            $present=0;$absent=0;$leave=0;
            $attend_list = $this->_get_attendance_list($value['attend_id'],$value['attend_date'])->result_array();
            if($attend_list!=null){
                foreach ($attend_list as $key => $value) {
                    if($value['attend_status']=='present'){
                        $present++;
                    }
                    elseif($value['attend_status']=='absent'){
                        $absent++;
                    }
                    elseif($value['attend_status']=='leave'){
                        $leave++;
                    }
                }
                $finalData['id'] = $value['attend_id'];
                $finalData['attendanceDate'] = $value['attend_date'];
                $finalData['presentStds']=$present;
                $finalData['absentStds']=$absent;
                $finalData['leaveStds']=$leave; 
                $finalData2[] = $finalData;  
            }
        }
        if(isset($finalData2) && !empty($finalData2)){
            $status = true;
            $data = $finalData2;
        } 
        else
        {
            $status = false;
            $message = 'Sorry! Attendance Record Not Found';
            $data = '';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}


function get_attendance_detail(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $org_id = $this->input->post('orgId');
        $subject_id = $this->input->post('subjectId');
        $attend_id = $this->input->post('attndId');
        $attend_date = $this->input->post('attndDate');
        $finalData['id'] = $attend_id;
        $finalData['attndanceDate'] = $attend_date;
        $attend_record = $this->_get_attendance_record($attend_id,$attend_date,$org_id, $subject_id)->result_array();
        if(isset($attend_record) && !empty($attend_record))
            $classData = $this->_get_teacher_classes($attend_record[0]['class_id'],$org_id)->result_array();
            $finalData['classId'] = $attend_record[0]['class_id'];

        if(isset($classData) && !empty($classData))
            $finalData['className'] = $classData[0]['className'];

        if(isset($attend_record) && !empty($attend_record))
            $subject_detail = $this->_get_subject_detail($attend_record[0]['subject_id'], $org_id)->result_array();
            $finalData['subjectId'] = $attend_record[0]['subject_id'];

        if(isset($subject_detail) && !empty($subject_detail))
            $finalData['subjectName'] = $subject_detail[0]['name'];
            $finalData['subjectType'] = $subject_detail[0]['s_type'];

        if(isset($attend_record) && !empty($attend_record))
        $finalData['noOfTotalStudents'] = $this->_get_total_num_of_stds($finalData['subjectType'],$subject_id,$attend_record[0]['section_id'],$attend_record[0]['class_id'],$org_id)->num_rows();

        $present=0;$absent=0;$leave=0;
        $attend_list = $this->_get_attendance_list($attend_id,$attend_date)->result_array();
        foreach ($attend_list as $key => $value) {
            if($value['attend_status'] == 'present'){
                $present++;
                $finalData1['id'] = $value['student_id'];
                $finalData1['rollNo'] = $value['roll_no'];
                $finalData['present'][] = $finalData1;
            }
            elseif($value['attend_status'] == 'absent'){
                $absent++;
                $finalData1['id'] = $value['student_id'];
                $finalData1['rollNo'] = $value['roll_no'];
                $finalData['absent'][] = $finalData1;
            }
            elseif($value['attend_status'] == 'leave'){
                $leave++;
                $finalData1['id'] = $value['student_id'];
                $finalData1['rollNo'] = $value['roll_no'];
                $finalData['leave'][] = $finalData1;
            }
        }   
        if($present != 0 || $absent != 0 || $leave != 0){
            $presentPercent=($present/($present+$absent+$leave))*100;
            $absentPercent=($absent/($present+$absent+$leave))*100;
            $leavePercent=($leave/($present+$absent+$leave))*100;
            if(isset($presentPercent)){
                $finalData['presentPercent']=round($presentPercent,2);
            }
            else{
                $finalData['presentPercent'] = 0;
            }
            if(isset($absentPercent)){
                $finalData['absentPercent']=round($absentPercent,2);
            }
            else{
                $finalData['absentPercent'] = 0;
            }
            if(isset($leavePercent)){
                $finalData['leavePercent']=round($leavePercent,2);
            }
            else{
                $finalData['leavePercent'] = 0;
            }
        }

        $finalData['presentStds']=$present;
        $finalData['absentStds']=$absent;
        $finalData['leaveStds']=$leave; 
        
        if(isset($finalData) && !empty($finalData)){
            $status = true;
            $data = $finalData;
        }
        else{
            $data = '';
            $status = false;
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_student_attendance_detail(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $std_id = $this->input->post('stdId');
        $std_roll_no = $this->input->post('stdRollNo');
        $org_id = $this->input->post('orgId');
        $subject_id = $this->input->post('subjectId');
        $attend_record = $this->_get_student_attendance_detail($org_id, $subject_id)->result_array();
        $present=0;$absent=0;$leave=0;$percent=0;
        $finalData['leavePercent'] = 0;
        $finalData['presentPercent'] = 0;
        $finalData['absentPercent'] = 0;
        $child_data = $this->_get_student($std_id,$org_id)->result_array();
        if (isset($child_data) && !empty($child_data)) {
            $finalData['stdId'] = $child_data[0]['stdId'];
            $finalData['stdRollNo'] = $child_data[0]['stdRollNo'];
            $finalData['stdName'] = $child_data[0]['stdName'];
        }
        if(isset($attend_record) && !empty($attend_record)){
            foreach ($attend_record as $key => $value) {
                $attend_data = $this->_get_student_attendance_record($std_id, $std_roll_no, $value['attend_id'], $value['attend_date'])->result_array();
                if(isset($attend_data) && !empty($attend_data)){
                    foreach ($attend_data as $key => $value) {
                        if($value['attend_status']=='present'){
                            $present++;
                            $finalData1['date'] = $value['attend_date'];
                            $finalData1['attendanceType'] = 'P';
                            $finalData['attendRecord'][] = $finalData1;
                        }
                        elseif($value['attend_status']=='absent'){
                            $absent++;
                            $finalData1['date'] = $value['attend_date'];
                            $finalData1['attendanceType'] = 'A';
                            $finalData['attendRecord'][] = $finalData1;
                        }
                        elseif($value['attend_status']=='leave'){
                            $leave++;
                            $finalData1['date'] = $value['attend_date'];
                            $finalData1['attendanceType'] = 'L';
                            $finalData['attendRecord'][] = $finalData1;
                        }  
                    }
                }
            }
        }
        if($present != 0 || $absent != 0 || $leave != 0){
            $presentPercent=($present/($present+$absent+$leave))*100;
            $absentPercent=($absent/($present+$absent+$leave))*100;
            $leavePercent=($leave/($present+$absent+$leave))*100;
            if(isset($presentPercent)){
                $finalData['presentPercent']=round($presentPercent,2);
            }
            if(isset($absentPercent)){
                $finalData['absentPercent']=round($absentPercent,2);
            }
            if(isset($leavePercent)){
                $finalData['leavePercent']=round($leavePercent,2);
            }
            $finalData['noOfTotalPresents']=$present;
            $finalData['noOfTotalAbsents']=$absent;
            $finalData['noOfTotalLeaves']=$leave;
        }
        if(isset($finalData) && !empty($finalData)){
            $status = true;
            $data[] = $finalData;
        }
        else{
            $message = 'Data not found for this user';
            $data = '';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data, 'message'=>$message));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_student_teacher_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $std_id = $this->input->post('stdId');
        $section_id = $this->input->post('sectionId');
        $org_id = $this->input->post('orgId');
        $teacher_id = $this->_student_subject_teacher($std_id,$org_id)->result_array();
        $teacherData = $this->_student_subject_teacher_list($section_id,$org_id)->result_array();

        if(isset($teacher_id) && !empty($teacher_id)){
            $finalData['subId'] = $teacher_id[0]['subject_id'];
            $finalData['subjectName'] = $teacher_id[0]['subject_name'];
            $finalData['teacherId'] = $teacher_id[0]['teacher_id'];
            $finalData['teacherName'] = $teacher_id[0]['teacher_name'];
            $finalData2[] = $finalData;
        }
        foreach ($teacherData as $key => $value) {
            $finalData['subId'] = $value['subject_id'];
            $finalData['subjectName'] = $value['subject_name'];
            $finalData['teacherId'] = $value['teacher_id'];
            $finalData['teacherName'] = $value['teacher_name'];
            $finalData2[] = $finalData;
        }

        if(isset($finalData2) && !empty($finalData2)){
            $status = true;
            $data = $finalData2;
        }
        else{
            $message = 'Data not found for this user';
            $data = '';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data, 'message'=>$message));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function apply_leave(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $selectedStd = $this->input->post('selectedStd');
        $stdData = explode(",",$selectedStd);
        $data['std_id'] = $stdData[0];
        $data['std_roll_no'] = $stdData[1];
        $data['std_name'] = $stdData[2];
        $data['section_id'] = $stdData[3];
        $data['parent_id'] = $this->input->post('parentId');
        $selectedTeacher = $this->input->post('selectedTeacher');
        if(isset($selectedTeacher) && !empty($selectedTeacher)){
            $teacherData = explode(",",$selectedTeacher);
            $data['teacher_id'] = $teacherData[0];
            $data['subject_id'] = $teacherData[1];
        }
        $data['leave_type'] = $this->input->post('leaveType');
        $data['leave_duration '] = $this->input->post('duration');
        $data['org_id'] = $this->input->post('orgId');
        $data['leave_start'] = $this->input->post('startDate');
        $data['leave_end '] = $this->input->post('endDate');
        $data['reason'] = $this->input->post('leaveReason');
        date_default_timezone_set("Asia/Karachi");
        $data['date'] = date("d-m-Y");
        $return_id = $this->_insert_apply_leave($data);
        // exit();
        $data2['notif_title'] = $data['leave_type'];
        $data2['notif_description'] = $data['reason'];
        $data2['notif_type'] = 'leave';
        $data2['type_id'] = $return_id;
        $data2['section_id'] = $data['section_id'];
        date_default_timezone_set("Asia/Karachi");
        $data2['notif_date'] = date('Y-m-d H:i:s');
        $data2['org_id']= $data['org_id'];
        $this->_notif_insert_data_teacher($data2);

        $where['section_id'] = $data2['section_id'];

        $teacher_id = $this->_get_teacher_for_push_noti($where,$data2['org_id'])->result_array();

        if (isset($teacher_id) && !empty($teacher_id)) {
            foreach ($teacher_id as $key => $value) {
                $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                $this->send_notification($token,$data2['notif_title'],$data2['notif_description']);
            }  
        }



        if($return_id != null){
            header('Content-Type: application/json');
            echo json_encode(array("status" => true, "message"=> "Leave submitted successfully"));   
        }
        else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => false, "message"=> "Unsuccessfull"));
        }
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}


function get_parent_leave_history() {
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $org_id = $this->input->post('orgId');
        $user_id = $this->input->post('parentId');
        $page_no = $this->input->post('page_no');
        $limit = 20;
        $leave_history = $this->_get_leave_history($org_id, $user_id, $page_no, $limit);
        foreach ($leave_history['all_data'] as $key => $value) {
            $finalData['leaveId'] = $value['id'];
            $finalData['stdId'] = $value['std_id'];
            $finalData['stdName'] = $value['std_name'];
            $finalData['stdRollNo'] = $value['std_roll_no'];
            $finalData['leaveType'] = $value['leave_type'];
            $finalData['leaveDuration'] = $value['leave_duration'];
            $finalData['appliedDate'] = $value['date'];
            $finalData['leaveStatus'] = $value['status'];
            $finalData2[] = $finalData;
        }
        
        if(isset($finalData2) && !empty($finalData2)){
            $status = true;
            $data = $finalData2;
        }
        else{
            $message = 'Record not found';
            $data = '';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data, 'message'=>$message, 'total_pages'=>ceil($leave_history['count_data']/$limit)));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_parent_leave_detail () {
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $leave_id = $this->input->post('leaveId');
        $org_id = $this->input->post('orgId');
        $leave_detail = $this->_get_leave_detail($leave_id,$org_id)->result_array();
        foreach ($leave_detail as $key => $value) {
            $finalData['stdId'] = $value['std_id'];
            $finalData['stdName'] = $value['std_name'];
            $finalData['stdRollNo'] = $value['std_roll_no'];
            $stdData = $this->_get_std_data($value['std_id'],$value['std_roll_no'],$org_id)->result_array();
            if(isset($stdData) && !empty($stdData))
                $sectionData = $this->_get_teacher_sections($stdData[0]['section_id'], $stdData[0]['class_id'],$org_id)->result_array();
                $finalData['sectionId'] = $stdData[0]['section_id'];
                $classData = $this->_get_teacher_classes($stdData[0]['class_id'],$org_id)->result_array();
                $finalData['classId'] = $stdData[0]['class_id'];

            if(isset($sectionData) && !empty($sectionData))
                $finalData['sectionName'] = $sectionData[0]['sectionName'];
            
            if(isset($classData) && !empty($classData))
                $finalData['className'] = $classData[0]['className'];

            $finalData['leaveType'] = $value['leave_type'];
            $finalData['leaveDuration'] = $value['leave_duration'];
            $finalData['appliedDate'] = $value['date'];
            $finalData['leaveStartDate'] = $value['leave_start'];
            $finalData['leaveEndDate'] = $value['leave_end'];
            $finalData['leaveReason'] = $value['reason'];
            $finalData['leaveStatus'] = $value['status'];
        }
        if(isset($finalData) && !empty($finalData)){
            $status = true;
            $data = $finalData;
        }
        else{
            $data ='';
            $status = false;
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_teacher_leave_history() {
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $org_id = $this->input->post('orgId');
        $user_id = $this->input->post('teacherId');
        $section = $this->_leave_teacher_section($org_id, $user_id)->result_array();
        if (isset($section) && !empty($section)) {
            foreach ($section as $key => $value) {
                $leave = $this->_leave_teacher_list($value['section_id'],$org_id)->result_array();
                if (isset($leave) && !empty($leave)) {
                    foreach ($leave as $key => $value1) {
                        $finalData['leaveId'] = $value1['id'];
                        $finalData['stdId'] = $value1['std_id'];
                        $finalData['stdName'] = $value1['std_name'];
                        $finalData['stdRollNo'] = $value1['std_roll_no'];
                        $finalData['leaveType'] = $value1['leave_type'];
                        $finalData['leaveDuration'] = $value1['leave_duration'];
                        $finalData['appliedDate'] = $value1['date'];
                        $finalData['leaveStatus'] = $value1['status'];
                        $finalData2[] = $finalData;
                    }
                }
            }
        }
        if(isset($finalData2) && !empty($finalData2)){
            $status = true;
            $data = $finalData2;
        }
        else{
            $message = 'Record not found';
            $data = '';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data, 'message'=>$message));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }

}

function get_teacher_leave_detail () {
    $api = $this->input->post('api');
    if($api == 'true'){
        $message = '';
        $status = false;
        $leave_id = $this->input->post('leaveId');
        $user_id = $this->input->post('teacherId');
        $org_id = $this->input->post('orgId');
        $leave_detail = $this->_get_leave_detail($leave_id,$org_id)->result_array();
        foreach ($leave_detail as $key => $value) {
            $finalData['stdId'] = $value['std_id'];
            $finalData['stdName'] = $value['std_name'];
            $finalData['stdRollNo'] = $value['std_roll_no'];
            $stdData = $this->_get_std_data($value['std_id'],$value['std_roll_no'],$org_id)->result_array();
            if(isset($stdData) && !empty($stdData))
                $sectionData = $this->_get_teacher_sections($stdData[0]['section_id'], $stdData[0]['class_id'],$org_id)->result_array();

            if(isset($sectionData) && !empty($sectionData)){
                $finalData['sectionName'] = $sectionData[0]['sectionName'];
                $finalData['sectionId'] = $sectionData[0]['id'];
                $teacher_id = $sectionData[0]['teacher_id'];
            }

            $classData = $this->_get_teacher_classes($stdData[0]['class_id'],$org_id)->result_array();
            if(isset($classData) && !empty($classData)){
                $finalData['className'] = $classData[0]['className'];
                $finalData['classId'] = $classData[0]['id'];
            }

            $parentData = $this->_get_user_profile($value['parent_id'],$org_id)->result_array();
            // print_r($parentData);exit();
            if (isset($parentData) && !empty($parentData)) {
                foreach ($parentData as $key => $value2) {
                    $finalData['parentName'] = $value2['name'];
                    $finalData['parentPhoneNo'] = $value2['phone'];
                }
            }

            $finalData['leaveType'] = $value['leave_type'];
            $finalData['leaveDuration'] = $value['leave_duration'];
            $finalData['appliedDate'] = $value['date'];
            $finalData['leaveStartDate'] = $value['leave_start'];
            $finalData['leaveEndDate'] = $value['leave_end'];
            $finalData['leaveReason'] = $value['reason'];
            $finalData['leaveStatus'] = $value['status'];
            if ($user_id ==$teacher_id) {
                $finalData['incharge'] = true;
            }
            else{
                $finalData['incharge'] = false;
            }
        }

        if(isset($finalData) && !empty($finalData)){
            $status = true;
            $data = $finalData;
        }
        else{
            $data ='';
            $status = false;
            $message = 'Record Not Found';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data, 'message'=>$message));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function change_leave_status(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $message = '';
        $check = 0;
        $status = false;
        $leave_id = $this->input->post('leaveId');
        $org_id = $this->input->post('orgId');
        $leave_status = $this->input->post('status');

        $std_id = $this->input->post('stdId');
        $std_name = $this->input->post('stdName');
        $std_roll_no = $this->input->post('stdRollNo');
        $leave_reason = $this->input->post('leaveReason');
        $leave_title = $this->input->post('leaveType');
        $section_id = $this->input->post('sectionId');
        $class_id = $this->input->post('classId');

        $status_change = $this->_change_leave_status($leave_status,$leave_id,$org_id);
        $data2['notif_title'] = $leave_title;
        if($leave_status == 1){
            $data2['notif_description'] = 'This leave has been Accepted for '.$std_name;
        }
        else{
            $data2['notif_description'] = 'This leave has been Rejected for '.$std_name;
        }
        $data2['notif_type'] = 'leave';
        $data2['type_id'] = $leave_id;
        $data2['section_id'] = $section_id;
        $data2['class_id'] = $class_id;
        $data2['std_id'] = $std_id;
        $data2['std_name'] = $std_name;
        $data2['std_roll_no'] = $std_roll_no;
        date_default_timezone_set("Asia/Karachi");
        $data2['notif_date'] = date('Y-m-d H:i:s');
        $data2['org_id'] = $org_id;
        $this->_notif_insert_data_parent($data2);
        $where['id'] = $std_id;
        $parent_id = $this->_get_parent_for_push_noti($where,$data2['org_id'])->result_array();

        if (isset($parent_id) && !empty($parent_id)) {
            $token = $this->_get_parent_token($parent_id[0]['parent_id'],$data2['org_id'])->result_array();
            $this->send_notification($token,$data2['notif_title'],$data2['notif_description']);   
        }

        if(isset($status_change) && !empty($status_change)){
            if($leave_status == 1){
                $status = true;
                $message = 'Leave Accepted';
                $check =1;
            }
            elseif ($leave_status == 2) {
                $status = true;
                $message = 'Leave Rejected';
                $check = 2;
            }
        }
        else{
            $status = false;
            $message = 'Unsuccessfull';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'check'=>$check));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }

}

function get_user_profile(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $user_id = $this->input->post('userId');
        $org_id = $this->input->post('orgId');
        $userData = $this->_get_user_profile($user_id,$org_id)->result_array();
        foreach ($userData as $key => $value) {
            $finalData['name'] = $value['name'];
            $finalData['cnic'] = $value['cnic'];
            $finalData['gender'] = $value['gender'];
            $finalData['phoneNo'] = $value['phone'];
            $finalData['userAddress'] = $value['user_address'];
            $finalData['email'] = $value['email'];
            $finalData['about'] = $value['about'];
            $orgData = $this->_get_org($org_id)->result_array();
            foreach ($orgData as $key => $value) {
                $finalData['orgName'] = $value['orgName'];
                $finalData['orgAddress'] = $value['orgAddress'];
                $finalData['orgEmail'] = $value['org_email'];
                $finalData['orgPhone'] = $value['org_phone'];
            }
        }

        if(isset($finalData) && !empty($finalData)){
            $status = true;
            $data = $finalData;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_student_subject_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $std_id = $this->input->post('stdId');
        $section_id = $this->input->post('sectionId');
        $org_id = $this->input->post('orgId');
        $subject_name = $this->_student_subject_teacher($std_id,$org_id)->result_array();

        $subject_data = $this->_student_subject_teacher_list($section_id,$org_id)->result_array();

        if(isset($subject_name) && !empty($subject_name)){
            $finalData['subId'] = $subject_name[0]['subject_id'];
            $finalData['time'] = $subject_name[0]['time'];
            $finalData['subjectName'] = $subject_name[0]['subject_name'];
            $finalData['teacherId'] = $subject_name[0]['teacher_id'];
            $finalData['teacherName'] = $subject_name[0]['teacher_name'];
            $finalData2[] = $finalData;
        }
        if(isset($subject_data) && !empty($subject_data)){
            foreach ($subject_data as $key => $value) {
                $finalData['subId'] = $value['subject_id'];
                $finalData['subjectName'] = $value['subject_name'];
                $finalData['time'] = $value['time'];
                $finalData['teacherId'] = $value['teacher_id'];
                $finalData['teacherName'] = $value['teacher_name'];
                $finalData2[] = $finalData;
            }
        }
        if(isset($finalData2) && !empty($finalData2)){
            $status = true;
            $data = $finalData2;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}


function submit_test(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $subjectData = $this->input->post('subjectData');
        $sbjData = explode(",",$subjectData);
        $data['class_id'] = $sbjData[0];
        $data['class_name'] = $sbjData[1];
        $data['section_id'] = $sbjData[2];
        $data['section_name'] = $sbjData[3];
        $data['subject_id'] = $sbjData[4];
        $data['subject_name'] = $sbjData[5];
        $data['test_title'] = $this->input->post('testTitle');
        $data['test_date'] = $this->input->post('testDate');
        $data['test_time'] = $this->input->post('testTime');
        $data['teacher_id'] = $this->input->post('teacherId');
        $data['org_id'] = $this->input->post('orgId');
        $data['total_marks'] = $this->input->post('totalMarks');
        $data['test_description'] = $this->input->post('testDescription');
        $data['created_by'] = 'teacher';

        $teacher_name = $this->_get_teacher_name($data['teacher_id'],$data['org_id'])->result_array();
        if (isset($teacher_name) && !empty($teacher_name)) {
            $data['teacher_id'] =  $teacher_name[0]['id'];
            $data['teacher_name'] =  $teacher_name[0]['teacher_name'];
        }
        $program_name = $this->_get_program_from_section($data['class_id'],$data['section_id'],$data['org_id'])->result_array();
        if (isset($program_name) && !empty($program_name)) {
            $data['program_id'] =  $program_name[0]['program_id'];
            $data['program_name'] =  $program_name[0]['program_name'];
        }
        $return_id = $this->_insert_submit_test($data);

        $data2['notif_title'] = $data['test_title'];
        $data2['notif_description'] = $data['test_description'];
        $data2['notif_type'] = 'test';
        $data2['type_id'] = $return_id;
        $data2['subject_id'] = $data['subject_id'];
        $data2['section_id'] = $data['section_id'];
        $data2['class_id'] = $data['class_id'];
        $data2['program_id'] = $data['program_id'];
        date_default_timezone_set("Asia/Karachi");
        $data2['notif_date'] = date('Y-m-d H:i:s');
        $data2['org_id'] = $data['org_id'];
        $this->_notif_insert_data_parent($data2);

        $where['section_id'] = $data2['section_id'];

        $parent_id = $this->_get_parent_for_push_noti($where,$data2['org_id'])->result_array();
        if (isset($parent_id) && !empty($parent_id)) {
            foreach ($parent_id as $key => $value) {
                $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                $this->send_notification($token,$data2['notif_title'],$data2['notif_description']);
            }   
        }

        if(isset($return_id) && !empty($return_id)){
            header('Content-Type: application/json');
            echo json_encode(array("status" => true, "message"=> "Test Created successfully"));   
        }
        else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => false, "message"=> "Test Not Created"));
        }
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_teacher_test_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $org_id = $this->input->post('orgId');
        $teacher_id = $this->input->post('userId');
        $where['teacher_id'] = $teacher_id;
        $test_list = $this->_get_test_list($where,$org_id)->result_array();

        if(isset($test_list) && !empty($test_list)){
            $status = true;
            $data = $test_list;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}


function get_teacher_exam_class_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $org_id = $this->input->post('orgId');
        $teacher_id = $this->input->post('userId');
        $where['subject.teacher_id'] = $teacher_id;

        $class_list = $this->_get_teacher_class_list($where,$org_id)->result_array();

        if(isset($class_list) && !empty($class_list)){
            $status = true;
            $data = $class_list;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_teacher_exam_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $org_id = $this->input->post('orgId');
        $class_id = $this->input->post('classId');

        $where['class_id'] = $class_id;

        $exam_list = $this->_get_exam_list($where,$org_id)->result_array();

        if(isset($exam_list) && !empty($exam_list)){
            $status = true;
            $data = $exam_list;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_teacher_class_student_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $org_id = $this->input->post('orgId');
        $class_id = $this->input->post('classId');
        $program_id = $this->input->post('programId');

        $exam_list = $this->_get_teacher_exam_student_list($class_id,$program_id,$org_id)->result_array();
        foreach ($exam_list as $key => $value) {
            $finalData['stdId'] = $value['id'];
            $finalData['stdName'] = $value['name'];
            $finalData['stdRollNo'] = $value['roll_no'];
            $finalData['parentName'] = $value['parent_name'];
            $finalData['dob'] = $value['dob'];
            $finalData['gender'] = $value['gender'];
            $finalData['classId'] = $value['class_id'];
            $finalData['programId'] = $value['program_id'];
            if(isset($value['image']) && !empty($value['image'])){
                $finalData['stdImage'] = BASE_URL.SMALL_STUDENT_IMAGE_PATH.$value['image'];
            }
            else{
                if ($value['gender'] == 'Female') {
                    $finalData['stdImage'] = STATIC_FRONT_IMAGE.'static-female.png';
                }
                else{
                    $finalData['stdImage'] = STATIC_FRONT_IMAGE.'static-male.png';
                }
            }
            $finalData1[] = $finalData;
        }
        if(isset($finalData1) && !empty($finalData1)){
            $status = true;
            $data = $finalData1;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_parent_test_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $org_id = $this->input->post('orgId');
        $parent_id = $this->input->post('userId');

        $children_list = $this->_get_children_list($parent_id,$org_id)->result_array();
        foreach ($children_list as $key => $value) {
            $where['section_id'] = $value['section_id'];
            $test_list = $this->_get_test_list($where,$org_id)->result_array();
            foreach ($test_list as $key => $value1) {
                $finalData['stdId'] = $value['stdId'];
                $finalData['stdName'] = $value['stdName'];
                $finalData['stdRollNo'] = $value['stdRollNo'];
                $finalData['testId'] = $value1['testId'];
                $finalData['testTitle'] = $value1['testTitle'];
                $finalData['testDescription'] = $value1['testDescription'];
                $finalData['testTime'] = $value1['testTime'];
                $finalData['testDate'] = $value1['testDate'];
                $finalData['classId'] = $value1['classId'];
                $finalData['className'] = $value1['className'];
                $finalData['sectionId'] = $value1['sectionId'];
                $finalData['sectionName'] = $value1['sectionName'];
                $finalData['subjectId'] = $value1['subjectId'];
                $finalData['subjectName'] = $value1['subjectName'];
                $finalData['teacherId'] = $value1['teacherId'];
                $finalData['teacherId'] = $value1['teacherName'];
                $finalData['totalMarks'] = $value1['totalMarks'];
                $finalData2[]=$finalData;
            }
        }
        
        if(isset($finalData2) && !empty($finalData2)){
            $status = true;
            $data = $finalData2;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_parent_exam_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $org_id = $this->input->post('orgId');
        $class_id = $this->input->post('classId');

        $where['class_id'] = $class_id;
        $exam_list = $this->_get_exam_list($where,$org_id)->result_array();
        foreach ($exam_list as $key => $value1) {
            $finalData['examId'] = $value1['examId'];
            $finalData['examTitle'] = $value1['examTitle'];
            $finalData['examDescription'] = $value1['examDescription'];
            $finalData['classId'] = $value1['classId'];
            $finalData['className'] = $value1['className'];
            $finalData['programId'] = $value1['programId'];
            $finalData['programName'] = $value1['programName'];
            $finalData['startDate'] = $value1['startDate'];
            $finalData['endDate'] = $value1['endDate'];
            $finalData2[]=$finalData;
        }
        
        if(isset($finalData2) && !empty($finalData2)){
            $status = true;
            $data = $finalData2;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_teacher_test_detail(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $org_id = $this->input->post('orgId');
        $test_id = $this->input->post('testId');

        $where['id'] = $test_id;
        $test_list = $this->_get_test_list($where,$org_id)->result_array();
        $test_marks = $this->_get_test_marks($test_id,$org_id)->result_array();
        if(isset($test_marks) && !empty($test_marks)){
            $status = true;
            $marks = $test_marks;
        }
        else{
            $marks=[];
        }
        if(isset($test_list) && !empty($test_list)){
            $status = true;
            $data = $test_list;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data,'marks'=>$marks));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_parent_test_detail(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $test_id = $this->input->post('testId');
        $parent_id = $this->input->post('userId');
        $org_id = $this->input->post('orgId');
        $std_id = $this->input->post('stdId');

        $where['id'] = $test_id;
        $test_list = $this->_get_test_list($where,$org_id)->result_array();
        foreach ($test_list as $key => $value1) {
            $finalData['testId'] = $value1['testId'];
            $finalData['testTitle'] = $value1['testTitle'];
            $finalData['testDescription'] = $value1['testDescription'];
            $finalData['testTime'] = $value1['testTime'];
            $finalData['testDate'] = $value1['testDate'];
            $finalData['classId'] = $value1['classId'];
            $finalData['className'] = $value1['className'];
            $finalData['sectionId'] = $value1['sectionId'];
            $finalData['sectionName'] = $value1['sectionName'];
            $finalData['subjectId'] = $value1['subjectId'];
            $finalData['subjectName'] = $value1['subjectName'];
            $finalData['totalMarks'] = $value1['totalMarks'];
            $finalData['teacherId'] = $value1['teacherId'];
            $teacher_name = $this->_get_user_profile($value1['teacherId'],$org_id)->result_array();
            $test_marks = $this->_get_test_marks_parent($test_id,$std_id,$org_id)->result_array();
            if (isset($test_marks) && !empty($test_marks)) {

                $finalData['obtainedMarks'] = $test_marks[0]['obtained_marks'];
            }
            if (isset($teacher_name) && !empty($teacher_name)) {
                $finalData['teacherName'] = $teacher_name[0]['name'];
            }
            $finalData2[]=$finalData;
        }

        if(isset($finalData2) && !empty($finalData2)){
            $status = true;
            $data = $finalData2;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_parent_exam_detail(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $exam_id = $this->input->post('examId');
        $org_id = $this->input->post('orgId');
        $std_id = $this->input->post('stdId');

        $where['id'] = $exam_id;
        $exam_list = $this->_get_exam_list($where,$org_id)->result_array();
        if(isset($exam_list) && !empty($exam_list)){
            foreach ($exam_list as $key => $value) {
                $finalData['examId'] = $value['examId'];
                $finalData['examTitle'] = $value['examTitle'];
                $finalData['examDescription'] = $value['examDescription'];
                $finalData['classId'] = $value['classId'];
                $finalData['className'] = $value['className'];
                $finalData['programId'] = $value['programId'];
                $finalData['programName'] = $value['programName'];
            }
        }
        $std_data = $this->_get_student($std_id,$org_id)->result_array();
        if(isset($std_data) && !empty($std_data)){
            foreach ($std_data as $key => $value) {
                $finalData['stdId'] = $value['stdId'];
                $finalData['stdName'] = $value['stdName'];
                $finalData['stdRollNo'] = $value['stdRollNo'];

                if(isset($value['image']) && !empty($value['image'])){
                    $finalData['stdImage'] = BASE_URL.SMALL_STUDENT_IMAGE_PATH.$value['image'];
                }
                else{
                    if ($value['gender'] == 'Female') {
                        $finalData['stdImage'] = STATIC_FRONT_IMAGE.'static-female.png';
                    }
                    else{
                        $finalData['stdImage'] = STATIC_FRONT_IMAGE.'static-male.png';
                    }
                }
            }
        }
        $marks_list = $this->get_student_result($exam_id,$org_id)->result_array();

        $total=0;$obtained=0;$percent=0;
        if (isset($marks_list) && !empty($marks_list)) {
            foreach ($marks_list as $key => $value) {
                $finalData2['subjectId'] = $value['subject_id'];
                $finalData2['subjectName'] = $value['subject_name'];
                $finalData2['examDate'] = $value['exam_date'];
                $finalData2['totalMarks'] = $value['total_marks'];
                $total = $total + $finalData2['totalMarks'];
                $mark_detail = $this->_get_student_result_detail($std_id,$value['subject_id'],$exam_id)->result_array();
                if (isset($mark_detail) && !empty($mark_detail)) {
                    foreach ($mark_detail as $key => $value1) {
                        $finalData2['obtainedMarks'] = $value1['obtained_marks'];
                        $obtained = $obtained + $finalData2['obtainedMarks'];
                    }
                }
                else{
                    $finalData2['obtainedMarks'] = 0;
                }
                $finalData3[] = $finalData2;
            }
        }
        if ($total !=0 || $obtained !=0) {
            $percent = ($obtained/$total)*100;
        }

        $finalData['total'] = $total;
        $finalData['obtained'] = $obtained;
        $finalData['percent'] = ceil($percent);

        if(isset($finalData3) && !empty($finalData3)){
            $status = true;
            $marks = $finalData3;
        }
        else{
            $marks= [];
        }
        
        if(isset($finalData) && !empty($finalData)){
            $status = true;
            $data[] = $finalData;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data,'marks'=>$marks));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function submit_test_marks(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $student_marks_list = $this->input->post('studentMarksList');
        $someArray = json_decode($student_marks_list, true);
        if(isset($someArray) && !empty($someArray)){
            foreach($someArray as $value){
                $data2['test_id'] = $this->input->post('testId');
                $data2['org_id'] = $this->input->post('orgId');
                $data2['total_marks'] = $this->input->post('totalMarks');
                $data2['std_id'] = $value['stdId'];
                $data2['std_roll_no'] = $value['stdRollNo'];
                $data2['std_name'] = $value['stdName'];
                if (isset($value['stdMarks']) && !empty($value['stdMarks'])) {
                    $data2['obtained_marks'] = $value['stdMarks'];
                    $return_id = $this->_submit_test_marks($data2);

                    $where['id'] = $data2['test_id'];
                    $test_list = $this->_get_test_list($where,$data2['org_id'])->result_array();
                    if(isset($test_list) && !empty($test_list)){
                        foreach ($test_list as $key => $value1) {
                            $data3['notif_title'] = $value1['testTitle'];
                            $data3['notif_description'] = 'Marks of '.$value['stdName']. ' for this test are '.$value['stdMarks'];
                            $data3['notif_type'] = 'test';
                            $data3['type_id'] = $value1['testId'];
                            $data3['section_id'] = $value1['sectionId'];
                            $data3['class_id'] = $value1['classId'];
                            $data3['program_id'] = $value1['programId'];
                            $data3['std_id'] = $value['stdId'];
                            $data3['std_roll_no'] = $value['stdRollNo'];
                            $data3['std_name'] = $value['stdName'];
                            date_default_timezone_set("Asia/Karachi");
                            $data3['notif_date'] = date('Y-m-d H:i:s');
                            $data3['org_id'] = $data2['org_id'];
                            $this->_notif_insert_data_parent($data3);

                            $where['id'] = $data3['std_id'];

                            $parent_id = $this->_get_parent_for_push_noti($where,$data3['org_id'])->result_array();
                            if (isset($parent_id) && !empty($parent_id)) {
                                foreach ($parent_id as $key => $value) {
                                    $token = $this->_get_parent_token($value['parent_id'],$data3['org_id'])->result_array();
                                    $this->send_notification($token,$data3['notif_title'],$data3['notif_description']);
                                }   
                            }
                        }
                    }
                }
                else{
                    $return_id=0;
                }
            }
        }
        if($return_id == 1){
            header('Content-Type: application/json');
            echo json_encode(array("status" => true, "message"=> "Marks submitted successfully"));   
        }
        else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => true, "message"=> "Marks submitted successfully"));
        }
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function edit_test_marks(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $test_id = $this->input->post('testId');
        $std_id = $this->input->post('stdId');
        $data['obtained_marks'] = $this->input->post('stdMarks');
        $return_id = $this->_edit_test_marks($test_id, $std_id, $data);
        $test_data = $this->_notif_get_test_detail($test_id)->result_array();
        if (isset($test_data) && !empty($test_data)) {
            $std_data = $this->_notif_get_child_detail($std_id)->result_array();
            if (isset($std_data) && !empty($std_data)) {
                $data2['notif_title'] = $test_data[0]['test_title'];
                $data2['notif_description'] = 'Marks of ' .$std_data[0]['name'].' for this test are '.$data['obtained_marks']. ' (updated)' ;
                $data2['notif_type'] = 'test';
                $data2['type_id'] = $test_id;
                $data2['section_id'] = $test_data[0]['section_id'];
                $data2['class_id'] = $test_data[0]['class_id'];
                $data2['program_id'] = $test_data[0]['program_id'];
                $data2['std_id'] = $std_data[0]['id'];
                $data2['std_roll_no'] = $std_data[0]['roll_no'];
                $data2['std_name'] = $std_data[0]['name'];
                $data2['notif_sub_type'] = 'update';
                date_default_timezone_set("Asia/Karachi");
                $data2['notif_date'] = date('Y-m-d H:i:s');
                $data2['org_id'] = $test_data[0]['org_id'];
                $this->_notif_insert_data_parent($data2);

                $where['id'] = $std_id;

                $parent_id = $this->_get_parent_for_push_noti($where,$data2['org_id'])->result_array();
                if (isset($parent_id) && !empty($parent_id)) {
                    foreach ($parent_id as $key => $value) {
                        $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                        $this->send_notification($token,$data2['notif_title'],$data2['notif_description']);
                    }   
                }
            }
        }
        if($return_id == 1){
            header('Content-Type: application/json');
            echo json_encode(array("status" => true, "message"=> "Marks edited successfully"));   
        }
        else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => false, "message"=> "Marks has not changed"));
        }
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function edit_test_detail(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $test_id = $this->input->post('testId');
        $org_id = $this->input->post('orgId');
        $data['total_marks'] = $this->input->post('totalMarks');
        $data['test_date'] = $this->input->post('testDate');
        $data['test_time'] = $this->input->post('testTime');
        $return_id = $this->_edit_test_detail($test_id, $org_id, $data);

        $test_data = $this->_notif_get_test_detail($test_id)->result_array();
        if (isset($test_data) && !empty($test_data)) {
            $data2['notif_title'] = $test_data[0]['test_title'];
            $data2['notif_description'] = 'Teacher Updated this Test';
            $data2['notif_type'] = 'test';
            $data2['type_id'] = $test_id;
            $data2['section_id'] = $test_data[0]['section_id'];
            $data2['class_id'] = $test_data[0]['class_id'];
            $data2['program_id'] = $test_data[0]['program_id'];
            date_default_timezone_set("Asia/Karachi");
            $data2['notif_date'] = date('Y-m-d H:i:s');
            $data2['org_id'] = $test_data[0]['org_id'];
            $this->_notif_insert_data_parent($data2);

            $where['section_id'] = $data2['section_id'];

            $parent_id = $this->_get_parent_for_push_noti($where,$data2['org_id'])->result_array();
            if (isset($parent_id) && !empty($parent_id)) {
                foreach ($parent_id as $key => $value) {
                    $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                    $this->send_notification($token,$data2['notif_title'],$data2['notif_description']);
                }   
            }
        }

        if($return_id == 1){
        header('Content-Type: application/json');
        echo json_encode(array("status" => true, "message"=> "Marks edited successfully"));   
        }
        else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => false, "message"=> "Test has not changed"));
        }
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_promotion_banner(){
    $api = $this->input->post('api');
    if($api == 'true'){
    $status = false;
        $promotion_banner = $this->_get_promotion_banner()->result_array();
        if(isset($promotion_banner) && !empty($promotion_banner)){
            $status = true;
            foreach ($promotion_banner as $key => $value) {
                $anc_data['bannerId'] = $value['id'];
                $anc_data['bannerTitle'] = $value['title'];
                $anc_data['image'] = BASE_URL.ACTUAL_BANNER_IMAGE_PATH.$value['image'];
                $data[] = $anc_data;
            }
        }
        if(isset($data) && !empty($data)){
            $data = $data;
        }
        else{
            $status = false;
            $data=[];
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_student_test(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $section_id = $this->input->post('sectionId');

        $arr_student = Modules::run('student/_get_by_arr_id_section',$section_id)->result_array();
        foreach($arr_student as $row){
            $student['studentId'] = $row['id'];
            $student['studentName'] = $row['name'];
            $student['studentRollNo'] = $row['roll_no'];  
            $finalData[] = $student; 
        }
        if(isset($finalData) && !empty($finalData)){
            $status = true;
            $data = $finalData;
        }
        else{
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}


function get_section_timetable(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $section_id = $this->input->post('sectionId');
        $class_id = $this->input->post('classId');
        $org_id = $this->input->post('orgId');
        $org = $this->_get_org($org_id)->result_array();
        $data2 = $this->_get_timetable_record($section_id,$class_id,$org_id)->result_array();
        if (isset($data2) && !empty($data2)) {
            $single['schoolName'] = $org[0]['orgName'];
            foreach ($data2 as $key => $value) {
                $finalData['dayName'] = $value['day'];
                $single['className'] = $value['class_name'];
                $single['sectionName'] = $value['section_name'];
                
                $data3 = $this->_get_timetable_data($value['id'])->result_array();
                if (isset($data3) && !empty($data3)) {
                    foreach ($data3 as $key => $value1) {
                        $finalData3['subjectName'] = $value1['subject_name'];
                        $finalData3['startTime'] = $value1['start_time'];
                        $finalData3['endTime'] = $value1['end_time'];
                        $finalData2[] = $finalData3;
                    }
                    $finalData['timeTable'] = $finalData2;
                    unset($finalData2);
                }
                $final[] = $finalData;
            }

        }
        if(isset($final) && !empty($final)){
            $status = true;
            $data = $final;
            $single_data = $single;
        }
        else{
            $data='';
            $message = "Record Not Found";
            $single_data = '';
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data, 'single_data'=>$single_data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function get_exam_datesheet(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $class_id = $this->input->post('classId');
        $org_id = $this->input->post('orgId');
        $org = $this->_get_org($org_id)->result_array();

        $data = $this->_get_datesheet_record($class_id,$org_id)->result_array();

        if (isset($data) && !empty($data)) {
            foreach ($data as $key => $value) {

                $finalData['schoolName'] = $org[0]['orgName'];
                $finalData['programName'] = $value['program_name'];
                $finalData['className'] = $value['class_name'];
                $finalData['start_date'] = $value['s_date'];
                $finalData['end_date'] = $value['e_date'];
                $data2 = $this->_get_datesheet_data($value['id'])->result_array();
                if (isset($data2) && !empty($data2)) {
                    foreach ($data2 as $key => $value1) {
                        $finalData2['subjectName'] = $value1['subject_name'];
                        $finalData2['examDate'] = $value1['date'];
                        $finalData2['startTime'] = $value1['start_time'];
                        $finalData2['endTime'] = $value1['end_time'];
                        $finalData2['examDay'] = date('l',strtotime($value1['exam_date']));
                        $finalData3[] = $finalData2;
                    }
                }
            }
        }
        if(isset($finalData3) && !empty($finalData3)){
            $status = true;
            $data = $finalData3;
            $single_data = $finalData;
        }
        else{
            $single_data = '';
            $data='';
            $message = "Record Not Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message, 'data'=>$data, 'single_data'=>$single_data));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}


function _get_datesheet_record($class_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_datesheet_record($class_id,$org_id);  
}

function _get_datesheet_data($id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_datasheet_data($id);  
}

function _get_timetable_record($section_id,$class_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_timetable_record($section_id,$class_id,$org_id);  
}

function _get_timetable_data($id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_timetable_data($id);  
}

function _get_institutes(){
    $this->load->model('mdl_front');
    $query = $this->mdl_front->_get_institutes();
    return $query;
}
function _get_user_login($inst_id, $username, $password){
    $this->load->model('mdl_front');
    $query = $this->mdl_front->_get_user_login($inst_id, $username, $password);
    return $query;
}
function _get_teacher_subject_list($teacher_id, $org_id, $page_no, $limit){
    $this->load->model('mdl_front');
    $query = $this->mdl_front->_get_teacher_subject_list($teacher_id, $org_id, $page_no, $limit);
    return $query;
}
function _get_teacher_sections($section_id, $class_id, $org_id){
    $this->load->model('mdl_front');
    $query = $this->mdl_front->_get_teacher_sections($section_id, $class_id, $org_id);
    return $query;
}
function _get_total_num_of_stds($subject_type,$subject_id,$section_id,$class_id, $org_id){
    $this->load->model('mdl_front');
    $query = $this->mdl_front->_get_total_num_of_stds($subject_type,$subject_id,$section_id,$class_id, $org_id);
    return $query;
}
function _get_teacher_classes($class_id, $org_id){
    $this->load->model('mdl_front');
    $query = $this->mdl_front->_get_teacher_classes($class_id, $org_id);
    return $query;
}
function _get_student_list($section_id, $org_id, $subject_id, $subject_type){
    $this->load->model('mdl_front');
    $query = $this->mdl_front->_get_student_list($section_id, $org_id, $subject_id, $subject_type);
    return $query;
}

function _get_announcement_list($org_id, $page_no, $limit){
    $this->load->model('mdl_front');
    $query = $this->mdl_front->_get_announcement_list($org_id, $page_no, $limit);
    return $query;
}

function _get_announcement_detail($ancmntId, $org_id){
    $this->load->model('mdl_front');
    $query = $this->mdl_front->_get_announcement_detail($ancmntId, $org_id);
    return $query;
}

function _get_children_list($parent_id,$org_id){
    $this->load->model('mdl_front');
    $query = $this->mdl_front->_get_children_list($parent_id,$org_id);
    return $query;
}

function _insert_attend_data($data){
        $this->load->model('mdl_front');
        return $this->mdl_front->_insert_attend_data($data);
}

function _insert_student_attend_data($data){
    $this->load->model('mdl_front');
    return $this->mdl_front->_insert_student_attend_data($data);
}

function _get_subject_detail($subject_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_subject_detail($subject_id,$org_id);
}

function _get_attendance_id($subject_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_attendance_id($subject_id,$org_id);
}

function _get_attendance_list($attend_id, $date){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_attendance_list($attend_id, $date);
}

function _insert_apply_leave($data){
    $this->load->model('mdl_front');
    return $this->mdl_front->_insert_apply_leave($data);
}

function _get_leave_history($org_id, $user_id, $page_no, $limit){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_leave_history($org_id, $user_id, $page_no, $limit);
}

function _get_std_data($std_id,$roll_no,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_std_data($std_id,$roll_no,$org_id);
}

function _get_leave_detail($leave_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_leave_detail($leave_id,$org_id);
}
function _get_student_attendance_record($std_id,$roll_no, $attend_id, $attend_date){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_student_attendance_record($std_id,$roll_no, $attend_id, $attend_date);
}

function _get_attendance_record($attend_id,$attend_date, $org_id, $subject_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_attendance_record($attend_id,$attend_date, $org_id, $subject_id);
}
function _get_student_attendance_detail($org_id, $subject_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_student_attendance_detail($org_id, $subject_id);
}

function _get_overall_student_attendence($roll_no,$std_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_overall_student_attendence($roll_no,$std_id);
}

function _get_user_profile($user_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_user_profile($user_id,$org_id);
}

function _leave_teacher_section($org_id, $user_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_leave_teacher_section($org_id, $user_id);
}

function _leave_teacher_list($section_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_leave_teacher_list($section_id,$org_id);
}

function _change_leave_status($status,$leave_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_change_leave_status($status,$leave_id,$org_id);
}

function _get_student($std_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_student($std_id,$org_id);
}

function _get_org($org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_org($org_id);
}

function _get_student_subject($std_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_student_subject($std_id,$org_id);
}

function _get_student_subject_list($section_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_student_subject_list($section_id,$org_id);
}

function _get_student_teacher($std_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_student_teacher($std_id,$org_id);
}

function _get_student_teacher_list($section_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_student_teacher_list($section_id,$org_id);
}

function _student_subject_teacher($std_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_student_subject_teacher($std_id,$org_id);
}

function _student_subject_teacher_list($section_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_student_subject_teacher_list($section_id,$org_id);
}

function _check_attendance($attend_date,$subject_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_check_attendance($attend_date,$subject_id,$org_id);
}

function _insert_submit_test($data){
    $this->load->model('mdl_front');
    return $this->mdl_front->_insert_submit_test($data);
}

function _get_test_list($where,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_test_list($where,$org_id);
}

function _get_exam_list($where,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_exam_list($where,$org_id);
}

function _get_teacher_exam_student_list($class_id,$program_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_teacher_exam_student_list($class_id,$program_id,$org_id);
}

function _get_teacher_class_list($where,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_teacher_class_list($where,$org_id);
}

function _get_test_marks($test_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_test_marks($test_id,$org_id);
}

function _get_exam_marks($exam_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_exam_marks($exam_id,$org_id);
}

function _get_test_marks_parent($test_id,$std_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_test_marks_parent($test_id,$std_id,$org_id);
}

function _get_exam_marks_parent($exam_id,$std_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_exam_marks_parent($exam_id,$std_id,$org_id);
}

function get_student_result($exam_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->get_student_result($exam_id,$org_id);
}

function _get_student_result_detail($std_id,$exam_subject_id,$exam_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_student_result_detail($std_id,$exam_subject_id,$exam_id);
}

function _submit_test_marks($data){
    $this->load->model('mdl_front');
    return $this->mdl_front->_submit_test_marks($data);
}


function _edit_test_marks($test_id, $std_id, $data){
    $this->load->model('mdl_front');
    return $this->mdl_front->_edit_test_marks($test_id, $std_id, $data);
}

function _edit_test_detail($test_id, $org_id, $data){
    $this->load->model('mdl_front');
    return $this->mdl_front->_edit_test_detail($test_id, $org_id, $data);
}
function _check_test_submission($test_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_check_test_submission($test_id,$org_id);
}

function _get_promotion_banner(){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_promotion_banner();
}

function _get_teacher_name($teacher_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_teacher_name($teacher_id,$org_id);
}

function _check_session($user_id,$username,$inst_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_check_session($user_id,$username,$inst_id);
}

function _create_session($data){
    $this->load->model('mdl_front');
    return $this->mdl_front->_create_session($data);
}

function _logout($currentDateTime,$user_id,$username,$inst_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_logout($currentDateTime,$user_id,$username,$inst_id);
}

function _get_program_from_section($class_id,$section_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_program_from_section($class_id,$section_id,$org_id);
}

function _login_validation($user_id,$username,$imei,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_login_validation($user_id,$username,$imei,$org_id);
}


// ========================================================= //
// =============== Notification API ------================== //
// ========================================================= //


function teacher_notification_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $count = '';
        $teacher_id = $this->input->post('teacherId');
        $org_id = $this->input->post('orgId');
        $page_no = $this->input->post('page_no');
        $limit = 10;


        $where2['org_id'] = $org_id;

        $id = $this->_notif_get_teacher($teacher_id,$org_id,$limit,$page_no);
        $section_ids = array_map("unserialize", array_unique(array_map("serialize", $id['all_data'])));
        if(isset($section_ids) && !empty($section_ids)){
            foreach ($section_ids as $key => $value) {
                $where1['section_id'] = $value['section_id'];
                $notif_list = $this->_notif_get_list_leave_teacher($where1,$where2)->result_array();
                foreach ($notif_list as $key => $value1) {
                    $data['notifId'] = $value1['notif_id'];
                    $data['notifTitle'] = $value1['notif_title'];
                    $data['notifDescription'] = $value1['notif_description'];
                    $data['notifType'] = $value1['notif_type'];
                    $data['typeId'] = $value1['type_id'];
                    $data['programId'] = $value1['program_id'];
                    $data['classId'] = $value1['class_id'];
                    $data['sectionId'] = $value1['section_id'];
                    $data['subjectId'] = $value1['subject_id'];
                    $data['stdName'] = $value1['std_name'];
                    $data['stdId'] = $value1['std_id'];
                    $data['stdRollNo'] = $value1['std_roll_no'];
                    $data['notifStatus'] = $value1['notif_status'];
                    $data['notifDate'] = $value1['notif_date'];
                    $data['orgId'] = $value1['org_id'];
                    $data2[] = $data;
                }
            }
            foreach ($section_ids as $key2 => $value2) {
                $where3['class_id'] = $value2['class_id'];
                $notif_list1 = $this->_notif_get_list_exam_teacher($where3,$where2)->result_array();
                foreach ($notif_list1 as $key => $value3) {
                    $data3['notifId'] = $value3['notif_id'];
                    $data3['notifTitle'] = $value3['notif_title'];
                    $data3['notifDescription'] = $value3['notif_description'];
                    $data3['notifType'] = $value3['notif_type'];
                    $data3['typeId'] = $value3['type_id'];
                    $data3['programId'] = $value3['program_id'];
                    $data3['classId'] = $value3['class_id'];
                    $data3['sectionId'] = $value3['section_id'];
                    $data3['subjectId'] = $value3['subject_id'];
                    $data3['stdName'] = $value3['std_name'];
                    $data3['stdId'] = $value3['std_id'];
                    $data3['stdRollNo'] = $value3['std_roll_no'];
                    $data3['notifStatus'] = $value3['notif_status'];
                    $data3['notifDate'] = $value3['notif_date'];
                    $data3['orgId'] = $value3['org_id'];
                    $data2[] = $data3;
                }
            }
            $subject_id = $this->_notif_get_subject_id($teacher_id,$org_id,$limit,$page_no);
            if (isset($subject_id) && !empty($subject_id)) {
                foreach ($subject_id as $key3 => $value4) {
                    $where4['subject_id'] = $value4['subject_id'];
                    $notif_list2 = $this->_notif_get_list_test_teacher($where4,$where2)->result_array();
                    foreach ($notif_list2 as $key => $value5) {
                        $data4['notifId'] = $value5['notif_id'];
                        $data4['notifTitle'] = $value5['notif_title'];
                        $data4['notifDescription'] = $value5['notif_description'];
                        $data4['notifType'] = $value5['notif_type'];
                        $data4['typeId'] = $value5['type_id'];
                        $data4['programId'] = $value5['program_id'];
                        $data4['classId'] = $value5['class_id'];
                        $data4['sectionId'] = $value5['section_id'];
                        $data4['subjectId'] = $value5['subject_id'];
                        $data4['stdName'] = $value5['std_name'];
                        $data4['stdId'] = $value5['std_id'];
                        $data4['stdRollNo'] = $value5['std_roll_no'];
                        $data4['notifStatus'] = $value5['notif_status'];
                        $data4['notifDate'] = $value5['notif_date'];
                        $data4['orgId'] = $value5['org_id'];
                        $data2[] = $data4;
                    }
                }
            }
        }
        $count = $this->count_unread_notification_teacher($teacher_id,$org_id);
        if(isset($data2) && !empty($data2)){
            array_multisort($data2,SORT_DESC);
            $status = true;
            $data = $data2;
            $unread_notif = $count;
        }
        else{
            $status = false;
            $data='';
            $message = 'No Notifications';
            $unread_notif = 0;
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message,'unread_notif'=>$unread_notif,'data'=>$data, 'total_pages'=>ceil($id['count_data']/$limit)));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function parent_notification_list(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $message = '';
        $count = 0;
        $parent_id = $this->input->post('parentId');
        $org_id = $this->input->post('orgId');
        $page_no = $this->input->post('page_no');
        $limit = 10;
        $where2['org_id'] = $org_id;

        $id = $this->_notif_get_parent($parent_id,$org_id,$limit,$page_no);
        $section_ids = array_map("unserialize", array_unique(array_map("serialize", $id['all_data'])));
        if(isset($section_ids) && !empty($section_ids)){
            foreach ($section_ids as $key => $value) {
                $where1['section_id'] = $value['section_id'];
                $notif_list = $this->_notif_get_list_parent($where1,$where2)->result_array();
                foreach ($notif_list as $key => $value1) {
                    $data['notifId'] = $value1['notif_id'];
                    $data['notifTitle'] = $value1['notif_title'];
                    $data['notifDescription'] = $value1['notif_description'];
                    $data['notifType'] = $value1['notif_type'];
                    $data['typeId'] = $value1['type_id'];
                    $data['programId'] = $value1['program_id'];
                    $data['classId'] = $value1['class_id'];
                    $data['sectionId'] = $value1['section_id'];
                    $data['stdId'] = $value1['std_id'];
                    $data['stdName'] = $value1['std_name'];
                    $data['stdRollNo'] = $value1['std_roll_no'];
                    $data['notifStatus'] = $value1['notif_status'];
                    $data['notifDate'] = $value1['notif_date'];
                    $data['orgId'] = $value1['org_id'];
                    $data2[] = $data;
                }
                $where3['class_id'] = $value['class_id'];
                $notif_list1 = $this->_notif_get_list_exam_parent($where3,$where2)->result_array();
                foreach ($notif_list1 as $key => $value3) {
                    $data3['notifId'] = $value3['notif_id'];
                    $data3['notifTitle'] = $value3['notif_title'];
                    $data3['notifDescription'] = $value3['notif_description'];
                    $data3['notifType'] = $value3['notif_type'];
                    $data3['typeId'] = $value3['type_id'];
                    $data3['programId'] = $value3['program_id'];
                    $data3['classId'] = $value3['class_id'];
                    $data3['sectionId'] = $value3['section_id'];
                    $data3['stdId'] = $value3['std_id'];
                    $data3['stdName'] = $value3['std_name'];
                    $data3['stdRollNo'] = $value3['std_roll_no'];
                    $data3['notifStatus'] = $value3['notif_status'];
                    $data3['notifDate'] = $value3['notif_date'];
                    $data3['orgId'] = $value3['org_id'];
                    $data2[] = $data3;
                }
            }
            $sid = $this->_notif_get_student_id($parent_id,$org_id,$limit,$page_no);
            $student_ids = array_map("unserialize", array_unique(array_map("serialize", $sid)));
            foreach ($student_ids as $key3 => $value4) {
                $where4['std_id'] = $value4['std_id'];
                $notif_list2 = $this->_notif_get_list_parent_update($where4,$where2)->result_array();
                foreach ($notif_list2 as $key => $value5) {
                    $data4['notifId'] = $value5['notif_id'];
                    $data4['notifTitle'] = $value5['notif_title'];
                    $data4['notifDescription'] = $value5['notif_description'];
                    $data4['notifType'] = $value5['notif_type'];
                    $data4['typeId'] = $value5['type_id'];
                    $data4['programId'] = $value5['program_id'];
                    $data4['classId'] = $value5['class_id'];
                    $data4['sectionId'] = $value5['section_id'];
                    $data4['stdId'] = $value5['std_id'];
                    $data4['stdName'] = $value5['std_name'];
                    $data4['stdRollNo'] = $value5['std_roll_no'];
                    $data4['notifStatus'] = $value5['notif_status'];
                    $data4['notifDate'] = $value5['notif_date'];
                    $data4['orgId'] = $value5['org_id'];
                    $data2[] = $data4;
                }
                $notif_list3 = $this->_notif_get_list_exam_parent_update($where4,$where2)->result_array();
                foreach ($notif_list3 as $key => $value7) {
                    $data5['notifId'] = $value7['notif_id'];
                    $data5['notifTitle'] = $value7['notif_title'];
                    $data5['notifDescription'] = $value7['notif_description'];
                    $data5['notifType'] = $value7['notif_type'];
                    $data5['typeId'] = $value7['type_id'];
                    $data5['programId'] = $value7['program_id'];
                    $data5['classId'] = $value7['class_id'];
                    $data5['sectionId'] = $value7['section_id'];
                    $data5['stdId'] = $value7['std_id'];
                    $data5['stdName'] = $value7['std_name'];
                    $data5['stdRollNo'] = $value7['std_roll_no'];
                    $data5['notifStatus'] = $value7['notif_status'];
                    $data5['notifDate'] = $value7['notif_date'];
                    $data5['orgId'] = $value7['org_id'];
                    $data2[] = $data5;
                }
            }
        }
        $count = $this->count_unread_notification_parent($parent_id,$org_id);
        if(isset($data2) && !empty($data2)){
            array_multisort($data2,SORT_DESC);
            $status = true;
            $data = $data2;
            $unread_notif = $count;
        }
        else{
            $status = false;
            $data='';
            $message = 'No Notifications';
            $unread_notif = 0;
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'message'=>$message,'unread_notif'=>$unread_notif,'data'=>$data,'total_pages'=>ceil($id['count_data']/$limit)));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }

}

function change_notification_status (){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $notif_id = $this->input->post('notifId');
        $org_id = $this->input->post('orgId');
        $user_type = $this->input->post('userType');
        
        $data = $this->_change_notification_status($notif_id,$org_id,$user_type);
        if($data==1){
            $status = true;
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }
}

function count_unread_notification(){
    $api = $this->input->post('api');
    if($api == 'true'){
        $status = false;
        $count = 0;
        $user_id = $this->input->post('userId');
        $org_id = $this->input->post('orgId');
        $user_type = $this->input->post('userType');
        if($user_type == 'Teacher'){
            $count = $this->count_unread_notification_teacher($user_id,$org_id);
        }
        elseif ($user_type == 'Parent') {
            $count = $this->count_unread_notification_parent($user_id,$org_id);
        }
        if(isset($count) && !empty($count)){
            $status = true;
            $unread_notif = $count;
        }
        else{
            $status = true;
            $unread_notif = 0;
        }
        header('Content-Type: application/json');
        echo json_encode(array('status'=>$status,'unread_notif'=>$unread_notif));
    }
    else{
        header('Content-Type: application/json');
        echo json_encode(array("status" => false, "message"=> "Unable to Connect"));
    }

}

function count_unread_notification_teacher($user_id,$org_id){
    $where2['org_id'] = $org_id;
    $count = 0;
    $id = $this->_notif_get_teacher($user_id,$org_id,'','');
    $section_ids = array_map("unserialize", array_unique(array_map("serialize", $id['all_data'])));
    if(isset($section_ids) && !empty($section_ids)){
        foreach ($section_ids as $key => $value) {
            $where1['section_id'] = $value['section_id'];
            $notif_list = $this->_notif_get_list_leave_status_teacher($where1,$where2)->result_array();
            foreach ($notif_list as $key => $value1) {
                if($value1['notif_status'] == 'unread'){
                    $count++;
                }
            }
        }
        foreach ($section_ids as $key2 => $value2) {
            $where3['class_id'] = $value2['class_id'];
            $notif_list1 = $this->_notif_get_list_exam_status_teacher($where3,$where2)->result_array();
            foreach ($notif_list1 as $key => $value3) {
                if($value3['notif_status'] == 'unread'){
                    $count++;
                }
            }
        }
        $subject_id = $this->_notif_get_subject_id($user_id,$org_id,'','');
        if (isset($subject_id) && !empty($subject_id)) {
            foreach ($subject_id as $key3 => $value4) {
                $where4['subject_id'] = $value4['subject_id'];
                $notif_list2 = $this->_notif_get_list_test_status_teacher($where4,$where2)->result_array();
                foreach ($notif_list2 as $key => $value5) {
                    if($value5['notif_status'] == 'unread'){
                        $count++;
                    }
                }
            }
        }
    }
    return $count;
}

function count_unread_notification_parent($user_id,$org_id){
    $where2['org_id'] = $org_id;
    $count = 0;
    $sid = $this->_notif_get_student_id($user_id,$org_id,'','');
    $student_ids = array_map("unserialize", array_unique(array_map("serialize", $sid)));
    $id = $this->_notif_get_parent($user_id,$org_id,'','');
    $section_ids = array_map("unserialize", array_unique(array_map("serialize", $id['all_data'])));
    if(isset($section_ids) && !empty($section_ids)){
        foreach ($section_ids as $key => $value) {
            $where1['section_id'] = $value['section_id'];
            $notif_list = $this->_notif_get_list_status_parent($where1,$where2)->result_array();
            foreach ($notif_list as $key => $value1) {
                if($value1['notif_status'] == 'unread'){
                    $count++;
                }
            }
        }
        foreach ($section_ids as $key2 => $value2) {
            $where3['class_id'] = $value2['class_id'];
            $notif_list1 = $this->_notif_get_list_status_exam_parent($where3,$where2)->result_array();
            foreach ($notif_list1 as $key => $value3) {
                if($value3['notif_status'] == 'unread'){
                    $count++;
                }
            }
        }
        foreach ($student_ids as $key3 => $value4) {
            $where4['std_id'] = $value4['std_id'];
            $notif_list2 = $this->_notif_get_list_status_parent_update($where4,$where2)->result_array();
            foreach ($notif_list2 as $key => $value5) {
                if($value5['notif_status'] == 'unread'){
                    $count++;
                }
            }
        }
        foreach ($student_ids as $key4 => $value6) {
            $where5['std_id'] = $value6['std_id'];
            $notif_list3 = $this->_notif_get_list_exam_status_parent_update($where5,$where2)->result_array();
            foreach ($notif_list3 as $key => $value7) {
                if($value7['notif_status'] == 'unread'){
                    $count++;
                }
            }
        }
    }
    return $count;
}


// ========================================================= //
// =============== Notification functions ================== //
// ========================================================= //

function _notif_insert_data_teacher($data){
    $this->load->model('mdl_front');
    $this->mdl_front->_notif_insert_data_teacher($data);
}

function _notif_insert_data_parent($data){
    $this->load->model('mdl_front');
    $this->mdl_front->_notif_insert_data_parent($data);
}

function _notif_get_teacher($teacher_id,$org_id,$limit,$page_no){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_teacher($teacher_id,$org_id,$limit,$page_no);
}

function _notif_get_subject_id($teacher_id,$org_id,$limit,$page_no){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_subject_id($teacher_id,$org_id,$limit,$page_no);
}

// function _notif_get_teacher_student_id($teacher_id,$org_id,$limit,$page_no){
//     $this->load->model('mdl_front');
//     return $this->mdl_front->_notif_get_teacher_student_id($teacher_id,$org_id,$limit,$page_no);
// }

function _notif_get_parent($parent_id,$org_id,$limit,$page_no){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_parent($parent_id,$org_id,$limit,$page_no);
}

function _notif_get_list_leave_teacher($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_leave_teacher($where1,$where2);
}

function _notif_get_list_test_teacher($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_test_teacher($where1,$where2);
}

// function _notif_get_list_test_update_teacher($where1,$where2){
//     $this->load->model('mdl_front');
//     return $this->mdl_front->_notif_get_list_test_update_teacher($where1,$where2);
// }

function _notif_get_list_exam_teacher($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_exam_teacher($where1,$where2);
}

function _notif_get_list_parent($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_parent($where1,$where2);
}

function _notif_get_list_exam_parent($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_exam_parent($where1,$where2);
}

function _notif_get_list_parent_update($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_parent_update($where1,$where2);
}

function _notif_get_list_exam_parent_update($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_exam_parent_update($where1,$where2);
}

function _notif_get_list_status_parent($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_status_parent($where1,$where2);
}

function _notif_get_list_status_exam_parent($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_status_exam_parent($where1,$where2);
}

function _notif_get_list_status_parent_update($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_status_parent_update($where1,$where2);
}

function _notif_get_list_exam_status_parent_update($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_exam_status_parent_update($where1,$where2);
}

function _change_notification_status($notif_id,$org_id,$user_type){
    $this->load->model('mdl_front');
    return $this->mdl_front->_change_notification_status($notif_id,$org_id,$user_type);
}

function _notif_get_list_leave_status_teacher($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_leave_status_teacher($where1,$where2);
}

function _notif_get_list_test_status_teacher($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_test_status_teacher($where1,$where2);
}

function _notif_get_list_exam_status_teacher($where1,$where2){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_list_exam_status_teacher($where1,$where2);
}

function _notif_get_test_detail($test_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_test_detail($test_id);
}

function _notif_get_child_detail($std_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_child_detail($std_id);
}

function _update_fcm_token($user_id,$fcm_token,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_update_fcm_token($user_id,$fcm_token,$org_id);
}

function _get_teacher_token($teacher_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_teacher_token($teacher_id,$org_id);
}

function _get_parent_token($parent_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_parent_token($parent_id,$org_id);
}

function _get_parent_for_push_noti($where,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_parent_for_push_noti($where,$org_id);
}
function _get_teacher_for_push_noti($where,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_teacher_for_push_noti($where,$org_id);
}

function _notif_get_student_id($parent_id,$org_id,$limit,$page_no){
    $this->load->model('mdl_front');
    return $this->mdl_front->_notif_get_student_id($parent_id,$org_id,$limit,$page_no);
}

}
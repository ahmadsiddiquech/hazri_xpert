<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Installment extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');

}

    function index() {
        $this->manage();
    }

    function manage() {
        $data['news'] = $this->_get_installment('installment.id desc');
        $data['view_file'] = 'installment_view';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function print_voucher(){
        $std_voucher_id = $this->uri->segment(4);
        $where['installment.id'] = $std_voucher_id;
        if (is_numeric($std_voucher_id) && $std_voucher_id != 0) {
            $data['news'] = $this->_get_data_from_db_print_voucher($where)->result_array();
        }
        $this->load->view('print',$data);
    }

    function voucher_record() {
        $data['news'] = $this->_get('voucher_record.id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function std_voucher_edit() {
        $voucher_id = $this->uri->segment(4);
        $class = $this->uri->segment(5);
        $std_voucher_id = $this->uri->segment(6);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        if (is_numeric($std_voucher_id) && $std_voucher_id != 0) {
            $data['news'] = $this->get_data_from_db_std_voucher($std_voucher_id);
        }
        $data['voucher_id'] = $voucher_id;
        $data['class'] = $class;
        $data['update_id'] = $std_voucher_id;
        $data['view_file'] = 'std_voucherform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function std_voucher() {
        $voucher_id = $this->uri->segment(4);
        if (is_numeric($voucher_id) && $voucher_id != 0) {
            $data['news'] = $this->_get_std_vouchers($voucher_id);
        }
        $data['view_file'] = 'std_voucher';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function get_data_from_db_std_voucher($update_id) {
        $where['voucher_data.id'] = $update_id;
        $query = $this->_get_by_arr_id_std_voucher($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['voucher_id'] = $row->voucher_id;
            $data['std_id'] = $row->std_id;
            $data['std_roll_no'] = $row->std_roll_no;
            $data['std_name'] = $row->std_name;
            $data['parent_name'] = $row->parent_name;
            $data['tution_fee'] = $row->tution_fee;
            $data['transport_fee'] = $row->transport_fee;
            $data['stationary_fee'] = $row->stationary_fee;
            $data['lunch_fee'] = $row->lunch_fee;
            $data['other_fee'] = $row->other_fee;
            $data['total'] = $row->total;
            $data['paid'] = $row->paid;
            $data['remaining'] = $row->remaining;
            $data['status'] = $row->status;
        }
        if(isset($data))
            return $data;
    }

    function _get_data_from_db_std_installment($id) {
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        $query = $this->_get_by_arr_id_std_installment($id);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->installment_id;
            $data['program_id'] = $row->program_id;
            $data['program_name'] = $row->program_name;
            $data['class_id'] = $row->class_id;
            $data['class_name'] = $row->class_name;
            $data['section_id'] = $row->section_id;
            $data['section_name'] = $row->section_name;
            $data['voucher_id'] = $row->voucher_id;
            $data['std_voucher_id'] = $row->std_voucher_id;
            $data['std_id'] = $row->std_id;
            $data['std_name'] = $row->std_name;
            $data['due_date'] = $row->due_date;
            $data['pay_date'] = $row->pay_date;
            $data['tution_fee'] = $row->i_tution_fee;
            $data['transport_fee'] = $row->i_transport_fee;
            $data['lunch_fee'] = $row->i_lunch_fee;
            $data['stationary_fee'] = $row->i_stationary_fee;
            $data['other_fee'] = $row->i_other_fee;
            $data['fee'] = $row->fee;
            $data['status'] = $row->status;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }

    function submit_std_voucher() {
        $voucher_id = $this->uri->segment(4);
        $class = $this->uri->segment(5);
        $std_voucher_id = $this->uri->segment(6);
        $total =$this->input->post('total');
        $tution_fee =$this->input->post('tution_fee');
        $transport_fee =$this->input->post('transport_fee');
        $lunch_fee =$this->input->post('lunch_fee');
        $stationary_fee =$this->input->post('stationary_fee');
        $other_fee =$this->input->post('other_fee');
        $installment =$this->input->post('n_of_i');
        $due_date = $this->input->post('due_date');
        $fee = $total/$installment;
        $i_tution_fee = $tution_fee/$installment;
        $i_transport_fee = $transport_fee/$installment;
        $i_lunch_fee = $lunch_fee/$installment;
        $i_stationary_fee = $stationary_fee/$installment;
        $i_other_fee = $other_fee/$installment;
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];

        $data = $this->get_data_from_db_std_voucher($std_voucher_id);

        $counter=0;
        foreach ($due_date as $key => $value) {
            $data2 = array();
            unset($data2); 
            $data2 = array();
            $data2['voucher_id']=$voucher_id;
            $data2['std_voucher_id']=$std_voucher_id;
            $data2['fee']=$fee;
            $data2['i_tution_fee']=$i_tution_fee;
            $data2['i_transport_fee']=$i_transport_fee;
            $data2['i_lunch_fee']=$i_lunch_fee;
            $data2['i_stationary_fee']=$i_stationary_fee;
            $data2['i_other_fee']=$i_other_fee;
            $data2['issue_date']=date('Y/m/d');
            $data2['std_id']=$data['std_id'];
            $data2['std_name']=$data['std_name'];
            $data2['due_date']=$due_date[$counter];
            $data2['org_id']=$org_id;
            
            $insert_id = $this->_insert_installment_std_voucher($data2);
            $counter++; 
        }
        $this->_installment_flag($voucher_id,$std_voucher_id);

        $whereStd['id'] = $data['std_id'];
        $parents = $this->_get_parent_id_for_notification($whereStd,$org_id)->result_array();
        if (isset($parents) && !empty($parents)) {
            foreach ($parents as $key => $value) {
                $data3['notif_for'] = 'Parent';
                $data3['user_id'] = $value['parent_id'];
                $data3['std_id'] = $value['id'];
                $data3['std_name'] = $value['name'];
                $data3['std_roll_no'] = $value['roll_no'];
                $data3['notif_title'] = 'Fee Voucher Installment';
                $data3['notif_description'] = 'Installment of Voucher for '.$value['name'].' has been made';
                $data3['notif_type'] = 'installment';
                $data3['notif_sub_type'] = 'installment';
                $data3['sub_type_id'] = $insert_id;
                $data3['type_id'] = $voucher_id;
                date_default_timezone_set("Asia/Karachi");
                $data3['notif_date'] = date('Y-m-d H:i:s');
                $data3['org_id'] = $org_id;
                $nid = $this->_notif_insert_data($data3);
                $token = $this->_get_parent_token($value['parent_id'],$org_id)->result_array();
                Modules::run('front/send_notification',$token,$nid,$data3['notif_title'],$data3['notif_description']);
            }
        }

        $this->session->set_flashdata('message', 'installment'.' '.DATA_SAVED);
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'installment');
    }


    function delete() {
        $delete_id = $this->input->post('id');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->_delete($delete_id, $org_id);
    }

    function set_publish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_publish($where);
        $this->session->set_flashdata('message', 'Post published successfully.');
        redirect(ADMIN_BASE_URL . 'installment/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'installment/manage/' . '');
    }

    function change_status() {
        date_default_timezone_set("Asia/Karachi");
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $fee = $this->input->post('fee');
        $std_voucher_id = $this->input->post('std_voucher_id');

        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];

        $s_v_data = $this->get_data_from_db_std_voucher($std_voucher_id);
        if ($status == 0) {
            $data2['paid'] = $s_v_data['paid'] + $fee;
            $data2['remaining'] = $s_v_data['remaining'] - $fee;
            if ($s_v_data['total'] == $data2['paid']) {
                $data2['status'] = 1;
            }
            else{
                $data2['status'] = 0;
            }
            if ($status == PUBLISHED){
                $status = UN_PUBLISHED;
            }
            else{
                $status = PUBLISHED;
            }
        }
        else if($status == 1){
            $data2['paid'] = $s_v_data['paid'] - $fee;
            $data2['remaining'] = $s_v_data['remaining'] + $fee;
            $data2['status'] = 0;
            if ($status == PUBLISHED){
                $status = UN_PUBLISHED;
            }
            else{
                $status = PUBLISHED;
            }
        }
        $data['status'] = $status;
        $data['pay_date'] = date('Y-m-d H:i:s');
        $data2['pay_date'] = date('Y-m-d H:i:s');
        $this->_update_id($id, $data, $std_voucher_id,$data2);

        $whereStd['id'] = $s_v_data['std_id'];
        $parents = $this->_get_parent_id_for_notification($whereStd,$org_id)->result_array();
        if (isset($parents) && !empty($parents)) {
            foreach ($parents as $key => $value) {
                $data3['notif_for'] = 'Parent';
                $data3['user_id'] = $value['parent_id'];
                $data3['std_id'] = $value['id'];
                $data3['std_name'] = $value['name'];
                $data3['std_roll_no'] = $value['roll_no'];
                $data3['notif_title'] = 'Fee Voucher Installment Paid';
                $data3['notif_description'] = 'Installment of Voucher for '.$value['name'].' has been Paid';
                $data3['notif_type'] = 'installment';
                $data3['notif_sub_type'] = 'installment';
                $data3['sub_type_id'] = $id;
                $data3['type_id'] = $s_v_data['voucher_id'];
                date_default_timezone_set("Asia/Karachi");
                $data3['notif_date'] = date('Y-m-d H:i:s');
                $data3['org_id'] = $org_id;
                $nid = $this->_notif_insert_data($data3);
                $token = $this->_get_parent_token($value['parent_id'],$org_id)->result_array();
                Modules::run('front/send_notification',$token,$nid,$data3['notif_title'],$data3['notif_description']);
            }
        }
    }

    /////////////// for detail ////////////

    function _set_publish($arr_col) {
        $this->load->model('mdl_installment');
        $this->mdl_installment->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_installment');
        $this->mdl_installment->_set_unpublish($arr_col);
    }

    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db_std_installment($update_id);
        $this->load->view('detail', $data);
    }
    
    function _get($order_by) {
        $this->load->model('mdl_installment');
        return $this->mdl_installment->_get($order_by);
    }

    function _get_installment($order_by) {
        $this->load->model('mdl_installment');
        return $this->mdl_installment->_get_installment($order_by);
    }

    function _get_std_vouchers($voucher_id) {
        $this->load->model('mdl_installment');
        return $this->mdl_installment->_get_std_vouchers($voucher_id);
    }

    function _get_by_arr_id_std_installment($id) {
        $this->load->model('mdl_installment');
        return $this->mdl_installment->_get_by_arr_id_std_installment($id);
    }

    function _get_by_arr_id_std_voucher($arr_col) {
        $this->load->model('mdl_installment');
        return $this->mdl_installment->_get_by_arr_id_std_voucher($arr_col);
    }

    function _insert_installment_std_voucher($data) {
        $this->load->model('mdl_installment');
        return $this->mdl_installment->_insert_installment_std_voucher($data);
    }

    function _update_id($id, $data, $std_voucher_id, $data2) {
        $this->load->model('mdl_installment');
        $this->mdl_installment->_update_id($id, $data, $std_voucher_id, $data2);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_installment');
        $this->mdl_installment->_delete($arr_col, $org_id);
    }

    function _installment_flag($voucher_id,$std_voucher_id){
        $this->load->model('mdl_installment');
        $this->mdl_installment->_installment_flag($voucher_id,$std_voucher_id);
    }

    function _get_parent_id_for_notification($where,$org_id){
        $this->load->model('mdl_installment');
        return $this->mdl_installment->_get_parent_id_for_notification($where,$org_id);
    }

    function _notif_insert_data($data2){
        $this->load->model('mdl_installment');
        return $this->mdl_installment->_notif_insert_data($data2);
    }

    function _get_parent_token($parent_id,$org_id){
        $this->load->model('mdl_installment');
        return $this->mdl_installment->_get_parent_token($parent_id,$org_id);
    }

    function _get_data_from_db_print_voucher($where){
        $this->load->model('mdl_installment');
        return $this->mdl_installment->_get_data_from_db_print_voucher($where);
    }
}
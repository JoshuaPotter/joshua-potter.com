<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Freelancer Office
 * 
 * Web based project and invoicing management system available on codecanyon
 *
 * @package     Freelancer Office
 * @author      William Mandai
 * @copyright   Copyright (c) 2014 - 2016 Gitbench,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://codecanyon.net/item/freelancer-office/8870728
 * @link        https://gitbench.com
 */


class Payments extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->module('layouts');
        $this->load->library(array('template','form_validation'));
        $this->load->model(array('Payment','App','Invoice','Client'));

        $this->applib->set_locale();

    }

    function index()
    {
        $this->template->title(lang('payments'));
        $data['page'] = lang('payments');
        $data['datatables'] = TRUE;
        $data['payments'] = $this->_payments_list();
        $this->template
            ->set_layout('users')
            ->build('payments',isset($data) ? $data : NULL);
    }



    function edit($transaction = NULL)
    {
        if ($this->input->post()) {
            $id = $this->input->post('p_id',TRUE);

            $this->form_validation->set_rules('payment_date', 'Payment Date', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                $_POST = '';
                Applib::go_to('payments/edit/'.$id,'error',lang('error_in_form'));
            }else{

                $_POST['payment_date'] = Applib::date_formatter($_POST['payment_date']);

                $_POST['month_paid'] = date("m",strtotime($_POST['payment_date']));
                $_POST['year_paid'] = date("Y",strtotime($_POST['payment_date']));

                Payment::update_pay($id,$this->input->post());

                $payment = Payment::view_by_id($id);

                $data = array(
                    'module' => 'invoices',
                    'module_field_id' => $payment->invoice,
                    'user' => User::get_id(),
                    'activity' => 'activity_edited_payment',
                    'icon' => 'fa-pencil',
                    'value1' => $payment->trans_id,
                    'value2' => $payment->amount
                );
                App::Log($data);

                Applib::go_to('payments/edit/'.$id,'success',lang('payment_edited_successfully'));

            }
        }else{
            $this->template->title(lang('payments'));
            $data['page'] = lang('payments');
            $data['datepicker'] = TRUE;
            $data['payments'] = $this->_payments_list();
            $data['id'] = $transaction;

            $this->template
                ->set_layout('users')
                ->build('edit_payment',isset($data) ? $data : NULL);

        }
    }

    function view($id =NULL)
    {
        $this->template->title(lang('payments'));
        $data['page'] = lang('payments');
        $data['payments'] = $this->_payments_list();
        $data['id'] = $id;
        $this->template
            ->set_layout('users')
            ->build('view',isset($data) ? $data : NULL);
    }



    function delete($id = NULL)
    {
        if ($this->input->post()) {
            $id = $this->input->post('id', TRUE);
            $payment = Payment::view_by_id($id);

            Payment::delete($id); //delete transaction

            Invoice::update($payment->invoice,array('status'=>'Unpaid'));

            $data = array(
                'module' => 'invoices',
                'module_field_id' => $payment->invoice,
                'user' => User::get_id(),
                'activity' => 'activity_delete_payment',
                'icon' => 'fa-times',
                'value1' => $payment->trans_id,
                'value2' => $payment->currency .''. $payment->amount
            );
            App::Log($data);

            Applib::go_to('payments','success',lang('payment_deleted_successfully'));

        }else{
            $data['id'] = $id;
            $this->load->view('modal/delete_payment',$data);

        }
    }

    function refund(){
        if($_POST){
            $id = $this->input->post('id', TRUE);
            $refund = Payment::view_by_id($id)->refunded;
            if($refund == 'Yes') Payment::update_pay($id,array('refunded'=>'No'));
            if($refund == 'No') Payment::update_pay($id,array('refunded'=>'Yes'));
            Applib::go_to('payments/view/'.$id,'success',lang('payment_edited_successfully'));
        }else{
            $data['id'] = $this->uri->segment(3);
            $this->load->view('modal/refund',$data);
        }
    }

    function _payments_list(){
        if(User::is_admin() || User::perm_allowed(User::get_id(),'view_all_payments')){
            return Payment::all();
        }else{
            return Payment::by_client(User::profile_info(User::get_id())->company);
        }
    }



}

/* End of file payments.php */
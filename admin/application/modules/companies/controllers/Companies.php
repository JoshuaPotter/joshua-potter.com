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
 * @link     	https://gitbench.com
 */


class Companies extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		User::logged_in();
		
		$this->load->library(array('form_validation'));
		$this->load->model(array('Client','App','Invoice','Expense','Project','Payment'));
		if (!User::is_admin()) {
			$this->session->set_flashdata('message', lang('access_denied'));
			redirect('');
		}
		$this->applib->set_locale();
		
	}

	function index()
	{
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title(lang('clients').' - '.config_item('company_name'));
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['currencies'] = App::currencies();
		$data['languages'] = App::languages();

		$data['companies'] = Client::get_all_clients();

		$data['countries'] = App::countries();
		$this->template
				->set_layout('users')
				->build('companies',isset($data) ? $data : NULL);
	}

	function view($company = NULL){
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title(lang('clients').' - '.config_item('company_name'));
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['company'] = $company;

		$this->template
		->set_layout('users')
		->build('view',isset($data) ? $data : NULL);
	}



	function create()
			{
				if ($this->input->post()) {

					$this->form_validation->set_rules('company_ref', 'Client Ref', 'required|is_unique[companies.company_ref]');
					$this->form_validation->set_rules('company_name', 'Client Name', 'required');
					$this->form_validation->set_rules('company_email', 'Client Email', 'required|valid_email');

					if ($this->form_validation->run() == FALSE)
					{
						$_POST = '';
						// $errors = validation_errors();
						Applib::go_to('companies','error',lang('error_in_form'));
					}else{
						$_POST['company_website'] = prep_url($_POST['company_website']);

						$company_id = Client::save($this->input->post(NULL,TRUE));

						$args = array(
							'user' => User::get_id(),
							'module' => 'Clients',
							'module_field_id' => $company_id,
							'activity' => 'activity_added_new_company',
							'icon' => 'fa-user',
							'value1' => $this->input->post('company_name',TRUE)
						);
						App::Log($args);

						$this->session->set_flashdata('response_status', 'success');
						$this->session->set_flashdata('message', lang('client_registered_successfully'));
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{
			        $this->load->view('modal/create');
				}
			}



	function update($company = NULL)
			{
				if ($this->input->post()) {
					$this->load->library('form_validation');
					$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
					$this->form_validation->set_rules('company_ref', 'Company ID', 'required');
					$this->form_validation->set_rules('company_name', 'Company Name', 'required');
					$this->form_validation->set_rules('company_email', 'Company Email', 'required|valid_email');
					
					if ($this->form_validation->run() == FALSE)
					{
						$this->session->set_flashdata('response_status', 'error');
						$this->session->set_flashdata('message', lang('error_in_form'));
						$company_id = $_POST['co_id'];
						$_POST = '';
						redirect('companies/view/'.$company_id);
					}else{
						$company_id = $_POST['co_id'];
						$_POST['company_website'] = prep_url($_POST['company_website']);
						Client::update($company_id, $this->input->post());

						$args = array(
							'user' => User::get_id(),
							'module' => 'Clients',
							'module_field_id' => $company_id,
							'activity' => 'activity_updated_company',
							'icon' => 'fa-edit',
							'value1' => $this->input->post('company_name',TRUE)
						);
						App::Log($args);

						$this->session->set_flashdata('response_status', 'success');
						$this->session->set_flashdata('message', lang('client_updated'));
						redirect('companies/view/'.$company_id);
					}
				}else{
			        $data['company'] = $company;
			        $this->load->view('modal/edit',$data);
				}
			}


			function send_invoice($user = NULL){

				$company = $this->uri->segment('4');

				if ($this->input->post()) {
					$lib = new Applib;
					$invoice_id = $this->input->post('invoice_id',TRUE);
					$company = $this->input->post('company',TRUE);
					$contact = $this->input->post('user',TRUE);

					$info = Invoice::view_by_id($invoice_id);
					$client = Client::view_by_id($info->client);

					if ($contact > 0) {
						$login = "?login=".$this->tank_auth->create_remote_login($contact);
					} else { $login = ""; }

					$amount = number_format(Invoice::get_invoice_due_amount($invoice_id),2,config_item('decimal_separator'),config_item('thousand_separator'));

					$cur = App::currencies($info->currency)->symbol;

					$message = App::email_template('invoice_message','template_body');
					$subject = App::email_template('invoice_message','subject');
					$signature = App::email_template('email_signature','template_body');

					$logo_link = '<img style="width:300px" src="'.base_url().'resource/images/logos/'.config_item('invoice_logo').'"/>';

					$logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

					$client_name = str_replace("{CLIENT}",$client->company_name,$logo);
					$Ref = str_replace("{REF}",$info->reference_no,$client_name);
					$Amount = str_replace("{AMOUNT}",$amount,$Ref);
					$Currency = str_replace("{CURRENCY}",$cur,$Amount);
					$link = str_replace("{INVOICE_LINK}",base_url().'invoices/view/'.$invoice_id.$login,$Currency);
					$EmailSignature = str_replace("{SIGNATURE}",$signature,$link);
					$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);


					$this->_email_invoice($invoice_id,$message,$subject,$contact); // Email Invoice

					$data = array('emailed' => 'Yes', 'date_sent' => date ("Y-m-d H:i:s", time()));

					App::update('invoices',array('inv_id'=>$invoice_id),$data);

					// Log Activity
					$activity = array(
						'user'				=> User::get_id(),
						'module' 			=> 'invoices',
						'module_field_id'	=> $invoice_id,
						'activity'			=> 'activity_invoice_sent',
						'icon'				=> 'fa-envelope',
						'value1'            => $info->reference_no
					);
					App::Log($activity); 

					Applib::go_to($_SERVER['HTTP_REFERER'],'success',lang('invoice_sent_successfully'));
				}else{
					$data['invoices'] = Invoice::get_client_invoices($company);
					$data['company'] = $company;
					$data['user'] = $user;
					$this->load->view('modal/email_invoice',$data);
				}
			}



			function _email_invoice($invoice_id,$message,$subject,$contact){

				$info = Invoice::view_by_id($invoice_id);

				$data['message'] = $message;

				$message = $this->load->view('email_template', $data, TRUE);

				$params = array(
					'recipient' => User::login_info($contact)->email,
					'subject'   => $subject,
					'message'   => $message
				);

				$this->load->helper('file');
				$attach['inv_id'] = $invoice_id;
				if (config_item('pdf_engine') == 'invoicr') {
					$invoicehtml = modules::run('fopdf/attach_invoice',$attach);
				}
				if (config_item('pdf_engine') == 'mpdf') {
					$invoicehtml = modules::run('invoices/attach_pdf',$invoice_id);
				}

				$params['attached_file'] = './resource/tmp/'.lang('invoice').' '.$info->reference_no.'.pdf';
				$params['attachment_url'] = base_url().'resource/tmp/'.lang('invoice').' '.$info->reference_no.'.pdf';

				modules::run('fomailer/send_email',$params);
				//Delete invoice in tmp folder
				if(is_file('./resource/tmp/'.lang('invoice').' '.$info->reference_no.'.pdf'))
				unlink('./resource/tmp/'.lang('invoice').' '.$info->reference_no.'.pdf');
			
			}



			function make_primary(){
				$contact = $this->uri->segment(3);
				$company = $this->uri->segment(4);
				$this->db->set('primary_contact', $contact);
				$this->db->where('co_id',$company)->update('companies');
				$this->session->set_flashdata('response_status', 'success');
				$this->session->set_flashdata('message', lang('primary_contact_set'));
				redirect('companies/view/'.$company);
			}

			function account()
			{
				$client = $this->db->where('co_id',$this->uri->segment(4))->get('companies')->result();
				$data['client'] = $client[0];
				$data['type'] = $this->uri->segment(3);
				$this->load->view('modal/account',isset($data) ? $data : NULL);
			}

			// Delete Company
	function delete()
	{
		if ($this->input->post()) {

			$company = $this->input->post('company', TRUE);
			

			Client::delete($company);

			$this->session->set_flashdata('response_status', 'success');
			$this->session->set_flashdata('message', lang('company_deleted_successfully'));
			redirect('companies');

		}else{
			$data['company_id'] = $this->uri->segment(4);
			$this->load->view('modal/delete',$data);
		}
	}
}
/* End of file contacts.php */

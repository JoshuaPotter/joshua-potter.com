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


class Projects extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->module('layouts');
        $this->load->library(array('template','form_validation'));
        $this->load->model(array('Client','Project','App','Expense'));
        $this->template->title(lang('projects'));

        $archive = FALSE;
        if (isset($_GET['view'])) { if ($_GET['view'] == 'archive') { $archive = TRUE; } }

        $this->filter_by = $this->_filter_by();

        $this->applib->set_locale();

    }


    function index()
    {
        $archive = FALSE;
        if (isset($_GET['view'])) { if ($_GET['view'] == 'archive') { $archive = TRUE; } }
        $data = array(
            'page' => lang('projects'),
            'projects' => $this->_project_list($archive),
            'datatables' => TRUE,
            'archive' => $archive
        );
        $this->template
            ->set_layout('users')
            ->build('projects',isset($data) ? $data : NULL);
    }


    function view($project = NULL)
    {
        $this->_check_owner($project);

        $data = array(
            'page'			=> lang('projects'),
            'datatables'	=> TRUE,
            'fuelux'		=> TRUE,
            'editor'		=> TRUE,
            'nouislider'	=> TRUE,
            'project'		=> $project,
            'todo_list'		=> TRUE,
            'datepicker'	=> TRUE,
            'task_checkbox'	=> TRUE
        );

        $data['group'] = $this->input->get('group', TRUE) ? $this->input->get('group', TRUE) : 'dashboard';


        if(isset($_GET['action']) ? $_GET['action'] : '' == 'edit'){
            $data['form'] = TRUE;
            $data['set_fixed_rate'] = TRUE;
        }

        if($data['group'] == 'calendar'){ $data['calendar'] = TRUE; }

        if($data['group'] == 'gantt'){
            $data['project'] = $project;
            $data['gantt'] = TRUE;
        }

        $this->template
            ->set_layout('users')
            ->build('view',isset($data) ? $data : NULL);
    }



    function add()
    {
        if(!User::can_add_project()) App::access_denied('projects');

        if ($this->input->post()) {
            // check form validation
            $this->form_validation->set_rules('project_code', 'Project Code', 'required');
            $this->form_validation->set_rules('project_title', 'Project Title', 'required');

            if ($this->form_validation->run() == FALSE) // Validation ok
            {
                Applib::make_flashdata(array(
                    'response_status' => 'error',
                    'message' => lang('operation_failed'),
                    'form_error'=> validation_errors()
                ));
                redirect('projects/add');
            }else{


                if ($this->input->post('fixed_rate') == 'on') { $fixed_rate = 'Yes'; } else { $fixed_rate = 'No'; }

                unset($_POST['fixed_rate']);

                if (User::login_role_name() != 'client') { // If added by client, just assign admin
                    if(User::login_role_name() == 'staff'){
                        $_POST['assign_to'] = 'a:1:{i:0;s:1:"'.User::get_id().'";}';
                    }else{
                        $_POST['assign_to'] = serialize($this->input->post('assign_to'));
                    }

                }else{
                    $_POST['assign_to'] = 'a:1:{i:0;s:1:"1";}';
                    $_POST['progress'] = 0;
                }


                if(User::login_role_name() == 'client'){
                    $company_id = User::profile_info(User::get_id())->company;
                    if($company_id > 0){
                        $_POST['client'] = $company_id;
                    }else{

                        Applib::go_to('projects','error',lang('company_not_set'));
                    }
                }

                $_POST['start_date'] = Applib::date_formatter($_POST['start_date']);

                $_POST['due_date'] = Applib::date_formatter($_POST['due_date']);

                if (isset($_POST['files'])) { unset($_POST['files']); }

                $project_id = Project::save($this->input->post());

                // Inherit currency and language settings

                if ($_POST['client'] > 0) {
                    $client_cur = Client::client_currency($_POST['client']);
                    $client_lang = Client::client_language($_POST['client']);
                } else {
                    $client_cur = App::currencies(config_item('default_currency'));
                    $client_lang = App::languages(config_item('default_language'));
                }
                $data = array(
                    'currency' => $client_cur->code,
                    'language' => $client_lang->name,
                    'project_id' => $project_id
                );
                Project::update($project_id,$data);


                // Store assignments in assign_projects table

                $assign = unserialize($_POST['assign_to']);

                Project::delete_team($project_id);

                foreach ($assign as $key => $value) {
                    $args = array(
                        'assigned_user' => $value,
                        'project_assigned' => $project_id
                    );
                    App::save_data('assign_projects',$args);
                }

                // Set Fixed Rate
                $data = array('fixed_rate' => $fixed_rate);
                Project::update($project_id,$data);

                // default project settings

                $default_settings = array(
                    'show_milestones'     	=> 'on',
                    'show_project_tasks'  	=> 'on',
                    'show_project_files'	=> 'on',
                    'show_project_bugs'		=> 'on',
                    'show_project_history'	=> 'on',
                    'show_project_calendar'	=> 'on',
                    'show_project_comments'	=> 'on',
                    'show_project_gantt'	=> 'on',
                    'show_project_hours'	=> 'on',
                    'client_add_tasks'		=> 'on',
                    'project_id'				=> $project_id
                );

                $default_settings = json_encode($default_settings);

                $data = array('settings' => $default_settings);
                Project::update($project_id,$data);

                // Send email to the assigned users
                if(config_item('notify_project_assignments') == 'TRUE'){
                    $this->assigned_notification($project_id);
                }

                // Send email to client
                if(config_item('notify_project_opened') == 'TRUE'){
                    $this->client_notification($project_id);
                }

                // Post to slack channel
                if(config_item('slack_notification') == 'TRUE'){
                    $this->load->helper('slack');
                    $slack = new Slack_Post;
                    $slack->slack_create_project($project_id,User::get_id());
                }

                $data = array(
                    'module' => 'projects',
                    'module_field_id' => $project_id,
                    'user' => User::get_id(),
                    'activity' => 'activity_added_new_project',
                    'icon' => 'fa-coffee',
                    'value1' => $_POST['project_title'],
                    'value2' => ''
                );
                App::Log($data);

                Applib::go_to('projects/view/'.$project_id.'?group=dashboard','success',lang('project_added_successfully'));
            }


        }else{
            $data = array(
                'page' => lang('projects'),
                'form' => TRUE,
                'datepicker' => TRUE,
                'nouislider' => TRUE,
                'editor'	=> TRUE,
                'set_fixed_rate' => TRUE,
                'projects' => $this->_project_list()
            );
            $this->template
                ->set_layout('users')
                ->build('create_project',isset($data) ? $data : NULL);
        }
    }





    function edit()
    {


        if ($this->input->post()) {
            $project_id = $this->input->post('project_id');

            if(!User::can_edit_project(Project::by_id($project_id)->client,$project_id)) App::access_denied('projects');
            // check form validation
            $this->form_validation->set_rules('project_code', 'Project Code', 'required');
            $this->form_validation->set_rules('project_title', 'Project Title', 'required');
            $this->form_validation->set_rules('client', 'Client', 'required');
            $this->form_validation->set_rules('assign_to[]', 'Assign To', 'required');

            if ($this->form_validation->run() == FALSE)
            {

                var_dump(validation_errors());
                die();
                Applib::make_flashdata(array(
                    'response_status' => 'error',
                    'message' => lang('error_in_form'),
                    'form_error'=> validation_errors()
                ));
                redirect('projects/view/'.$project_id.'/?group=dashboard&action=edit');
            }else{

                $notify = TRUE; // Send email only when team changed
                $current_team = Project::by_id($project_id)->assign_to;
                if(serialize($this->input->post('assign_to')) == $current_team) $notify = FALSE;


                $fixed_rate = ($this->input->post('fixed_rate') == 'on') ? 'Yes' : 'No';
                unset($_POST['fixed_rate']);

                $new_team = $this->input->post('assign_to');

                Project::delete_team($project_id);

                foreach ($new_team as $key => $value) {
                    $data = array(
                        'assigned_user' => $value,
                        'project_assigned' => $project_id
                    );
                    App::save_data('assign_projects',$data);
                }

                if ($_POST['client'] > 0) {
                    $client_cur = Client::client_currency($_POST['client']);
                    $client_lang = Client::client_language($_POST['client']);
                } else {
                    $client_cur = App::currencies(config_item('default_currency'));
                    $client_lang = App::languages(config_item('default_language'));
                }


                $_POST['assign_to'] = serialize($new_team);

                $_POST['start_date'] = Applib::date_formatter($_POST['start_date']);
                $_POST['due_date'] = Applib::date_formatter($_POST['due_date']);

                if (isset($_POST['files'])) unset($_POST['files']);

                Project::update($project_id,$this->input->post());

                $data = array(
                    'currency' => $client_cur->code,
                    'language' => $client_lang->name,
                    'project_id' => $project_id
                );
                Project::update($project_id,$data);


                // Set Fixed Rate
                $data = array('fixed_rate' => $fixed_rate);
                Project::update($project_id,$data);

                // Send email to the assigned users
                if(config_item('notify_project_assignments') == 'TRUE' && $notify){
                    $this->_notify_project_update($project_id);
                }
                // Log activity
                $data = array(
                    'module' => 'projects',
                    'module_field_id' => $project_id,
                    'user' => User::get_id(),
                    'activity' => 'activity_edited_a_project',
                    'icon' => 'fa-coffee',
                    'value1' => $_POST['project_title'],
                    'value2' => ''
                );
                App::Log($data);

                if ($this->input->post('progress') == '100') {
                    $this->_project_complete($project_id);
                }

                Applib::go_to('projects/view/'.$project_id.'?group=dashboard&action=edit','success',lang('project_edited_successfully'));
            }
        }else{
            Applib::go_to('projects','error',lang('error_in_form'));
        }
    }



    function todo($action = NULL){

        $action = $this->uri->segment(3);

        if($action == 'add'){

            if($_POST){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('todo_item', 'Item', 'required');

                if ($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('operation_failed'));
                    redirect($_SERVER['HTTP_REFERER']);
                }else{
                    $project = $this->input->post('project',TRUE);
                    $visible = ($this->input->post('visible') == 'on') ? 'Yes' : 'No';
                    $data = array('list_name' 	=> $this->input->post('todo_item'),
                        'saved_by'	=> User::get_id(),
                        'visible'		=> $visible,
                        'project'		=> $project
                    );
                    App::save_data('todo',$data);
                    Applib::go_to('projects/view/'.$project,'success',lang('item_added_successfully'));
                }

            }else{
                $data['project_id'] = $this->uri->segment(4);
                $data['action'] = 'add_todo';
                $this->load->view('modal/project_action',$data);
            }

        }

        if ($action == 'edit') {
            if($_POST){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('todo_item', 'Item', 'required');

                if ($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('operation_failed'));
                    redirect($_SERVER['HTTP_REFERER']);
                }else{
                    $id = $this->input->post('id',TRUE);
                    $project = $this->input->post('project',TRUE);
                    if(!isset($_POST['visible'])) $visible = 'No';
                    $visible = ($this->input->post('visible') == 'on') ? 'Yes' : 'No';
                    $data = array('list_name' 	=> $this->input->post('todo_item'),
                        'saved_by'	=> User::get_id(),
                        'visible'		=> $visible
                    );
                    App::update('todo',array('id'=>$id),$data);
                    Applib::go_to('projects/view/'.$project,'success',lang('operation_successful'));
                }

            }else{
                $data['id'] = $this->uri->segment(4);
                $data['action'] = 'edit_todo';
                $this->load->view('modal/project_action',$data);
            }
        }

        if($action == 'delete'){
            if($_POST){
                $id = $this->input->post('id');
                App::delete('todo',array('id'=>$id));
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('operation_successful'));
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $data['id'] = $this->uri->segment(4);
                $data['action'] = 'delete_todo';
                $this->load->view('modal/project_action',$data);
            }
        }

        if($action == 'status'){
            if($_POST){
                $id = $this->input->post('id');
                $i = $this->db->where('id',$id)->get('todo')->row();
                if($i->saved_by != User::get_id()){
                    $data['success'] = false;
                    $data['message'] = 'Failed!';
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('operation_failed'));
                    echo json_encode($data);
                    exit;
                }

                $todo_complete = $this->input->post('todo_complete');
                $progress = ($todo_complete == 'true') ? 'done' : 'pending';
                $args = array('status' => $progress);
                App::update('todo',array('id'=>$id),$args);

                $data['success'] = true;
                $data['message'] = 'Success!';
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('operation_successful'));
                echo json_encode($data);
                exit;
            }
        }


    }


    function delete($id = NULL)
    {
        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('project_id', 'Project ID', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('delete_failed'));
                redirect('projects');
            }else{

                $project = $this->input->post('project_id',TRUE);
                if(User::is_admin() || User::perm_allowed(User::get_id(),'delete_projects')){
                    Project::delete($project);
                    Applib::go_to('projects','success',lang('project_deleted_successfully'));
                }

            }
        }else{
            $data['project_id'] = $id;
            $data['action'] = 'delete_project';
            $this->load->view('modal/project_action',$data);
        }
    }



    function gantt($project = NULL)
    {
        $data = array(
            'page' => lang('projects'),
            'project' => $project,
            'gantt' => TRUE,
        );
        $this->template
            ->set_layout('users')
            ->build('gantt',isset($data) ? $data : NULL);
    }




    function archive($id)
    {
        $archived = $this->uri->segment(4);
        $data = array("archived" => $archived);
        Project::update($id,$data);

        // Post to slack channel
        if(config_item('slack_notification') == 'TRUE'){
            $project_title = Project::by_id($id)->project_title;
            Applib::slack(
                sprintf(lang('project_archived_msg'), $project_title,date('d-M-Y H:i:s')),
                sprintf(lang('project_archived'), $project_title),
                base_url().'projects/view/'.$id,
                sprintf(lang('project_archived_by'), User::displayName(User::get_id()))
            );
        }

        // Log activity
        $data = array(
            'module'            => 'projects',
            'module_field_id'   => $id,
            'user'              => User::get_id(),
            'activity'          => 'activity_edited_a_project',
            'icon'              => 'fa-coffee',
            'value1'            => $project_title,
            'value2'            => ''
        );
        App::Log($data);
        Applib::go_to('projects','success',lang('project_edited_successfully'));
    }

    function copy_project($project = NULL)
    {
        if ($this->input->post()) {

            $project = $this->input->post('project', TRUE);

            $this->form_validation->set_rules('project', 'Project', 'required');
            if ($this->form_validation->run() == FALSE)
            {
                Applib::go_to('projects/view/'.$project.'?group=dashboard','error',lang('project_copy_failed'));
            }else{

                $inf = Project::by_id($project);

                $new_code = filter_var($inf->project_code,FILTER_SANITIZE_NUMBER_INT)+1 ;

                $new_project = array(
                    'project_code' 	=> config_item('project_prefix').$new_code,
                    'project_title' => $inf->project_title,
                    'description' 	=> $inf->description,
                    'client'		=> $inf->client,
                    'currency'		=> $inf->currency,
                    'start_date' 	=> $inf->start_date,
                    'due_date'		=> $inf->due_date,
                    'fixed_rate'	=> $inf->fixed_rate,
                    'hourly_rate'	=> $inf->hourly_rate,
                    'fixed_price'	=> $inf->fixed_price,
                    'progress'		=> $inf->progress,
                    'notes'			=> $inf->notes,
                    'assign_to'		=> $inf->assign_to,
                    'status'		=> $inf->status,
                    'settings'		=> $inf->settings,
                    'estimate_hours'=> $inf->estimate_hours,
                    'language'      => $inf->language,
                    'archived'      => 0,
                    'date_created'	=> $inf->date_created
                );

                $new_project_id = Project::save($new_project);

                $team = unserialize($inf->assign_to);
                foreach ($team as $key => $user) {
                    $args = array(
                        'assigned_user' => $user,
                        'project_assigned' => $new_project_id
                    );
                    App::save_data('assign_projects',$args);
                }

                foreach (Project::has_milestones($project) as $key => $milestone) {
                    $params = array(
                        'milestone_name' 	=> $milestone->milestone_name,
                        'description' 		=> $milestone->description,
                        'project'			=> $new_project_id,
                        'start_date' 		=> $milestone->start_date,
                        'due_date'			=> $milestone->due_date
                    );
                    App::save_data('milestones',$params);
                }

                foreach (Project::has_tasks($project) as $key => $task) {
                    $args = array(
                        'task_name' 		=> $task->task_name,
                        'project' 			=> $new_project_id,
                        'milestone' 		=> $task->milestone,
                        'assigned_to' 		=> $task->assigned_to,
                        'description' 		=> $task->description,
                        'visible'  			=> $task->visible,
                        'task_progress' 	=> $task->task_progress,
                        'timer_status' 		=> $task->timer_status,
                        'timer_started_by' 	=> $task->timer_started_by,
                        'start_time' 		=> $task->start_time,
                        'estimated_hours' 	=> $task->estimated_hours,
                        'logged_time' 		=> $task->logged_time,
                        'due_date' 			=> $task->due_date,
                        'added_by' 			=> $task->added_by
                    );
                    $task_id = App::save_data('tasks',$args);

                    $team = unserialize($task->assigned_to);

                    foreach ($team as $key => $user) {
                        $args = array(
                            'assigned_user'     => $user,
                            'project_assigned'  => $new_project_id,
                            'task_assigned'     => $task_id
                            );
                        App::save_data('assign_tasks',$args);
                    }
                }
                foreach (Project::has_links($project) as $key => $link) {
                    $args = array(
                                'project_id'    => $new_project_id,
                                'client'        => $inf->client,
                                'icon'          => $link->icon,
                                'link_title'    => $link->link_title,
                                'link_url'      => $link->link_url,
                                'description'   => $link->description,
                                'username'      => $link->username,
                                'password'      => $link->password,
                                );
                    App::save_data('links',$args);
                }

                // Log activity
                $data = array(
                    'module' => 'projects',
                    'module_field_id' => $new_project_id,
                    'user' => User::get_id(),
                    'activity' => 'activity_copied_project',
                    'icon' => 'fa-copy',
                    'value1' => $inf->project_title,
                    'value2' => ''
                );
                App::Log($data);

                Applib::go_to('projects/view/'.$new_project_id.'?group=dashboard','success',lang('project_copied'));
            }
        }else{
            $data['project'] = $project;
            $data['action'] = 'clone_project';
            $this->load->view('modal/project_action',isset($data) ? $data : NULL);
        }
    }

    function settings(){

        if ($_POST) {
            $project_id = $this->input->post('project_id');

            $settings = json_encode($_POST);
            $data = array('settings' => $settings);

            Project::update($project_id,$data);

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect(base_url().'projects/view/'.$project_id.'?group=settings');
        }else{
            $this->index();
        }

    }

    function team($project = NULL)
    {
        if ($this->input->post()) {

            $project = $this->input->post('project', TRUE);

            $this->form_validation->set_rules('project', 'Project', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                Applib::go_to('projects/view/'.$project.'?group=teams','error',lang('error_in_form'));
            }else{
                $assigned = serialize($this->input->post('assigned_to'));

                Project::delete_team($project);

                $assign = $this->input->post('assigned_to');

                foreach ($assign as $key => $value) {
                    $data = array('assigned_user' => $value,'project_assigned'=>$project);
                    App::save_data('assign_projects',$data);
                }

                Project::update($project,array('assign_to' => $assigned));

                // Send email to assigned members
                if(config_item('notify_project_assignments') == 'TRUE') $this->assigned_notification($project);

                // Post to slack channel
                if(config_item('slack_notification') == 'TRUE'){
                    $project_title = Project::by_id($project)->project_title;
                    Applib::slack(
                        sprintf(lang('team_updated_msg'), $project_title),
                        sprintf(lang('team_updated'), $project_title),
                        base_url().'projects/view/'.$project,
                        sprintf(lang('team_updated_by'), User::displayName(User::get_id()))
                    );
                }

                // Log activity
                $data = array(
                    'module' => 'projects',
                    'module_field_id' => $project,
                    'user' => User::get_id(),
                    'activity' => 'activity_edited_team',
                    'icon' => 'fa-group',
                    'value1' => Project::by_id($project)->project_title,
                    'value2' => ''
                );
                App::Log($data);
                Applib::go_to('projects/view/'.$project.'/?group=teams','success',lang('project_team_updated'));

            }
        }else{
            $data['project'] = $project;
            $data['action'] = 'edit_team';
            $this->load->view('modal/project_action',isset($data) ? $data : NULL);
        }
    }

    function invoice($project = NULL)
    {
        if ($this->input->post()) {

            $this->load->model('Invoice');

            $project = $this->input->post('project', TRUE);

            $this->form_validation->set_rules('project', 'Project', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                Applib::go_to('projects/view/'.$project.'?group=dashboard','error',lang('invoice_not_created'));
            }else{

                $this->load->helper('string');
                $reference_no = config_item('invoice_prefix').random_string('nozero', 6);

                if(config_item('increment_invoice_number') == 'TRUE') $reference_no = config_item('invoice_prefix').Invoice::generate_invoice_number();

                $info = Project::by_id($project);
                $project_rate = ($info->fixed_rate == 'Yes') ? $info->fixed_price : $info->hourly_rate;
                $due_date = strftime(config_item('date_format'), strtotime("+".config_item('invoices_due_after')." days"));

                $data = array(
                    'reference_no' 	=> $reference_no,
                    'tax'			=> 0,
                    'client'		=> $info->client,
                    'currency' 		=> $info->currency,
                    'due_date'		=> $due_date,
                    'notes'			=> config_item('default_terms')
                );
                $invoice_id = Invoice::save($data);

                $activity = array(
                    'user'              => User::get_id(),
                    'module'            => 'invoices',
                    'module_field_id'   => $invoice_id,
                    'activity'          => 'activity_invoice_created',
                    'icon'              => 'fa-plus',
                    'value1'            => $reference_no
                );
                App::Log($activity); // Log activity

                $task_list = array();
                foreach (Project::has_tasks($project) as $task) {
                    $task_list[] = $task->task_name.' - '.$this->applib->get_time_spent(Project::task_timer($task->t_id));
                }

                $items = array(
                    'invoice_id' => $invoice_id,
                    'item_name'	 => $info->project_title,
                    'item_desc'	=> lang('time_spent').' : '.Project::total_hours($project).' '.lang('hours').PHP_EOL.implode(PHP_EOL, $task_list),
                    'unit_cost'	=> $project_rate,
                    'quantity'	=> Project::total_hours($project),
                    'total_cost' => Project::sub_total($project)
                );
                Invoice::save_items($items);

                if($this->input->post('unbill_invoiced_time', TRUE) == 'on'){
                        $this->db->where('project',$project)->update('project_timer',array('billable' => 0));
                        $this->db->where('pro_id',$project)->update('tasks_timer',array('billable' => 0));
                    }

                // Add selected expenses

                if(isset($_POST['expense'])){

                    foreach ($_POST['expense'] as $key => $ar) {
                        $e = Expense::view_by_id($key);
                        $cat = App::get_category_by_id($e->category);

                        $project_title = Project::by_id($e->project)->project_title;
                        $items = array(
                            'item_name' => lang('expenses').' [ '.$e->expense_date.' ]',
                            'item_desc'	=> '['.$project_title.']'.PHP_EOL.'&raquo; '.$cat.PHP_EOL.'&raquo; '.$e->notes,
                            'unit_cost'	=> $e->amount,
                            'invoice_id'	=> $invoice_id,
                            'total_cost'	=> $e->amount,
                            'quantity'		=> '1.00'

                        );
                        Invoice::save_items($items);
                        Expense::update($e->id,array('invoiced' => '1','invoiced_id' => $invoice_id));
                    }
                }



                // Post to slack channel
                if(config_item('slack_notification') == 'TRUE'){
                    Applib::slack(
                        sprintf(lang('project_invoiced_msg'), $info->project_title, $reference_no),
                        sprintf(lang('project_invoiced'), $info->project_title),
                        base_url().'projects/view/'.$project,
                        sprintf(lang('project_invoiced_by'), User::displayName(User::get_id()))
                    );
                }

                // Log activity
                $data = array(
                    'module' => 'projects',
                    'module_field_id' => $project,
                    'user' => User::get_id(),
                    'activity' => 'invoiced_project',
                    'icon' => 'fa-money',
                    'value1' => $info->project_title,
                    'value2' => ''
                );
                App::Log($data);
                Applib::go_to('invoices/view/'.$invoice_id,'success',lang('invoice_created_successfully'));
            }
        }else{
            $data['project'] = $project;
            $data['action'] = 'invoice_project';
            $this->load->view('modal/project_action',isset($data) ? $data : NULL);
        }
    }



    function comment()
    {
        if ($this->input->post()) {
            $id = $this->input->post('project');
            $comment = $this->input->post('comment');
            $data = array('project'=>$id,'posted_by'=>User::get_id(),'message'=>$comment);
            $comment_id = App::save_data('comments',$data);

            // Log activity
            $data = array(
                'module' => 'projects',
                'module_field_id' => $id,
                'user' => User::get_id(),
                'activity' => 'activity_project_comment_added',
                'icon' => 'fa-comment',
                'value1' => Project::by_id($id)->project_title,
                'value2' => ''
            );
            App::Log($data);

            if (config_item('notify_project_comments') == 'TRUE') {
                $this->_comment_notification($id,$comment);
                //send notification to the administrator
            }

            // Post to slack channel
            if(config_item('slack_notification') == 'TRUE'){
                $this->load->helper('slack');
                $slack = new Slack_Post;
                $params = array('project'   	=> $id,
                    'comment'       => $comment_id,
                    'user'      	=> User::get_id()
                );
                $slack->slack_project_comment($params);
            }

            Applib::go_to('projects/view/'.$id.'/?group=comments','success',lang('comment_successful'));

        }else{
            redirect('projects');
        }
    }



    function replies()
    {
        if ($this->input->post()) {
            $project_id = $this->input->post('project',TRUE);

            $this->load->library('form_validation');
            $this->form_validation->set_rules('message', 'Message', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('comment_failed'));
                redirect('projects/view/'.$project_id.'?group=comments');
            }else{
                $message = $this->input->post('message');
                $comment_id = $this->input->post('comment', TRUE);
                $data = array('parent_comment' => $comment_id,'reply_msg' => $message,'replied_by' => User::get_id());
                $reply_id = App::save_data('comment_replies',$data);

                if (config_item('notify_project_comments') == 'TRUE') {
                    //send notifications
                    $this->_comment_notification($project_id,$message);
                }
                // Post to slack channel
                if(config_item('slack_notification') == 'TRUE'){
                    $this->load->helper('slack');
                    $slack = new Slack_Post;
                    $params = array('project'   => $project_id,
                        'reply'     => $reply_id,
                        'user'     	=> User::get_id()
                    );
                    $slack->slack_project_comment_reply($params);
                }

                Applib::go_to('projects/view/'.$project_id.'/?group=comments','success',lang('comment_replied_successful'));

            }

        }else{
            $data['comment'] = $this->input->get('c', TRUE);
            $data['project'] = $this->input->get('p', TRUE);
            $data['action'] = 'comment_reply';
            $this->load->view('modal/project_action',isset($data) ? $data : NULL);
        }
    }

    function delete_comment($id = NULL){

        if($this->input->post()){
            $id = $this->input->post('id',TRUE);
            $info = Project::view_comment($id);

            if(User::get_id() == $info->posted_by || User::is_admin()){
                App::delete('comments',array('comment_id'=>$id));

                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('comment_deleted'));
            }
            redirect('projects/view/'.$info->project.'?group=comments');
        }else{
            $data['info'] = Project::view_comment($id);
            $data['action'] = 'delete_comment';
            $this->load->view('modal/project_action',isset($data) ? $data : NULL);
        }
    }

    function delete_reply($id = NULL){
        if($this->input->post()){
            $id = $this->input->post('reply_id');
            $replied_by = Project::view_reply($id)->replied_by;
            if(User::get_id() == $replied_by || User::is_admin()){
                App::delete('comment_replies',array('reply_id'=>$id));
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('comment_deleted'));
            }
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $data['info'] = Project::view_reply($id);
            $data['action'] = 'delete_reply';
            $this->load->view('modal/project_action',isset($data) ? $data : NULL);
        }
    }

    function download($project = NULL)
    {
        if (isset($_GET['id'])) {
            $file_id = $this->input->get('id', TRUE);
            $info = Project::view_file($file_id);
            $this->load->helper('download');

            if($info->file_name == ''){
                Applib::go_to($_SERVER["HTTP_REFERER"],'error',lang('operation_failed'));
            }
            if(file_exists('./resource/project-files/'.$info->path.$info->file_name)){
                $data = file_get_contents('./resource/project-files/'.$info->path.$info->file_name);
                // Read the file's contents
                force_download($info->file_name, $data);
            }else{
                Applib::go_to($_SERVER["HTTP_REFERER"],'error',lang('operation_failed'));
            }
        }

    }

    function tracking()
    {
        $action = ucfirst($this->uri->segment(3));
        $project = $this->uri->segment(4);
        $info = Project::by_id($project);
        $timer_msg = '';
        if ($action == 'Off') {
            if(!$this->_timer_started_by($project)){
                Applib::go_to($_SERVER["HTTP_REFERER"],'error',lang('timer_not_allowed'));
            }
            $project_logged_time =  Project::total_hours($project);
            $time_logged = (time() - $info->timer_start) + $project_logged_time;

            $data = array('timer'=>$action,'time_logged'=>$time_logged,'timer_start'=>'');
            Project::update($project,$data);
            $data = array('project'=>$project,'start_time'=>$info->timer_start,
                'user'=>User::get_id(),'end_time'=>time());

            App::save_data('project_timer',$data);
            $timer_msg = 'timer_stopped_success';

        }else{
            $data = array('timer'=>$action,'timer_started_by'=>User::get_id(),'timer_start'=>time());
            Project::update($project,$data);
            $timer_msg = 'timer_started_success';
        }
        Applib::go_to($_SERVER["HTTP_REFERER"],'success',lang($timer_msg));
    }

    function _timer_started_by($project){
        $started_by = Project::by_id($project)->timer_started_by;
        return ($started_by == User::get_id() || User::is_admin()) ? TRUE : FALSE;
    }

    function mark_as_complete($id = NULL){

        if ($this->input->post()) {
            if(!User::is_admin()) App::access_denied('projects');
            $id = $this->input->post('id');
            $data = array('progress' => 100,'auto_progress' => 'FALSE');
            Project::update($id,$data);

            $this->_project_complete($id);

            // Post to slack channel
            if(config_item('slack_notification') == 'TRUE'){
                $project_title = Project::by_id($id)->project_title;
                Applib::slack(
                    sprintf(lang('project_marked_complete'), $project_title),
                    sprintf(lang('project_closed'), $project_title),
                    base_url().'projects/view/'.$id,
                    sprintf(lang('project_closed_by'), User::displayName(User::get_id()))
                );
            }

            Applib::go_to($_SERVER['HTTP_REFERER'],'success',lang('project_edited_successfully'));

        }else{
            $data['id'] = $id;
            $data['action'] = 'mark_as_complete';
            $this->load->view('modal/project_action',$data);

        }

    }

    function _project_complete($project) {

        $message = App::email_template('project_complete','template_body');
        $signature = App::email_template('email_signature','template_body');

        $info = Project::by_id($project);

        $cur = Client::client_currency($info->client);
        Project::update($project,array('status' => 'Done'));

        $logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';

        $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

        $client = str_replace("{CLIENT_NAME}",Client::view_by_id($info->client)->company_name,$logo);
        $title = str_replace("{PROJECT_TITLE}",$info->project_title,$client);
        $code = str_replace("{PROJECT_CODE}",$info->project_code,$title);
        $link = str_replace("{PROJECT_URL}",base_url().'projects/view/'.$project,$code);
        $hours = str_replace("{PROJECT_HOURS}",Project::total_hours($project),$link);
        $cost = str_replace("{PROJECT_COST}",$cur->symbol.''.Project::sub_total($project),$hours);
        $signature = str_replace("{SIGNATURE}",$signature,$cost);
        $message = str_replace("{SITE_NAME}",config_item('company_name'),$signature);

        $data['message'] = $message;
        $message = $this->load->view('email_template', $data, TRUE);

        $params['recipient'] = Client::view_by_id($info->client)->company_email;
        $params['subject'] = App::email_template('project_complete','subject');
        $params['message'] = $message;


        $params['attached_file'] = '';

        modules::run('fomailer/send_email',$params);

    }

    function client_notification($project){

        $info = Project::by_id($project);
        $message = App::email_template('project_created','template_body');
        $subject =  App::email_template('project_created','subject');
        $signature = App::email_template('email_signature','template_body');



        $logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';

        $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

        $created_by = str_replace("{CREATED_BY}",User::displayName(User::get_id()),$logo);
        $title = str_replace("{PROJECT_TITLE}",$info->project_title,$created_by);
        $link =  str_replace("{PROJECT_URL}",base_url().'projects/view/'.$project,$title);
        $signature = str_replace("{SIGNATURE}",$signature,$link);
        $message = str_replace("{SITE_NAME}",config_item('company_name'),$signature);

        $data['message'] = $message;
        $message = $this->load->view('email_template', $data, TRUE);

        $params['recipient'] = Client::view_by_id($info->client)->company_email;

        $params['subject'] = '['.config_item('company_name').']'.' '.$subject;
        $params['message'] = $message;

        $params['attached_file'] = '';

        modules::run('fomailer/send_email',$params);
    }



    function _comment_notification($project,$comment){
        $comment = strip_tags($comment);

        $message = App::email_template('project_comment','template_body');
        $subject = App::email_template('project_comment','subject');
        $signature = App::email_template('email_signature','template_body');


        $info = Project::by_id($project);

        $logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';

        $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);
        $comment_msg = str_replace("{COMMENT_MESSAGE}",$comment,$logo);
        $posted_by = str_replace("{POSTED_BY}",User::displayName(User::get_id()),$comment_msg);
        $title = str_replace("{PROJECT_TITLE}",$info->project_title,$posted_by);
        $link =  str_replace("{COMMENT_URL}",base_url().'projects/view/'.$project.'?group=comments',$title);
        $signature = str_replace("{SIGNATURE}",$signature,$link);
        $message = str_replace("{SITE_NAME}",config_item('company_name'),$signature);

        $data['message'] = $message;
        $message = $this->load->view('email_template', $data, TRUE);

        // Send email to team

        if(User::is_client()){
            foreach (Project::project_team($project) as $key => $user) {
                $params['recipient'] = User::login_info($user->assigned_user)->email;
                $params['subject'] = '['.config_item('company_name').']'.' '.$subject;
                $params['message'] = $message;
                $params['attached_file'] = '';
                modules::run('fomailer/send_email',$params);

            }
        }else{
            // Send email to client
            $params['recipient'] = Client::view_by_id($info->client)->company_email;
            $params['subject'] = '['.config_item('company_name').']'.' '.$subject;
            $params['message'] = $message;
            $params['attached_file'] = '';
            modules::run('fomailer/send_email',$params);
        }
    }

    function assigned_notification($project){

        $message = App::email_template('project_assigned','template_body');
        $signature = App::email_template('email_signature','template_body');

        $logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';

        $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

        $assigned_by = str_replace("{ASSIGNED_BY}",User::displayName(User::get_id()),$logo);
        $title = str_replace("{PROJECT_TITLE}",Project::by_id($project)->project_title,$assigned_by);
        $link =  str_replace("{PROJECT_URL}",base_url().'projects/view/'.$project,$title);
        $signature = str_replace("{SIGNATURE}",$signature,$link);
        $message = str_replace("{SITE_NAME}",config_item('company_name'),$signature);

        $data['message'] = $message;
        $message = $this->load->view('email_template', $data, TRUE);

        foreach (Project::project_team($project) as $user) {

            $params['recipient'] = User::login_info($user->assigned_user)->email;

            $params['subject'] = App::email_template('project_assigned','subject');
            $params['message'] = $message;

            $params['attached_file'] = '';

            modules::run('fomailer/send_email',$params);
        }
    }

    function _notify_project_update($project){

        $message = App::email_template('project_updated','template_body');
        $signature = App::email_template('email_signature','template_body');

        $project_title = Project::by_id($project)->project_title;

        $logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';

        $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

        $assigned_by = str_replace("{ASSIGNED_BY}",User::displayName(User::get_id()),$logo);
        $title = str_replace("{PROJECT_TITLE}",$project_title,$assigned_by);
        $link =  str_replace("{PROJECT_URL}",base_url().'projects/view/'.$project,$title);
        $signature = str_replace("{SIGNATURE}",$signature,$link);
        $message = str_replace("{SITE_NAME}",config_item('company_name'),$signature);

        $data['message'] = $message;
        $message = $this->load->view('email_template', $data, TRUE);

        foreach (Project::project_team($project) as $user) {
            $params['recipient'] = User::login_info($user->assigned_user)->email;

            $params['subject'] = '['.config_item('company_name').']'.' '.lang('project_updated_subject');
            $params['message'] = $message;

            $params['attached_file'] = '';

            modules::run('fomailer/send_email',$params);
        }
    }



    function auto_progress($project = NULL){
        if ($project) {
            $current_status = Project::by_id($project)->auto_progress;
            $set_to = ($current_status == 'TRUE') ? 'FALSE' : 'TRUE';
            $data = array('auto_progress'=>$set_to);
            Project::update($project,$data);

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('progress_auto_calculated'));
            redirect($_SERVER['HTTP_REFERER']);
        }

    }






    function _project_list($archive = NULL){

        if (User::is_admin() || User::perm_allowed(User::get_id(),'view_all_projects'))
            return $this->_admin_projects($archive,$this->filter_by);
        elseif (User::login_role_name() == 'staff') {
            return $this->_staff_projects($archive,$this->filter_by);
        }else{
            return $this->_client_projects($archive,$this->filter_by);

        }
    }


    function _admin_projects($archive = FALSE,$filter_by = NULL){

        if ($archive) return Project::by_where(array('archived'=>'1'));

        if($filter_by != NULL){
            return Project::by_where(array('archived !='=>'1','status' => $filter_by));
        }else{
            return Project::by_where(array('archived !='=>'1'));
        }
    }


    function _staff_projects($archive = FALSE, $filter_by = NULL){

        if ($archive) {
            return Project::by_where(array('archived'=>'1','assigned_user'=>User::get_id()),'assign_projects');
        }

        if($filter_by != NULL){

            return Project::by_where(array('assigned_user'=>User::get_id(),'archived !='=>'1','status'=>$filter_by),'assign_projects');

        }else{

            return Project::by_where(array('assigned_user'=>User::get_id(),'archived !='=>'1'),'assign_projects');
        }
    }



    function _client_projects($archive = FALSE, $filter_by = NULL){
        $client = User::profile_info(User::get_id())->company;
        if ($archive) {
            return Project::by_where(array('archived'=>'1','client'=>$client));

        }
        if($filter_by != NULL){
            return Project::by_where(array('client'=>$client, 'archived !=' => '1', 'status' => $filter_by));
        }else{
            return Project::by_where(array('client'=>$client,'archived !=' => '1'));
        }
    }

    // Check filter by

    function _filter_by(){

        $filter = isset($_GET['view']) ? $_GET['view'] : '';

        switch ($filter) {

            case 'active':
                return 'Active';
                break;

            case 'on_hold':
                return 'On Hold';
                break;

            case 'done':
                return 'Done';

                break;

            default:
                return NULL;
                break;
        }
    }




    // Check project owner
    function _check_owner($project){

        if(User::is_admin()) return TRUE;
        if(User::profile_info(User::get_id())->company == Project::by_id($project)->client){ return TRUE; }
        if(User::perm_allowed(User::get_id(),'view_all_projects')) { return TRUE; }
        if(Project::is_assigned(User::get_id(),$project)){ return TRUE;
        } else{
            App::access_denied('projects');
        }
    }

}

/* End of file projects.php */
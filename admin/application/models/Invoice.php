<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


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

class Invoice extends CI_Model
{

    private static $db;

    function __construct(){
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    static function view_by_id($invoice)
    {
        return self::$db->where('inv_id',$invoice)->get('invoices')->row();
    }

    static function get_invoices($limit = NULL)
    {
        return self::$db->where(array('inv_id >'=>0,'inv_deleted'=>'No'))->get('invoices',$limit)->result();
    }

    static function saved_items()
    {
        return self::$db->get('items_saved')->result();
    }

    // Update Invoice
    static function update($invoice,$data){
        return self::$db->where('inv_id',$invoice)->update('invoices',$data);
    }

    // Save Invoice 
    static function save($data){
        self::$db->insert('invoices',$data);
        return self::$db->insert_id();
    }


    static function save_items($data){
        return self::$db->insert('items',$data);
    }

    // Save tax rates
    static function save_tax($data){
        return self::$db->insert('tax_rates',$data);
    }

    // Get tax rate using ID
    static function tax_by_id($id)
    {
        return self::$db->where('tax_rate_id',$id)->get('tax_rates')->row();
    }
    // Update tax rate
    static function update_tax($id,$data){
        return self::$db->where('tax_rate_id',$id)->update('tax_rates',$data);
    }

    // Delete tax rate from DB
    static function delete_tax($id){
        return self::$db->where('tax_rate_id',$id)->delete('tax_rates');
    }

    static function view_item($id)
    {
        return self::$db->where('item_id',$id)->get('items')->row();
    }

    static function get_invoice_due_amount($invoice){

        $tax =self::get_invoice_tax($invoice);
        $discount = self::get_invoice_discount($invoice);
        $invoice_cost =self::get_invoice_subtotal($invoice);
        $payment_made = self::get_invoice_paid($invoice);
        $fee = self::get_invoice_fee($invoice);
        $due_amount =  (($invoice_cost - $discount) + $tax + $fee) - $payment_made;
        if($due_amount <= 0){ $due_amount = 0; }
        return round($due_amount,2);
    }

    // Calculate Invoice Tax
    static function get_invoice_tax($invoice){
        $tax = self::view_by_id($invoice)->tax;
        return ($tax/100) * self::get_invoice_subtotal($invoice);
    }

    static function get_invoice_discount($invoice){
        return (self::view_by_id($invoice)->discount / 100) * self::get_invoice_subtotal($invoice);
    }

    static function get_invoice_fee($invoice){
        return (self::view_by_id($invoice)->extra_fee / 100) * self::get_invoice_subtotal($invoice);
    }

    static function get_invoice_subtotal($invoice){
        return self::$db->select_sum('total_cost')->where('invoice_id',$invoice)->get('items')->row()->total_cost;
    }

    static function get_invoice_paid($invoice){
        return self::$db->select_sum('amount')->where(array('invoice'=>$invoice,'refunded' => 'No'))->get('payments')->row()->amount;
    }

    static function all_invoice_amount(){

        $invoices = self::get_invoices();
        $cost[] = array();
        foreach ($invoices as $key => $invoice) {
            $tax = self::get_invoice_tax($invoice->inv_id);
            $discount = self::get_invoice_discount($invoice->inv_id);
            $invoice_cost = self::get_invoice_subtotal($invoice->inv_id);
            $fee = self::get_invoice_fee($invoice->inv_id);

            $tempcost = ($invoice_cost + $tax + $fee) - $discount;
            if ($invoice->currency != config_item('default_currency')) {
                $tempcost = Applib::convert_currency($invoice->currency, $tempcost);
            }
            $cost[] = $tempcost;
        }
        if(is_array($cost)){
            return round(array_sum($cost),config_item('currency_decimals'));
        }else{
            return 0;
        }

    }

    // Get tax rates
    static function get_tax_rates(){
        return self::$db->get('tax_rates')->result();
    }

    // Get payment methods
    static function payment_methods(){
        return self::$db->get('payment_methods')->result();
    }

    // List items ordered
    static function has_items($id,$type='invoice') {
        $table = ($type == 'invoice' ? '' : 'estimate_').'items';
        return self::$db->where($type.'_id',$id)->order_by('item_order','asc')->get($table)->result();
    }

    // Get Invoice Status
    static function payment_status($invoice = NULL) {
        $invoice_status = self::view_by_id($invoice)->status;
        $tax = self::get_invoice_tax($invoice);
        $discount = self::get_invoice_discount($invoice);
        $invoice_cost = self::get_invoice_subtotal($invoice);
        $payment_made = round(self::get_invoice_paid($invoice),2);
        $due = round(((($invoice_cost - $discount) + $tax) - $payment_made));

        if($payment_made < 1){
            return 'not_paid'; // Not paid
        }elseif ($due <= 0) {
            return 'fully_paid'; // Fully paid
        }else{
            return 'partially_paid'; // Partially Paid
        }
    }

    // Get Invoice Activities
    static function activities($invoice = NULL){
        return self::$db->where(array('module_field_id'=>$invoice,'module'=>'invoices'))
            ->order_by('activity_date','desc')->get('activities')->result();
    }

    // Get Invoices by CLIENT ID
    static function get_client_invoices($company)
    {
        return self::$db->where(array('client'=>$company,'show_client'=>'Yes'))->get('invoices')->result();
    }
    // Get list of paid invoices
    static function paid_invoices($company = NULL){
        if($company != NULL) self::$db->where(array('client'=>$company,'show_client'=>'Yes'));

        return self::$db->where(array('status'=>'Paid','inv_id >' => 0))->get('invoices')->result();
    }
    // Get list of unpaid invoices
    static function unpaid_invoices($company = NULL){
        $invoices = ($company != NULL) ? self::get_client_invoices($company) : self::get_invoices();
        foreach ($invoices as $key => &$inv) {
            if(self::payment_status($inv->inv_id) != 'not_paid'){
                unset($invoices[$key]);
            }
        }
        return $invoices;
    }

    // Generate new Invoice Number

    static function generate_invoice_number() {
        $query = self::$db->select('reference_no')->select_max('inv_id')->get('invoices');
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $ref_number = intval(substr($row->reference_no, -4));
            $next_number = $ref_number + 1;
            if ($next_number < config_item('invoice_start_no')) { $next_number = config_item('invoice_start_no'); }
            $next_number = self::ref_exists($next_number);
            return sprintf('%04d', $next_number);
        }else{
            return sprintf('%04d', config_item('invoice_start_no'));
        }
    }

    // Verify if REF Exists

    static function ref_exists($next_number){
        $next_number = sprintf('%04d', $next_number);

        $records = self::$db->where('reference_no',config_item('invoice_prefix').$next_number)
            ->get('invoices')->num_rows();
        if ($records > 0) {
            return self::ref_exists($next_number + 1);
        }else{
            return $next_number;
        }
    }


    // Get a list of partially paid invoices
    static function partially_paid_invoices($company = NULL){
        $invoices = ($company != NULL) ? self::get_client_invoices($company) : self::get_invoices();
        foreach ($invoices as $key => &$inv) {
            if(self::payment_status($inv->inv_id) != 'partially_paid'){
                unset($invoices[$key]);
            }
        }
        return $invoices;
    }


    // Get a list of recurring invoices
    static function recurring_invoices($company = NULL){
        if($company != NULL) self::$db->where(array('client'=>$company,'show_client'=>'Yes'));
        return self::$db->where(array('recurring'=>'Yes','inv_id >' => 0))->get('invoices')->result();
    }


    // Delete Invoice
    static function delete($invoice){
        //delete invoice items
        self::$db->where(array('invoice_id'=>$invoice))->delete('items');
        //delete invoice payments
        self::$db->where(array('invoice'=>$invoice))->delete('payments');
        //clear invoice activities
        self::$db->where(array('module'=>'invoices', 'module_field_id' => $invoice))->delete('activities');
        //delete invoice
        self::$db->where(array('inv_id'=>$invoice))->delete('invoices');
    }


    static function recur($invoice,$data){

        $recur_days = App::num_days($data['r_freq']);
        $due_date = self::view_by_id($invoice)->due_date;
        $next_date = date("Y-m-d",strtotime($due_date."+ ".$recur_days." days"));
        if ($data['recur_end_date'] == '') {
            $recur_end_date = '0000-00-00';
        }else{
            $recur_end_date = date_format(date_create_from_format(config_item('date_php_format'), $data['recur_end_date']), 'Y-m-d');
        }
        $data = array(
            'recurring' => 'Yes',
            'r_freq' => $recur_days,
            'recur_frequency' => $data['r_freq'],
            'recur_start_date'=>date_format(date_create_from_format(config_item('date_php_format'), $data['recur_start_date']), 'Y-m-d'),
            'recur_end_date'=>$recur_end_date,
            'recur_next_date' => $next_date
        );
        self::update($invoice, $data);
        // Log recur activity
        $activity = array(
            'user'				=> User::get_id(),
            'module' 			=> 'invoices',
            'module_field_id'	=> $invoice,
            'activity'			=> 'activity_invoice_made_recur',
            'icon'				=> 'fa-tweet',
            'value1'        	=> self::view_by_id($invoice)->reference_no,
            'value2'			=> $next_date
        );
        App::Log($activity);
        return TRUE;
    }


}

/* End of file model.php */
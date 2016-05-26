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
 * @link     	https://gitbench.com
 */

class Estimate extends CI_Model
{

	private static $db;

	function __construct(){
		parent::__construct();
		self::$db = &get_instance()->db;
	}

	static function estimate_by_client($company)
	{
		return self::$db->where('client',$company)->get('estimates')->result();
	}
	static function view_estimate($id)
	{
		return self::$db->where('est_id',$id)->get('estimates')->row();
	}
	static function view_item($id)
	{
		return self::$db->where('item_id',$id)->get('estimate_items')->row();
	}

	static function by_where($table,$array = NULL){
    	return self::$db->where($array)->get($table)->result();
	}

	static function rates()
	{
		return self::$db->get('tax_rates')->result();
	}
	

	static function sub_total($estimate){
		$row = self::$db->select_sum('total_cost')->where('estimate_id',$estimate)->get('estimate_items')->row();
		return $row->total_cost;
	}

	static function total_tax($estimate){
		$tax = self::view_estimate($estimate)->tax;
		return ($tax / 100) * self::sub_total($estimate);
	}

	static function total_discount($estimate){
		$discount = self::view_estimate($estimate)->discount;
		return ($discount / 100) * self::sub_total($estimate);
	}

	static function due($estimate){
		$discount = self::total_discount($estimate);
		return round((self::sub_total($estimate) - $discount) + self::total_tax($estimate),2);
	}

	// List items ordered
	static function has_items($id){
		return self::$db->where('estimate_id',$id)->order_by('item_order','asc')->get('estimate_items')->result();
	}

		// Generate new Invoice Number

	static function generate_estimate_number() {
		$query = self::$db->select('reference_no')->select_max('est_id')->get('estimates');
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$ref_number = intval(substr($row->reference_no, -4));
			$next_number = $ref_number + 1;
			if ($next_number < config_item('estimate_start_no')) { $next_number = config_item('estimate_start_no'); }
			$next_number = self::ref_exists($next_number);
			return sprintf('%04d', $next_number);
		}else{
			return sprintf('%04d', config_item('estimate_start_no'));
		}
	}

	// Verify if REF Exists

	static function ref_exists($next_number){
		$next_number = sprintf('%04d', $next_number);

		$records = self::$db->where('reference_no',config_item('estimate_prefix').$next_number)
							->get('estimates')->num_rows();
		if ($records > 0) {
			return self::ref_exists($next_number + 1);
		}else{
			return $next_number;
		}
	}

	

}

/* End of file model.php */
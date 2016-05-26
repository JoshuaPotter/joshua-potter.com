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

class Expense extends CI_Model
{

	private static $db;

	function __construct(){
		parent::__construct();
		self::$db = &get_instance()->db;
	}

	// Calculate client expenses
 	static function total_by_client($client = NULL)
		{
			return self::$db->select_sum('amount')
							->where(array('billable' => '1','invoiced' => '0','client' => $client))
							->get('expenses')
							->row()->amount;
		}

	// Get client expenses
	static function billable_by_client($company)
	{
		self::$db->where(array('invoiced' => '0','billable' => '1','client' => $company,'show_client' => 'Yes'));
		return self::$db->get('expenses')->result();
	}

	// Get expense information
	static function view_by_id($id){
		return self::$db->where('id',$id)->get('expenses')->row();
	}
	// Update Expense
	static function update($id,$data){
		return self::$db->where('id',$id)->update('expenses',$data);
	}
	// Get all client expenses
	static function expenses_by_client($company){
		return self::$db->where('client',$company)->get('expenses')->result();
	}

}

/* End of file model.php */
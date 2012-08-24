<?php
namespace li3b_blog\models;

use lithium\util\Validator;

class Label extends \lithium\data\Model {

	protected $_meta = array(
		'locked' => true,
		'connection' => 'li3b_mongodb',
		'source' => 'li3b_blog.labels'
	);
	
	protected $_schema = array(
		'_id' => array('type' => 'id'),
		'name' => array('type' => 'string'),
		'color' => array('type' => 'string'),
		'bgColor' => array('type' => 'string')
	);
	
	public $validates = array(
		'name' => array(
			array('validLabel', 'message' => 'Name cannot contain any numbers or special characters other than dashes and underscores.'),
			array('notEmpty', 'message' => 'Name cannot be empty.')
		)
	);
	
	public static function __init() {
		$class = __CLASS__;
		
		Validator::add('validLabel', '/^[A-z _-]*$/i');
		
		// Future compatibility.
		if(method_exists('\lithium\data\Model', '__init')) {
			parent::__init();
		}
	}
	
}
?>
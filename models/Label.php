<?php
namespace li3b_blog\models;

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
			array('notEmpty', 'message' => 'Name cannot be empty.')
		)
	);
	
}
?>
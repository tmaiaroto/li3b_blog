<?php
namespace li3b_blog\controllers;

use li3b_blog\models\Label;

class LabelsController extends \lithium\action\Controller {

	public function admin_index() {
		$response = array('success' => false, 'labels' => array());
		if(!$this->request->is('json')) {
			return $response;
		}
		
		$documents = Label::all(array('order' => array('name')));
		if($documents) {
			$response['labels'] = $documents;
			$response['success'] = true;
		}
		
		return $response;
	}
	
	public function admin_create() {
		$response = array('success' => false);
		if(!$this->request->is('json')) {
			///return $response;
		}
		
		$document = Label::create();
		
		// If data was passed, set some more data and save
		if ($this->request->data) {
			// Simple validation here, without returning any error messages.
			if(strlen($this->request->data['name']) > 40) {
				return $response;
			}
			$existingLabel = Label::find('first', array('conditions' => array('name' => $this->request->data['name'])));
			if($existingLabel) {
				$document = $existingLabel;
			}
			
			// Save
			if($document->save($this->request->data)) {
				$response['success'] = true;
				return $response;
			}
		}
		return $response;
	}
	
	public function admin_delete($name=null) {
		$response = array('success' => false);
		if(!$this->request->is('json')) {
			return $response;
		}
		
		// If data was passed, set some more data and save
		if ($name) {
			$label = Label::find('first', array('conditions' => array('name' => urldecode($name))));
			if($label && $label->delete()) {
				$label['_id'] = (string)$label->_id;
				$response['success'] = true;
			}
		}
		return $response;
	}
	
}
?>
<?php
App::uses('AppController', 'Controller');

class ContactsController extends AppController {
	public $helpers = array('Html', 'Form');

	public function index() {
		$this->loadModel('Country');
		$countries = $this->Country->find('all');
		$country_arr = array(0 => 'Please Select a Country');
		foreach($countries as $country)
		{
			$country_arr[$country['Country']['id']] = $country['Country']['country'];
		}
		$this->set('countries', $country_arr);
		$this->set('contacts', $this->Contact->find('all', array('order' => 'Contact.created DESC')));
	}
	public function add() {
		$validation = array(
			'success' => false,
			'message' => 'invalid request'
		);
		
	  if ($this->request->is('post')) {
		error_log(print_r($this->request->data['Contact']['id'], true));
		  $this->Contact->create(null, $this->request->data['Contact']['id']);
			if ($this->Contact->saveAll($this->request->data, array('deep' => true))) {
				$validation['message'] = 'Your Contact has been saved.';
				$validation['success'] = true;
				// again, I would usually set up an array to return, and manually set each value, but using read() makes sense given the time to do this
				$contact = $this->Contact->read();
				$validation['contact'] = $contact;
		  } else {
				$validation['message'] = $this->Contact->invalidFields();
		  }
	  }
		return new CakeResponse(array('body' => json_encode($validation),'type' => 'json'));
  }
}
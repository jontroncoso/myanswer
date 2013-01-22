<?php
class Contact extends AppModel {
	var $validate = array(
		'first'		=> array(
			'rule'	  => array('minLength', 3),
			'message' => 'A valid First Name is Required',
			'required'	=> true,
		),
		'last'		=> array(
			'rule'	  => array('minLength', 3),
			'message' 	=> 'A valid Last Name is Required',
			'required'	=> true,
		),
		'street'		=> array(
			// 'rule'	  	=> 'alphaNumeric',
			// 'message' 	=> 'Please Enter a valid Street Address',
		),
		'street2'		=> array(
			// 'rule'	  	=> 'alphaNumeric',
			// 'message' 	=> 'Please Enter a valid Street Address',
		),
		'country_id'=> array(
			'rule'	  	=> array('numeric'),
			'message' 	=> 'Please Enter a valid Country',
		),
		'state_id'	=> array(
			'rule'	  	=> array('numeric'),
			'message' 	=> 'Please Enter a valid State',
		),
		'city_id'		=> array(
			'rule'	  	=> array('numeric'),
			'message' 	=> 'Please Enter a valid City',
		),
		'zip'				=> array(
			'rule'	  	=> array('numeric'),
			'message' 	=> 'Please Enter a valid Zip Code',
		),
		'phone' 		=> array(
			'rule'			=> 'phone',
			'message'		=> 'A valid Phone Number is Required',
			'required'	=> true
		),
		'email'			=> array(
			'rule'			=> 'email', 
			'message'		=> 'A valid Email is Required',
			'required'	=> true
		)
	);
	
	public $belongsTo = array (
		'City' =>array(
			'className'=>'City',
			'foreignKey'=>'city_id'
		),
		'State' =>array(
			'className'=>'State',
			'foreignKey'=>'state_id'
		),
		'Country' =>array(
			'className'=>'Country',
			'foreignKey'=>'country_id'
		),
	);
	
	public function save($data = null, $validate = true, $fieldList = array()) {
      // Clear modified field value before each save
      $this->set($data);
			$this->data['Contact']['created'] = time();
      return parent::save($this->data, $validate, $fieldList);
  }
}
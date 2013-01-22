<?php
class State extends AppModel {

	// public $hasMany = array(
	// 	'City'=>array(
	// 		'className'		=>'City',
	// 		'foreign Key'	=>'state_id')
	// );
	public $belongsTo = array (
		'Country' =>array(
			'className'		=>'Country',
			'foreignKey'	=>'country_id')
	);
}
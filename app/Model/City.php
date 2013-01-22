<?php
class City extends AppModel {

	// public $hasMany = array(
	// 	'Contact'=>array(
	// 		'className'		=>'Contact',
	// 		'foreign Key'	=>'city_id')
	// );
	// 
	public $belongsTo = array (
		'State' =>array(
			'className'		=>'State',
			'foreignKey'	=>'state_id')
	);
}
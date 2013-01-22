<?php
class StateController extends AppController {


	public function index() {
		$array = func_get_args();
		$states = $this->State->find('all', array('conditions' => array('State.country_id' => $array[0])));
		// typically, I'd use a new array so that, 
		// 	a) the JSON response doesn't mirror the database and
		// 	b) I only use the fields necessary
		// But, this is just a test example, and that would take some unnecessary time.
		return new CakeResponse(array('body' => json_encode($states),'type' => 'json'));

	}

}
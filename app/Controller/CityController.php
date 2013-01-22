<?php
class CityController extends AppController {


	public function index() {
		$array = func_get_args();
		$cities = $this->City->find('all', array('conditions' => array('City.state_id' => $array[0])));
		return new CakeResponse(array('body' => json_encode($cities),'type' => 'json'));

	}

}
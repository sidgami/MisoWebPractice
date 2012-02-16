<?php
class CountriesController {
	public $models = array('Country');
	
	public function index() {
		//checking for the POST Values
		if (isset($_POST['add'])) {
			$country = new Country();
			$country->set_values($_POST);
			
			if (!$country->save()) {
				User::error('Cannot save the country instance');
			}
			
			Paraglide::redirect('countries');
		}
		
		if (isset($_POST['up'])) {
			$country = Country::find($_POST['up']);
			
			if (empty($country)) {
				Paraglide::redirect('countries');
			}
			
			$country->moveUp();
			Paraglide::redirect('countries');
		}
		
		if (isset($_POST['down'])) {
			$country = Country::find($_POST['down']);
			
			if (empty($country)) {
				Paraglide::redirect('countries');
			}
			
			$country->moveDown();
			Paraglide::redirect('countries');
		}
		
		$countries = Country::find(array(
			'order' => 'order', 'id',
		));
		Paraglide::render_view('countries/index', array(
			'countries' => $countries,
		));
	}

	public function edit($id = null) {
		$country = Country::find($id);
		
		if (empty($country)) {
			Paraglide::redirect('countries');
		}
		
		if (!empty($_POST)) {
			//checking for the POST value
			if (!empty($_POST['delete'])) {
				$country->delete();
				Paraglide::redirect('countries');
			}
			
			$country->set_values($_POST);
			
			if (!$country->save()) {
				User::error('Cannot save the country instance');
			}
			
			Paraglide::redirect('countries');
		}
		
		Paraglide::render_view('countries/edit',array(
			'country' => $country
		));
	}
}

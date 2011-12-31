<?php
class CountriesController {
	public $models = array('Country');
	
	public function index() {
		if(isset($_POST['add'])) {
			$country = new Country();
			$country->set_values($_POST);
			$country->save();
		}else if(isset($_POST['up'])) {
			$country = Country::find($_POST['up']);
			$country->up();
		}else if(isset($_POST['down'])) {
			$country = Country::find($_POST['down']);
			$country->down();
		}
		
		$countries = Country::find(array('order' => 'order'));
		Paraglide::render_view('countries/index', array(
			'countries' => $countries,
		));
	}

	public function edit($id = null) {
		$country = Country::find($id);
		
		if (empty($country)) {
			Paraglide::redirect('countries');
		}
		if(!empty($_POST)) {
			if (!empty($_POST['delete'])) {
				$country->delete();
				Paraglide::redirect('countries');
				return;
			}
			$country->set_values($_POST);
			$country->save();
			Paraglide::redirect('countries');
		}
		
		Paraglide::render_view('countries/edit',array(
			'country' => $country
		));
	}
}

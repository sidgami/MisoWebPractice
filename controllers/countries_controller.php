<?php
class CountriesController {
	public $models = array('Country');
	
	public function index() {
		// $_POST is a global array containing the variables from a form submitted
		// if you have a field celled "foo" and you type in "bar" as the value and submit,
		// then $_POST['foo'] will be equal to "bar"
		if(isset($_POST['add'])){
			Country::addNewRecord();
		}
		if(isset($_POST['delete'])){
			Country::deleteRecord();
		}else if(isset($_POST['up'])){
			Country::moveUp();	
		}else if(isset($_POST['down'])){
			Country::moveDown();
		}
		
		$countries = Country::find(array("order"=>"order"));
		Paraglide::render_view('countries/index', array(
			'countries' => $countries,
		));
	}

	public function editRecord($id=null) {
		if(!empty($_POST)){
			$country = Country::find($_POST['id']);
			
			if(!empty($country)){
				$country->set_values($_POST);
				if($country->save()){
					Paraglide::redirect('countries');
				}
			}
		}
		
		$country = Country::find($id);
		
		if(!empty($country)){
			Paraglide::render_view('countries/edit',array(
							'country' => $country
							));
			return;
		}
	}

}

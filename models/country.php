<?php
class Country extends Paragon{
	protected static $_table = 'country';
	
	public $id;
	public $order;
	public $name;
	public $population;
	public $capital;
	
	public function addNewRecord() {
		$country = new Country();
		$country->name = $_POST['add-country'];
		$country->capital = $_POST['add-capital'];
		$country->population = $_POST['add-population'];
		$country->order = $_POST['add-order'];
			
		if($country->save()){
			Paraglide::redirect('countries');
		}
	}
	
	public function deleteRecord() {
		$country = Country::find($_POST['delete']);
			
		if(!empty($country)){
			$country->delete();
		}
	}
	
	public function moveUp() {
		$country = Country::find($_POST['up']);
		$currentOrder = $country->order;
		$loopCount = 0;
		$flag = 0;
		$flag1 = 0; 
		$countries = Country::find(array(
			'conditions' => array(
				'order' => $currentOrder
			),
			'order' => 'order'
			));
			
		if(count($countries) == 1){
			$currentOrder = $currentOrder - 1;
		}else if(count($countries) > 1){
			if($countries[0]->id == $country->id){
				$currentOrder = $currentOrder - 1;
			}else{
				for($i=1;$i<count($countries);$i++){
					$flag1 = 1;
						
					if($countries[$i]->id == $country->id){
						$countryAbove = new Country();
						$countryAbove->name = $countries[$i]->name;
						$countryAbove->capital = $countries[$i]->capital;
						$countryAbove->population = $countries[$i]->population;
							
						$country->name = $countries[$i-1]->name;
						$country->capital = $countries[$i-1]->capital;
						$country->population = $countries[$i-1]->population;
							
						$countries[$i-1]->name = $countryAbove->name;
						$countries[$i-1]->capital = $countryAbove->capital;
						$countries[$i-1]->population = $countryAbove->population;
							
						$countries[$i-1]->save();
						$country->save();
					}
				}
			}
		}
						
		if($currentOrder == 0){
			$flag = 1;
		}
		
		if($flag != 1 && $flag1!= 1){
			do{
				$countries = Country::find(array(
					'conditions' => array(
						'order' => $currentOrder
					),
					'order' => 'order'
					));
				$loopCount++;
				$currentOrder = $currentOrder - 1;
			}while(count($countries) == 0);
			
			if(count($countries) > 1 ){
				$countryAbove = $countries[count($countries) - 1];
				$countryAbove->order = $countryAbove->order + $loopCount;
				if($currentOrder + 1 > 0){
					$country->order = $currentOrder + 1;
				}
			}else{
				$countryAbove = $countries[0];
				if($currentOrder + 1 > 0){
					$country->order = $currentOrder + 1;
				}
				$countryAbove->order = $countryAbove->order + $loopCount; 
			}
			
			$country->save();
			$countryAbove->save();
		}

	}
	
	public function moveDown() {
		$country = Country::find($_POST['down']);
		$currentOrder = $country->order;
		$loopCount = 0;
		$flag = 0;

		$countries = Country::find(array(
			'conditions' => array(
				'order' => $currentOrder
				),
			'order' => 'order'
			));
			
		if(count($countries) == 1){
			$currentOrder = $currentOrder + 1;
		}else if(count($countries) > 1){
			if($countries[count($countries) - 1]->id == $country->id){
				$currentOrder = $currentOrder + 1;
			}else{
				for($i=0;$i<count($countries)-1;$i++){
					$flag = 1;
					if($countries[$i]->id == $country->id){
						$countryBelow = new Country();
							
						$countryBelow->name = $countries[$i]->name;
						$countryBelow->capital = $countries[$i]->capital;
						$countryBelow->population = $countries[$i]->population;
							
						$country->name = $countries[$i+1]->name;
						$country->capital = $countries[$i+1]->capital;
						$country->population = $countries[$i+1]->population;
							
						$countries[$i+1]->name = $countryBelow->name;
						$countries[$i+1]->capital = $countryBelow->capital;
						$countries[$i+1]->population = $countryBelow->population;
							
						$countries[$i+1]->save();
						$country->save();
					}
				}
			}
		}
			
		if($flag == 0){
			do{
				$countries = Country::find(array(
					'conditions' => array(
						'order' => $currentOrder
						),
					'order' => 'order'
					));
				
				$loopCount++;
				$currentOrder = $currentOrder + 1;
			}while(count($countries) == 0);
				
			if(count($countries) > 1 ){
				$countryBelow = $countries[0];
				
				if($countryBelow->order - $loopCount > 0){
					$countryBelow->order = $countryBelow->order - $loopCount;
				}
				
			$country->order = $currentOrder - 1;
			}else{
				$countryBelow = $countries[0];
				$country->order = $currentOrder - 1;
				
				if($countryBelow->order - $loopCount > 0){
					$countryBelow->order = $countryBelow->order - $loopCount; 
				}
			}
			
		$country->save();
		$countryBelow->save();
		}
	}
}
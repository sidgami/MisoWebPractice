<?php
class Country extends Paragon{
	protected static $_table = 'countries';
	
	public static $validations = array(
		'order' => array('required' => true),
		'name' => array('required' => true),
		'population' => array(),
		'capital' => array(),	
	);
	
	public $id;
	public $order;
	public $name;
	public $population;
	public $capital;
	
	public function moveUp() {
		$countryAbove = Country::find_one(array(
			'conditions' => array(
				'order' => self::condition('lt', $this->order),
			),
			'order' => '-order, -id',
		));
		
		if (empty($countryAbove)) {
			return false;
		}else{
			$tempOrder = $countryAbove->order;
			$countryAbove->order = $this->order;
			$this->order = $tempOrder;
			
			if(!$this->save()){
				return false;
			}
			
			if(!$countryAbove->save()){
				return false;
			}

			return true;
		}
	}
	
	public function moveDown() {
		$countryBelow = Country::find_one(array(
			'conditions' => array(
				'order' => self::condition('gt', $this->order),
			),
			'order' => 'order', 'id',
		));
			
		if (empty($countryBelow)) {
			return false;
		}else{
			$tempOrder = $countryBelow->order;
			$countryBelow->order = $this->order;
			$this->order = $tempOrder;
			
			if (!$this->save()){
				return false;
			}
			
			if (!$countryBelow->save()){
				return false;
			}
			
			return true;
		}
	}
}
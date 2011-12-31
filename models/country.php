<?php
class Country extends Paragon{
	protected static $_table = 'country';
	
	public $id;
	public $order;
	public $name;
	public $population;
	public $capital;
	
	public function up() {
		$countryAbove = Country::find_one(array(
			'conditions' => array(
				'order' => self::condition('lt', $this->order),
			),
			'order' => '-order'
		));
		
		if(!empty($countryAbove)) {
			$tempOrder = $countryAbove->order;
			$countryAbove->order = $this->order;
			$this->order = $tempOrder;
			$this->save();
			$countryAbove->save();
		}else {
			Paraglide::redirect('countries');
		}
	}
	
	public function down() {
		$countryBelow = Country::find_one(array(
			'conditions' => array(
				'order' => self::condition('gt', $this->order),
			),
			'order' => '+order'
		));
			
		if(!empty($countryBelow)) {
			$tempOrder = $countryBelow->order;
			$countryBelow->order = $this->order;
			$this->order = $tempOrder;
			$this->save();
			$countryBelow->save();
		}else {
			Paraglide::redirect('countries');
		}
	}
}
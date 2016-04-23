<?php
App::uses('Model', 'Model');

class IdGenerator
{
	private $uses = array();

	public function __construct($model, $field)
	{
		$this->uses[] = $model;
		$this->field = $field;

		App::import('Model', $this->uses[0]);
	}

	private function getDbData()
	{
		$model = new $this->uses[0]();
		$data = $model->find('all', array('fields' => 'SUBSTRING(' . $this->field . ', 4) AS pid', 'order' => 'pid'));
		return $data;
	}

	public function get_free_number()
	{
		$missing_number = 1;
		$data = $this->getDbData();

		if(count($data) == 0)
			return $missing_number;
		
		for ($i = 0; $i < number_format($data[count($data)-1][0]['pid']); $i++) {
			if(number_format($data[$i][0]['pid']) != $missing_number)
				return $missing_number;

			$missing_number++;
		}
		
		return $missing_number;
	}
}
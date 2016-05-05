<?php
App::uses('Model', 'Model');

class IdGenerator
{
	private $uses = array();

	public function __construct($model, $field, $length = 4, $prefix = null)
	{
		$this->uses[] = $model;
		$this->field = $field;
        $this->length = $length;
        $this->prefix = $prefix;

		App::import('Model', $this->uses[0]);
	}

	private function getDbData()
	{
		$model = new $this->uses[0]();
        $data = $model->find('all', array('fields' => 'SUBSTRING(' . $this->field . ', '. $this->length .') AS pid', 'order' => 'pid'));
		return $data;
	}

	public function get_free_code()
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

        $missing_code = str_pad($missing_number, $this->length, '0', STR_PAD_LEFT);

        return $this->prefix.$missing_code;
	}
}

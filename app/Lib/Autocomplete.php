<?php
App::uses('Model', 'Model');

class Autocomplete
{
	private $uses = [];

	public function __construct($model, $fields = [], $conditions = [])
	{
		$this->uses[] = $model;
		$this->fields = $fields;
        $this->conditions = $conditions;

		App::import('Model', $this->uses[0]);
	}

	public function get()
	{
		$model = new $this->uses[0]();
        $data = $model->find('all', [
            'fields' => $this->fields,
            'conditions' => $this->conditions,
            ]);
		return $data;
	}
}

<?php
App::uses('Model', 'Model');

class PrepareModel
{
    private $uses = ['Item', 'Transaction', 'Payment'];

    public function __construct($idx = 0, $data = []) {
        $this->idx = $idx;
        $this->data = $data;
    }

    public function run()
    {
        App::import('Model', $this->uses[$this->idx]);
        $model = new $this->uses[$this->idx]();
        $obj = $model->create();
        foreach($this->data as $key => $value) {
            $obj[$this->uses[$this->idx]][$key] = $value;
        }
        $obj[$this->uses[$this->idx]]['created_at'] = '';
        $obj[$this->uses[$this->idx]]['updated_at'] = '';

        return $obj;
    }

}

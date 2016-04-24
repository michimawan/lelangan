<?php
App::uses('Model', 'Model');
App::uses('NormalTransaction', 'TransactionType');
App::uses('SellingTransaction', 'TransactionType');
App::uses('GivingTransaction', 'TransactionType');

class TransactionRepository
{
    private $uses = ['Item', 'Transaction', 'Payment'];

    public function __construct($data = [])
    {
        $this->item = isset($data['Item']) ? $data['Item']: [];
        $this->transaction = isset($data['Transaction']) ? $data['Transaction'] : [];
    }

    public function save()
    {
        switch ($this->transaction['type']) {
            case 'common' :
                return (new NormalTransaction($this->item, $this->transaction))->save();
            case 'selling' :
                return (new SellingTransaction($this->item, $this->transaction))->save();
            case 'giving' :
                return (new GivingTransaction($this->item, $this->transaction))->save();
            default :
                return false;
        }

        return false;
    }
}

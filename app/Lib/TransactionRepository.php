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
        $this->transaction = isset($data['Transaction']) ? $data['Transaction'] : [];
    }

    public function save()
    {
        switch ($this->transaction['type']) {
            case 'common' :
                return (new NormalTransaction($this->transaction))->save();
            case 'selling' :
                return (new SellingTransaction($this->transaction))->save();
            case 'giving' :
                return (new GivingTransaction($this->transaction))->save();
            default :
                return false;
        }

        return false;
    }
}

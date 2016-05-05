<?php
App::uses('Model', 'Model');
App::import('Lib', 'IdGenerator');
App::import('TransactionType', 'PrepareModel');

class SpecialTransaction
{
    private $uses = ['Transaction', 'Customer'];

    public function __construct($transaction = [])
    {
        $this->transaction = $transaction;

        foreach($this->uses as $use)
            App::import('Model', $use);
    }

    public function save()
    {
        $transactionModel = new $this->uses[0]();
        $customerModel = new $this->uses[1]();

        $item_id = $this->transaction['item_id'];
        $type = $this->transaction['type'];
        $failed = [];
        $i = 1;
        $dataSource = $transactionModel->getDataSource();
        $dataSource->begin();
        try {
            foreach($this->transaction as $key => $value) {
                if(is_numeric($key)) {
                    $customer = $customerModel->find('first', [
                        'conditions' => ['Customer.name LIKE' => '%'.$value['customer_name'].'%']
                    ]);
                    if(isset($customer['Customer'])) {
                        $transaction = (new PrepareModel(1))->run();
                        $transaction[$this->uses[0]]['transaction_id'] = $this->generate_transaction_id();
                        $transaction[$this->uses[0]]['item_id'] = $item_id;
                        $transaction[$this->uses[0]]['type'] = $type;
                        $transaction[$this->uses[0]]['customer_id'] = $customer['Customer']['id'];
                        $transaction[$this->uses[0]]['bid_price'] = $value['bid_price'];
                        $transactionModel->save($transaction);
                    }
                    else {
                        $failed[] = $value['customer_name'];
                    }

                    $i++;
                }
            }
            $dataSource->commit();
            $data['status'] = true;
            $data['customer'] = $i;
            $data['failed'] = $failed;
            return $data;
        } catch(Exception $e) {
            $dataSource->rollback();
            $data['status'] = false;
            $data['customer'] = $i;
            $data['failed'] = $failed;
            return false;
        }
    }

    private function generate_transaction_id()
    {
        $prefix = 'TID';
        $length = 8;
        $idgenerator = new IdGenerator('Transaction', 'transaction_id', $length, $prefix);

        return $idgenerator->get_free_code();
    }
}

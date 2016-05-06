<?php
App::import('Lib', 'IdGenerator');
App::import('Lib', 'Autocomplete');
App::import('Repository', 'TransactionRepository');
App::import('Factory', 'FilterFactory');
App::import('Factory', 'ModelConditionFactory');

class TransactionsController extends AppController
{
    public $layout = 'layout';
    public $uses = ['Transaction'];

    public function index()
    {
        $this->set('title', 'List of Transaction');
        $this->paginate = [
            'limit' => 20,
            'order' => ['Transaction.transaction_id' => 'asc' ],
            'conditions' => ['NOT' => ['Transaction.status' => '0']]
        ];
        $transactions = $this->paginate('Transaction');
        $this->set(['transactions' => $transactions, 'filters' => $this->getFilters()]);
    }

    public function add($type = null)
    {
        $this->set('title', 'Add Transaction');
        if($this->request->is('post') || $this->request->is('put')) {

            $transactionRepo = new TransactionRepository($this->request->data);

            $saveStatus = $transactionRepo->save();
            if($saveStatus['status']) {
                $message = 'Success adding new transaction. ';
                $additionalMessage =
                    count($saveStatus['failed']) > 0 ?
                        'There are ' . $this->getFailedSavedCustomerCount($saveStatus) . ' transaction failed to save' : '';

                $this->Session->setFlash($message . $additionalMessage, 'flashmessage', ['class' => 'success']);
                return $this->redirect(['action' => 'index']);
            } else {
                $message = 'Failed to save transaction. ';
                $additionalMessage =
                    count($saveStatus['failed']) > 0 ?
                        'There are ' . $this->getFailedSavedCustomerCount($saveStatus) . ' transaction failed to save' : '';
                $this->Session->setFlash($message . $additionalMessage, 'flashmessage', ['class' => 'danger']);
            }
        }

        if(!$type)
            $this->redirect(['action' => 'index']);

        $this->set(['type' => $type, 'transaction_id' => $this->generate_transaction_id()]);
        return $this->render('add_'.$type);
    }

    public function delete($transaction_id)
    {
        if($this->request->is('post')) {
            if (!$transaction_id) {
                $this->Session->setFlash('No transaction choosen', 'flashmessage', ['class' => 'warning']);
            }
            try {
                $transactionRepo = new TransactionRepository($this->request->data);

                $deleteStatus = $transactionRepo->delete($transaction_id);
                if ($deleteStatus) {
                    $this->Session->setFlash('Transaction data has been deleted', 'flashmessage', ['class' => 'success']);
                }
            } catch (NotFoundException $ex) {
                $this->Session->setFlash('Transaction not found', 'flashmessage', ['class' => 'warning']);
            }
        }
        $this->redirect(['action'=>'index']);
    }

    public function show($transaction_id = null)
    {
        if($transaction_id) {
            $transaction = $this->getTransactionData($transaction_id);
            if($transaction)
                return $this->set(['transactions' => $transaction]);
            else {
                $this->Session->setFlash("No Payment for '$transaction_id' yet", 'flashmessage', ['class' => 'warning']);
                $this->redirect(['action'=>'index']);
            }
        } else {
            $this->Session->setFlash('Transaction not found', 'flashmessage', ['class' => 'warning']);
            $this->redirect(['action'=>'index']);
        }
    }

    public function to_print($transaction_id = null)
    {
        if($transaction_id) {
            $this->set('title', 'Print Transaction');
            $transaction = $this->getTransactionData($transaction_id);
            if($transaction) {
                $this->set(['transaction' => $transaction]);
                $this->layout = 'print';
                $this->render('print');
            } else {
                $this->Session->setFlash("Can't print '$transaction_id' yet", 'flashmessage', ['class' => 'warning']);
                $this->redirect(['action'=>'index']);
            }
        } else {
            $this->Session->setFlash('Transaction not found', 'flashmessage', ['class' => 'warning']);
            $this->redirect(['action'=>'index']);
        }
    }

    private function getTransactionData($transaction_id)
    {
        $this->Transaction->unbindModel(['hasMany' => ['Payment']]);
        $transaction = $this->Transaction->find('all', [
            'conditions' => [
                'Transaction.transaction_id' => $transaction_id,
                'Transaction.status' => 1,
                'Payment.status' => 1,
            ],
            'fields' => [
                'Transaction.id', 'Transaction.transaction_id', 'Transaction.bid_price', 'Transaction.payed', 'Transaction.updated_at', 'Transaction.created_at',
                'Customer.name', 'Customer.address',
                'Payment.payment_id', 'Payment.pay', 'Payment.created_at',
                'Item.item_id', 'Item.item_name'
            ],
            'joins' => [
                [
                    'table' => 'payments',
                    'alias' => 'Payment',
                    'type' => 'LEFT',
                    'conditions' => ['Transaction.id = Payment.transaction_id']
                ]
            ],
        ]);

        return $transaction;
    }

    public function isAuthorized($user)
    {
        if ($this->action === 'add' || $this->action === 'index' ||
            $this->action === 'edit' || $this->action === 'delete') {
                return true;
            }

        return parent::isAuthorized($user);
    }

    private function generate_transaction_id()
    {
        $prefix = 'TID';
        $length = 8;
        $idgenerator = new IdGenerator('Transaction', 'transaction_id', $length, $prefix);
        return $idgenerator->get_free_code();
    }

    public function filter()
    {
        $filter = $this->params['url']['filter'];
        $text = $this->params['url']['text'];

        if($filter == null || $text == null) {
            $this->redirect(['action' => 'index']);
        }
        $this->set('title', 'List of Transaction');

        $filterConditions = $this->getModelCondition($filter, $text);
        $this->paginate = [
            'limit' => 20,
            'order' => ['Transaction.transaction_id' => 'asc' ],
            'conditions' => ['NOT' => ['Transaction.status' => '0'], $filterConditions]
        ];
        $transactions = $this->paginate('Transaction');
        $this->set(['transactions' => $transactions, 'filters' => $this->getFilters()]);
        return $this->render('index');
    }

    private function getFilters()
    {
        return (new FilterFactory('Transaction'))->produce();
    }

    private function getModelCondition($filter, $text)
    {
        $params = [
            'filter' => $filter,
            'text' => $text
        ];
        return (new ModelConditionFactory('Transaction', $params))->produce();
    }

    private function getFailedSavedCustomerCount($data)
    {
        return ($data['customer'] - count($data['failed']));
    }
}

<!-- app/View/Payments/add.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-10">
        <?php echo $this->Form->create('Payment');?>
            <h1><?php echo __('Add Payment'); ?></h1>
            <?php
            echo $this->Form->input('Payment.transaction_id', [
                'type' => 'text',
                'required',
                'class' => 'form-control',
                'div' => ['class' => 'form-group hidden']
            ]);
            echo $this->Form->input('Transaction.transaction_id', [
                'type' => 'text',
                'label' => 'Transaction Code',
                'required',
                'class' => 'form-control',
                'div' => ['class' => 'form-group']
            ]);
            echo $this->Form->input('Payment.customer_id', [
                'type' => 'number',
                'required',
                'class' => 'form-control',
                'div' => ['class' => 'form-group hidden']
            ]);
            echo $this->Form->input('Transaction.customer_name', [
                'type' => 'text',
                'required',
                'readonly',
                'label' => 'Customer Name',
                'class' => 'form-control',
                'div' => ['class' => 'form-group']
            ]);
            echo $this->Form->input('Transaction.bid_price', [
                'type' => 'number',
                'label' => 'Bid Price',
                'min' => '0',
                'max' => '10000000',
                'readonly',
                'class' => 'form-control',
                'div' => ['class' => 'form-group']
            ]);
            echo $this->Form->input('Payment.pay', array('label' => 'Pay', 'min' => 0, 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('deficient', array('label' => 'Deficit', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->submit('Add payment', array('class' => 'form-submit btn btn-primary',  'title' => 'click to add new payment', 'div' => array('class' => 'form-group')));
            ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<?php
    echo $this->Html->script(['jquery-ui.min.js']);
    echo $this->Html->css(['jquery-ui.min.css']);
    echo $this->element('autocomplete_transaction', [
        'firstId' => 'TransactionTransactionId',
        'secondId' => json_encode([
            'PaymentTransactionId',
            'PaymentCustomerId',
            'TransactionCustomerName',
            'TransactionBidPrice',
        ]),
        'model' => json_encode(['Transaction', 'Customer']),
        'controller' => 'transactions',
        'action' => 'get_transactions',
        'fields' => json_encode(['id',
            'transaction_id',
            'customer_id',
            'name',
            'bid_price',
        ]),
    ]);
    echo $this->element('auto_counting');
?>

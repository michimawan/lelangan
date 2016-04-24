<!-- app/View/Transactions/add_giving.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-10">
        <?php echo $this->Form->create('Transaction');?>
            <h1><?php echo __('Add Transaction'); ?></h1>
            <?php
            echo $this->Form->input('Transaction.transaction_id', [
                'type' => 'text',
                'label' => 'Transaction Code',
                'value' => $transaction_id,
                'readonly',
                'class' => 'form-control',
                'div' => ['class' => 'form-group']
            ]);
            echo $this->Form->input('Transaction.bid_price', [
                'type' => 'text',
                'required',
                'label' => 'Bid Price',
                'class' => 'form-control',
                'div' => ['class' => 'form-group']
            ]);
            echo $this->Form->input('Transaction.customer_id', [
                'type' => 'number',
                'class' => 'form-control',
                'div' => ['class' => 'form-group hidden']
            ]);
            echo $this->Form->input('customer_name', [
                'type' => 'text',
                'required',
                'label' => 'Customer Name',
                'class' => 'form-control',
                'div' => ['class' => 'form-group']
            ]);
            echo $this->Form->input('Transaction.type', [
                'type' => 'text',
                'value' => $type,
                'class' => 'form-control',
                'div' => ['class' => 'form-group hidden']
            ]);
            echo $this->Form->submit('Add Transaction', [
                'class' => 'form-submit btn btn-primary',
                'title' => 'click to add new transaction',
                'div' => ['class' => 'form-group']
            ]);
            ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php
    echo $this->Html->script(['jquery-ui.min.js']);
    echo $this->Html->css(['jquery-ui.min.css']);
    echo $this->element('autocomplete', [
        'firstId' => 'TransactionCustomerName',
        'secondId' => 'TransactionCustomerId',
        'model' => 'Customer',
        'controller' => 'customers',
        'action' => 'get_customer',
        'fields' => json_encode(['id', 'name'])
    ]);
?>

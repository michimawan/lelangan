<!-- app/View/Transactions/add_common.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-10">
        <?php echo $this->Form->create('Transaction');?>
            <h1><?php echo __('Add Transaction'); ?></h1>
            <?php
            echo $this->Form->input('item_id', array('type' => 'number', 'class' => 'form-control', 'div' => array('class' => 'form-group hidden')));
            echo $this->Form->input('item_name', array('type' => 'text', 'required', 'label' => 'Item Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('bid_price', array('type' => 'number', 'label' => 'Bid Price', 'min' => '0', 'max' => '10000000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('customer_id', array('type' => 'number', 'class' => 'form-control', 'div' => array('class' => 'form-group hidden')));
            echo $this->Form->input('customer_name', array('type' => 'text', 'required', 'label' => 'Customer Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('type', array('type' => 'text', 'value' => $type, 'class' => 'form-control', 'div' => array('class' => 'form-group hidden')));
            echo $this->Form->submit('Add Transaction', array('class' => 'form-submit btn btn-primary',  'title' => 'click to add new transaction', 'div' => array('class' => 'form-group')));
            ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php
    echo $this->Html->script(array('jquery-ui.min.js'));
    echo $this->Html->css(array('jquery-ui.min.css'));
    echo $this->element('autocomplete', [
        'firstId' => 'TransactionCustomerName',
        'secondId' => 'TransactionCustomerId',
        'model' => 'Customer',
        'controller' => 'customers',
        'action' => 'get_customer',
        'fields' => json_encode(['id', 'name'])
    ]);
    echo $this->element('autocomplete', [
        'firstId' => 'TransactionItemName',
        'secondId' => 'TransactionItemId',
        'model' => 'Item',
        'controller' => 'items',
        'action' => 'get_item',
        'fields' => json_encode(['id', 'item_name'])
    ]);
?>

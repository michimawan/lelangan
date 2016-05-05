<!-- app/View/Transactions/add_special.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-10">
        <?php echo $this->Form->create('Transaction');?>
            <h1><?php echo __('Add Transaction'); ?></h1>
            <?php
            echo $this->Form->input('Transaction.item_id', [
                'type' => 'text',
                'required',
                'class' => 'form-control',
                'div' => ['class' => 'form-group hidden']
            ]);
            echo $this->Form->input('Item.item_name', [
                'type' => 'text',
                'required',
                'label' => 'Item Name',
                'class' => 'form-control',
                'div' => ['class' => 'form-group']
            ]);
            echo $this->Form->input('quantity', [
                'type' => 'number',
                'class' => 'form-control',
                'min' => 1,
                'div' => ['class' => 'form-group']
            ]);
            ?>
            <div class="form-group">
            <?php
            echo $this->Form->button('Create Form', [
                'type' => 'button',
                'class' => 'btn btn-primary',
                'label' => false,
                'id' => 'create'
            ]);
            ?>
            </div>
            <div class="hidden master">
            <?php
            echo $this->Form->input('Transaction.xxx.customer_id', [
                'type' => 'number',
                'required' => false,
                'class' => 'form-control',
                'id' => 'TransactionxxxCustomerId',
                'div' => ['class' => 'form-group hidden customer_id']
            ]);
            echo $this->Form->input('Transaction.xxx.customer_name', [
                'type' => 'text',
                'label' => 'Customer xxx Name',
                'class' => 'form-control',
                'id' => 'TransactionxxxCustomerName',
                'div' => ['class' => 'form-group customer_name']
            ]);
            echo $this->Form->input('Transaction.xxx.bid_price', [
                'type' => 'number',
                'label' => 'Customer xxx Bid Price',
                'required' => false,
                'min' => '0',
                'max' => '10000000',
                'class' => 'form-control',
                'div' => ['class' => 'form-group bid_price']
            ]);
            ?>
            </div>
            <div class="js-customers">
            </div>
            <?php
            echo $this->Form->input('Transaction.type', [
                'type' => 'text',
                'value' => $type,
                'class' => 'form-control',
                'div' => ['class' => 'form-group hidden']
            ]);
            echo $this->Form->submit('Add Transaction', [
                'class' => 'form-submit btn btn-primary',
                'title' => 'click to add new transaction',
                'div' => ['class' => 'form-group',  'id' => 'submit_btn']
            ]);
            ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php
    echo $this->Html->script(['jquery-ui.min.js']);
    echo $this->Html->css(['jquery-ui.min.css']);
    echo $this->element('autocomplete', [
        'firstId' => 'ItemItemName',
        'secondId' => 'TransactionItemId',
        'model' => 'Item',
        'controller' => 'items',
        'action' => 'get_item',
        'fields' => json_encode(['id', 'item_name'])
    ]);
    echo $this->element('duplicate_form');
?>

<!-- app/View/Items/edit.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="btn-group" role="group">
            <?php echo $this->Html->link( "List of Transaction", array('action'=>'index'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
    <div class="col-xs-12 col-md-12">
    <?php echo $this->Form->create('Transaction'); ?>
            <h1><?php echo __('Edit Transaction Details'); ?></h1>
            <?php 
            echo $this->Form->hidden('id', array('value' => $this->data['Transaction']['id']));
            echo $this->Form->input('item_name', array('label' => 'Item Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('base_price', array('type' => 'number', 'label' => 'Base Price', 'min' => '0', 'max' => '10000000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('stock', array('type' => 'number', 'label' => 'Stock', 'min' => '0', 'max' => '1000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->submit('Edit Item Data', array('class' => 'form-submit',  'title' => 'click to edit item data', 'div' => array('class' => 'form-group'))); 
    ?>
    <?php echo $this->Form->end(); ?>
    </div>
</div>

<!-- app/View/Items/edit.ctp -->

<div class="row">
    <div class="col-xs-3 col-md-2">
        <div class="btn-group-vertical" role="group">
            <div class='btn-group' role='group'>
            <?php echo $this->Html->link( "List of Items", array('action'=>'index'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-10">
    <?php echo $this->Form->create('Item'); ?>
            <h1><?php echo __('Edit Item Details'); ?></h1>
            <?php 
            echo $this->Form->hidden('id', array('value' => $this->data['Item']['id']));
            echo $this->Form->input('item_name', array('label' => 'Item Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('base_price', array('type' => 'number', 'label' => 'Base Price', 'min' => '0', 'max' => '10000000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('stock', array('type' => 'number', 'label' => 'Stock', 'min' => '0', 'max' => '1000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->submit('Edit Item Data', array('class' => 'form-submit',  'title' => 'click to edit item data', 'div' => array('class' => 'form-group'))); 
    ?>
    <?php echo $this->Form->end(); ?>
    </div>
</div>

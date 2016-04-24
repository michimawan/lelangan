<!-- app/View/Items/add.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-10">
        <?php echo $this->Form->create('Item');?>
            <h1><?php echo __('Add item'); ?></h1>
            <?php
            echo $this->Form->input('item_name', array('label' => 'Item Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('base_price', array('type' => 'number', 'label' => 'Base Price', 'min' => '0', 'max' => '10000000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('stock', array('type' => 'number', 'label' => 'Stock', 'min' => '0', 'max' => '1000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->submit('Add item', array('class' => 'form-submit btn btn-primary',  'title' => 'click to add new item', 'div' => array('class' => 'form-group'))); 
            ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>  

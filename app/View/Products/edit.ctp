<!-- app/View/Products/edit.ctp -->

<div class="row">
    <div class="col-xs-3 col-md-2">
        <div class="btn-group-vertical" role="group">
            <div class='btn-group' role='group'>
            <?php echo $this->Html->link( "List of Products", array('action'=>'index'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-10">
    <?php echo $this->Form->create('Product'); ?>
            <h1><?php echo __('Edit Product Details'); ?></h1>
            <?php 
            echo $this->Form->hidden('id', array('value' => $this->data['Product']['id']));
            echo $this->Form->input('product_id', array('type' => 'text', 'label' => 'Product ID can not be changed', 'readonly' => true, 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('product_name', array('label' => 'Product Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('price_buy', array('type' => 'number', 'label' => 'Buy Price', 'min' => '0', 'max' => '10000000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('price_sell', array('type' => 'number', 'label' => 'Sell Price', 'min' => '0', 'max' => '10000000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->submit('Edit Product Data', array('class' => 'form-submit',  'title' => 'click to edit product data', 'div' => array('class' => 'form-group'))); 
    ?>
    <?php echo $this->Form->end(); ?>
    </div>
</div>
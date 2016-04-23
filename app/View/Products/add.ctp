<!-- app/View/Products/add.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-10">
        <?php echo $this->Form->create('Product');?>
            <h1><?php echo __('Add Product'); ?></h1>
            <?php
            echo $this->Form->input('product_name', array('label' => 'Product Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('price_buy', array('type' => 'number', 'label' => 'Buy Price', 'min' => '0', 'max' => '10000000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('price_sell', array('type' => 'number', 'label' => 'Sell Price', 'min' => '0', 'max' => '10000000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('stock', array('type' => 'number', 'label' => 'Product Stock', 'min' => '0', 'max' => '1000', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->submit('Add Product', array('class' => 'form-submit btn btn-primary',  'title' => 'click to add new product', 'div' => array('class' => 'form-group'))); 
            ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>  
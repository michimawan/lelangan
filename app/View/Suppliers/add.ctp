<!-- app/View/Suppliers/add.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-10">
        <?php echo $this->Form->create('Supplier');?>
            <h1><?php echo __('Add Supplier'); ?></h1>
            <?php
            echo $this->Form->input('supplier_name', array('label' => 'Supplier Name', 'required' => true, 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('address', array('type' => 'text', 'required' => true, 'label' => 'Address', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('phone', array('type' => 'number', 'required' => true, 'label' => 'Phone (HP)', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->submit('Add Supplier', array('class' => 'form-submit btn btn-primary',  'title' => 'click to add new supplier', 'div' => array('class' => 'form-group'))); 
            ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
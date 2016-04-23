<!-- app/View/Suppliers/edit.ctp -->

<div class="row">
    <div class="col-xs-3 col-md-2">
        <div class="btn-group-vertical" role="group">
            <div class='btn-group' role='group'>
            <?php echo $this->Html->link( "List of Suppliers", array('action'=>'index'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-10">
    <?php echo $this->Form->create('Supplier'); ?>
            <h1><?php echo __('Edit Supplier Details'); ?></h1>
            <?php 
            echo $this->Form->hidden('id', array('value' => $this->data['Supplier']['id']));
            echo $this->Form->input('supplier_id', array('type' => 'text', 'label' => 'Supplier ID can not be changed', 'readonly' => true, 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('supplier_name', array('label' => 'Supplier Name', 'required' => true, 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('address', array('type' => 'text', 'required' => true, 'label' => 'Address', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('phone', array('type' => 'number', 'required' => true, 'label' => 'Phone (HP)', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->submit('Edit Supplier', array('class' => 'form-submit btn btn-primary',  'title' => 'click to edit supplier', 'div' => array('class' => 'form-group')));
    ?>
    <?php echo $this->Form->end(); ?>
    </div>
</div>
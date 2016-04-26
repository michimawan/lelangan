<!-- app/View/Customers/add.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-10">
        <?php echo $this->Form->create('Customer');?>
            <h1><?php echo __('Add Customer'); ?></h1>
            <?php
            echo $this->Form->input('name', array('label' => 'Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('address', array('type' => 'text', 'label' => 'Address', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('phone', array('type' => 'number', 'label' => 'Phone Number', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('group_id', [
                'type' => 'select',
                'options' => $groups,
                'required',
                'div' => ['class' => 'form-group'],
                'class' => 'form-control'
            ]);
            echo $this->Form->submit('Add Customer', array('class' => 'form-submit btn btn-primary',  'title' => 'click to add new item', 'div' => array('class' => 'form-group'))); 
            ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>  

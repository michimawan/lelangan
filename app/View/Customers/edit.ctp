<!-- app/View/Customers/edit.ctp -->

<div class="row">
    <div class="col-xs-3 col-md-2">
        <div class="btn-group-vertical" role="group">
            <div class='btn-group' role='group'>
            <?php echo $this->Html->link( "List of Customers", array('action'=>'index'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-10">
    <?php echo $this->Form->create('Customer'); ?>
            <h1><?php echo __('Edit Customer Details'); ?></h1>
            <?php
            echo $this->Form->hidden('id', array('value' => $this->data['Customer']['id']));
            echo $this->Form->input('name', array('label' => 'Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('address', array('type' => 'text', 'label' => 'Address', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('phone', array('type' => 'number', 'label' => 'Phone Number', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('group_id', [
                'type' => 'select',
                'options' => $groups,
                'default' => $this->data['Customer']['group_id'],
                'div' => ['class' => 'form-group'],
                'class' => 'form-control'
            ]);
            echo $this->Form->submit('Edit Customer Data', array('class' => 'form-submit',  'title' => 'click to edit customer data', 'div' => array('class' => 'form-group')));
    ?>
    <?php echo $this->Form->end(); ?>
    </div>
</div>

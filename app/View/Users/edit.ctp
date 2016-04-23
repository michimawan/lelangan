<!-- app/View/Users/edit.ctp -->

<div class="row">
    <div class="col-xs-3 col-md-2">
        <div class="btn-group-vertical" role="group">
            <div class='btn-group' role='group'>
            <?php echo $this->Html->link( "List of User", array('action'=>'index'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-10">
    <?php echo $this->Form->create('User'); ?>
            <h1><?php echo __('Edit Data User'); ?></h1>
            <?php 
            echo $this->Form->hidden('id', array('value' => $this->data['User']['id']));
            echo $this->Form->input('username', array('label' => 'Username', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('display_name', array('label' => 'Full Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('password', array('type' => 'password', 'label' => 'Password', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('confirm_password', array('type' => 'password', 'id' => 'confirm_password', 'label' => 'Confirmation Password', 'required' => true, 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('role', array(
                'options' => array( 'admin' => 'Admin', 'staff' => 'Staff'),
                'label' => 'Role',
                'class' => 'form-control',
                'div' => 'form-group'
            ));
            echo $this->Form->submit('Edit User', array('class' => 'form-submit btn btn-primary',  'title' => 'click to edit user', 'div' => array('class' => 'form-group')));
    ?>
    <?php echo $this->Form->end(); ?>
    </div>
</div>

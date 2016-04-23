<!-- app/View/Users/add.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-10">
        <?php echo $this->Form->create('User');?>
            <h1><?php echo __('Add User'); ?></h1>
            <?php
            echo $this->Form->input('username', array('label' => 'Username', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('display_name', array('label' => 'Full Name', 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('password', array('type' => 'password', 'id' => 'password','label' => 'Password', 'required' => true, 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('confirm_password', array('type' => 'password', 'id' => 'confirm_password', 'label' => 'Confirmation Password', 'required' => true, 'class' => 'form-control', 'div' => array('class' => 'form-group')));
            echo $this->Form->input('role', array(
                'options' => $option,
                'label' => 'Role',
                'default' => 'staff',
                'class' => 'form-control',
                'div' => 'form-group'
            ));
            echo $this->Form->submit('Add User', array('class' => 'form-submit btn btn-primary',  'title' => 'click to add user', 'div' => array('class' => 'form-group'))); 
            ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<!-- app/View/Users/login.ctp -->

<div class="">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <h1>Enter Username and Password</h1>
    <?php
    echo $this->Form->input('username', array('class' => 'form-control', 'div' => 'form-group'));
    echo $this->Form->input('password', array('class' => 'form-control', 'div' => 'form-group'));
	?>
<?php echo $this->Form->end(__('Login')); ?>
</div>

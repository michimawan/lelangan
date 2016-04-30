<!-- app/View/Users/view.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="btn-group" role="group">
            <?php
            $current_user = $this->Auth->User();
            if($current_user['role'] != 'staff')
            echo $this->Html->link( "List of User", array('action'=>'index'), array('escape' => false, 'class' => 'btn btn-default'));
            else {
                echo $this->Html->link( "Edit Profile", array('action'=>'edit', $current_user['id']), array('escape' => false, 'class' => 'btn btn-default'));
            }
            ?>
        </div>
    </div>

    <div class="col-xs-12 col-md-12">
        <div>
            <h1>User Profile</h1>
            <h3>Username: <?php echo $user['User']['username'];?></h3>
            <h3>Name: <?php echo $user['User']['display_name'];?></h3>
        </div>
    </div>
</div>

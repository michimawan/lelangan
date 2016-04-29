<!-- app/View/Users/index.ctp -->

<?php
$params = [
    'action' => 'filter',
    'controllers' => 'users',
    'filters' => $filters,
    'model' => 'User'
];
echo $this->element('filter', $params);
?>

<div class="row">
    <div class="col-xs-3 col-md-2">
        <div class="btn-group-vertical" role="group">
            <div class='btn-group' role='group'>
            <?php echo $this->Html->link( "Add User", array('action'=>'add'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-10">
    <h1>List of User(s)</h1>
    <div class='table-responsive'>
    <table class='table table-condensed table-hover table-stripped'>
        <thead>
            <tr>
                <th>No.</th>
                <th><?php echo $this->Paginator->sort('username', 'Username', array('direction' => 'asc'));?>  </th>
                <th><?php echo $this->Paginator->sort('display_name', 'Display Name');?>  </th>
                <th><?php echo $this->Paginator->sort('role', 'Role');?></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!$users){
            ?>
            <tr>
                <td colspan=5>There is no user yet</td>
            </tr>
            <?php
            }
            else {
            ?>
            <?php $count=0; ?>
            <?php foreach($users as $user):
                $count ++;
            ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $this->Html->link( $user['User']['username'], array('action' => 'view', $user['User']['username']));?></td>
                <td><?php echo $user['User']['display_name'];?></td>
                <td><?php echo $user['User']['role']; ?></td>
                <td>
                <?php echo $this->Html->link(    "Edit",   array('action'=>'edit', $user['User']['username']), array('class' => 'btn btn-info')); ?>

                <?php
                    echo $this->Form->postLink(    "Delete", array('action'=>'delete', $user['User']['username']), array('class' => 'btn btn-danger', 'confirm'=>'Are you sure to delete '.$user['User']['display_name']));
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php unset($user); } ?>
        </tbody>
    </table>
    </div>
    <div class="paging">
        <?php
            echo $this->Paginator->prev() .'  '. $this->Paginator->numbers(array('before'=>false, 'after'=>false,'separator'=> false)) .'  '. $this->Paginator->next();
        ?>
    </div>
    </div>
</div>

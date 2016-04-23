<!-- app/View/Customers/index.ctp -->

<div class="row">
    <div class="col-xs-3 col-md-2">
        <div class="btn-group-vertical" role="group">
            <div class='btn-group' role='group'>
            <?php echo $this->Html->link( "Add Customer", array('action'=>'add'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-10">
    <h1>List of Customer(s)</h1>
    <div class='table-responsive'>
    <table class='table table-condensed table-hover table-stripped'>
        <thead>
            <tr>
                <th>No.</th>
                <th><?php echo $this->Paginator->sort('name', 'Name');?>  </th>
                <th><?php echo $this->Paginator->sort('address', 'Address');?></th>
                <th><?php echo $this->Paginator->sort('phone', 'Phone');?></th>
                <th>Block</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!$customers){
            ?>
            <tr>
                <td colspan=6>There is no customer yet</td>
            </tr>
            <?php
            }
            else {
            ?>
            <?php $count=0; ?>
            <?php foreach($customers as $customer):
                $count ++;
            ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $customer['Customer']['name'];?></td>
                <td><?php echo $customer['Customer']['address'];?></td>
                <td><?php echo $customer['Customer']['phone']?></td>
                <td><?php echo $customer['Group']['name']; ?></td>
                <td>
                <?php
                    echo $this->Html->link(    "Edit",   array('action'=>'edit', $customer['Customer']['id']), array('class' => 'btn btn-info'));
                    echo $this->Form->postLink(    "Delete", array('action'=>'delete', $customer['Customer']['id']), array('class' => 'btn btn-danger', 'confirm'=>'Are you sure want to delete '.$customer['Customer']['name']));
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php unset($customer); } ?>
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

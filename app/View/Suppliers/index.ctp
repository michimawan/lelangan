<!-- app/View/Suppliers/index.ctp -->

<div class="row">
    <div class="col-xs-3 col-md-2">
        <div class="btn-group-vertical" role="group">
            <div class='btn-group' role='group'>
            <?php echo $this->Html->link( "Add Supplier", array('action'=>'add'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-10">
    <h1>List of Supplier(s)</h1>
    <h4>Display <?php echo $this->params['paging']['Supplier']['count'] < 20? ($this->params['paging']['Supplier']['count']." from ".$this->params['paging']['Supplier']['count']." record") : ("20 from ".$this->params['paging']['Supplier']['count']." record") ?></h4>
    <div class='table-responsive'>
    <table class='table table-condensed table-hover table-stripped'>
        <thead>
            <tr>
                <th>No.</th>
                <th><?php echo $this->Paginator->sort('supplier_id', 'Supplier ID', array('direction' => 'asc'));?>  </th>
                <th><?php echo $this->Paginator->sort('supplier_name', 'Supplier Name');?>  </th>
                <th><?php echo $this->Paginator->sort('address', 'Address');?></th>
                <th><?php echo $this->Paginator->sort('phone', 'Phone (HP)');?></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody> 
            <?php 
            if(!$suppliers){
            ?>
            <tr>
                <td colspan=6>There is no supplier yet</td>
            </tr>
            <?php
            }
            else {
            ?>                             
            <?php $count=0; ?>
            <?php foreach($suppliers as $supplier):
                $count ++;
            ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $supplier['Supplier']['supplier_id'];?></td>
                <td><?php echo $supplier['Supplier']['supplier_name'];?></td>
                <td><?php echo $supplier['Supplier']['address']?></td>
                <td><?php echo $supplier['Supplier']['phone']; ?></td>
                <td>
                <?php echo $this->Html->link(    "Edit",   array('action'=>'edit', $supplier['Supplier']['supplier_id']), array('class' => 'btn btn-info')); ?> 

                <?php
                    echo $this->Form->postLink(    "Delete", array('action'=>'delete', $supplier['Supplier']['supplier_id']), array('class' => 'btn btn-danger', 'confirm'=>'Are you sure want to delete '.$supplier['Supplier']['supplier_name']));
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php unset($supplier); } ?>
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
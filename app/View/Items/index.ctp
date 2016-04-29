<!-- app/View/Items/index.ctp -->

<?php
$params = [
    'action' => 'filter',
    'controllers' => 'items',
    'filters' => $filters,
    'model' => 'Item'
];
echo $this->element('filter', $params);
?>

<div class="row">
    <div class="col-xs-3 col-md-2">
        <div class="btn-group-vertical" role="group">
            <div class='btn-group' role='group'>
            <?php echo $this->Html->link( "Add Item", array('action'=>'add'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-10">
    <h1>List of item(s)</h1>
    <div class='table-responsive'>
    <table class='table table-condensed table-hover table-stripped'>
        <thead>
            <tr>
                <th>No.</th>
                <th><?php echo $this->Paginator->sort('item_id', 'Item ID', array('direction' => 'asc'));?>  </th>
                <th><?php echo $this->Paginator->sort('item_name', 'Item Name');?>  </th>
                <th><?php echo $this->Paginator->sort('base_price', 'Buy Price');?></th>
                <th><?php echo $this->Paginator->sort('stock', 'Item Stock');?></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!$items){
            ?>
            <tr>
                <td colspan=6>There is no item yet</td>
            </tr>
            <?php
            }
            else {
            ?>
            <?php $count=0; ?>
            <?php foreach($items as $item):
                $count ++;
            ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $item['Item']['item_id'];?></td>
                <td><?php echo $item['Item']['item_name'];?></td>
                <td><?php echo $item['Item']['base_price']?></td>
                <td><?php echo $item['Item']['stock']; ?></td>
                <td>
                <?php
                    echo $this->Html->link(    "Edit",   array('action'=>'edit', $item['Item']['item_id']), array('class' => 'btn btn-info'));
                    echo $this->Form->postLink(    "Delete", array('action'=>'delete', $item['Item']['item_id']), array('class' => 'btn btn-danger', 'confirm'=>'Are you sure want to delete '.$item['Item']['item_name']));
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php unset($item); } ?>
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

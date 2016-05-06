<!-- app/View/Transactions/index.ctp -->

<?php
$params = [
    'action' => 'filter',
    'controllers' => 'transactions',
    'filters' => $filters,
    'model' => 'Transaction',
];
echo $this->element('filter', $params);
?>

<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="btn-group" role="group">
            <?php
                echo $this->Html->link( "Add Transaction", array('action'=>'add', 'common'), array('class' => 'btn btn-default'));
                echo $this->Html->link( "Add Transaction 2", array('action'=>'add', 'special'), array('class' => 'btn btn-default'));
                echo $this->Html->link( "Add Transaction 3", array('action'=>'add', 'selling'), array('class' => 'btn btn-default'));
                echo $this->Html->link( "Add Transaction 4", array('action'=>'add', 'giving'), array('class' => 'btn btn-default'));
            ?>
        </div>
    </div>
    <div class="col-xs-12 col-md-12">
    <h1>List of Transaction(s)</h1>
    <div class='table-responsive'>
    <table class='table table-condensed table-hover table-stripped'>
        <thead>
            <tr>
                <th>No.</th>
                <th><?php echo $this->Paginator->sort('Transaction.transaction_id', 'Transaction ID', array('direction' => 'asc'));?>  </th>
                <th><?php echo $this->Paginator->sort('Item.item_name', 'Item Name');?></th>
                <th><?php echo $this->Paginator->sort('Item.base_price', 'Item Base Price');?></th>
                <th><?php echo $this->Paginator->sort('Transaction.bid_price', 'Bid Price');?></th>
                <th><?php echo $this->Paginator->sort('Customer.name', 'Winner');?></th>
                <th><?php echo $this->Paginator->sort('Customer.address', 'Address');?></th>
                <th><?php echo $this->Paginator->sort('Transaction.type', 'Auction Type');?></th>
                <th><?php echo $this->Paginator->sort('Transaction.payed', 'Payed');?></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!$transactions){
            ?>
            <tr>
                <td colspan=9>There is no transaction yet</td>
            </tr>
            <?php
            }
            else {
            ?>
            <?php $count=0; ?>
            <?php foreach($transactions as $transaction):
                $count ++;
            ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $this->Html->link($transaction['Transaction']['transaction_id'], ['action' => 'show', $transaction['Transaction']['transaction_id']]);?></td>
                <td><?php echo $transaction['Item']['item_name'];?></td>
                <td><?php echo $transaction['Item']['base_price'];?></td>
                <td><?php echo $transaction['Transaction']['bid_price'];?></td>
                <td><?php echo $transaction['Customer']['name'];?></td>
                <td><?php echo $transaction['Customer']['address'];?></td>
                <td><?php echo $transaction['Transaction']['type'];?></td>
                <td><?php echo $transaction['Transaction']['payed'] ? 'payed' : 'not payed';?></td>
                <td>
                    <div class="btn-group" role="group">
                <?php
                    echo $this->Html->link( "Pay", array('controller' => 'payments', 'action'=>'add', $transaction['Transaction']['transaction_id']), array('class' => 'btn btn-primary'));
                    echo $this->Form->postLink(    "Delete", array('action'=>'delete', $transaction['Transaction']['transaction_id']), array('class' => 'btn btn-danger', 'confirm'=>'Are you sure want to delete '.$transaction['Transaction']['transaction_id']));
                    if($transaction['Transaction']['payed'])
                    echo $this->Html->link( "Print", array('action'=>'to_print', $transaction['Transaction']['transaction_id']), array('class' => 'btn btn-default'));
                ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php unset($transaction); } ?>
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

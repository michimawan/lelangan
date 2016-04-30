<!-- app/View/Transactions/show.ctp -->
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="btn-group" role="group">
            <?php echo $this->Html->link( "Back", array('action'=>'index'), array('class' => 'btn btn-default')); ?>
            <?php echo $this->Html->link( "Print", array('action'=>'to_print', $this->params['pass'][0]), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
</div>
<h2>Transaction History</h2>
<div class="row">
    <div class="col-md-6">
    <h5>Transaction ID: <?php echo $transactions[0]['Transaction']['transaction_id'];?></h5>
    <p>
    Customer ID: <?php echo $transactions[0]['Customer']['name']; ?><br/>
    Address: <?php echo $transactions[0]['Customer']['address']; ?><br/>
    </p>
    </div>
    <div class="col-md-6">
    <h5><?php echo $transactions[0]['Transaction']['created_at'];?></h5>
    <p>
    Item ID: <?php echo $transactions[0]['Item']['item_id']; ?><br/>
    Item Name: <?php echo $transactions[0]['Item']['item_name']; ?><br/>
    </p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <h3>Status: <?php echo $transactions[0]['Transaction']['payed'] ? 'payed' : 'not yet payed';?></h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class='table-responsive'>
        <table class='table table-condensed table-hover table-stripped'>
            <thead>
                <th>No.</th>
                <th>Payment ID</th>
                <th>Amount</th>
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
                <td><?php echo $transaction['Payment']['payment_id']; ?></td>
                <td><?php echo $transaction['Payment']['pay'];?></td>
            </tr>
            <?php endforeach; ?>
            <?php unset($transaction); } ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<!-- app/View/Payments/index.ctp -->

<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="btn-group" role="group">
            <?php echo $this->Html->link( "Add Payment", array('action'=>'add'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
    <div class="col-xs-12 col-md-12">
    <h1>List of Payment(s)</h1>
    <div class='table-responsive'>
    <table class='table table-condensed table-hover table-stripped'>
        <thead>
            <tr>
                <th>No.</th>
                <th><?php echo $this->Paginator->sort('Transaction.transaction_id', 'Transaction ID', array('direction' => 'asc'));?>  </th>
                <th><?php echo $this->Paginator->sort('Payment.payment_id', 'Payment ID', array('direction' => 'asc'));?>  </th>
                <th><?php echo $this->Paginator->sort('Customer.name', 'Customer Name');?>  </th>
                <th><?php echo $this->Paginator->sort('Payment.pay', 'Payed');?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!$payments){
            ?>
            <tr>
                <td colspan=5>There is no payment yet</td>
            </tr>
            <?php
            }
            else {
            ?>
            <?php $count=0; ?>
            <?php foreach($payments as $payment):
                $count ++;
            ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $payment['Transaction']['transaction_id'];?></td>
                <td><?php echo $payment['Payment']['payment_id'];?></td>
                <td><?php echo $payment['Customer']['name'];?></td>
                <td><?php echo $payment['Payment']['pay']?></td>
            </tr>
            <?php endforeach; ?>
            <?php unset($payment); } ?>
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

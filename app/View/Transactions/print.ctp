<?php
$current_date = date('d-M-Y');
$transaction_id = $transaction[0]['Transaction']['transaction_id'];
$bid_price = $transaction[0]['Transaction']['bid_price'];
$payment_status = $transaction[0]['Transaction']['payed'];
$customer_name = $transaction[0]['Customer']['name'];
$customer_address = $transaction[0]['Customer']['address'];
$item_id = $transaction[0]['Item']['item_id'];
$item_name = $transaction[0]['Item']['item_name'];
?>

<div class="print">
<div class='print--header'>
    <div class='receipt--title'>
        <h2>Transaction Receipt</h2>
    </div>
    <div class='receipt--id'>
        <h3>Transaction ID: <?php echo $transaction_id; ?></h3>
    </div>
</div>
<div class='print--subheader'>
    <div class='receipt--date'>
        <h4>Date: <?php echo $current_date ?></h4>
        <h4>Bid Amount: <?php echo $bid_price; ?></h4>
    </div>
    <div class='print--subheader--left'>
        <div class='receipt--item-id'>
            <h4>Item ID: <?php echo $item_id ?></h4>
        </div>
        <div class='receipt--item-name'>
            <h4>Item Name: <?php echo $item_name; ?></h4>
        </div>
    </div>
    <div class='print--subheader--right'>
        <div class='receipt--customer-name'>
            <h4>Customer: <?php echo $customer_name ?></h4>
        </div>
        <div class='receipt--customer-address'>
            <h4>Address: <?php echo $customer_address; ?></h4>
        </div>
    </div>
    <div class='receipt--status'>
        <h4>Status: <?php echo $payment_status ? 'Paid' : 'Credit' ?></h4>
    </div>
</div>
<div class='print--content'>
    <table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>Date</th>
            <th>Payment ID</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php $count=0; $total=0?>
        <?php foreach($transaction as $payment):
            $count ++;
        ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $payment['Payment']['created_at'];?></td>
            <td><?php echo $payment['Payment']['payment_id'];?></td>
            <td><?php echo $payment['Payment']['pay'];?></td>
        </tr>
        <?php $total += $payment['Payment']['pay']; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan=3>Total</td>
            <td><?php echo $total ?></td>
        </tr>
    </tbody>
    </table>
</div>
<div class='signature'>
    <div class='leader--signature'>
        <h4>Simon Caldwell</h4>
    </div>
    <div class='secretary--signature'>
        <h4>Catherine Whatson</h4>
    </div>
</div>
</div>


<?php
    echo $this->element('print-js');
?>

<!-- app/View/Products/index.ctp -->

<div class="row">
    <div class="col-xs-3 col-md-2">
        <div class="btn-group-vertical" role="group">
            <div class='btn-group' role='group'>
            <?php echo $this->Html->link( "Add Product", array('action'=>'add'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-10">
    <h1>List of Product(s)</h1>
    <h4>Display <?php echo $this->params['paging']['Product']['count'] < 20? ($this->params['paging']['Product']['count']." from ".$this->params['paging']['Product']['count']." record") : ("20 from ".$this->params['paging']['Product']['count']." record") ?></h4>
    <div class='table-responsive'>
    <table class='table table-condensed table-hover table-stripped'>
        <thead>
            <tr>
                <th>No.</th>
                <th><?php echo $this->Paginator->sort('product_id', 'Product ID', array('direction' => 'asc'));?>  </th>
                <th><?php echo $this->Paginator->sort('product_name', 'Product Name');?>  </th>
                <th><?php echo $this->Paginator->sort('price_buy', 'Buy Price');?></th>
                <th><?php echo $this->Paginator->sort('price_sell', 'Sell Price');?></th>
                <th><?php echo $this->Paginator->sort('stock', 'Product Stock');?></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody> 
            <?php 
            if(!$products){
            ?>
            <tr>
                <td colspan=7>There is no product yet</td>
            </tr>
            <?php
            }
            else {
            ?>                             
            <?php $count=0; ?>
            <?php foreach($products as $product):
                $count ++;
            ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $product['Product']['product_id'];?></td>
                <td><?php echo $product['Product']['product_name'];?></td>
                <td><?php echo $product['Product']['price_buy']?></td>
                <td><?php echo $product['Product']['price_sell']; ?></td>
                <td><?php echo $product['Product']['stock']; ?></td>
                <td>
                <?php echo $this->Html->link(    "Add Stock",   array('action'=>'#', $product['Product']['product_id']), array('class' => 'btn btn-success')); ?> 

                <?php echo $this->Html->link(    "Edit",   array('action'=>'edit', $product['Product']['product_id']), array('class' => 'btn btn-info')); ?> 

                <?php
                    echo $this->Form->postLink(    "Delete", array('action'=>'delete', $product['Product']['product_id']), array('class' => 'btn btn-danger', 'confirm'=>'Are you sure want to delete '.$product['Product']['product_name']));
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php unset($product); } ?>
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
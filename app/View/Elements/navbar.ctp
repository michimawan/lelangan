<!-- app/View/Elements/navbar.ctp -->

<?php
$main = '';
$users = '';
$customers= '';
$items= '';
$transactions= '';
$payments= '';
$logouturl= $this->Html->url(array('controller'=>'users', 'action'=>'logout'));
$userurl= $this->Html->url(array('controller'=>'users', 'action'=>'index'));
$customerurl= $this->Html->url(array('controller'=>'customers', 'action'=>'index'));
$itemurl= $this->Html->url(array('controller'=>'items', 'action'=>'index'));
$transactionurl= $this->Html->url(array('controller'=>'transactions', 'action'=>'index'));
$paymenturl= $this->Html->url(array('controller'=>'payments', 'action'=>'index'));

if($menu === 'mains') {
	$main = 'class="active"';
} else if($menu === 'users') {
	$users = 'class="active"';
} else if ($menu === 'customers') {
	$customers = 'class="active"';
} else if ($menu === 'items') {
	$items = 'class="active"';
} else if ($menu === 'transactions') {
	$transactions = 'class="active"';
} else if ($menu === 'payments') {
	$payments = 'class="active"';
}
?>

<?php 
$user = $this->Auth->user();
?>
<div class="navbar navbar-default navbar-fixed-top">
  	<div class="container">
    	<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div class="navbar-brand">
                <img src="http://fakeimg.pl/50x20/000000/?text=GKJ Gayamprit" class="img-responsive" alt="GKJ Gayamprit" title="GKJ Gayamprit">
                <?php // echo $this->Html->image('...', array('class' => 'navbar-brand img-responsive', 'alt' => 'GKJ Gayamprit', 'title' => 'GKJ Gayamprit'));?>
			</div>
		</div>

		<div id='navbar' class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<?php if($this->Auth->loggedIn()){ ?>
        		<li <?php echo $users ?> >
        			<a href="<?php echo $userurl; ?>">User</a>
        		</li>
        		<li <?php echo $customers ?> >
        			<a href="<?php echo $customerurl; ?>">Customer</a>
        		</li>
        		<li <?php echo $items; ?> >
        			<a href="<?php echo $itemurl; ?>">Item</a>
        		</li>
        		<li <?php echo $transactions ?> >
        			<a href="<?php echo $transactionurl; ?>">Transaction</a>
        		</li>
        		<li <?php echo $payments ?> >
        			<a href="<?php echo $paymenturl; ?>">Payment</a>
        		</li>
                <?php } ?>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li id='navbar-login'>
					<?php if($user){?>
					<a href="<?php echo $logouturl; ?>" class='logout'><span>Logout, <?php echo $user['display_name'];?></span></a>
					<?php } else { 
						if(strpos($this->request->here(), "login") === FALSE)
						echo $this->Html->link('Login',
                            array('controller' => 'users', 'action'=>'login'),
						    array('escape' => false)
						);
					} ?>
				</li>
			</ul>
		</div>
  	</div>
</div>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title ?></title>

	<?php
		echo $this->Html->css(array('cake.generic','bootstrap.min', 'sticky-footer'));
		echo $this->Html->script(array('jquery-2.1.3.min','bootstrap.min'));
	?>
</head>
<body>
	<div id="wrap">

		<div class="container">
			<?php
			echo $this->Session->Flash();
			echo $this->fetch('content');
			?>
		</div>

		<footer class='footer'>
		<?php
		echo $this->element('footer');
		?>
		</footer>
	</div>
</body>
</html>

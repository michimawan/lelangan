<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title ?></title>
    <?php
		echo $this->Html->css(array('cake.generic','bootstrap.min', 'print'));
		echo $this->Html->script(array('jquery-2.1.3.min'));
    ?>
</head>
<body>
    <div id="container">
        <?php
        echo $this->fetch('content');
        ?>
	</div>
</body>
</html>

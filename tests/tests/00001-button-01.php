<?php
$button = bsc::create('button',array('label'=>'button-01'));
file_put_contents($output_path,$button->render());
?>
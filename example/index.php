<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="FPHP_Fields">
	<meta name="author" content="Leonardo Mauro">
	
	<title>FPHP_Fields: Simple</title>
	
	<!-- Jquery Validate Includes -->
	<script src="../dist/js/jquery.min.js"></script>
	<script src="../dist/js/validate/jquery.validate.min.js"></script>
	<!-- <script src="../dist/js/validate/jquery.validate-messages-pt-br.js"></script> Brazilian Language -->
	<script src="../dist/js/validate/jquery.validate-auto.js"></script>
</head>

<body>
<?php

/* Autoload Include */
require('../dist/php/autoload.php');

use \FPHP\Fields\InputField;
use \FPHP\Fields\BoxesField;
use \FPHP\Fields\SelectField;
use \FPHP\Fields\TextareaField;
use \FPHP\Fields\ButtonField;
use \FPHP\Fields\FormField;

/** 
* Example: Litle example to show some methods
*/

$input = new InputField('text', ['name'=>'full_name', 'validate'=>['required'=>true, 'minlength'=>10]], 'Name');
//$input->construct_field();	//<= echo the 'input' tag
//$input->get_field();			//<= get the 'input' tag

$checkbox = new BoxesField('checkbox', 'boxes', 'Boxes Example');
$checkbox_data = [
	['text'=>'abc', 'value'=>0, 'attr'=>['validate'=>['required'=>true]]],
	['text'=>'bcd', 'value'=>1]
];
$checkbox->add_boxes($checkbox_data, [1]);
$checkbox->add_box('cde', 2);
//$checkbox->construct_field();

$select = new SelectField(['name'=>'foo', 'id'=>'foo', 'validate'=>['required'=>true, 'min'=>1]], 'Number Select');
$select_data = [
	['text'=>'Zero', 'value'=>0],
	['text'=>'One', 'value'=>1]
];
$select->add_options($select_data, [0]);
$select->add_option('Two - new', 2);
//$select->construct_field();

$textarea = new TextareaField('Big Text', ['id'=>'textbig', 'name'=>'textbig', 'rows'=>5]);
//$textarea->construct_field();

$button = new ButtonField('submit', 'Send');
//$button->construct_field();

$form = new FormField(['action'=>'#', 'method'=>'get', 'id'=>'form_example', 'name'=>'form_example']);
$fields = [$checkbox, $select, $textarea, $button];
$form->add_field($input);
$form->add_fields($fields);
$form->construct_form();

?>

</body>
</html>
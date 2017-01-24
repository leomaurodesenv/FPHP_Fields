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
	<script src="../dist/js/jquery.validate.min.js"></script>
	<!-- <script src="../dist/js/jquery.validate-messages-pt-br.js"></script> Brazilian Language -->
	<script src="../dist/js/jquery.validate-auto.js"></script>
</head>

<body>
<?php

/* Class Includes */
require_once('../dist/php/interface.field.php');
require_once('../dist/php/error.parser.fields.php');
require_once('../dist/php/class.master.php');
require_once('../dist/php/class.input.php');
require_once('../dist/php/class.boxes.php');
require_once('../dist/php/class.select.php');
require_once('../dist/php/class.textarea.php');
require_once('../dist/php/class.button.php');
require_once('../dist/php/class.form.php');

/** 
* Example: Litle example to show some methods
*/

$input = new Field_Input('text', array('name'=>'full_name', 'id'=>'full_name', 'validate'=>['required'=>true, 'minlength'=>10]), 'Name');
//$input->construct_field();	//<= echo the 'input' tag
//$input->get_field();			//<= get the 'input' tag

$checkbox = new Field_Boxes('checkbox', 'boxes', 'Boxes Example');
$checkbox_data = array(
	array('text'=>'abc', 'value'=>0, 'attr'=>['validate'=>['required'=>true]]),
	array('text'=>'bcd', 'value'=>1)
);
$checkbox->add_boxes($checkbox_data, array(1));
$checkbox->add_box('cde', 2);
//$checkbox->construct_field();

$select = new Field_Select(array('name'=>'foo', 'id'=>'foo', 'validate'=>['required'=>true, 'min'=>1]), 'Number Select');
$select_data = array(
	array('text'=>'Zero', 'value'=>0),
	array('text'=>'One', 'value'=>1)
);
$select->add_options($select_data, array(0));
$select->add_option('Two - new', 2);
//$select->construct_field();

$textarea = new Field_Textarea('Big Text', array('id'=>'textbig', 'name'=>'textbig', 'rows'=>5));
//$textarea->construct_field();

$button = new Field_Button('submit', 'Send');
//$button->construct_field();

$form = new FPHP_form(array('action'=>'#', 'method'=>'get', 'id'=>'form_example', 'name'=>'form_example'));
$fields = array($checkbox, $select, $textarea, $button);
$form->add_field($input);
$form->add_fields($fields);
$form->construct_form();

?>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="FPHP_Fields">
	<meta name="author" content="Leonardo Mauro">
	
	<title>FPHP_Fields: Bootstrap</title>
	
	<!-- Jquery Validate Includes -->
	<script src="../dist/js/jquery.min.js"></script>
	<script src="../dist/js/validate/jquery.validate.min.js"></script>
	<!-- <script src="../dist/js/validate/jquery.validate-messages-pt-br.js"></script> Brazilian Language -->
	<script src="../dist/js/validate/jquery.validate-auto.js"></script>

	<!-- Bootstrap - Latest compiled and minified CSS and JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<style>
.jumbotron{margin:30px auto;padding:30px 40px; width:400px;}
h3{margin:0;}
label.error{width:100%;color:#d22626;font-weight:normal;font-style:italic;margin:6px 0;}
</style>

</head>
<body>
<div class="jumbotron">
<h3>Bootstrap Example</h3>
<br/>

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
* Example: Same fields used in /example/index.php, but with style bootstrap
*/

$input = new InputField('text', ['name'=>'full_name', 'id'=>'full_name', 'validate'=>['required'=>true, 'minlength'=>10], 'class'=>'form-control'], 'Name');

$checkbox = new BoxesField('checkbox', 'boxes', 'Boxes Example');
$checkbox_data = [
	['text'=>'abc', 'value'=>0, 'attr'=>['validate'=>['required'=>true]]],
	['text'=>'bcd', 'value'=>1]
];
$checkbox->add_boxes($checkbox_data, [1]);
$checkbox->add_box('cde', 2);

$select = new SelectField(['name'=>'foo', 'id'=>'foo', 'class'=>'form-control', 'validate'=>['required'=>true, 'min'=>1]], 'Number Select');
$select_data = [
	['text'=>'Zero', 'value'=>0],
	['text'=>'One', 'value'=>1]
];
$select->add_options($select_data, [0]);
$select->add_option('Two - new', 2);

$textarea = new TextareaField('Big Text', ['id'=>'textbig', 'name'=>'textbig', 'rows'=>5, 'class'=>'form-control']);

$button = new ButtonField('submit', 'Send', ['class'=>'btn btn-primary']);

$form = new FormField(['action'=>'#', 'method'=>'get', 'id'=>'form_example', 'name'=>'form_example']);
$fields = [$input, $checkbox, $select, $textarea, $button];
$form->add_fields($fields);
$form->construct_form();

?>

</div>
</body>
</html>
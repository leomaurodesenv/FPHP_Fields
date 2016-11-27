<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<style>
.jumbotron{margin:30px auto;padding:30px 40px; width:400px;}
h3{margin:0;}
</style>

</head>
<body>
<div class="jumbotron">
<h3>Bootstrap Example</h3>
<br/>
<?php

/* Class Includes */
require_once('../dist/interface.field.php');
require_once('../dist/error.parser.php');
require_once('../dist/class.master.php');
require_once('../dist/class.input.php');
require_once('../dist/class.boxes.php');
require_once('../dist/class.select.php');
require_once('../dist/class.button.php');
require_once('../dist/class.textarea.php');
require_once('../dist/class.form.php');


/** 
* Example: Same fields used in /example/index.php, but with style bootstrap
*/

$input = new Field_Input('text', array('name'=>'full_name', 'id'=>'full_name', 'class'=>'form-control'), 'Name');

$checkbox = new Field_Boxes('checkbox', 'shopping', 'Mega Shopping');
$checkbox_data = array(
	array('text'=>'abc', 'value'=>0),
	array('text'=>'bcd', 'value'=>1),
	array('text'=>'klm', 'value'=>2)
);
$checkbox->add_boxes($checkbox_data, array(0, 1));
$checkbox->add_box('lmn', 3);

$select = new Field_Select(array('name'=>'foo', 'id'=>'foo', 'class'=>'form-control'), 'Foo Select');
$select_data = array(
	array('text'=>'abc', 'value'=>0),
	array('text'=>'cba', 'value'=>1)
);
$select->add_options($select_data, array(0));
$select->add_option('new', 2);

$button = new Field_Button('submit', 'Send', array('class'=>'btn btn-primary'));

$textarea = new Field_Textarea('Big Text', array('id'=>'textbig', 'name'=>'textbig', 'rows'=>5, 'class'=>'form-control'));

$form = new FPHP_form(array('action'=>'#', 'method'=>'get', 'id'=>'form_example', 'name'=>'form_example'));
$fields = array($input, $checkbox, $select, $textarea, $button);
$form->add_fields($fields);
$form->construct_form();

?>
</div>
</body>
</html>
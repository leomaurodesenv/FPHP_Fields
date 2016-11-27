<?php

/* Set header just to this example */
header('Content-Type: text/plain');

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
* Example: Litle example to show some methods
*/

$input = new Field_Input('text', array('name'=>'full_name', 'id'=>'full_name'), 'Name');
//$input->construct_field();	<= echo the 'input' tag
//$input->get_field();			<= get the 'input' tag

$checkbox = new Field_Boxes('checkbox', 'shopping', 'Mega Shopping'); // boxes => checkbox or radio
$checkbox_data = array(
	array('text'=>'abc', 'value'=>0),
	array('text'=>'bcd', 'value'=>1),
	array('text'=>'klm', 'value'=>2)
);
$checkbox->add_boxes($checkbox_data, array(0, 1)); // add multiples box
$checkbox->add_box('lmn', 3); // add one box
//$checkbox->construct_field();

$select = new Field_Select(array('name'=>'foo', 'id'=>'foo'), 'Foo Text');
$select_data = array(
	array('text'=>'abc', 'value'=>0),
	array('text'=>'cba', 'value'=>1)
);
$select->add_options($select_data, array(1)); // add multiples options
$select->add_option('new', 2); // add one option
//$select->construct_field();

$button = new Field_Button('submit', 'Send');
//$button->construct_field();

$textarea = new Field_Textarea('Big Text', array('id'=>'textbig', 'name'=>'textbig'));
//$textarea->construct_field();

$form = new FPHP_form(array('action'=>'#', 'method'=>'get', 'id'=>'form_example', 'name'=>'form_example'));
$fields = array($input, $checkbox, $select, $textarea, $button);
$form->add_fields($fields);
$form->construct_form(); // <= echo all form, fields and buttons

?>
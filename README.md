# FPHP_Fields #

Links:      
[API Documentation](http://doc.leonardomauro.com/fphp/)
   
Class from package FPHP.   

This class can compose in PHP and render in HTML standard fields forms, like: checkbox, radio, inputs, select, textarea and button.   
Each field have your specific class, and you can modify and customize with your styles (have an example with Bootstrap).   
Also include a class with error parser, case you access any class/function using absence or wrong values.   
   
## Example  
Example: Litle example to show some methods   
   
```php
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
```

## Also look ~  	
* [License GPL v2][gpl]
* Create by Leonardo Mauro ([leo.mauro.desenv@gmail.com][email])
* Git: [leomaurodesenv][git]
* Site: [Portfolio][leomauro]
   
[gpl]: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
[email]: leo.mauro.desenv@gmail.com
[git]: https://github.com/leomaurodesenv/
[leomauro]: http://leonardomauro.com/portfolio/
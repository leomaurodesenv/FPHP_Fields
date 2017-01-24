# FPHP_Fields #

Links:      
[API Documentation](http://doc.leonardomauro.com/fphp/) and [PHP Classes](http://www.phpclasses.org/fphp_fields)   
[Simple Online Example](http://projects.leonardomauro.com/FPHP_Fields/example/index.php) and [Bootstrap Online Example](http://projects.leonardomauro.com/FPHP_Fields/example/index.bootstrap.php)   
   
Class from package FPHP.   

**New**: Have a automatic integration with [jquery.validate.js](https://jqueryvalidation.org) methods for all fields.   
**Fixed**: Problem with boxes; better way to create labels.   
   
This class can compose in PHP and render in HTML standard fields forms, like: checkbox, radio, inputs, select, textarea and button.   
Each field have your specific class, and you can modify and customize with your styles (have an example with Bootstrap).     
Also include a class with error parser, case you access any class/function using absence or wrong values.   
   
## Example  
Example: Litle example to show some methods. See others examples in ./example/   
   
```php
$input = new Field_Input('text', array('name'=>'full_name', 'id'=>'full_name', 'validate'=>['required'=>true, 'minlength'=>10]), 'Name');   
//$input->construct_field();	<= echo the 'input' tag   
//$input->get_field();			<= get the 'input' tag   

$checkbox = new Field_Boxes('checkbox', 'boxes', 'Boxes Example'); // boxes => checkbox or radio   
$checkbox_data = array(   
	array('text'=>'abc', 'value'=>0),   
	array('text'=>'bcd', 'value'=>1),   
	array('text'=>'klm', 'value'=>2)   
);   
$checkbox->add_boxes($checkbox_data, array(0, 1)); // add multiples box   
$checkbox->add_box('lmn', 3); // add one box   
//$checkbox->construct_field();   

$form = new FPHP_form(array('action'=>'#', 'method'=>'get', 'id'=>'form_example', 'name'=>'form_example'));   
$fields = array($input, $checkbox);   
$form->add_fields($fields);   
$form->construct_form(); // <= echo all form, fields and buttons   
```

## Also look ~  	
* [License GPL v2](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
* Create by Leonardo Mauro (leo.mauro.desenv@gmail.com)
* Git: [leomaurodesenv](https://github.com/leomaurodesenv/)
* Site: [Portfolio](http://leonardomauro.com/portfolio/)

# FPHP_Fields #

Links:      
[PHP Classes](http://www.phpclasses.org/fphp_fields) and [Github](https://github.com/leomaurodesenv/FPHP_Fields)   
   
[Simple Online Example](http://projects.leonardomauro.com/FPHP_Fields/example/index.php) and [Bootstrap Online Example](http://projects.leonardomauro.com/FPHP_Fields/example/index.bootstrap.php)   
   
Class from package FPHP.   
   
**New**: Have a automatic integration with [jquery.validate.js](https://jqueryvalidation.org) methods for all fields.   
   
**Fixed**: Problem with boxes; better way to create labels.   
   
___
   
This class can compose in PHP and render in HTML standard fields forms, like: checkbox, radio, inputs, select, textarea and button.   
Each field have your specific class, and you can modify and customize with your styles (have an example with Bootstrap).     
Also include a class with error parser, case you access any class/function using absence or wrong values.   
   
___

```
/php/
  |__ /fphp/
  |     |__ /fields/
  |            |__ ErrorParserFields.php
  |            |__ FieldInterface.php
  |            |__ MasterFields.php
  |            |__ InputField.php
  |            |__ BoxesField.php
  |            |__ SelectField.php
  |            |__ TextareaField.php
  |            |__ ButtonField.php
  |            |__ FormField.php
  |__ /example/

/js/
  |__ jquery.min.js
  |__ /validate/
        |__ jquery.validate.min.js
        |__ jquery.validate-auto.js
        |__ jquery.validate-messages-pt-br.js
```
   
* /php/fphp/fields/: Classes to render each field and error parser;   
* jquery.validate-auto.js: automatic the validation;   
* jquery.validate-messages-pt-br.js: change the messages to portuguese language;  
   
___
   
## Example  
Example: Litle example to show some methods. See others examples in *./example/*   
   
```php
require('../dist/php/autoload.php');
use \FPHP\Fields\InputField;
use \FPHP\Fields\FormField;

$input = new InputField('text', array('name'=>'full_name', 'validate'=>['required'=>true, 'minlength'=>10]), 'Name');
//$input->construct_field();	//<= echo the 'input' tag
//$input->get_field();			//<= get the 'input' tag

$form = new FormField(array('action'=>'#', 'method'=>'get', 'name'=>'form_example'));
$form->add_field($input);
$form->construct_form();
```
   
___
   
## Also look ~  	
* [License GPL v2](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
* Create by Leonardo Mauro (leo.mauro.desenv@gmail.com)
* Git: [leomaurodesenv](https://github.com/leomaurodesenv/)
* Site: [Portfolio](http://leonardomauro.com/portfolio/)

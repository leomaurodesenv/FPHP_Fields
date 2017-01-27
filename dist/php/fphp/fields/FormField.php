<?php

/** 
 * This class rendering a <form> tag and your fields
 * 
 * @author Leonardo Mauro <leo.mauro.desenv@gmail.com>
 * @link https://github.com/leomaurodesenv/FPHP_Fields GitHub
 * @link https://www.phpclasses.org/fphp-fields PHP Classes
 * @license https://opensource.org/licenses/GPL-2.0 GNU Public License (GPL v2)
 * @copyright 2016 Leonardo Mauro
 * @version 2.2.0 17-01-27
 * @package FPHP_Fields
 * @access public
 */

namespace FPHP\Fields;

use \FPHP\Fields\MasterFields;
use \FPHP\Fields\ErrorParserFields as Error;

class FormField extends MasterFields {
	
	/** 
	 * Variables description.
	 * @var array $attr			Attributes of 'form'.
	 * @var array $fields		Fields and buttons of 'form'.
	 * 
	 * @var bool $_is_active	Active or deactivate the objectClass.
	 */ 
	private $attr;
	private $fields;
    
	private $_is_active;
	
	/**
	 * Construct.
	 * @access public
	 * @param array $in_attr	Set attributes of button. [optional]
	 * @return self
	 */
	public function __construct($in_attr=false) {
		/* Create templates and authenticate information */
		$valid = true;
		$template_attr = [
			'action'		=> false,
			'method'		=> false,
			'target'		=> false,
			'id'			=> false,
			'name'			=> false,
			'class'			=> false,
			'style'			=> false,
			'autocomplete'	=> false
		];
		$auth_attr = [
			'action'		=> ['required'=>true, 'type'=>'text'],
			'method'		=> ['required'=>true, 'pattern'=>['get', 'post']],
			'target'		=> ['pattern'=>['_blank', '_self', '_parent', '_top']],
			'id'			=> ['type'=>'text'],
			'name'			=> ['required'=>true, 'type'=>'text'],
			'class'			=> ['type'=>'text'],
			'style'			=> ['type'=>'text'],
			'autocomplete'	=> ['pattern'=>['on', 'off']]
		];
		parent::template_data($attr_t, $template_attr, $in_attr);
		
		foreach($template_attr as $key => $value)
		parent::authenticate_data($auth_attr[$key], $attr_t[$key], 'construct ('.$key.')', $valid, false);
		
		/* Authenticated and saved information */
		if(!$valid){ self::destruct_obj(); return; }
		
		$this->attr = $attr_t;
		$this->fields = [];
		
		$this->_is_active = true;	
	}
	
	/**
	 * Set the objectClass unuseble.
	 * @access private
	 * @return void
	 */
	private function destruct_obj() {
		Error::dump($this, Error::E_DESTROYING);
		$this->_is_active = false;
	}
	
	/**
	 * Callbacks.
	 * @access public
	 * @param string $name			Name of function called.
	 * @param array $arguments		Arguments to use in function called.
	 * @return self::method
	 */
	public function __call($name, $arguments) {
		if($this->_is_active)
			return call_user_func_array([$this, '_'.$name], $arguments);
    }
	
	/**
	 * Add fields to the form.
	 * @access public
	 * @param array $in_field		Add field|button.
	 * @return void
	 */
	public function _add_field($in_field=false) {
		/* Field is object */
		if(!is_object($in_field)){ Error::dump($this, Error::E_INCONSISTENT, 'is not object'); return; }
		$class_field = get_class($in_field);
		
		$valid = true;
		
		$auth_field	= ['pattern'=>['FPHP\Fields\InputField', 'FPHP\Fields\BoxesField', 'FPHP\Fields\SelectField', 'FPHP\Fields\TextareaField', 'FPHP\Fields\ButtonField']];
		parent::authenticate_data($auth_field, $class_field, 'add_field (field)', $valid);
		
		/* Authenticated and saved information */
		if(!$valid) return;
		$this->fields[] = $in_field;
	}
	
	/**
	 * Add group of fields to the form.
	 * @access public
	 * @param array $in_fields		Add group of fields|buttons.
	 * @return void
	 */
	public function _add_fields($in_fields=false) {
		/* Authenticate information */
		if(!parent::is_arrayt($in_fields)){ Error::dump($this, Error::E_INCONSISTENT, 'is not array'); return; }
		
		/* Try add $field */
		foreach($in_fields as $key => $field){
			self::_add_field($field);
		}
	}
	
	/**
	 * Construct 'form' and your fields.
	 * @access public
	 * @return string
	 */
	public function _construct_form(){
		$out = '<form fphp-auto-validate="true"'.parent::get_attributes($this->attr).'>'.PHP_EOL;
		foreach($this->fields as $key => $field){
			if(method_exists($field,'_get_field'))
				$out .= $field->_get_field($this->attr['id']);
		}
		$out .= '</form>'.PHP_EOL;
		
		echo $out;
	}
	
}

?>
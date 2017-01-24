<?php

/** 
* Class FPHP_form
* This class create 'form' tag
* 
* @author Leonardo Mauro <leo.mauro.desenv@gmail.com>
* @link http://leonardomauro.com/portfolio/	Portfolio of Leonardo Mauro
* @version 1.2.1
* @copyright © 2016 Leonardo Mauro
* @license https://opensource.org/licenses/GPL-2.0 GNU Public License (GPL v2)
* @package FPHP_fields
* @access public
*/ 
class FPHP_form extends FPHP_Master_Fields{
	
	/** 
	* Variables description.
	* @var array() $attr			Attributes of 'form'.
	* @var array() $fields			Fields and buttons of 'form'.
	* 
	* @var bool $_is_active			Active or deactivate the objectClass.
	*/ 
	private $attr;
	private $fields;
    
	private $_is_active;
	
	/**
	* Construct of class FPHP_form.
	* @access public
	* @param array() $in_attr			Set attributes of button. [optional]
	*/
	public function __construct($in_attr=false){
		/* Create templates and authenticate information */
		$valid = true;
		$template_attr = array(
			'action'		=> false,
			'method'		=> false,
			'target'		=> false,
			'id'			=> false,
			'name'			=> false,
			'class'			=> false,
			'style'			=> false,
			'autocomplete'	=> false
		);
		$auth_attr  = array(
			'action'		=> array('required'=>true, 'type'=>'text'),
			'method'		=> array('required'=>true, 'pattern'=>array('get', 'post')),
			'target'		=> array('pattern'=>array('_blank', '_self', '_parent', '_top')),
			'id'			=> array('required'=>true, 'type'=>'text'),
			'name'			=> array('required'=>true, 'type'=>'text'),
			'class'			=> array('type'=>'text'),
			'style'			=> array('type'=>'text'),
			'autocomplete'	=> array('pattern'=>array('on', 'off'))
		);
		parent::template_data($attr_t, $template_attr, $in_attr);
		
		foreach($template_attr as $key => $value)
		parent::authenticate_data($auth_attr[$key], $attr_t[$key], 'construct ('.$key.')', $valid, false);
		
		/* Authenticated and saved information */
		if(!$valid){ self::destruct_obj(); return; }
		
		$this->attr = $attr_t;
		$this->fields = array();
		
		$this->_is_active = true;	
	}
	
	/**
	* Set the objectClass (FPHP_form) unuseble.
	* @access private
	*/
	private function destruct_obj(){
		parent::dump_error($this, E_FPHP_Fields::E_DESTROYING);
		$this->_is_active = false;
	}
	
	/**
	* Callbacks of class FPHP_form.
	* @access public
	* @param string $name			Name of function called.
	* @param array() $arguments		Arguments to use in function called.
	*/
	public function __call($name, $arguments){
		if($this->_is_active)
			return call_user_func_array(array($this, '_'.$name), $arguments);
    }
	
	/**
	* Add fields to the form.
	* @access public
	* @param array() $in_field			Add field|button.
	*/
	public function _add_field($in_field=false){
		/* Field is object */
		if(!is_object($in_field)){ parent::dump_error($this, E_FPHP_Fields::E_INCONSISTENT, 'is not object'); return; }
		$class_field = get_class($in_field);
		
		$valid = true;
		$auth_field	= array('pattern'=>array('Field_Input', 'Field_Boxes', 'Field_Select', 'Field_Textarea', 'Field_Button'));
		parent::authenticate_data($auth_field, $class_field, 'add_field (field)', $valid);
		
		/* Authenticated and saved information */
		if(!$valid) return;
		$this->fields[] = $in_field;
	}
	
	/**
	* Add group of fields to the form.
	* @access public
	* @param array() $in_fields			Add group of fields|buttons.
	*/
	public function _add_fields($in_fields=false){
		/* Authenticate information */
		if(!parent::is_arrayt($in_fields)){ parent::dump_error($this, E_FPHP_Fields::E_INCONSISTENT, 'is not array'); return; }
		
		/* Try add $field */
		foreach($in_fields as $key => $field){
			self::_add_field($field);
		}
	}
	
	/**
	* Construct 'form' and your fields.
	* @access public
	*/
	public function _construct_form(){
		
		$out = '<form fphp-auto-validate'.parent::get_attributes($this->attr).'>'.PHP_EOL;
		foreach($this->fields as $key => $field){
			if(method_exists($field,'_get_field'))
				$out .= $field->_get_field($this->attr['id']);
		}
		$out .= '</form>'.PHP_EOL;
		
		echo $out;
	}
}

?>
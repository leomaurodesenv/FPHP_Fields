<?php

/** 
* Class Field_Textarea
* This class create <textarea> tag
* 
* @author Leonardo Mauro <leo.mauro.desenv@gmail.com>
* @link http://leonardomauro.com/portfolio/	Portfolio of Leonardo Mauro
* @version 1.2.1
* @copyright © 2016 Leonardo Mauro
* @license https://opensource.org/licenses/GPL-2.0 GNU Public License (GPL v2)
* @package FPHP_fields
* @access public
*/ 
class Field_Textarea extends FPHP_Master_Fields implements interface_field{
	
	/** 
	* Variables description.
	* @var string	$label			Label of 'textarea'.
	* @var array()	$attr			Attributes of 'textarea'.
	* @var string	$value			Text inside of 'textarea'.
	* 
	* @var bool		$_is_active		Active or deactivate the objectClass.
	* @var bool		$_br			Verify if allow break lines/PHP_EOL.
	*/ 
	private $label;
	private $attr;
	private $value;
    
	private $_is_active;
	private $_br;
	
	/**
	* Construct of class Field_Textarea.
	* @access public
	* @param string		$in_label	Set label for 'textarea' tag. [optional]
	* @param array()	$in_attr	Set attributes of 'textarea'. [optional]
	* @param string		$in_value	Set text of 'textarea'. [optional]
	* @param bool		$br			Allow or block breaklines/PHP_EOL. [optional]
	*/
    public function __construct($in_label=false, $in_attr=false, $in_value=false, $br=true){
		/* Create templates and authenticate information */
		$valid = true;
		$template_attr = array(
			'id'		=> false,
			'name'		=> false,
			'validate'	=> false,
			'class'		=> false,
			'style'		=> false,
			'cols'		=> false,
			'rows'		=> false
		);
		$auth_attr  = array(
			'id'		=> array('required'=>true, 'type'=>'text'),
			'name'		=> array('required'=>true, 'type'=>'text'),
			'validate'	=> array('type'=>'array'),
			'class'		=> array('type'=>'text'),
			'style'		=> array('type'=>'text'),
			'cols'		=> array('type'=>'int'),
			'rows'		=> array('type'=>'int')
		);
		parent::template_data($attr_t, $template_attr, $in_attr);
		
		$auth_label	= array('type'=>'text');
		$auth_value	= array('type'=>'text');
		parent::authenticate_data($auth_label, $in_label, 'construct (label)', $valid, false);
		parent::authenticate_data($auth_value, $in_value, 'construct (value)', $valid, false);
		foreach($template_attr as $key => $value)
		parent::authenticate_data($auth_attr[$key], $attr_t[$key], 'construct ('.$key.')', $valid, false);
		
		/* Authenticated and saved information */
		if(!$valid){ self::destruct_obj(); return; }
		
		$this->label = $in_label;
		$this->attr = $attr_t;
		$this->value = $in_value;

		$this->_is_active = true;
		$this->_br = (bool) $br;	
	}
	
	/**
	* Set the objectClass (Field_Textarea) unuseble.
	* @access private
	*/
	private function destruct_obj(){
		parent::dump_error($this, E_FPHP_Fields::E_DESTROYING);
		$this->_is_active = false;
	}
	
	/**
	* Callbacks of class Field_Textarea.
	* @access public
	* @param string		$name		Name of function called.
	* @param array()	$arguments	Arguments to use in function called.
	*/
	public function __call($name, $arguments){
		if($this->_is_active)
			return call_user_func_array(array($this, '_'.$name), $arguments);
    }
	
	/**
	* Construct the 'textarea' field.
	* @method string _construct_field($form_id)
	* @access public
	*/
    public function _construct_field($form_id=false){
		$out = self::_get_field($form_id);
		echo $out;
	}
	
	/**
	* Return the 'textarea' field for forms.
	* @method string _get_field($form_id)
	* @access public
	*/
	public function _get_field($form_id=false){
		$form = ($form_id != false && parent::is_stringt($form_id)) ? ' form="'.$form_id.'"' : '';
		$out = self::_get_label();
		$out .= '<textarea'.parent::get_attributes($this->attr).'>'.PHP_EOL;
		if(parent::is_stringt($this->value)) $out .= $this->value.PHP_EOL;
		$out .= '</textarea>'.PHP_EOL;
		
		if($this->_br) $out .= '<br/>'.PHP_EOL;
		return $out;
	}
	
	/**
	* Return the label of 'textarea' field.
	* @method string _get_label($in_attr)
	* @access public
	*/
	public function _get_label($in_attr=false){
		return parent::construct_label($this->attr['id'], $this->label, $in_attr);
	}
}

?>
<?php

/** 
* Class FPHP_button
* This class create 'button' tag
* 
* @author Leonardo Mauro <leo.mauro.desenv@gmail.com>
* @link http://leonardomauro.com/portfolio/	Portfolio of Leonardo Mauro
* @version 1.1.0
* @copyright © 2016 Leonardo Mauro
* @license https://opensource.org/licenses/GPL-2.0 GNU Public License (GPL v2)
* @package FPHP_fields
* @access public
*/ 
class Field_Button extends FPHP_Master_Fields implements interface_field{
	
	/** 
	* Variables description.
	* @var string $type				Type of 'button'.
	* @var string $text				Text of 'button'.
	* @var array() $attr			Attributes of 'button'.
	* 
	* @var bool $_is_active			Active or deactivate the objectClass.
	* @var bool $_br				Verify if allow break lines/PHP_EOL.
	*/ 
	private $type;
	private $text;
	private $attr;
    
	private $_is_active;
	private $_br;
	
	/**
	* Construct of class FPHP_button.
	* @access public
	* @param string $in_type			Set 'button' type. [optional]
	* @param string $in_text			Set text for 'button' tag. [optional]
	* @param array() $in_attr			Set attributes of 'button'. [optional]
	* @param bool $br					Allow or block breaklines/PHP_EOL. [optional]
	*/
    public function __construct($in_type=false, $in_text=false, $in_attr=false, $br=true){
		/* Create templates and authenticate information */
		$valid = true;
		$template_attr = array(
			'id'		=> false,
			'name'		=> false,
			'class'		=> false,
			'style'		=> false,
			'value'		=> false,
			'disabled'	=> false
		);
		$auth_attr  = array(
			'id'		=> array('type'=>'text'),
			'name'		=> array('type'=>'text'),
			'class'		=> array('type'=>'text'),
			'style'		=> array('type'=>'text'),
			'value'		=> array('type'=>'text'),
			'disabled'	=> array('type'=>'bool')
		);
		parent::template_data($attr_t, $template_attr, $in_attr);
		
		$auth_type 	= array('required'=>true, 'pattern'=>array('button', 'reset', 'submit'));
		$auth_text	= array('required'=>true, 'type'=>'text');
		parent::authenticate_data($auth_type, $in_type, 'construct (type)', $valid);
		parent::authenticate_data($auth_text, $in_text, 'construct (text)', $valid);
		foreach($template_attr as $key => $value)
		parent::authenticate_data($auth_attr[$key], $attr_t[$key], 'construct ('.$key.')', $valid, false);
		
		/* Authenticated and saved information */
		if(!$valid){ self::destruct_obj(); return; }
		
		$this->type = $in_type;
		$this->text = $in_text;
		$this->attr = $attr_t;
		$this->options = array();
		
		$this->_is_active = true;
		$this->_br = (bool) $br;
	}
	
	/**
	* Set the objectClass (FPHP_button) unuseble.
	* @access private
	*/
	private function destruct_obj(){
		parent::dump_error($this, E_FPHP_Fields::E_DESTROYING);
		$this->_is_active = false;
	}
	
	/**
	* Callbacks of class FPHP_button.
	* @access public
	* @param string $name			Name of function called.
	* @param array() $arguments		Arguments to use in function called.
	*/
	public function __call($name, $arguments){
		if($this->_is_active)
			return call_user_func_array(array($this, '_'.$name), $arguments);
    }
	
	/**
	* Construct the 'button' field.
	* @method string _construct_field($form_id)
	* @access public
	*/
    public function _construct_field($form_id=false){
		$out = self::_get_field($form_id);
		echo $out;
	}
	
	/**
	* Return the 'button' field for forms.
	* @method string _get_field($form_id)
	* @access public
	*/
	public function _get_field($form_id=false){
		$form = ($form_id != false && parent::is_stringt($form_id)) ? ' form="'.$form_id.'"' : '';
		$out = self::_get_label();
		$out .= '<button type="'.$this->type.'"'.parent::get_attributes($this->attr).'>'.$this->text.'</button>';
		if($this->_br) $out .= '<br/>'.PHP_EOL;
		return $out;
	}
	
	/**
	* Return the label of 'button' field, null value.
	* @method string _get_label($in_attr)
	* @access public
	*/
	public function _get_label($in_attr=false){ return ''; }
	
}

?>

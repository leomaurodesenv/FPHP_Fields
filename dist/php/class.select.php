<?php

/** 
* Class Field_Select
* This class create <select> tag
* 
* @author Leonardo Mauro <leo.mauro.desenv@gmail.com>
* @link http://leonardomauro.com/portfolio/	Portfolio of Leonardo Mauro
* @version 1.2.1
* @copyright © 2016 Leonardo Mauro
* @license https://opensource.org/licenses/GPL-2.0 GNU Public License (GPL v2)
* @package FPHP_fields
* @access public
*/ 
class Field_Select extends FPHP_Master_Fields implements interface_field{
	
	/** 
	* Variables description.
	* @var string	$label			Title of 'select'.
	* @var array()	$attr			Attributes of 'select'.
	* @var array()	$options		Options of 'select'.
	* 
	* @var bool		$_is_active		Active or deactivate the objectClass.
	* @var bool		$_br			Verify if allow break lines/PHP_EOL.
	*/ 
	private $label;
	private $attr;
	private $options;
    
	private $_is_active;
	private $_br;
	
	/**
	* Construct of class Field_Select.
	* @access public
	* @param string	$in_attr	Set attr of 'select'. [optional]
	* @param string	$in_label	Set label text for 'select' tag. [optional]
	* @param bool	$br			Allow or block breaklines/PHP_EOL. [optional]
	*/
    public function __construct($in_attr=false, $in_label=false, $br=true){
		/* Create templates and authenticate information */
		$valid = true;
		$template_attr = array(
			'id'		=> false,
			'name'		=> false,
			'validate'	=> false,
			'class'		=> false,
			'size'		=> false,
			'disabled'	=> false
		);
		$auth_attr  = array(
			'id'		=> array('required'=>true, 'type'=>'text'),
			'name'		=> array('required'=>true, 'type'=>'text'),
			'validate'	=> array('type'=>'array'),
			'class'		=> array('type'=>'text'),
			'size'		=> array('type'=>'int'),
			'disabled'	=> array('type'=>'bool')
		);
		parent::template_data($attr_t, $template_attr, $in_attr);
		
		$auth_label = array('type'=>'text');
		parent::authenticate_data($auth_label, $in_label, 'construct (label)', $valid, false);
		foreach($template_attr as $key => $value)
		parent::authenticate_data($auth_attr[$key], $attr_t[$key], 'construct ('.$key.')', $valid, false);
		
		/* Authenticated and saved information */
		if(!$valid){ self::destruct_obj(); return; }
		
		$this->label = $in_label;
		$this->attr = $attr_t;
		$this->options = [0=>['text'=>'Select', 'value'=>'', 'attr'=>false]];
		/*$this->options = []; // <= orign */
		
		$this->_is_active = true;
		$this->_br = (bool) $br;
	}
	
	/**
	* Set the objectClass (Field_Select) unuseble.
	* @access private
	*/
	private function destruct_obj(){
		parent::dump_error($this, E_FPHP_Fields::E_DESTROYING);
		$this->_is_active = false;
	}
	
	/**
	* Callbacks of class Field_Select.
	* @access public
	* @param string		$name		Name of function called.
	* @param array()	$arguments	Arguments to use in function called.
	*/
	public function __call($name, $arguments){
		if($this->_is_active)
			return call_user_func_array(array($this, '_'.$name), $arguments);
    }
	
	/**
	* Add new option for 'select' tag.
	* @access public
	* @param string		$in_text	Set text label for 'select'.
	* @param string		$in_value	Set value of 'select'.
	* @param array()	$in_attr	Set attributes of 'select'. [optional]
	*/
	public function _add_option($in_text=false, $in_value=false, $in_attr=false){
		/* Authenticate information */
		$valid = true;
		$template_attr = array(
			'id'		=> false,
			'class'		=> false,
			'style'		=> false,
			'label'		=> false,
			'selected'	=> false,
			'disabled'	=> false
		);
		$auth_attr  = array(
			'id'		=> array('type'=>'text'),
			'class'		=> array('type'=>'text'),
			'style'		=> array('type'=>'text'),
			'label'		=> array('type'=>'text'),
			'selected'	=> array('type'=>'bool'),
			'disabled'	=> array('type'=>'bool')
		);
		
		parent::template_data($attr_t, $template_attr, $in_attr);
		
		$auth_text  = array('required'=>true, 'type'=>'text');
		$auth_value = array('required'=>true);
		parent::authenticate_data($auth_text, $in_text, 'add_option (text)', $valid);
		parent::authenticate_data($auth_value, $in_value, 'add_option (value)', $valid);
		foreach($template_attr as $key => $value)
		parent::authenticate_data($auth_attr[$key], $attr_t[$key], 'add_option ('.$key.')', $valid, false);
		
		/* Authenticated and saved information */
		if(!$valid) return;
		
		$option['text'] = $in_text;
		$option['value'] = $in_value;
		$option['attr'] = $attr_t;
		$this->options[] = $option;
	}
	
	/**
	* Add a group of options.
	* @access public
	* @param array() $in_options	Set group of 'option's to add.
	* @param array() $in_selected	Set 'option's with attribute selected. [optional]
	*/
	public function _add_options($in_options=false, $in_selected=false){
		/* Authenticate information */
		$valid = true;
		$auth_options = array('required'=>true, 'type'=>'array');
		parent::authenticate_data($auth_options, $in_options, 'construct (option)', $valid);
		if(!parent::is_arrayt($in_selected)) $in_selected = array();
		
		/* Authenticated and _add_option calls */
		if(!$valid) return;
		
		foreach($in_options as $key => $option){			
			if(parent::is_arrayt($option) && isset($option['text']) && isset($option['value'])){
				/* Verify attributes (& selected) of $option */
				if(in_array($key, $in_selected)){
					if(isset($option['attr'])) $option['attr']['selected'] = true;
					else $option['attr'] = array('selected'=>true);
				}
				if(!isset($option['attr'])) $option['attr'] = false;
				/* Try add $option */
				self::_add_option($option['text'], $option['value'], $option['attr']);
			}
			else{
				/* Dump error */
				parent::dump_error($this, E_FPHP_Fields::E_INCONSISTENT, 'add_options: ["text"] | ["value"] not exists in ['.$key.']');
				return;
			}
		}
	}
	
	/**
	* Construct the select field.
	* @method string _construct_field($form_id)
	* @access public
	*/
    public function _construct_field($form_id=false){
		$out = self::_get_field($form_id);
		echo $out;
	}
	
	/**
	* Return the 'select' field for forms.
	* @method string _get_field($form_id)
	* @access public
	*/
	public function _get_field($form_id=false){
		$form = ($form_id != false && parent::is_stringt($form_id)) ? ' form="'.$form_id.'"' : '';
		$out = self::_get_label();
		$out .= '<select'.$form.parent::get_attributes($this->attr).'>'.PHP_EOL;
		foreach($this->options as $key => $option){
			$out .= '<option value="'.$option['value'].'"'.parent::get_attributes($option['attr']).'>'.$option['text'].'</option>'.PHP_EOL;
		}
		$out .= '</select>';
		if($this->_br) $out .= '<br/>'.PHP_EOL;
		return $out;
	}
	
	/**
	* Return the label of 'select' field.
	* @method string _get_label($in_attr)
	* @access public
	*/
	public function _get_label($in_attr=false){
		return parent::construct_label($this->attr['id'], $this->label, $in_attr);
	}
	
}

?>

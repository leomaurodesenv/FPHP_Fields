<?php

/** 
* Class FPHP_input
* This class create 'input's types of 'text', 'hidden', 'password'
* 
* @author Leonardo Mauro <leo.mauro.desenv@gmail.com>
* @link http://leonardomauro.com/portfolio/	Portfolio of Leonardo Mauro
* @version 1.1.1
* @copyright © 2016 Leonardo Mauro
* @license https://opensource.org/licenses/GPL-2.0 GNU Public License (GPL v2)
* @package FPHP_fields
* @access public
*/ 
class Field_Input extends FPHP_Master_Fields implements interface_field{
	
	/** 
	* Variables description.
	* @var string $type				Type of 'input'.
	* @var array() $attr			Attributes of 'input'.
	* @var string $label			Label text for 'input'.
	* 
	* @var bool $_is_active			Active or deactivate the objectClass.
	* @var bool $_br				Verify if allow breaklines/PHP_EOL.
	*/ 
	private $type;
	private $attr;
	private $label;
    
	private $_is_active;
	private $_br;
	
	/**
	* Construct of class FPHP_input.
	* @access public
	* @param string $in_type			Set type of 'input'.
	* @param array() $in_attr			Set attributes of 'input'. [optional]
	* @param string $in_label			Set label text of 'input'. [optional]
	* @param bool $br					Allow or block breaklines/PHP_EOL. [optional]
	*/
    public function __construct($in_type=false, $in_attr=false, $in_label=false, $br=true){
		/* Create templates and authenticate information */
		$template_attr = array(
			'id'			=> false,
			'name'			=> false,
			'class'			=> false,
			'style'			=> false,
			'value' 		=> false,
			'maxlength' 	=> false,
			'placeholder' 	=> false,
			'autocomplete' 	=> false,
			'disabled' 		=> false
		);
		$auth_attr = array(
			'id'			=> array('required'=>true, 'type'=>'text'),
			'name'			=> array('required'=>true, 'type'=>'text'),
			'class' 		=> array('type'=>'text'),
			'style' 		=> array('type'=>'text'),
			'value' 		=> array('type'=>'text'),
			'maxlength' 	=> array('type'=>'int'),
			'placeholder' 	=> array('type'=>'text'),
			'autocomplete' 	=> array('pattern'=>array('on', 'off')),
			'disabled' 		=> array('type'=>'bool'),
		);
		
		$auth_type 		= array('required'=>true, 'pattern'=>array('text', 'hidden', 'password'));
		$auth_label 	= array('type'=>'text');
		
		parent::template_data($attr_t, $template_attr, $in_attr);
		
		$valid = true;
		parent::authenticate_data($auth_type, $in_type, 'construct (type)', $valid);
		parent::authenticate_data($auth_label, $in_label, 'construct (label)', $valid, false);
		foreach($template_attr as $key => $value)
		parent::authenticate_data($auth_attr[$key], $attr_t[$key], 'construct ('.$key.')', $valid, false);
		
		/* Authenticated and saved information */
		if(!$valid){ self::destruct_obj(); return; }
		
		$this->attr = $attr_t;
		$this->type = $in_type;
		$this->label = $in_label;
		
		$this->_is_active = true;
		$this->_br = (bool) $br;
	}
	
	/**
	* Set the objectClass (FPHP_input) unuseble.
	* @access private
	*/
	private function destruct_obj(){
		parent::dump_error($this, E_FPHP_Fields::E_DESTROYING);
		$this->_is_active = false;
	}
	
	/**
	* Callbacks of class FPHP_input.
	* @access public
	* @param string $name			Name of function called.
	* @param array() $arguments		Arguments to use in function called.
	*/
	public function __call($name, $arguments){
		if($this->_is_active)
			return call_user_func_array(array($this, '_'.$name), $arguments);
		/* else parent::dump_error($this, 'cant call '.$name.' function', 'invalid object'); */
    }
	
	/**
	* Construct the 'input' field.
	* @method string _construct_field($form_id)
	* @access public
	*/
    public function _construct_field($form_id=false){
		$out = self::_get_field($form_id);
		echo $out;
	}
	
	/**
	* Return the 'input' field.
	* @method string _get_field($form_id)
	* @access public
	*/
	public function _get_field($form_id=false){
		$form = ($form_id != false && parent::is_stringt($form_id)) ? ' form="'.$form_id.'"' : '';
		$out = self::_get_label();
		$out .= '<input type="'.$this->type.'"' .$form.parent::get_attributes($this->attr).'/>'.PHP_EOL;
		if($this->_br) $out .= '<br/>'.PHP_EOL;
		
		return $out;
	}
	
	/**
	* Return the label of 'input' field.
	* @method string _get_label($in_attr)
	* @access public
	*/
	public function _get_label($in_attr=false){
		/* Create templates and authenticate information */
		$valid = true;
		$template_attr = array(
			'highlight'		=> false,
			'strikethrough'	=> false,
			'underline'		=> false,
			'small'			=> false,
			'bold'			=> false,
			'italic'		=> false
		);
		$auth_attr  = array(
			'highlight'		=> array('type'=>'bool'),
			'strikethrough'	=> array('type'=>'bool'),
			'underline'		=> array('type'=>'bool'),
			'small'			=> array('type'=>'bool'),
			'bold'			=> array('type'=>'bool'),
			'italic'		=> array('type'=>'bool')
		);
		parent::template_data($attr_t, $template_attr, $in_attr);
		
		/* Authenticated and create label */
		if(!$valid) return;
		
		$out = '';
		if(parent::is_stringt($this->label)){
			$out .= ($attr_t['highlight']) ? '<mark>' : null;
			$out .= ($attr_t['strikethrough']) ? '<s>' : null;
			$out .= ($attr_t['underline']) ? '<u>' : null;
			$out .= ($attr_t['small']) ? '<small>' : null;
			$out .= ($attr_t['bold']) ? '<strong>' : null;
			$out .= ($attr_t['italic']) ? '<em>' : null;
			
			$out .= '<label for="'.$this->attr['id'].'">'.$this->label.'</label>';
			
			$out .= ($attr_t['highlight']) ? '</mark>' : null;
			$out .= ($attr_t['strikethrough']) ? '</s>' : null;
			$out .= ($attr_t['underline']) ? '</u>' : null;
			$out .= ($attr_t['small']) ? '</small>' : null;
			$out .= ($attr_t['bold']) ? '</strong>' : null;
			$out .= ($attr_t['italic']) ? '</em>' : null;
		}
		return $out.'&nbsp;'.PHP_EOL;
	}
}

?>

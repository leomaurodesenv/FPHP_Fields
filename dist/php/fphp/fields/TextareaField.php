<?php

/** 
 * This class rendering a <textarea> tag
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
use \FPHP\Fields\FieldInterface;
use \FPHP\Fields\ErrorParserFields as Error;

class TextareaField extends MasterFields implements FieldInterface {
	
	/** 
	 * Variables description.
	 * @var string	$label			Label of 'textarea'.
	 * @var array	$attr			Attributes of 'textarea'.
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
	 * Construct.
	 * @access public
	 * @param string	$in_label	Set label for 'textarea' tag. [optional]
	 * @param array		$in_attr	Set attributes of 'textarea'. [optional]
	 * @param string	$in_value	Set text of 'textarea'. [optional]
	 * @param bool		$br			Allow or block breaklines/PHP_EOL. [optional]
	 * @return self
	 */
    public function __construct($in_label=false, $in_attr=false, $in_value=false, $br=true) {
		/* Create templates and authenticate information */
		$valid = true;
		$template_attr = [
			'id'		=> false,
			'name'		=> false,
			'validate'	=> false,
			'class'		=> false,
			'style'		=> false,
			'cols'		=> false,
			'rows'		=> false
		];
		$auth_attr = [
			'id'		=> ['type'=>'text'],
			'name'		=> ['required'=>true, 'type'=>'text'],
			'validate'	=> ['type'=>'array'],
			'class'		=> ['type'=>'text'],
			'style'		=> ['type'=>'text'],
			'cols'		=> ['type'=>'int'],
			'rows'		=> ['type'=>'int']
		];
		parent::template_data($attr_t, $template_attr, $in_attr);
		
		$auth_label	= ['type'=>'text'];
		$auth_value	= ['type'=>'text'];
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
	 * @param string	$name		Name of function called.
	 * @param array		$arguments	Arguments to use in function called.
	 * @return self::method
	 */
	public function __call($name, $arguments) {
		if($this->_is_active)
			return call_user_func_array([$this, '_'.$name], $arguments);
    }
	
	/**
	 * Construct the 'textarea' field.
	 * @method string _construct_field($form_id)
	 * @access public
	 * @return string
	 */
    public function _construct_field($form_id=false) {
		$out = self::_get_field($form_id);
		echo $out;
	}
	
	/**
	 * Return the 'textarea' field for forms.
	 * @method string _get_field($form_id)
	 * @access public
	 * @return string
	 */
	public function _get_field($form_id=false) {
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
	 * @return string
	 */
	public function _get_label($in_attr=false) {
		return parent::construct_label($this->attr['id'], $this->label, $in_attr);
	}
	
}

?>
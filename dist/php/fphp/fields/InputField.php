<?php

/** 
 * This class rendering a <input> [type='text|hidden|password']
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

class InputField extends MasterFields implements FieldInterface {
	
	/** 
	 * Variables description.
	 * @var string $type			Type of 'input'.
	 * @var array $attr				Attributes of 'input'.
	 * @var string $label			Label text for 'input'.
	 * 
	 * @var bool $_is_active		Active or deactivate the objectClass.
	 * @var bool $_br				Verify if allow breaklines/PHP_EOL.
	 */ 
	private $type;
	private $attr;
	private $label;
    
	private $_is_active;
	private $_br;
	
	/**
	 * Construct of class InputField.
	 * @access public
	 * @param string $in_type			Set type of 'input'.
	 * @param array $in_attr			Set attributes of 'input'. [optional]
	 * @param string $in_label			Set label text of 'input'. [optional]
	 * @param bool $br					Allow or block breaklines/PHP_EOL. [optional]
	 * @return self
	 */
    public function __construct($in_type=false, $in_attr=false, $in_label=false, $br=true) {
		/* Create templates and authenticate information */
		$template_attr = [
			'id'			=> false,
			'name'			=> false,
			'validate'		=> false,
			'class'			=> false,
			'style'			=> false,
			'value' 		=> false,
			'maxlength' 	=> false,
			'placeholder' 	=> false,
			'autocomplete' 	=> false,
			'disabled' 		=> false
		];
		$auth_attr = [
			'id'			=> ['type'=>'text'],
			'name'			=> ['required'=>true, 'type'=>'text'],
			'validate'		=> ['type'=>'array'],
			'class' 		=> ['type'=>'text'],
			'style' 		=> ['type'=>'text'],
			'value' 		=> ['type'=>'text'],
			'maxlength' 	=> ['type'=>'int'],
			'placeholder' 	=> ['type'=>'text'],
			'autocomplete' 	=> ['pattern'=>['on', 'off']],
			'disabled' 		=> ['type'=>'bool'],
		];
		
		$auth_type 	= ['required'=>true, 'pattern'=>['text', 'hidden', 'password']];
		$auth_label = ['type'=>'text'];
		
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
		/* else parent::dump_error($this, 'cant call '.$name.' function', 'invalid object'); */
    }
	
	/**
	 * Construct the 'input' field.
	 * @method string _construct_field($form_id)
	 * @access public
	 * @return string
	 */
    public function _construct_field($form_id=false) {
		$out = self::_get_field($form_id);
		echo $out;
	}
	
	/**
	 * Return the 'input' field.
	 * @method string _get_field($form_id)
	 * @access public
	 * @return string
	 */
	public function _get_field($form_id=false) {
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
	 * @return string
	 */
	public function _get_label($in_attr=false) {
		return parent::construct_label($this->attr['id'], $this->label, $in_attr);
	}
}

?>

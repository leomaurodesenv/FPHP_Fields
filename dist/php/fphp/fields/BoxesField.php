<?php

/** 
 * This class rendering a <input>s [type='checkbox|radio']
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

class BoxesField extends MasterFields implements FieldInterface {
	
	/** 
	 * Variables description.
	 * @var string $type			Type of inputs 'boxes'.
	 * @var string $name			Name of inputs 'boxes'.
	 * @var string $label			Title of inputs 'boxes'.
	 * @var array $boxes			Inputs 'boxes' information.
	 * 
	 * @var bool $_is_active		Active or deactivate the objectClass.
	 * @var bool $_br				Verify if allow breaklines/PHP_EOL.
	 */ 
	private $type;
	private $name;
	private $label;
	private $boxes;
    
	private $_is_active;
	private $_br;
	
	/**
	 * Construct of class BoxesField.
	 * @access public
	 * @param string $in_type			Set type of 'boxes'.
	 * @param string $in_name			Set name of 'boxes'.
	 * @param string $in_label			Set label text of 'boxes'. [optional]
	 * @param bool $br					Allow or block breaklines/PHP_EOL. [optional]
	 * @return self
	 */
    public function __construct($in_type=false, $in_name=false, $in_label=false, $br=true) {
		/* Create templates and authenticate information */
		$valid = true;
		$auth_type = ['required'=>true, 'pattern'=>['checkbox', 'radio']];
		$auth_name = ['required'=>true, 'type'=>'text'];
		$auth_label = ['type'=>'text'];
		parent::authenticate_data($auth_type, $in_type, 'construct (type)', $valid);
		parent::authenticate_data($auth_name, $in_name, 'construct (name)', $valid);
		parent::authenticate_data($auth_label, $in_label, 'construct (label)', $valid, false);
		
		/* Authenticated and saved information */
		if(!$valid){ self::destruct_obj(); return; }
		
		$this->type = $in_type;
		$this->name = $in_name;
		$this->label = $in_label;
		$this->boxes = [];
		
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
    }
	
	/**
	 * Add new input box to group.
	 * @access public
	 * @param string $in_text		Set text label for input.
	 * @param string $in_value		Set value of input.
	 * @param array $in_attr		Set attributes of input. [optional]
	 * @return void
	 */
	public function _add_box($in_text=false, $in_value=false, $in_attr=false) {
		/* Authenticate information */
		$valid = true;
		$template_attr = [
			'id'		=> false,
			'class'		=> false,
			'style'		=> false,
			'checked'	=> false,
			'disabled'	=> false
		];
		$auth_attr = [
			'id'		=> ['type'=>'text'],
			'class'		=> ['type'=>'text'],
			'style'		=> ['type'=>'text'],
			'checked'	=> ['type'=>'bool'],
			'disabled'	=> ['type'=>'bool']
		];
		parent::template_data($attr_t, $template_attr, $in_attr);
		
		$auth_text  = ['required'=>true, 'type'=>'text'];
		$auth_value = ['required'=>true];
		parent::authenticate_data($auth_text, $in_text, 'add_box (text)', $valid);
		parent::authenticate_data($auth_value, $in_value, 'add_box (value)', $valid);
		foreach($template_attr as $key => $value)
		parent::authenticate_data($auth_attr[$key], $attr_t[$key], 'add_box ('.$key.')', $valid, false);
		
		/* Authenticated and saved information */
		if(!$valid) return;
		
		$box['text'] = $in_text;
		$box['value'] = $in_value;
		$box['attr'] = $attr_t;
		$this->boxes[] = $box;
	}
	
	/**
	 * Add a group of inputs boxes.
	 * @access public
	 * @param array $in_boxes		Set group of inputs to add.
	 * @param array $in_checked		Set inputs with attribute checked. [optional]
	 * @return void
	 */
	public function _add_boxes($in_boxes=false, $in_checked=false) {
		/* Authenticate information */
		$valid = true;
		$auth_boxes = ['required'=>true, 'type'=>'array'];
		parent::authenticate_data($auth_boxes, $in_boxes, 'construct (boxes)', $valid);
		if(!parent::is_arrayt($in_checked)) $in_checked = [];
		
		/* Authenticated and _add_box calls */
		if(!$valid) return;
		
		foreach($in_boxes as $key => $box){
			$auth_box = ['required'=>true, 'type'=>'array', 'count'=>3];
			parent::authenticate_data($auth_box, $box, 'boxes['.$key.']', $valid);
			if(!$valid) return;
			
			/* Verify attributes (& checked) of $box */
			if(in_array($key, $in_checked)){
				if(isset($box['attr'])) $box['attr']['checked'] = true;
				else $box['attr'] = ['checked'=>true];
			}
			elseif(!isset($box['attr'])) $box['attr'] = false;
			
			/* Try add $box */
			if(!isset($box['text']) || !isset($box['value'])){
				Error::dump($this, Error::E_INCONSISTENT, 'add_boxes: ["text"] | ["value"] not exists in ['.$key.']');
				return; 
			}
			self::_add_box($box['text'], $box['value'], $box['attr']);
		}
	}
	
	/**
	 * Construct the 'boxes' fields.
	 * @method string _construct_field($form_id)
	 * @access public
	 * @return string
	 */
    public function _construct_field($form_id=false) {
		$out = self::_get_field($form_id);
		echo $out;
	}
	
	/**
	 * Return the 'boxes' for forms.
	 * @method string _get_field($form_id)
	 * @access public
	 * @return string
	 */
	public function _get_field($form_id=false) {
		$form = ($form_id != false && parent::is_stringt($form_id)) ? ' form="'.$form_id.'"' : '';
		$out = self::_get_label();
		foreach($this->boxes as $key => $box){
			$out .= '<div class="'.$this->type.'">';
			$out .= '<label><input type="'.$this->type.'" name="'.$this->name.'" value="'.$box['value'].'"'.$form.parent::get_attributes($box['attr']).'/>&nbsp;'.$box['text'].'</label>';
			$out .= '</div>'.PHP_EOL;
		}
		if($this->_br) $out .= '<br/>'.PHP_EOL;
		return $out;
	}
	
	/**
	 * Return the label of 'boxes' field.
	 * @method string _get_label($in_attr)
	 * @access public
	 * @return string
	 */
	public function _get_label($in_attr=false) {
		return parent::construct_label(false, $this->label, $in_attr);
	}
	
}

?>

<?php

/** 
 * Parent of Field Classes
 * This class is used in 'extends' class.
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

use \FPHP\Fields\ErrorParserFields as Error;

class MasterFields{
	
	/**
	 * Function to authenticate information based on rules.
	 * @access protected
	 * @param array 				$in_auth	Set rules.
	 * @param string|int|bool|array	$in			input information.
	 * @param string 				$var		Name of variable (uses in Error::dump).
	 * @param bool	 				$valid		Return value of authenticate.
	 * @param bool	 				$needed		Variable can be bool(false). [optional]
	 * @return self
	 */
    protected function authenticate_data($in_auth, $in, $var, &$valid, $needed=true) {
		$template_auth = [
			'required' 	=> false,
			'pattern' 	=> false,
			'type'		=> false,
			'count'		=> false
		];
		self::template_data($auth, $template_auth, $in_auth);
		
		/* Required */
		if(self::is_boolt($auth['required']) && $auth['required'] == true && (self::is_nullt($in) || ($in == false && !self::is_intt($in)))){
			Error::dump($this, Error::E_AUTH_REQUIRED, $var);
			$valid = false; return;
		}
		/* Pattern */
		elseif(self::is_arrayt($auth['pattern'])){
			if($needed == true && !self::authenticate_pattern($auth['pattern'], $in)){
				Error::dump($this, Error::E_AUTH_PATTERN, 'value: '.self::get_value($in));
				$valid = false; return;
			}
			elseif($needed == false){
				if(self::is_boolt($in) && $in!=false){
					Error::dump($this, Error::E_AUTH_PATTERN, 'type: '.gettype($in));
					$valid = false; return;
				}
				elseif(!self::is_boolt($in) && !self::authenticate_pattern($auth['pattern'], $in)){
					Error::dump($this, Error::E_AUTH_PATTERN, 'value: '.self::get_value($in));
					$valid = false; return;
				}
			}
		}
		/* Type */
		elseif(self::is_stringt($auth['type'])){
			$pattern_type = ['text', 'int', 'array', 'bool'];
			if(!self::authenticate_pattern($pattern_type, $auth['type'])){
				Error::dump($this, Error::E_AUTH_TYPE, 'not exists type: '.$auth['type']);
				$valid = false; return;
			}
			elseif(
			($auth['type'] == 'text' && !self::is_stringt($in, $needed)) ||
			($auth['type'] == 'array' && !self::is_arrayt($in, $needed)) ||
			($auth['type'] == 'int' && !self::is_intt($in, $needed)) ||
			($auth['type'] == 'bool' && !self::is_boolt($in)) ){
				Error::dump($this, Error::E_AUTH_TYPE, 'type: '.gettype($in));
				$valid = false; return;
			}
		}
		/* Count */
		if(self::is_intt($auth['count'])){
			if(!self::is_arrayt($in)){
				Error::dump($this, Error::E_AUTH_COUNT, 'is not array '.gettype($in));
				$valid = false; return;
			}
			elseif(count($in) > $auth['count']){
				Error::dump($this, Error::E_AUTH_COUNT, 'is bigger than '.$auth['count']);
				$valid = false; return;
			}
		}
	}
	
	/**
	 * Return value of variable (uses in Error::dump).
	 * @access private
	 * @param string|int|bool|array $var	Variable.
	 * @return string
	 */
	private function get_value($var) {
		if(self::is_arrayt($var)){
			return 'array('.count($var).')';
		}
		return $var;
	}
	
	/**
	 * Function to authenticate a pattern.
	 * @access protected
	 * @param array $pattern	Set pattern.
	 * @param string	 $value		Value to find in pattern.
	 * @return bool
	 */
	protected function authenticate_pattern($pattern, $value) {
		foreach($pattern as $key => $val){
			if($value == $val) return true;
		}
		return false;
	}
	
	/**
	 * Return a array based in template and input information.
	 * @access protected
	 * @param array $array		Array returned.
	 * @param array $template	Set template.
	 * @param array $in			Inputs information.
	 * @return array
	*/
	protected function template_data(&$array, $template, $in) {
		if(self::is_arrayt($in)){
			foreach($template as $key => $value){
				if(isset($in[$key])) $array[$key] = $in[$key];
				else $array[$key] = $value;
			}
		}
		else{
			foreach($template as $key => $value){
				$array[$key] = $value;
			}
		}
	}
	
	/**
	 * Check if is array.
	 * @access public
	 * @param array		$test		Variable to test.
	 * @param bool		$needed		Variable can be bool(false). [optional]
	 * @return bool
	 */
	public function is_arrayt($test, $needed=true) {
		if($needed) return is_array($test);
		else return (is_array($test) || (self::is_boolt($test) && $test==false));
	}
	
	/**
	 * Check if if string.
	 * @access public
	 * @param array		$test		Variable to test.
	 * @param bool		$needed		Variable can be bool(false). [optional]
	 * @return bool
	 */
	public function is_stringt($test, $needed=true) {
		if($needed) return is_string($test);
		else return (is_string($test) || (self::is_boolt($test) && $test==false));
	}
	
	/**
	 * Check if is int.
	 * @access public
	 * @param array		$test		Variable to test.
	 * @param bool		$needed		Variable can be bool(false). [optional]
	 * @return bool
	 */
	public function is_intt($test, $needed=true) {
		if($needed) return is_int($test);
		else return (is_int($test) || (self::is_boolt($test) && $test==false));
	}
	
	/**
	* Check if is bool.
	* @access public
	* @param array $test		Variable to test.
	* @return bool
	*/
	public function is_boolt($test) {
		return is_bool($test);
	}
	
	/**
	 * Check if is null.
	 * @access public
	 * @param array $test		Variable to test.
	 * @return bool
	 */
	public function is_nullt($test) {
		return is_null($test);
	}
	
	/**
	 * Return structure attributes of the fields.
	 * @access protected
	 * @param array $in_attr All attributes to create attributes.
	 * @return string
	 */
	protected function get_attributes($in_attr) {
		$out = ' ';
		if(!self::is_arrayt($in_attr)) return $out;
		foreach($in_attr as $attr => $value){
			if($attr == 'validate' && $value != false) $out .= 'data-validate="'.self::json_hex_quot($value).'" ';
			elseif(!self::is_boolt($value)) $out .= $attr.'="'.$value.'" ';
			elseif($attr == 'checked' && $value == true) $out .= 'checked ';
			elseif($attr == 'selected' && $value == true) $out .= 'selected ';
			elseif($attr == 'disabled' && $value == true) $out .= 'disabled ';
		}
		return $out;
	}

	/**
	 * Return json with double quots in hexa.
	 * @access private
	 * @param string	$value	Value to be converted.
	 * @return string
	 */
	private function json_hex_quot($value) {
		return preg_replace('/"/', '\u0022', json_encode($value));
	}
	
	/**
	 * Return the label of field.
	 * @access protected
	 * @param string	$in_attr	Attributes of field.
	 * @return string
	 */
	protected function construct_label($id, $label, $in_attr=false) {
		/* Create templates and authenticate information */
		$valid = true;
		$template_attr = [
			'highlight'		=> false,
			'strikethrough'	=> false,
			'underline'		=> false,
			'small'			=> false,
			'bold'			=> false,
			'italic'		=> false
		];
		$auth_attr = [
			'highlight'		=> ['type'=>'bool'],
			'strikethrough'	=> ['type'=>'bool'],
			'underline'		=> ['type'=>'bool'],
			'small'			=> ['type'=>'bool'],
			'bold'			=> ['type'=>'bool'],
			'italic'		=> ['type'=>'bool']
		];
		self::template_data($attr_t, $template_attr, $in_attr);
		
		/* Authenticated and create label */
		if(!$valid) return;
		
		$out = '';
		if(self::is_stringt($label)){
			$out .= ($attr_t['highlight']) ? '<mark>' : null;
			$out .= ($attr_t['strikethrough']) ? '<s>' : null;
			$out .= ($attr_t['underline']) ? '<u>' : null;
			$out .= ($attr_t['small']) ? '<small>' : null;
			$out .= ($attr_t['bold']) ? '<strong>' : null;
			$out .= ($attr_t['italic']) ? '<em>' : null;
			
			if($id) $out .= '<label for="'.$id.'">'.$label.'</label>';
			else $out .= '<label>'.$label.'</label>';
			
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

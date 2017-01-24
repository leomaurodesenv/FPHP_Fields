<?php

/** 
* Parent of all Classes
* This class is used in 'extends' class.
* 
* @author Leonardo Mauro <leo.mauro.desenv@gmail.com>
* @link http://leonardomauro.com/portfolio/	Portfolio of Leonardo Mauro
* @version 1.2.1
* @copyright © 2016 Leonardo Mauro
* @license https://opensource.org/licenses/GPL-2.0 GNU Public License (GPL v2)
* @package FPHP_Fields
*/ 
class FPHP_Master_Fields{
	
	/**
	* Function to authenticate information based on rules.
	* @access protected
	* @param array() 				 $in_auth	Set rules.
	* @param string|int|bool|array() $in		input information.
	* @param string 				 $var		Name of variable (for FPHP_Master_Fields::dump_error).
	* @param bool	 				 $valid		Return value of authenticate.
	* @param bool	 				 $needed	Variable can be bool(false). [optional]
	*/
    protected function authenticate_data($in_auth, $in, $var, &$valid, $needed=true){
		$template_auth = array(
			'required' 	=> false,
			'pattern' 	=> false,
			'type'		=> false,
			'count'		=> false
		);
		self::template_data($auth, $template_auth, $in_auth);
		
		/* Required */
		if(self::is_boolt($auth['required']) && $auth['required'] == true && (self::is_nullt($in) || ($in == false && !self::is_intt($in)))){
			self::dump_error($this, E_FPHP_Fields::E_AUTH_REQUIRED, $var);
			$valid = false; return;
		}
		/* Pattern */
		elseif(self::is_arrayt($auth['pattern'])){
			if($needed == true && !self::authenticate_pattern($auth['pattern'], $in)){
				self::dump_error($this, E_FPHP_Fields::E_AUTH_PATTERN, 'value: '.self::get_value($in));
				$valid = false; return;
			}
			elseif($needed == false){
				if(self::is_boolt($in) && $in!=false){
					self::dump_error($this, E_FPHP_Fields::E_AUTH_PATTERN, 'type: '.gettype($in));
					$valid = false; return;
				}
				elseif(!self::is_boolt($in) && !self::authenticate_pattern($auth['pattern'], $in)){
					self::dump_error($this, E_FPHP_Fields::E_AUTH_PATTERN, 'value: '.self::get_value($in));
					$valid = false; return;
				}
			}
		}
		/* Type */
		elseif(self::is_stringt($auth['type'])){
			$pattern_type = array('text', 'int', 'array', 'bool');
			if(!self::authenticate_pattern($pattern_type, $auth['type'])){
				self::dump_error($this, E_FPHP_Fields::E_AUTH_TYPE, 'not exists type: '.$auth['type']);
				$valid = false; return;
			}
			elseif(
			($auth['type'] == 'text' && !self::is_stringt($in, $needed)) ||
			($auth['type'] == 'array' && !self::is_arrayt($in, $needed)) ||
			($auth['type'] == 'int' && !self::is_intt($in, $needed)) ||
			($auth['type'] == 'bool' && !self::is_boolt($in)) ){
				self::dump_error($this, E_FPHP_Fields::E_AUTH_TYPE, 'type: '.gettype($in));
				$valid = false; return;
			}
		}
		/* Count */
		if(self::is_intt($auth['count'])){
			if(!self::is_arrayt($in)){
				self::dump_error($this, E_FPHP_Fields::E_AUTH_COUNT, 'is not array '.gettype($in));
				$valid = false; return;
			}
			elseif(count($in) > $auth['count']){
				self::dump_error($this, E_FPHP_Fields::E_AUTH_COUNT, 'is bigger than '.$auth['count']);
				$valid = false; return;
			}
		}
	}
	
	/**
	* Return value of variable (for FPHP_Master::dump_error).
	* @access private
	* @param string|int|bool|array() $var	Variable.
	*/
	private function get_value($var){
		if(self::is_arrayt($var)){
			return 'array('.count($var).')';
		}
		return $var;
	}
	
	/**
	* Function to authenticate a pattern.
	* @access protected
	* @param array() $pattern	Set pattern.
	* @param string	 $value		Value to find in pattern.
	*/
	protected function authenticate_pattern($pattern, $value){
		foreach($pattern as $key => $val){
			if($value == $val) return true;
		}
		return false;
	}
	
	/**
	* Return a array() based in template and input information.
	* @access protected
	* @param array() $array		Array returned.
	* @param array() $template	Set template.
	* @param array() $in		Inputs information.
	*/
	protected function template_data(&$array, $template, $in){
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
	* Return a bool is_array.
	* @access public
	* @param array() $test		Variable to test.
	* @param bool	 $needed	Variable can be bool(false). [optional]
	*/
	public function is_arrayt($test, $needed=true){
		if($needed) return is_array($test);
		else return (is_array($test) || (self::is_boolt($test) && $test==false));
	}
	
	/**
	* Return a bool is_string.
	* @access public
	* @param array() $test		Variable to test.
	* @param bool	 $needed	Variable can be bool(false). [optional]
	*/
	public function is_stringt($test, $needed=true){
		if($needed) return is_string($test);
		else return (is_string($test) || (self::is_boolt($test) && $test==false));
	}
	
	/**
	* Return a bool is_int.
	* @access public
	* @param array() $test		Variable to test.
	* @param bool	 $needed	Variable can be bool(false). [optional]
	*/
	public function is_intt($test, $needed=true){
		if($needed) return is_int($test);
		else return (is_int($test) || (self::is_boolt($test) && $test==false));
	}
	
	/**
	* Return a bool is_bool.
	* @access public
	* @param array() $test		Variable to test.
	*/
	public function is_boolt($test){
		return is_bool($test);
	}
	
	/**
	* Return a bool is_null.
	* @access public
	* @param array() $test		Variable to test.
	*/
	public function is_nullt($test){
		return is_null($test);
	}
	
	/**
	* Echo a dump error.
	* @access protected
	* @param object $class_call	Class how called this function.
	* @param string $error		Error parser.
	* @param string	$detail		Detail of dump.
	*/
	protected function dump_error($class_call, $error, $detail=false){
		$out = 'Class '.get_class($class_call).' Error ('.$error.'): ';
		$out .= E_FPHP_Fields::parser($error);
		if($detail != false) $out .= ' - '.$detail;
		echo $out.'<br/>'.PHP_EOL;
	}
	
	/**
	* Return structure attributes of the fields.
	* @access protected
	* @param array() $in_attr All attributes to create attributes.
	*/
	protected function get_attributes($in_attr){
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
	*/
	private function json_hex_quot($value){
		return preg_replace('/"/', '\u0022', json_encode($value));
	}
	
	/**
	* Return the label of field.
	* @access protected
	* @param string	$in_attr	Attributes of field.
	*/
	protected function construct_label($id, $label, $in_attr=false){ ///////// Terminarrrrrrrrrrrrrr--------------------------------------
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

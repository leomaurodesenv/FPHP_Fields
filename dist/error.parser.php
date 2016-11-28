<?php

/** 
* Error parser from FPHP_Fields
* This class get and show error in uses of classes
* 
* @author Leonardo Mauro <leo.mauro.desenv@gmail.com>
* @link http://leonardomauro.com/portfolio/	Portfolio of Leonardo Mauro
* @version 1.1.0
* @copyright © 2016 Leonardo Mauro
* @license https://opensource.org/licenses/GPL-2.0 GNU Public License (GPL v2)
* @package FPHP_Fields
* @access public
*/ 

class E_FPHP_Fields{
	
	/** 
	* Const description.
	* @var string	$label			Label of 'textarea'.
	* @var array()	$attr			Attributes of 'textarea'.
	* @var string	$value			Text inside of 'textarea'.
	*/ 
	
	/* All fields */
	const E_DESTROYING = 47;
	const E_INCONSISTENT = 48;
	
	/* FPHP_Master_Fields */
	const E_AUTH_REQUIRED = 49;
	const E_AUTH_PATTERN = 50;
	const E_AUTH_TYPE = 51;
	const E_AUTH_COUNT = 52;
	
	/**
	* Get error parser (string).
	* @access public
	* @param int $error	const of E_FPHP_Fields.
	*/
	public static function parser($error){
		switch($error){
			case self::E_DESTROYING:
				return 'destroying the object';
			case self::E_INCONSISTENT:
				return 'inconsistent data';	
			/* FPHP_Master_Fields */
			case self::E_AUTH_REQUIRED:
				return 'undefined';
			case self::E_AUTH_PATTERN:
				return 'pattern not allowed';
			case self::E_AUTH_TYPE:
				return 'type not allowed';
			case self::E_AUTH_COUNT:
				return 'count problem';
		}
		return "don't have this error in list."; 
	}
	
}

?>

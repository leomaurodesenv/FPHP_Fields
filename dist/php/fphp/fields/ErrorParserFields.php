<?php

/** 
 * Error parser from FPHP_Fields
 * This class get and show error in uses of classes
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

class ErrorParserFields{
	
	/** 
	 * Const description.
	 * @var const int	E_DESTROYING		Destroy object.
	 * @var const int	E_INCONSISTENT		Values inconsistent.
	 * @var const int	E_AUTH_REQUIRED		MasterFields: Value required.
	 * @var const int	E_AUTH_PATTERN		MasterFields: Pattern invalid.
	 * @var const int	E_AUTH_TYPE			MasterFields: Type invalid.
	 * @var const int	E_AUTH_COUNT		MasterFields: Count(array) is bigger.
	 */ 	

	const E_DESTROYING = 47;
	const E_INCONSISTENT = 48;
	
	/* uses in MasterFields */
	const E_AUTH_REQUIRED = 49;
	const E_AUTH_PATTERN = 50;
	const E_AUTH_TYPE = 51;
	const E_AUTH_COUNT = 52;
	
	/**
	 * Get error parser (string).
	 * @access public
	 * @param int $error	const of ErrorParserFields.
	 * @return string
	 */
	public static function parser($error){
		switch($error){
			case self::E_DESTROYING:
				return 'destroying the object';
			case self::E_INCONSISTENT:
				return 'inconsistent data';	
			/* MasterFields */
			case self::E_AUTH_REQUIRED:
				return 'undefined';
			case self::E_AUTH_PATTERN:
				return 'pattern not allowed';
			case self::E_AUTH_TYPE:
				return 'type not allowed';
			case self::E_AUTH_COUNT:
				return 'count problem';
		}
		return 'don\'t have this error in list.'; 
	}
	
	/**
	 * Echo a dump error.
	 * @access public
	 * @param object	$class		Class how called this function.
	 * @param string	$error		Error parser.
	 * @param string	$detail		Detail of dump.
	 * @param bool		$breakline	Set breakline (`<br/>` and `PHP_EOL`).
	 * @return void
	 */
	public static function dump($class, $error, $detail=false, $breakline=true) {
		$out = 'Class '.get_class($class).' Error ('.$error.'): ';
		$out .= self::parser($error);
		if($detail != false) $out .= ' - '.$detail;
		if($breakline) echo($out.'<br/>'.PHP_EOL);
	}
	
}

?>

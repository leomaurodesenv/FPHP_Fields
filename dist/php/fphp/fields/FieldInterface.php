<?php

/** 
 * Interface for form fields.
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

interface FieldInterface {
	public function _get_field($form_id);
	public function _get_label($in_attr);
	public function _construct_field($form_id);
}

?>

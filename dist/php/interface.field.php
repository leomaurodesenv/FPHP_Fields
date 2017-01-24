<?php

/** 
* Interface interface_field
* This interface is used in all fields forms.
* 
* @author Leonardo Mauro <leo.mauro.desenv@gmail.com>
* @link http://leonardomauro.com/portfolio/	Portfolio of Leonardo Mauro
* @version 1.2.1
* @copyright © 2016 Leonardo Mauro
* @license https://opensource.org/licenses/GPL-2.0 GNU Public License (GPL v2)
* @package FPHP_fields
* @access public
*/ 
interface Interface_Field{
	public function _get_field($form_id);
	public function _get_label($in_attr);
	public function _construct_field($form_id);
}

?>

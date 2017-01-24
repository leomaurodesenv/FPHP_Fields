/** 
* Automatic rules for jquery.validate.js
* This class add all rules setted in inputs[data-validate] to form[fphp-auto-validate]
* 
* @author Leonardo Mauro <leo.mauro.desenv@gmail.com>
* @link http://leonardomauro.com/portfolio/	Portfolio of Leonardo Mauro
* @version 1.2.1
* @copyright © 2016 Leonardo Mauro
* @license https://opensource.org/licenses/GPL-2.0 GNU Public License (GPL v2)
* @package FPHP_Fields
*/ 
$(function(){
	
	/**
	* Add rules for all forms with [fphp-auto-validate]
	*/
	var $form = $('form[fphp-auto-validate]');
	var $inputs = $form.find(':input[type!="submit"]');
	var json_rules = fphpav_json_rules($inputs);
	$form.validate({
		rules: json_rules,
		submitHandler: function(form){ form.submit(); }
	});
	
});

/**
* Return json create from each input.
* @access public
* @param objectDom	$inputs	Inputs of a form.
*/
function fphpav_json_rules($inputs){
	var jsonr = {};
	$inputs.each(function(){
		var namei = $(this).attr('name');
		var rules = $(this).data('validate');
		//console.debug(rules);
		if(rules != null) jsonr[namei] = fphpav_get_rules(rules);
	});
	return jsonr;
}

/**
* Return json in data-validate.
* @access public
* @param objectDom	$inputs	Inputs of a form.
*/
function fphpav_get_rules($rules){
	var unesc_rules = $rules.replace(/(\\u0022)/g, '"');
	/*return $.extend(true, {}, unesc_rules);*/
	return JSON.parse(unesc_rules);
}

<?php



/**
 * Gravity Forms Bootstrap Styles
 *
 * Applies bootstrap classes to various common field types.
 * Requires Bootstrap to be in use by the theme.
 *
 * Using this function allows use of Gravity Forms default CSS
 * in conjuction with Bootstrap (benefit for fields types such as Address).
 *
 * Original git https://github.com/5t3ph/gravity-forms-snippets
 *
 * @see  gform_field_content
 * @link http://www.gravityhelp.com/documentation/page/Gform_field_content
 *
 * @return string Modified field content
 */

 	if(!is_admin()){
		add_action( 'gform_field_container', 'my_field_container', 10, 6 );
		add_filter("gform_field_content", "bootstrap_styles_for_gravityforms_fields", 10, 5);
		add_filter("gform_submit_button", "form_submit_button", 10, 2);
		add_filter( 'gform_next_button', 'my_next_button_markup', 10, 2 );
		add_filter( 'gform_previous_button', 'my_previous_button_markup', 10, 2 );
		add_filter("gform_validation_message", "change_message", 10, 2);
		add_filter("gform_field_validation", "custom_validation", 10, 4);
	};

function bootstrap_styles_for_gravityforms_fields($content, $field, $value, $lead_id, $form_id){
	// Currently only applies to most common field types, but could be expanded.
  //echo '<pre>';var_dump($field);echo '</pre>';
	if($field["type"] != 'hidden' && $field["type"] != 'list' && $field["type"] != 'multiselect' && $field["type"] != 'checkbox' && $field["type"] != 'fileupload' && $field["type"] != 'date' && $field["type"] != 'html' && $field["type"] != 'address') {
		$content = str_replace('class=\'medium', 'class=\'form-control medium', $content);
	}

	if($field["type"] == 'list') {
		$content = str_replace('<input ', '<input class=\'form-control\' ', $content);
	}

	if($field["type"] == 'multiselect') {
		$content = str_replace('<select ', '<select class=\'form-control\' ', $content);
	}

	if($field["type"] == 'name') {
		$content = str_replace('<input ', '<input class=\'form-control\' ', $content);
		//$content = str_replace('<select ', '<select class=\'form-control\' ', $content);
	}

	if( $field["type"] == 'address') {
		$content = str_replace('<input ', '<input class=\'form-control\' ', $content);
		$content = str_replace('<select ', '<select class=\'form-control\' ', $content);
	}

	if($field["type"] == 'textarea' || ($field["type"] == 'survey' && $field["inputType"] = 'textarea') ) {
		$content = str_replace('class=\'textarea', 'class=\'form-control textarea', $content);
	}

	if( ($field["type"] == 'survey' && $field["inputType"] = 'checkbox' && !empty($field["inputs"]) )  ) {
		//echo '<pre>';var_dump($field);echo '</pre>';
		$content = str_replace('li class=\'', 'li class=\'checkbox ', $content);
		$content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
	}


	if( ($field["type"] == 'survey' && empty($field["inputType"])  ) ) {

		$content = str_replace('li class=\'', 'li class=\'radio ', $content);
		$content = str_replace('type=\'radio\' ', 'type=\'radio\' style=\'margin-left:1px;\' ', $content);
		$content = str_replace('type=\'text\' ', 'type=\'text\' style=\'margin-left:20px;\' ', $content);

	}

		if( $field["type"] == 'checkbox'  ) {
		$content = str_replace('li class=\'', 'li class=\'checkbox ', $content);
		$content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
	}

	if($field["type"] == 'radio' ) {
		//echo '<pre>';var_dump($field);echo '</pre>';
		$content = str_replace('li class=\'', 'li class=\'radio ', $content);
		$content = str_replace('type=\'radio\' ', 'type=\'radio\' style=\'margin-left:1px;\' ', $content);
		$content = str_replace('type=\'text\' ', 'type=\'text\' style=\'margin-left:20px;\' ', $content);

	}

	if($field["isRequired"] == true && !($field["type"] == 'checkbox' || $field["type"] == 'survey' || $field["type"] == 'radio'  ) ) {
		$content = str_replace('<input ', '<input required="required" ', $content);
	}

	return $content;

} // End bootstrap_styles_for_gravityforms_fields()


	//replace class for container block

        function my_field_container( $field_container, $field, $form, $class_attr, $style, $field_content ) {

            if($field["type"] == 'name') {
	            //echo '<pre>';var_dump($field);echo '</pre>';
				//$field_content = preg_replace('~<span(.*?) class=\'(.*?)\'>~i', '<span$1 class="col-sm-6">', $field_content);
				$field_content = str_replace('name_prefix_select', 'name_prefix_select col-sm-12', $field_content);
				if (strpos($field_content,'name_middle') !== false) {
					$field_content = str_replace('name_middle', 'name_middle col-sm-4', $field_content);
					$field_content = str_replace('name_first', 'name_first col-sm-4', $field_content);
					$field_content = str_replace('name_last', 'name_last col-sm-4', $field_content);
				}else{
					$field_content = str_replace('name_first', 'name_first col-sm-6', $field_content);
					$field_content = str_replace('name_last', 'name_last col-sm-6', $field_content);
				}
				$field_content = str_replace('name_suffix ', 'name_suffix  col-sm-1', $field_content);
			}
			if($field["type"] == 'address') {
	            //echo '<pre>';var_dump($field_content);echo '</pre>';
				//$field_content = preg_replace('~<span(.*?) class=(.*?)(.*?)(.*?)>~i', '<span$1 class="col-sm-6">', $field_content);
				$field_content = str_replace('ginput_full', 'ginput_full col-sm-12', $field_content);
				$field_content = str_replace('ginput_left', 'ginput_left col-sm-6', $field_content);
				$field_content = str_replace('ginput_right', 'ginput_right col-sm-6', $field_content);
			}

			if($field["isRequired"] == true) {

				$class_attr = str_replace('gfield_error', 'gfield_error has-error', $class_attr);
			}

			if($field["size"] == 'number') {
	           // echo '<pre>';var_dump($field);echo '</pre>';
				$field_content = '<div class="row"><div class="col-md-4">'.$field_content.'</div></div>';
			}
	        $field_content = str_replace('ginput_complex', 'ginput_complex row', $field_content);

			return '<li id="field_'.$form['id'].'_'.$field['id'].'" class="'.$class_attr.' form-group">'. $field_content .'</li>';

        }
// filter the Gravity Forms button type

function form_submit_button($button, $form){
	$button = str_replace('gform_button', 'gform_button btn', $button);
    return $button;
}

//Next button
function my_next_button_markup( $next_button, $form ) {
    $next_button = str_replace('gform_next_button', 'gform_next_button btn', $next_button);
    return $next_button;
}
//previous button
function my_previous_button_markup( $previous_button, $form ) {
	$previous_button = str_replace('gform_prev_button', 'gform_prev_button btn', $previous_button);
    return $previous_button;

}
//Validation message
function change_message($message, $form){
	$message= str_replace('validation_error', 'validation_error alert alert-danger', $message);
	return $message;
}

function custom_validation($result, $value, $form, $field){
	$result['message'] = '<span class="help-block">This field is required.</span>';
	return $result;
}
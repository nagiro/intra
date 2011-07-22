<?php

/**
 * include_partial('fieldSpan',array('width'=>150,'FORM'=>array(array('field'=>$FORMULARI['Material'],'checkbox'=>true)));
 */

if(isset($FORM)):
	foreach($FORM as $F):
		$class = "";
		if(isset($F['checkbox'])) $class = "checkbox_list";		
		echo '<div style="clear: both;" class="FORMULARI">';
		echo '	<span class="fb title row_title"><b>'.$F['field']->renderLabel().'</b></span>';
		echo '  <span class="fb row_field '.$class.'">'.$F['field']->render().'</span>';
		echo '</div>';
	endforeach;
else:
	echo '<div class="clear row fb">';
	if(isset($label)) echo '<span class="title row_title fb">'.$label.'</span>';
	if(isset($field)) echo '<span class="row_field fb">'.$field.'</span>';
	echo '</div>';
endif;
?>


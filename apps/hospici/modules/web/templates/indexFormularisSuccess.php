<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = sfConfig::get('sf_webrooturl').'images/hospici'; ?> 

<?php if($MODE == 'CERCA') include_partial('web/showCercadorFormularis',array('CERCA'=>$CERCA,'VISIBLE'=>($MODE <> 'DETALL'),'DESPLEGABLES'=>$DESPLEGABLES)); ?>                
<?php if($MODE == 'DETALL') include_partial('web/showDetallFormularis',array('IDU'=>$IDU, 'FORM'=>$FORM , 'FORM_TEXT' => $FORM_TEXT , 'AUTH'=>$AUTH)); ?>                
<?php if($MODE == 'CERCA') include_partial('web/showLlistatFormularis',array('IDU'=>$IDU, 'LLISTAT_FORMS'=>$LLISTAT_FORMS,'AUTH'=>$AUTH)); ?>
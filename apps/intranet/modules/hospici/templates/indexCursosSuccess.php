<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = sfConfig::get('sf_webrooturl').'images/hospici'; ?>
 

<?php include_partial('hospici/showCercadorCursos',array('CERCA'=>$CERCA,'VISIBLE'=>($MODE <> 'DETALL'))); ?>
<?php if(!$MODE == 'INICIAL') include_partial('hospici/showDestacats'); ?>                
<?php if($MODE == 'DETALL') include_partial('hospici/showDetallCurs',array('CURS'=>$CURS)); ?>                
<?php if($MODE == 'CERCA') include_partial('hospici/showLlistatCursos',array('LLISTAT_CURSOS'=>$LLISTAT_CURSOS)); ?>    
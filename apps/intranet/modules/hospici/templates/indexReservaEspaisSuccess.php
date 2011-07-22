<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = sfConfig::get('sf_webrooturl').'images/hospici'; ?>
 

<?php include_partial('hospici/showCercadorEspais',array('CERCA'=>$CERCA,'VISIBLE'=>($MODE <> 'DETALL'))); ?>
<?php if(!$MODE == 'INICIAL') include_partial('hospici/showDestacats'); ?>                
<?php if($MODE == 'DETALL') include_partial('hospici/showDetallEspai',array('ESPAI'=>$ESPAI)); ?>                
<?php if($MODE == 'CERCA') include_partial('hospici/showLlistatEspais',array('LLISTAT_ESPAIS'=>$LLISTAT_ESPAIS)); ?>
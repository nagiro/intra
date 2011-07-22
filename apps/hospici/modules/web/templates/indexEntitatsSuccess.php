<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = sfConfig::get('sf_webrooturl').'images/hospici'; ?>
 
<?php if($MODE == 'CERCA') include_partial('web/showCercadorEntitats',array('CERCA'=>$CERCA,'VISIBLE'=>($MODE <> 'DETALL'),'DESPLEGABLES'=>$DESPLEGABLES)); ?>
<?php if($MODE == 'CERCA') include_partial('web/showLlistatEntitats',array('LLISTAT_ENTITATS'=>$LLISTAT_ENTITATS,'AUTH'=>$AUTH)); ?>
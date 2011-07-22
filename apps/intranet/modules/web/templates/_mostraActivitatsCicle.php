<?php use_helper('Presentation'); ?>

<td colspan="2" class="CONTINGUT">

    <?php include_partial('breadcumb',array('text'=>$TITOL)); ?>

    <?php 

    if(sizeof($LLISTAT_ACTIVITATS) == 0): 

		echo '<DIV>No s\'ha trobat cap activitat pública disponible per aquest cicle.<DIV>';

	else: 			    
	
		$C = CiclesPeer::retrieveByPK($IDC);
		$NA = CiclesPeer::getActivitatsCicle( $C->getCicleID() , $IDS );						
		$PA = CiclesPeer::getDataPrimeraActivitat( $C->getCicleID() , $IDS );
		$PF = CiclesPeer::getDataUltimaActivitat( $C->getCicleID() , $IDS );		
		$imatge = $C->getImatge();
		$pdf = $C->getPdf();		
		
		?>
							
		<div style="border:2px solid #96BF0D; clear:both; padding:10px;">					
			<div class="df" style="width:150px;">
				<div><?php if($imatge > 0): ?> <img src="<?php echo sfConfig::get('sf_webrooturl').'images/cicles/'.$imatge ?>" style="vertical-align:middle"><?php endif; ?></div>						
				<div style="margin-top:20px;font-size:11px;">Del <?php echo $PA ?> al <?php echo $PF ?></div>
				<div style="margin-top:20px;font-size:11px;">Activitats del cicle: <?php echo $NA ?></div>						
				<div style="margin-top:0px; font-size:10px"><a href="javascript:history.back()">Torna al llistat de cicles</a></div>
				<div class="pdf_cicle"><?php if($pdf > 0): ?> <br /><a href="<?php echo sfConfig::get('sf_webrooturl').'images/cicles/'.$pdf ?>">Baixa't el pdf</a><?php endif; ?></div>						
			</div>
			<div class="df" style="width:330px;">
				<div style="padding-left:10px; font-size:11px;">                    							
					<?php foreach($LLISTAT_ACTIVITATS as $OA): ?>								
							<b><?php echo '<a href="'.url_for('@web_activitat?idA='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl()).'">'.$OA->getTmig().'</a>'; ?></b><br />
							<?php echo generaHoraris($OA->getHorarisActius($IDS)); ?><br /><br />
					<?php endforeach; ?>
																	
				</div>
			</div>
			<div style="clear:both">&nbsp;</div>													
		</div>					
				
		<?php 					
	
	endif;

    ?>
    
      <div style="height:40px;"></div>
                
    </td>
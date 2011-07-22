<?php use_helper('Presentation'); ?>

    <TD colspan="2" class="CONTINGUT">

    <?php include_partial('breadcumb',array('text'=>$TITOL)); ?>

    <?php
     
    if(empty($LLISTAT_ACTIVITATS)): echo '<DIV>Aquest dia no hi ha cap activitat pública.<DIV>'; endif;		
		
	foreach($LLISTAT_ACTIVITATS as $A):
			
		$C = CiclesPeer::retrieveByPK($A->getCiclescicleid());
        
		if($C instanceof Cicles && $C->getCicleID() > 1):
            $nom_cicle = '<b>'.$C->getTMig().'</b>';
            $idC = $C->getCicleID(); 
        else:
            $nom_cicle = "";
            $idC = 0;
        endif;
        
        $url_cicle = myUser::text2url($C->getTMig());
		$imatge = $A->getImatge();
		$pdf = $A->getPdf();         
        $pdf_cicle = $C->getPdf();               
						
        if(!empty($nom_cicle)):	
		?>
			<div style="clear:both;">											
				<div class="df titol_cicle" style="width:150px;">Activitat del cicle</div>
				<div class="df titol_cicle" style="color: #A73339; width:330px; padding-left:20px;"><?php echo $nom_cicle ?></div>									 
			</div>
		<?php endif; ?>
			<div style="border:2px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $A->getTMig() ?></b></div>                
				<div style="font-size:10px"><?php echo generaHoraris($A->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
				<div style="height:30px;">&nbsp;</div>				
										
				<div class="df" style="width:150px;">
					<div><?php if($imatge > 0): ?> <img src="<?php echo sfConfig::get('sf_webrooturl').'images/activitats/'.$imatge ?>" style="vertical-align:middle"><?php endif; ?></div>
						<div style="margin-top:20px; font-size:10px"><?php echo getRetorn(); ?></div>
                        <?php if(!empty($nom_cicle)): ?>
                            <div style="font-size:10px"><a href="<?php echo url_for('@web_cicle?idC='.$idC.'&titol='.$url_cicle) ?>">Veure activitats del cicle</a></div>
                        <?php endif; ?>
						<div class="pdf_cicle">
                            <?php if($pdf > 0): ?> 
                                    <br /><a href="<?php echo sfConfig::get('sf_webrooturl').'images/activitats/'.$pdf ?>">Baixa't el pdf</a>
                            <?php elseif($pdf_cicle > 0): ?>
                                    <br /><a href="<?php echo sfConfig::get('sf_webrooturl').'images/cicles/'.$pdf_cicle ?>">Baixa't el pdf del cicle</a>
                            <?php endif; ?>                            
                        </div>

                    <div style="margin-top: 20px;">
                        <?php echo ph_getAddThisDiv(); ?>                        
                    </div>
                                                            				                        						
				</div>
				<div class="df" style="width:330px;">
					<div style="padding-left:10px; font-size:10px;">
						<?php echo $A->getDmig() ?>
					</div>					
				</div>
				
				<div style="margin-left:150px; padding-top:20px; width:330px; clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">INFORMACIÓ PRÀCTICA</div> 
				<div style=" margin-left:150px; width:330px; clear:both; background-color:#DFECB6">					
					<div style="padding:10px; font-size:10px;">
						<?php echo $A->getInfoPractica(); ?>
					</div>
				</div>
				<div style="clear:both">&nbsp;</div>													
			</div>					
			
			<?php 
			
			echo '<div style="clear:both; height:40px;"></div>';
	     	             	      	                
	endforeach;
    ?>
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

<?php 
/*    
    function getRetorn($A,$NODE)
    {                
        return '<a href="javascript:history.back()">Torna al llistat d\'activitats</a>';                     
    } 
*/
?>
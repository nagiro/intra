<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php if($ACTIVITAT instanceof Activitats):
            $i = $ACTIVITAT->getImatge();
            $imatge = sfConfig::get('sf_webrooturl').'images/activitats/'.$i;
            if(empty($i)) $imatge = sfConfig::get('sf_webrooturl').'images/hospici/logo_hospici.png'; 
            
            $pdf = $ACTIVITAT->getPdf();                          
     ?>
			<div style="border:0px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $ACTIVITAT->getTMig() ?></b></div>
				<div style="font-size:10px"><?php echo generaHoraris($ACTIVITAT->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
				<div style="height:30px;">&nbsp;</div>				
										
				<div style="width:150px; float:left">
					<div><img src="<?php echo $imatge ?>" style="vertical-align:middle" /></div>
						<div style="margin-top:20px; font-size:10px"><?php echo getRetorn(); ?></div>
						<div class="pdf_cicle"><?php if($pdf > 0): ?> <br /><a href="<?php echo sfConfig::get('sf_webrooturl').'images/activitats/'.$pdf ?>">Baixa't el pdf</a><?php endif; ?></div>
                    <div style="margin-top:20px;">
                        <?php echo ph_getAddThisDiv(); ?>
                    </div>                        						
				</div>
                
				<div style="width:330px; float:left;">
					<div style="padding-left:10px; font-size:10px;">
						<?php echo $ACTIVITAT->getDmig() ?>
					</div>					
				</div>
				
                <!-- Requadre d'informació pràctica  -->
                <?php $ip = $ACTIVITAT->getInfopractica(); if(!empty($ip)): ?>
				<div style="margin-left:150px; padding-top:20px; width:330px; clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">INFORMACIÓ PRÀCTICA</div> 
				<div style=" margin-left:150px; width:330px; clear:both; background-color:#DFECB6">					
					<div style="padding:10px; font-size:10px;">
						<?php echo $ip; ?>
					</div>
				</div>
                <?php endif; ?>
				<div style="clear:both">&nbsp;</div>
                
                <!-- Fi Requadre d'informació pràctica  -->
                <!-- Requadre de compra o reserva d'entrades  -->
                
   				<div style="margin-left:150px; padding-top:20px; width:330px; clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">RESERVA D'ENTRADES</div> 
				<div style=" margin-left:150px; width:330px; clear:both; background-color:#DFECB6">					
					<div style="padding:10px; font-size:10px;">
                    
                    <?php if(isset($AUTENTIFICAT) && $AUTENTIFICAT > 0): ?>                                        
                        <div class="taula_dades">
                            <div style="font-weight:bold; float:left; width: 60px;text-align:right;">Dia</div>    
                            <div style="font-weight:bold; float:left; width: 60px;text-align:right;">Hora</div>
                            <div style="font-weight:bold; float:left; width: 60px;text-align:right;">Preu</div>
                            <div style="font-weight:bold; float:left; width: 60px;text-align:right;">Quantes</div>
                            <div style="font-weight:bold; float:left; width: 60px;text-align:right;"></div>
                            <div style="clear: both;"></div>
                            <?php   foreach($LHO as $HO): ?>
                            <form action="<?php echo url_for('@hospici_compra_entrada') ?>">
                                <div style="float:left; width: 60px;text-align:right;"><?php echo $HO->getDia('d/m/Y') ?></div>    
                                <div style="float:left; width: 60px;text-align:right;"><?php echo $HO->getHorainici('H:i') ?></div>
                                <div style="float:left; width: 60px;text-align:right;"><?php echo $ACTIVITAT->getPreu() ?> €</div>
                                <div style="float:left; width: 60px;text-align:right;"><?php echo select_tag('entrades[num]',options_for_select(array(1=>'1',2=>'2',3=>'3',4=>'4')),array('style'=>'width:50px')) ?></div>
                                <div style="float:left; width: 60px;text-align:right;"><input type="submit" name="BRESERVA" value="Reserva" /></div>
                                <div style="clear: both;"><input type="hidden" value="<?php echo $HO->getHorarisid() ?>" name="entrades[idH]" /></div>
                            </form>
                            <?php   endforeach; ?>                        
                        </div>
                    <?php else: ?>
                        <div>
                            Per poder comprar o reservar entrades heu d'accedir al vostre usuari o crear-ne un de nou. 
                        </div>
                    <?php endif; ?>
					</div>
				</div>
                
                <!-- Fi Requadre de compra o reserva d'entrades  -->													
			</div>
    <?php endif; ?>					                                                                    
    </div>
</div>
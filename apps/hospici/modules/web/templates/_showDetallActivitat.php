<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php if($ACTIVITAT instanceof Activitats){
    
            $i = $ACTIVITAT->getImatge();            
            $imatge = '/images/activitats/'.$i;
            
            if(!($i > 0)) $imatge = SitesPeer::getSiteLogo($ACTIVITAT->getSiteId());                                     
            
            $pdf = $ACTIVITAT->getPdf();                          
     ?>
			<div style="border:0px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $ACTIVITAT->getTMig() ?></b></div>
				<div style="font-size:10px"><?php echo generaHoraris($ACTIVITAT->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
				<div style="height:30px;">&nbsp;</div>				
										                                        
                <!-- Columna esquerra -->
                                        
				<div style="width:150px; float:left">
                
					<div><img src="<?php echo $imatge ?>" style="width:150px; vertical-align:middle;" /></div>
                    
                    <div style="margin-top:20px; font-size:10px">
                        <div class="requadre_mini" style="background-color:#A2844A;">
                            <a href="javascript:history.back()">&lt; Torna al llistat de cursos</a>
                        </div>
                    </div>
                    
                    <?php if($pdf > 0): ?>
                    <div class="pdf_cicle" style="margin-top: 5px;">
                        <div class="requadre_mini" style="background-color: #D4A261;">
                            <a href="/images/activitats/<?php echo $pdf ?>">Baixa't el pdf</a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div style="margin-top:5px;">
                        <?php echo myUser::ph_getEtiquetaActivitats($AUTENTIFICAT, $ACTIVITAT, $ACTIVITATS_AMB_ENTRADES); ?>
                    </div>
                    												
                    <div style="margin-top:20px;">
                        <?php echo ph_getAddThisDiv(); ?>
                    </div>   
                                         						
				</div>
                
                <!-- Fi columna esquerra -->
                <!-- Text central -->
                
				<div style="width:400px; float:left; ">
					<div style="padding-left:10px; font-size:10px;">
						<?php echo $ACTIVITAT->getDmig() ?>
					</div>					
				</div>
				
                <!-- Fi text central -->
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
				<div style="margin-left:150px; width:330px; clear:both; background-color:#DFECB6">					
					<div style="padding:10px; font-size:10px;">

                        <?php
                                 
                            $AUTEN  = (isset($AUTENTIFICAT) && $AUTENTIFICAT > 0);
                            $isMat  = $ACTIVITAT->getIsentrada();
                            $Places = $ACTIVITAT->getPlaces();
                            $isPle  = $ACTIVITAT->getIsPle();                 
                            $JaRes  = (isset($ACTIVITATS_AMB_ENTRADES[$ACTIVITAT->getActivitatid()]));
                            $url    = url_for('@hospici_detall_activitat?idA='.$ACTIVITAT->getActivitatid().'&titol='.$ACTIVITAT->getNomForUrl());
                            $idS    = $ACTIVITAT->getSiteId();
                    
                            $OS     = SitesPeer::retrieveByPK($idS);
                            $nom    = $OS->getNom();
                            $email  = $OS->getEmailString();
                            $tel    = $OS->getTelefonString();
                                                        

                            //Si no està autentificat
                            if( !$AUTEN ){
                                echo '<div>Per poder comprar o reservar entrades heu d\'accedir al vostre usuari clicant <a class="auth" href="'.$url.'" >aquí</a>.</div>';
                            //Ja està autentificat
                            }else {                    
                                //Ja ha reservat per aquesta activitat
                                if( $JaRes ){                                    
                                    $OER =  EntradesreservaPeer::retrieveByPK($ACTIVITATS_AMB_ENTRADES[$ACTIVITAT->getActivitatid()]);
                                    if( $OER instanceof EntradesReserva ){
                                        //Si l'usuari ja té l'entrada reservada, doncs li marquem
                                        if($OER->getEstat() == EntradesreservaPeer::CONFIRMADA){
                                            echo '<div>Vostè ha reservat entrades per aquesta activitat correctament.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>';                                            
                                        //La reserva està anul·lada
                                        } elseif($OER->getEstat() == EntradesreservaPeer::ANULADA) {
                                            echo '<div>Vostè ha reservat entrades però han estat anul·lades.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>';                                            
                                        }
                                    }                                                                                                                                
                                //No ha reservat            
                                } else {                                    
                                    //No queden places
                                    if( $isPle ){
                                        echo '<div>Aquesta activitat ha exhaurit les entrades.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>';                                                                                                                
                                    //Pot reservar entrades
                                    }elseif( $isMat ){
                                        ?>
                                        <form action="<?php echo url_for('@hospici_compra_entrada') ?>">
                                            <div class="taula_dades">                                            
                                                <div style="margin-bottom: 5px;">
                                                    <div style="float:left; font-weight: bold; width:120px;">Activitat: </div>
                                                    <div>
                                                        <?php echo $ACTIVITAT->getNom() ?>
                                                        <span class="tipMy tip" title="Aquest és el nom de l'activitat a la que vol reservar una o més entrades.">?</span>                                                                                                                                                            
                                                    </div>
                                                </div>
                                                <div style="margin-bottom: 5px;">
                                                    <div style="font-weight: bold; float:left; width:120px;">Preu:</div>
                                                    <div>
                                                        <?php echo $ACTIVITAT->getPreu() ?> €
                                                        <span class="tipMy tip" title="La reserva a una activitat és gratuïta. L'import que es mostra serà abonat a l'entitat seguint el seu criteri exposat. En cas de dubte, consulti a l'entitat organitzadora.">?</span>
                                                    </div>
                                                </div>
                                                <div style="margin-bottom: 5px;">
                                                    <div style="font-weight: bold; float:left; width:120px;">Quantes entrades?</div>
                                                    <div>
                                                        <?php echo select_tag('entrades[num]',options_for_select(array(1=>'1',2=>'2',3=>'3',4=>'4')),array('style'=>'width:50px')) ?>
                                                        <span class="tipMy tip" title="Amb el seu usuari, només pot extreure un màxim de 4 entrades per activitat.">?</span>
                                                    </div>
                                                </div>
                                                <div style="margin-bottom: 5px;">
                                                    <?php echo input_hidden_tag('entrades[idA]',$ACTIVITAT->getActivitatid()) ?>
                                                    <div style="margin-left:200px;"><input style="padding:3px;" type="submit" name="BRESERVA" value="Reserva l'entrada" /></div>                                                    
                                                </div>
                                            </div>                                            
                                        </form>
                                        <?php   
                                    }            
                                    
                                }                                
                            }                                                                                    
                    
                    ?>
                    
				</div>
               </div>                
                
                <!-- Fi Requadre de compra o reserva d'entrades  -->													
			</div>
    <?php } ?>					                                                                    
    </div>
</div>

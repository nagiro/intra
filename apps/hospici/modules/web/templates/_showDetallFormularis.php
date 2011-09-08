<style>
  .text-secund { color:gray; text-align:justify; padding-left:30px;}
  .col1 { clear:both; float:left; width:150px;  }
  .col2 { float:left; width:450px; }  
</style>
<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php if($FORM instanceof Formularis){            
            $imatge = "/images/hospici/hospici100_100.jpg";
            $url    = url_for('@hospici_formularis_detall?idF='.$FORM->getIdformularis().'&titol='.$FORM->getNomForUrl());            
                                      
     ?>
			<div style="border:0px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $FORM->getNom() ?></b></div>
                <div style="font-size: 11px; color:gray; "><?php echo $FORM->getDescripcio() ?></div>
				<div style="font-size:10px"><?php // echo generaHoraris($ACTIVITAT->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
				<div style="height:30px;">&nbsp;</div>				
                                
				<div style="width:550px; float:left;">
					<div style="padding-left:10px; font-size:10px;">
                        <form action="<?php echo url_for('@hospici_nou_formulari'); ?>" method="post">
                        <div>
                        <?php 
                            if( $AUTH ):
                                echo $FORM_TEXT;                                                         
                            endif; 
                        ?>                                                
                        </div>                        
                                                
                        <!-- Requadre de compra o reserva d'entrades  -->
                    <?php if(!$FORM->isOmplert($IDU)){ ?>                        
           				<div style="margin-left:150px; padding-top:20px; width:330px; clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">ENVIA EL FORMULARI</div> 
        				<div style="margin-left:150px; width:330px; clear:both; background-color:#DFECB6">					
        					<div style="padding:10px; font-size:10px;">
        
                                <?php
                                         
                                    //Si no està autentificat
                                    if( !$AUTH ){
                                        echo '<div>Per omplir i enviar el formulari heu d\'accedir al vostre usuari clicant <a class="auth" href="'.$url.'" >aquí</a>.</div>';
                                    //Ja està autentificat
                                    }else {        
                                        echo '  <div style="margin-bottom: 5px;">
                                                    '.input_hidden_tag('formulari[idF]',$FORM->getIdformularis()).'
                                                    Cliqueu el botó per enviar i enregistrar el formulari.<br /><br />
                                                    <div style="margin-left:200px;">                                                        
                                                        <input style="padding:3px;" type="submit" name="BRESERVA" value="Envia el formulari" />
                                                    </div>                                                    
                                                </div>';                                                                                    
                                    }                                                                                    
                            
                            ?>
                            
        				</div>
                       </div>                
                        
                        <!-- Fi Requadre de compra o reserva d'entrades  -->
                        <?php } ?>													
                        </form>                                                                           
					</div>                    
                </div>
                
			</div>					   
    <?php } ?>                                                                 
   </div>
</div>
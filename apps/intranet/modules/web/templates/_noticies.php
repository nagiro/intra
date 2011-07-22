<?php use_helper('Form'); ?>
<?php use_helper('Presentation'); ?>

    <td colspan="2" class="CONTINGUT">
    
    <?php include_partial('breadcumb',array('text'=>'NOTÍCIES')); ?>
    
    <?php 
    
    	if(!is_null($NOTICIA)):
    		mostraNoticia( $NOTICIA , $PAGINA );
    	else: 
    		mostraNoticies( $NOTICIES , $PAGINA );    	
    	endif; 
		    	
	?>
	
      <div style="height:40px;"></div>
                
    </td>
    
    <?php 

    
	function mostraNoticia( $NOTICIA , $PAGINA )
    {
            	     							       											
     	$titol = '<b>'.$NOTICIA->getTitolnoticia().'</b>'; $imatge = $NOTICIA->getImatge(); $pdf = $NOTICIA->getAdjunt(); $descripcio = $NOTICIA->getTextnoticia();
        
        $WEBURL = OptionsPeer::getString('SF_WEBROOTURL',1).'images/noticies/';
        $SYSURL = OptionsPeer::getString('SF_WEBSYSROOT',1).'images/noticies/';
        
        $IMG_EXIST = (file_exists($SYSURL.$imatge) && !empty($imatge) );
        $PDF_EXIST = (file_exists($SYSURL.$pdf)  && !empty($pdf) );
     	
		if(!empty($titol)):
		?>                    																		
			<div class="titol_noticia"><?php echo $titol ?></div>									 
			<div style="margin-top:10px;">														
				<div class="text_noticia"><?php echo $descripcio ?></div>
				<div class="imatge_noticia">
                    <?php if($IMG_EXIST): ?> 
    					<img src="<?php echo $WEBURL.$imatge ?>" style="vertical-align:middle"> 
                    <?php endif; ?>					
				    <div style="padding-top:10px;" class="pdf_noticia">
                    <?php if($PDF_EXIST): ?>
                        <a href="<?php echo $WEBURL.$pdf ?>">Descarrega't el pdf</a>
                    <?php endif; ?>
                </div>
				</div>
			</div>
			<div style="clear:both; padding-top:10px;">
				<div class="llegir_mes">
                    <div>
                        <?php echo ph_getAddThisDiv(); ?>                                                    
                    </div>                				
			</div>					
			
			<div style="clear:both;">&nbsp;</div>																						
						
            				
	    <?php
 		endif;

    }
    
    
    
    
	function mostraNoticies($NOTICIES, $PAGINA)
	{	    		
		
	    if($NOTICIES->getNbResults() == 0): 
	
			echo '<DIV>Actualment no hi ha cap notícia.<DIV>';
	
		else: 			    
				
			foreach($NOTICIES->getResults() as $ON):
															
				$imatge = $ON->getImatge();
				$pdf = $ON->getAdjunt();		
				$text = FormHelper_SubstrCloseTags($ON->getTextnoticia(),400);	
				$nom_noticia = '<b>'.$ON->getTitolnoticia().'</b>';

                $WEBURL = OptionsPeer::getString('SF_WEBROOTURL',1).'images/noticies/';
                $SYSURL = OptionsPeer::getString('SF_WEBSYSROOT',1).'images/noticies/';
                
                $IMG_EXIST = (file_exists($SYSURL.$imatge) && !empty($imatge) );
                $PDF_EXIST = (file_exists($SYSURL.$pdf)  && !empty($pdf) );
                                
			?>
				<div style="border-bottom:2px solid #CADF86;">
																
					<div class="titol_noticia">
                        <a href="<?php echo url_for('@web_noticia?idN='.$ON->getIdnoticia().'&p='.$PAGINA.'&titol='.$ON->getNomForUrl()) ?>"><?php echo $nom_noticia ?></a>                                                
                    </div>									 
					<div style="margin-top:10px;">														
						<div class="text_noticia">                            
                            <?php echo $text; ?>...                                                    
                        </div>
						<div class="imatge_noticia">
                            <?php if($IMG_EXIST): ?> 
                                <img src="<?php echo $WEBURL.$imatge ?>" style="vertical-align:middle" /> 
                            <?php endif; ?>                            
							<div style="padding-top:10px;" class="pdf_noticia">
                                <?php if($PDF_EXIST): ?>
                                    <a href="<?php echo $WEBURL.$pdf ?>">Descarrega't el pdf</a>
                                <?php endif; ?>
                            </div>                            
						</div>
					</div>
					<div style="clear:both; padding-top:10px;">
						<div class="llegir_mes">                                                                    
                        </div>
					</div>					
					
					<div style="clear:both;">&nbsp;</div>					
																
				</div>
					
				<div style="clear:both; height:20px;"></div>
				
			<?php	
			endforeach;
		
		endif;
				
	}

?>
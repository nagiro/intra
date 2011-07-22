<?php use_helper('Form')?>

    <TD colspan="3" class="CONTINGUT_ADMIN">
    
    <?php include_partial('breadcumb',array('text'=>'LLISTES')); ?>
    
	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post" enctype="multipart/form-data">
  	    <DIV class="REQUADRE">
	    <DIV class="TITOL"> <?php echo link_to(image_tag('tango/32x32/actions/document-new.png', array('size'=>'16x16','alt'=>'Nova llista')),'gestio/gLlistes'.getPar(NULL,'N')); ?> Llistes disponibles</DIV>
	    	<table class="DADES">          
                <?php                 
                  if( sizeof($LLISTES) == 0 ) echo '<TR><TD class="LINIA" colspan="5">No hi ha cap llista disponible.</TD></TR>';
                                    
                  foreach($LLISTES as $L):                  
                      echo '<TR><TD class="LINIA">'.link_to($L->getNom(),'gestio/gLlistes?accio=E&IDL='.$L->getIdllistes()).'</TD>
                                <TD class="OPCIONS" width="80px">'.creaOpcions($L->getIdllistes()).'</TD>
                            </TR>';                                   
                  endforeach;                                  
                ?>
    
	        </table>
	     </DIV>
	     
	<?php if(empty($MODE)): ?>
	   	<DIV class="REQUADRE">
	    <DIV class="TITOL"> <?php echo link_to(image_tag('tango/32x32/actions/document-new.png', array('size'=>'16x16','alt'=>'Nova llista')),'gestio/gLlistes?accio=EM'); ?> Missatges disponibles</DIV>
	    	<table class="DADES" width="100%">	    		          
                <?php                 
                  if( sizeof($MISSATGES) == 0 ) echo '<TR><TD class="LINIA" colspan="5">No hi ha cap missatge enviat.</TD></TR>';
                                    
                  foreach($MISSATGES->getResults() as $M):                  
                      echo '<TR><TD class="LINIA">'.link_to($M->getTitol(),'gestio/gLlistes?accio=EM&IDM='.$M->getidMissatge()).'</TD>
		 	                   	<TD class="LINIA">'.getMissatgesEnviatsLlistes($M).'</TD>                                
                            </TR>';                                   
                  endforeach;                                  
                ?>
    
	        </table>
	     </DIV>
	<?php endif; ?>	     
	     	     
     </form>                  
  
  <?php IF( $MODE == 'NOU' || $MODE == 'EDICIO' ): ?>

	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">            
	 	<DIV class="REQUADRE">	 
	 		<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gLlistes'))?>
	    	<table class="FORMULARI" width="500px">
                <?php echo $FLlista ?>                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
						<?php include_partial('botonera',array('tipus'=>'Guardar','element'=>'la llista')); ?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>  

  <?php ENDIF; ?>
  <?php IF( $MODE == 'USUARIS' ): ?>

	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">
        <input type="hidden" name="IDL" value="<?php echo $IDL ?>" />    
 	    <DIV class="REQUADRE">
 	    	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gLlistes'))?>
 	    	<DIV class="TITOL">Filtra usuaris</DIV>            
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?> 
	            <tr>
	            	<td></td>
                    <td>                    
                        <button name="BCERCA">Prem per buscar</button></td> 			            			            	
	            	</td>
	            </tr>
	        </table>
	     </DIV>
	
	    <DIV class="REQUADRE">
            <table width="100%">
                <tr>
                    <td style="vertical-align:top;">
                        <b>Usuaris subscrits</b><br /><br />
                        <?php echo select_tag('BAIXA_USUARI',options_for_select($VINCULATS,array(),array()),array('multiple'=>false,'width'=>"200px",'height'=>'500px')); ?>
                    </td>
                    <td style="vertical-align:top;">
                        <b>Usuaris NO subscrits</b><br /><br />
                        <?php echo select_tag('ALTA_USUARI',options_for_select($DESVINCULATS,array(),array()),array('multiple'=>false,'width'=>"200px")); ?>
                    </td>
                </tr>
                <tr><td><button class="BOTO_ACTIVITAT" name="BDESVINCULA">DESVINCULA</button></td>
                    <td><button class="BOTO_ACTIVITAT" name="BVINCULA">VINCULA</button></td></tr>
            </table>                            	                  
        </DIV>


	    <DIV class="REQUADRE">
            <table width="100%">
                <?php include_partial('missatgeTaula',array('MISS'=>$MISSATGE,'colspan' => '1')); ?>
                <tr>
                    <td style="vertical-align:top;">
                        <b>Emails lliures subscrits</b><br /><br />
                        <?php echo textarea_tag('EMAILS',$EMAILS, array('style'=>'height: 200px')); ?>
                    </td>                    
                </tr>
                <tr><td><button class="BOTO_ACTIVITAT" name="BACTUALITZAEMAILS">ACTUALITZA</button></td><tr>                    
            </table>                            	                  
        </DIV>

      
       </form>

  <?php ENDIF; ?>      
  <?php IF( $MODE == 'MISSATGES' ): ?>


	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">            
	 	<DIV class="REQUADRE">
         <DIV class="TITOL">Escriu el missatge</DIV>	             	
	    	<table class="FORMULARI" width="600px">	    	
                <?php echo $FMissatge ?>                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br />
	            		<button class="BOTO_ACTIVITAT" name="BSAVE_MISSATGE">Guardar</button>	            		    			
	            		<button class="BOTO_ACTIVITAT" name="BSEGUEIX_LLISTES">Segueix -->></button>	            			            	            		
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
      	
     </form>  

    
  <?php ENDIF; ?>
  
  <?php IF( $MODE == 'MISSATGES_LLISTES' ): ?>


	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">            
	 	<DIV class="REQUADRE">	 
         <DIV class="TITOL">Escull les llistes on vols enviar-lo </DIV>
            <?php echo input_hidden_tag('IDM',$IDM); ?>            	
	    	<table class="FORMULARI" width="600px">
	    		<tr><td>Llistes: </td><td><?php echo select_tag('LLISTES_ENVIAMENT',options_for_select(LlistesPeer::select($IDS),$LLISTES_ENVIAMENT),array('multiple'=>true)); ?></td></tr>	    	                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br>
	            		<button class="BOTO_ACTIVITAT" name="BSAVE_LLISTES">Guardar</button>
	            		<button class="BOTO_ACTIVITAT" name="BSEGUEIX_ENVIAMENT">Segueix -->></button>	            		    				            		         	            		
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
      	
     </form>  

    
  <?php ENDIF; ?>
  

  <?php IF( $MODE == 'FER_PROVA' ): ?>


	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">
        <input type="hidden" name="IDM" value="<?php echo $IDM ?>" />            
	 	<DIV class="REQUADRE">	 	
        <DIV class="TITOL">Envia el missatge</DIV>
	    	<table class="FORMULARI" width="600px">
	    		<tr><td>Email de prova: </td><td><?php echo input_tag('email'); ?></td></tr>	    	                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br>
	            		<button class="BOTO_ACTIVITAT" name="BSEND_PROVA">Enviar prova</button>
	            		<button onClick="return confirm('Segur que vols enviar el missatge a tothom?')" class="BOTO_ACTIVITAT" name="BSEND_TOTHOM">Enviar a tothom</button>
	            		<button class="BOTO_ACTIVITAT" name="BFI">Finalitzar</button>	            		    				            			            			            	            		
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
      	
     </form>  

    
  <?php ENDIF; ?>

  
  
  <?php IF( $MODE == 'ENVIAT' ): ?>
    
      <TABLE class="BOX"><TR><TD class="NOTICIA">MISSATGE ENVIAT A <?php echo $MAILS?> PERSONES.</TD></TR></TABLE>      

  <?php ENDIF; ?>
  <?php IF( $MODE == 'LLISTAT' ): ?>

	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Llistat de missatges de la llista:  <?php echo $LLISTA->getNom(); ?> (<a href="<?php echo url_for('gestio/gLlistes?accio=EM&IDL='.$IDL); ?>">Nou missatge</a>)</DIV>
	    	<table class="DADES">	    		       
	    			
		    	  <?php if($LMISSATGES->getNbResults() == 0): ?>
		    		<tr><td class="LINIA">Actualment no hi ha cap missatge a la llista.</td></tr>	    	
		    	  <?php endif; ?>
	    	  
                  <?php foreach($LMISSATGES->getResults() as $M):  ?>                                                       
                  	<TR>
                  		<TD class="LINIA"><?php echo link_to($M->getTitol(),'gestio/gLlistes?accio=M&IDM='.$M->getIdmissatge().'&IDL='.$LLISTA->getIdllistes())?></TD>
						<TD class="LINIA">
							<?php 
								
								if(!is_null($M->getDataEnviament($LLISTA->getIdllistes()))):
								
									echo $M->getDataEnviament($LLISTA->getIdllistes());
									
								else:
								
									echo 'No enviat';
									
								endif;
								
							?>
						</TD>
              		</TR>
                  <?php endforeach; ?>
                  <TR>                	                   	  
	        </table>
	     </DIV>
  
  <?php ENDIF; ?>

  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    
    
<!-- FI CONTINGUT -->
<!-- CALENDARI -->
 <!-- >
    <TD class="CALENDARI">          
      
    </TD>
-->
<!-- FI CALENDARI -->

<?php 

function creaOpcions($IDL , $ACCIO = NULL)
{      
	
  $R  = link_to('<span>Gestió dels usuaris de la llista</span>'.image_tag('template/user.png',array('alt'=>'Gestió d\'usuaris de la llista.')),'gestio/gLlistes?accio=U&IDL='.$IDL,array('class'=>'tt2'));
  $R .= " ";  
  $R .= link_to('<span>Llistat de missatges enviats</span>'.image_tag('template/page_white_stack.png',array('alt'=>'Llistat de missatges enviats.')),'gestio/gLlistes?accio=L&IDL='.$IDL,array('class'=>'tt2'));  
  
  return $R;
}


function generaTaula($USUARISLLISTES,$PAGINA)
{
  $RET = '<TABLE class="Dades">';        
  foreach($USUARISLLISTES as $UL):   
    $U = $UL->getUsuaris(); 
    $RET .= '<TR><TD class="linia">'.checkbox_tag('USUARIS[]',$U->getUsuariid(),false).'</TD><TD class="linia">'.$U->getDNI().'</TD><TD class="linia">'.$U->getCog1()." ".$U->getCog2().', '.$U->getNom().'</TD></TR>';    
  endforeach;
  $RET .= "</TABLE>";  
  
  return $RET;
}


function generaLlistaMails($MISSATGES,$IDL)
{
  $RET = '<TABLE class="Dades">';        
  foreach($MISSATGES->getResults() as $M):                
    $RET .= '<TR><TD class="linia">&nbsp;&nbsp;&nbsp;'.fletxeta().'&nbsp;&nbsp;&nbsp;'.link_to($M->getTitol(),'gestio/gLlistes'.getPar($IDL,'MV',$M->getIdmissatgesllistes())).'</TD><TD class="linia">'.$M->getDate().'</TD></TR>';    
  endforeach;
  $RET .= "</TABLE>";  
  
  return $RET;
}



function fletxeta()
{
  return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));
}


function getPar($IDL = NULL, $accio = NULL, $IDM = NULL)
{
    $A = "";        
    if(!is_null($IDL)) $A[] = 'IDL='.$IDL;
    if(!is_null($accio)) $A[] = 'accio='.$accio;
    if(!is_null($IDM)) $A[] = 'IDM='.$IDM;
    if(!empty($A)) return '?'.implode('&',$A); 
    else return '';
    
}

function getParPaginacio($ACCIO , $PAGINA = 1, $IDL = null)
{
    $A = "";        
    if(!empty($ACCIO)) $A[] = 'accio='.$ACCIO;
    if(!empty($PAGINA)) $A[] = 'PAGINA='.$PAGINA;    
    if(!empty($IDL)) $A[] = 'IDL='.$IDL;
    
    if(!empty($A)) return '?'.implode('&',$A); 
    else return '';
    
}

function gestorPaginesUsuarisLlista( $USUARIS )
{
   if($USUARIS->haveToPaginate())
   {       
      echo link_to(image_tag('tango/16x16/actions/go-previous.png'), "gestio/gLlistes".getParPaginacio('U',$USUARIS->getPreviousPage()));
	  echo " ";
	  echo link_to(image_tag('tango/16x16/actions/go-next.png'), "gestio/gLlistes".getParPaginacio('U',$USUARIS->getNextPage()));
   }
}

function gestorPaginesUsuarisNoLlista( $USUARIS )
{
   if($USUARIS->haveToPaginate())
   {       
      echo link_to(image_tag('tango/16x16/actions/go-previous.png'), "gestio/gLlistes".getParPaginacio('U',$USUARIS->getPreviousPage()));
	  echo " ";
	  echo link_to(image_tag('tango/16x16/actions/go-next.png'), "gestio/gLlistes".getParPaginacio('U',$USUARIS->getNextPage()));
   }
}

function getMissatgesEnviatsLlistes($M)
{
	$RET = "";
	
	foreach($M->getMissatgesllistess() as $L):						
		$RET .= $L->getLlistes()->getNom().'<br />';
	endforeach;
	
	return $RET;
	
}

?>

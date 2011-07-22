<script type="text/javascript">

	 $(document).ready(function() {

         $('#new_user').validate({            
                rules:{
                    "usuaris[DNI]": { required: true, rangelength: [9, 9] },
                    "usuaris[Passwd]": { required: true },
                    "usuaris[Nom]": { required: true },
                    "usuaris[Cog1]": { required: true },
                    "usuaris[Cog2]": { required: false },
                    "usuaris[Email]": { required: true , email: true },
                    "usuaris[Adreca]": { required: true },
                    "usuaris[CodiPostal]": { required: true , number: true },
                    "usuaris[Poblacio]": { required: false },
                    "usuaris[Poblaciotext]": { required: function(){ return ($('#usuaris_Poblacio option:selected').val() == ''); } },
                    "usuaris[Telefon]": { required: false },
                    "usuaris[Mobil]": { required: function(){ return ($('#usuaris_Telefon').val().length == 0); }},                                        
                },
                messages: {
                    "usuaris[DNI]": { rangelength: "<br />Format: 00000000A o X0000000A." }
                }
         });
    });
                                     
</script>

<?php use_helper('Form') ?>

    <TD colspan="3" class="CONTINGUT_ADMIN">
    
    <?php include_partial('breadcumb',array('text'=>'USUARIS')); ?>
    
   	<form action="<?php echo url_for('gestio/gUsuaris') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<button name="BCERCA">Prem per buscar</button>	            		
	            		<button name="BNOU">Nou usuari</button>	            		
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>  
  
  <?php IF( isset($MODE['NOU']) && $MODE['NOU'] || isset($MODE['EDICIO']) && $MODE['EDICIO'] ): ?>
      
	<form id="new_user" action="<?php echo url_for('gestio/gUsuaris') ?>" method="post" enctype="multipart/form-data">  	               
	 	<DIV class="REQUADRE">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gUsuaris?accio=FC'))?>	 	
	    	<table class="FORMULARI" width="500px">
                <?php echo $FUsuari?>                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
						<?php include_partial('botonera',array('element'=>'l\\\'usuari')); ?>	            	
					</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    
  
  <?php ENDIF;?>
  
  <?php IF( isset($MODE['LLISTES']) && $MODE['LLISTES'] ): ?>

	<form action="<?php echo url_for('gestio/gUsuaris') ?>" method="post">
     <DIV class="REQUADRE">
     	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gUsuaris?accio=FC'))?>        
        <DIV class="TITOL">Llistes subscrites de'n <?php echo $USUARI->getNomComplet() ?></DIV>
      	<TABLE class="DADES">
                <?php
                                                     
                  if($USUARI->countUsuarisllistess() == 0) echo '<TR><TD class="LINIA" colspan="5">L\'Usuari no està subscrit a cap llista.</TD></TR>';                                    
                  foreach($USUARI->getUsuarisllistess() as $L):                  
                      echo '<TR>
                       			<TD width="10px" class="LINIA">'.checkbox_tag('D[IDL][]',$L->getLlistesIdllistes(),false).'<TD class="LINIA">'.$L->getLlistes()->getNom().'</TD>                                                           
                            </TR>';                                   
                  endforeach;                                  
                  echo '<TR><TD colspan="2"><button name="BDESVINCULA">DESVINCULA</button></TD></TR>';
                                    
                ?>
      	</TABLE>      
      </DIV>
  
     <DIV class="REQUADRE">
        <div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gUsuaris?accio=FC'); ?></div>
        <DIV class="TITOL">Llistes disponibles per a en <?php echo $USUARI->getNomComplet() ?></DIV>
      	<TABLE class="DADES">
                  <?php
                                                     
	                  if(empty($LLISTAT_LLISTES)) echo '<TR><TD class="LINIA" colspan="5">No s\'ha trobat cap llista disponible.</TD></TR>';                                    
	                  foreach($LLISTAT_LLISTES as $IDL => $L):                  
	                      echo '<TR>
	                       			<TD width="10px" class="LINIA">'.checkbox_tag('D[IDL][]',$IDL,false).'<TD class="LINIA">'.$L.'</TD>                                                           
	                            </TR>';                                   
	                  endforeach;                                  
	                  echo '<TR><TD colspan="2"><button name="BVINCULA">VINCULA</button></TD></TR>';
                                    
                ?>
      	</TABLE>      
      </DIV>
      </form>
    
  <?php ENDIF;?>
  
  <?php IF( isset($MODE['CURSOS']) && $MODE['CURSOS'] ): ?>

     <DIV class="REQUADRE">
     	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gUsuaris?accio=FC'))?>	    
        <DIV class="TITOL">Llistat de matrícules de'n <?php echo $USUARI->getNomComplet() ?> (<?php echo link_to('Nova matricula','gestio/gMatricules?accio=NU&id_usuari='.$USUARI->getUsuariid()); ?>)</DIV>
      	<TABLE class="DADES">
                <?php                 
                  if(sizeof($MATRICULES) == 0) echo '<TR><TD class="LINIA" colspan="5">L\'Usuari no ha fet cap curs a la Casa de Cultura.</TD></TR>';                                    
                  foreach($MATRICULES as $M):                  		
						$CURSOS = $M->getCursos();           
	                    if($CURSOS instanceof Cursos):           
	                    echo '<TR><TD class="LINIA">'.$CURSOS->getCodi().'</TD>
	                              <TD class="LINIA">'.$CURSOS->getTitolCurs().'</TD>
	                              <TD class="LINIA">'.$M->getEstatString().'</TD>
	                              <TD class="LINIA">'.$M->getDataInscripcio().'</TD>
	                              <TD class="LINIA">'.$M->getTreduccioString().'</TD>
	                              <TD class="LINIA">'.$M->getComentari().'</TD>                                                                                           
	                          </TR>';                 
						endif;                  
                  endforeach;                                                    
                ?>
      	</TABLE>      
      </DIV>
  
  <?php ENDIF; ?>
  
  <?php IF( isset($MODE['REGISTRES']) && $MODE['REGISTRES'] ): ?>

     <DIV class="REQUADRE">
     	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gUsuaris?accio=FC'))?>
        <DIV class="TITOL">Llistat de reserves de'n <?php echo $USUARI->getNomComplet() ?></DIV>
      	<TABLE class="DADES">
                <?php
                                  
                  if(sizeof($RESERVES) == 0) echo '<TR><TD class="LINIA" colspan="5">L\'Usuari no ha fet cap reserva.</TD></TR>';                                    
                  foreach($RESERVES as $R):                                            
                      echo "<TR><TD class=\"LINIA\">".link_to($R->getNom(),'gestio/gReserves?accio=E&IDR='.$R->getReservaespaiid())."</TD><TD class=\"LINIA\">".$R->getUsuaris()->getNomComplet()."</TD><TD class=\"LINIA\">".$R->getDataactivitat()."</TD><TD class=\"LINIA\">".$R->getEstatText()."<TD></TR>";
                  endforeach;                                  

                ?>
      	</TABLE>      
      </DIV>

  <?php ENDIF; ?>
  
  <?php IF( isset($MODE['GESTIO_APLICACIONS']) && $MODE['GESTIO_APLICACIONS'] ): ?>

	<form action="<?php echo url_for('gestio/gUsuaris') ?>" method="post">
     <DIV class="REQUADRE">
	    <?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gUsuaris?accio=FC'));
                echo input_hidden_tag('id_usuari',$USUARI->getUsuariId());
        
        ?>
        <DIV class="TITOL">Gestió de permisos d'aplicacions de l'usuari <?php echo $USUARI->getNomComplet() ?></DIV>        
      	<TABLE class="DADES">
                <?php                    
                	foreach(AppsPeer::select() as $IDAPP => $APP):     
                		$SELECT = (isset($LLISTAT_PERMISOS[$IDAPP]))?$LLISTAT_PERMISOS[$IDAPP]:NivellsPeer::CAP;                		
                		           		
                		echo '<tr><td>'.AppsPeer::getNom($IDAPP).'</td>
                				  <td>'.select_tag('PERMIS['.$IDAPP.']',options_for_select(NivellsPeer::getSelect(),$SELECT,array('include_blank'=>true))).'</td>
                			  </tr>';
                	endforeach;
                	
                	echo '<TR><TD colspan="2"><button name="BACTUALITZA_PERMISOS" class="BOTO_ACTIVITAT">ACTUALITZA</TD></TR>';                                         
                ?>
      	</TABLE>      
      </DIV>
     </form>

  <?php ENDIF; ?>

	<?php IF( isset($MODE['CONSULTA']) && $MODE['CONSULTA'] ): ?>

     <DIV class="REQUADRE">     	
        <DIV class="TITOL">Llistat d'usuaris (<?php echo $PAGER_USUARIS->getNbResults()?>)</DIV>
      	<TABLE class="DADES">
      			<?php 
                	if($PAGER_USUARIS->getNbResults() == 0):
                  		echo '<TR><TD class="LINIA" colspan="4">No s\'ha trobat cap usuari.</TD></TR>';
                 	else:                 
	                 	foreach($PAGER_USUARIS->getResults() as $U):
		                 	echo '	<TR><TD class="LINIA">'.link_to($U->getDni(),'gestio/gUsuaris'.getPar($PAGINA,$U->getusuariid(),'E')).'</TD>
		                        		<TD class="LINIA">'.$U->getNomComplet().'</TD>
		                        		<TD class="LINIA">'.$U->getTelefon().'</TD> 
		                        		<TD class="OPCIONS">'.creaOpcions($PAGINA, $U->getusuariid(), NULL).'</TD>
		                    		</TR>';                                   
	                	endforeach;                    
	                	echo '<TR><TD>'.gestorPaginesUsuaris( $PAGER_USUARIS ).'</TD></TR>';
	            	endif;
	            ?> 
      	</TABLE>      
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

	function creaOpcions($PAGINA, $IDU, $ACCIO)
	{  
	
	  $R  = link_to(image_tag('template/page_white_stack.png').'<span>Llistes a les que està subscrit</span>','gestio/gUsuaris'.getPar($PAGINA,$IDU,'L'),array('class'=>'tt2')).' ';
	  $R .= link_to(image_tag('template/bookmark_document.png').'<span>Historial de cursos</span>','gestio/gUsuaris'.getPar($PAGINA,$IDU,'C'),array('class'=>'tt2')).' ';  
	  $R .= link_to(image_tag('template/book.png').'<span>Historial de reserves</span>','gestio/gUsuaris'.getPar($PAGINA,$IDU,'R'),array('class'=>'tt2')).' ';
	  $R .= link_to(image_tag('template/application2.png').'<span>Gestió de les aplicacions i permisos.</span>','gestio/gUsuaris'.getPar($PAGINA,$IDU,'GA'),array('class'=>'tt2')).' ';
	   
	  return $R;
	}
	
	
	function fletxeta()
	{
	  return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));
	}
	
	
	function getPar($PAGINA = "", $IDU = "", $ACCIO = "")
	{
	   
	    $A = ""; 
	    if(!empty($PAGINA)) $A[] = 'PAGINA='.$PAGINA;
	    if(!empty($IDU)) $A[] = 'id_usuari='.$IDU;
	    if(!empty($ACCIO)) $A[] = 'accio='.$ACCIO;
	    if(!empty($A)) return '?'.implode('&',$A); 
	    else return '';
	    
	}
	
	
	function gestorPaginesUsuaris( $USUARIS )
	{
	   if($USUARIS->haveToPaginate())
	   {       
	      echo link_to(image_tag('tango/16x16/actions/go-previous.png'), "gestio/gUsuaris".getPar($USUARIS->getPreviousPage()));
		  echo " ";
		  echo link_to(image_tag('tango/16x16/actions/go-next.png'), "gestio/gUsuaris".getPar($USUARIS->getNextPage()));
	   }
	}

?>
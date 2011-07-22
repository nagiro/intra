<?php use_helper('Form') ?>
<?php use_javascript('/sfFormExtraPlugin/js/jquery.autocompleter.js') ?>
<?php use_stylesheet('/sfFormExtraPlugin/css/jquery.autocompleter.css') ?>
 
<script type="text/javascript">

$(document).ready( function() { 
	$('#IDD').change( function() {
		$('#FCERCA').append('<input type="hidden" name="B_VEURE_PERMISOS"></input>').submit(); 			
	});
});


</script>
 
<STYLE>
.cent { width:100%; }
.noranta { width:90%; }
.vuitanta  { width:80%; }
.setanta { width:75%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }
.espai { padding-left:5px; padding-right:5px; }

</STYLE>
   
    <TD colspan="3" class="CONTINGUT_ADMIN">
    
    <?php include_partial('breadcumb',array('text'=>'DOCUMENTS')); ?>
      
    <form action="<?php echo url_for('gestio/gDocuments') ?>" method="POST" id="FCERCA">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Escull un directori: </DIV>            
	    	<table class="FORMULARI">
	    		<?php echo select_tag('IDD',options_for_select(AppDocumentsDirectorisPeer::getSelectDirectoris($IDS),$IDD));  ?>          	
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="B_VEURE_PERMISOS" value="Veure permisos" />	            
	            		<input type="submit" name="B_NOU" value="Nou directori" />
	            		<input type="submit" name="B_EDITA_DIRECTORI" value="Edita directori" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>   

	<?php IF( $MODE == 'CONSULTA' ): ?>      
        
        
	<form action="<?php echo url_for('gestio/gDocuments') ?>" method="POST">
        <?php echo input_hidden_tag('IDD',$IDD); ?>
	      <DIV class="REQUADRE">
	        <DIV class="TITOL">Llitat d'usuaris i permisos</DIV>
	      	<TABLE class="DADES">
	 			<?php 
					if( sizeof($LLISTAT_PERMISOS) == 0 ):					
						echo '<TR><TD colspan="3">Ningú hi té accés.</TD></TR>';						
					else:					 
						echo '<TR><th>DNI</th><th>Nom</th><th>Permís</th></TR>';
											
						foreach($LLISTAT_PERMISOS as $P):							                      	                	
	                    	echo '<TR>							
									<TD>'.$P['DNI'].'</TD>
								    <TD>'.$P['nomUsuari'].'</TD>
								    <TD>'.select_tag('nivell['.$P['idUsuari'].']',options_for_select(NivellsPeer::getSelectPermisos(),$P['idNivell'])).'</TD>
							      </TR>';							                		                 															                		                 															
	                    endforeach;
	                  
	                 endif;	                 
	             ?>
	                   	
	            <td colspan="3" class="dreta"><br>
	            	<button name="B_NEW_USER" class="BOTO_ACTIVITAT">Afegir usuari</button>
	            	<button name="B_UPDATE_PERMISOS" class="BOTO_ACTIVITAT"> Actualitza els permisos</button> 	            			            	
	            </td>
	                               	
	      	</TABLE>      
	      </DIV>
	</form>

  <?php ENDIF; ?>
  
  <?php IF( $MODE == 'NOU' ):  ?>

 	<form action="<?php echo url_for('gestio/gDocuments') ?>" method="POST">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Nom del nou directori</DIV>            
	    	<table class="FORMULARI" width="100%">
                <?php include_partial('missatgeTaula',array('MISS'=>$MISSATGE)); ?>
                <?php echo $FDir ?>	 				 		
	 			<td colspan="2" class="dreta"><br>
                    <?php include_partial('botonera',array('element'=>'el directori','tipus'=>'Guardar','nom'=>'B_SAVE_NOU')); ?>	 				          			            	
                    <?php include_partial('botonera',array('element'=>'el directori','tipus'=>'Esborrar','nom'=>'B_DELETE_DIRECTORI')); ?>                    
	            </td>
	 		      
	        </table>
	     </DIV>
     </form>	

  <?php ENDIF; ?>  
  
  <?php IF( $MODE == 'NOU_USUARI' ):  ?>

 	<form action="<?php echo url_for('gestio/gDocuments') ?>" method="POST">
        <?php echo input_hidden_tag('IDD',$IDD); ?>
	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Escull el nou usuari i els permisos al directori</DIV>
	    	<table class="FORMULARI" width="100%">
	    		<?php echo $FPERMISOS; ?>
	 			<td colspan="2" class="dreta"><br>
	 				<button name="B_NOU_USUARI_PERMISOS" class="BOTO_ACTIVITAT">Afegeix el nou usuari</button>	 					            			            
	            </td>
	 		      
	        </table>
	     </DIV>
     </form>	

  <?php ENDIF; ?>

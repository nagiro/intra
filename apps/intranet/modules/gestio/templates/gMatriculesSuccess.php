<?php use_helper('Form')?>
<?php $BASE = OptionsPeer::getString('SF_WEBROOT',$IDS); ?>
<script type="text/javascript" src="<?php echo $BASE.'js/jquery.autocompleter.js'; ?>"></script>

<style type="text/css" >
    
    @import url('<?php echo $BASE.'css/jquery.autocompleter.css'; ?>');
	.cent { width:100%; }
	.noranta { width:90%; }
	.vuitanta  { width:80%; }
	.setanta { width:75%; }
	.cinquanta { width:50%; }
	.HTEXT { height:100px; }
	.espai { padding-left:5px; padding-right:5px; }
    .MATRICULES th { font-size:12px; font-weight:bold; }

 </style>



<script type="text/javascript">

	$(document).ready( function() { 
		$('#cerca_select').change( function() {
			$('#FCERCA').append('<input type="hidden" name="BCERCA"></input>').submit(); 			
		});
		
		$("#form_sel_user").submit(validaFormulariUsuari);
	});
	
</script>

<script type="text/javascript">

	function vacio(q){for(i=0;i<q.length;i++){if(q.charAt(i)!=" "){return true}}return false}
	function validaData(q){		
		var userPattern = new RegExp("^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$");		
		if (userPattern.exec(q) == null) return false; else return true;
	}
	
	function validaCodi(q){
		var userPattern = new RegExp("^[A-Za-z]{3}[0-9]{3}\.[0-9]{2}$");		
		if (userPattern.exec(q) == null) return false; else return true;
	}


	function validaFormulariUsuari(){			
		if(vacio(autocomplete_matricules_usuari_Usuaris_UsuariID.value) == false) { alert('Has d\'entrar un usuari.'); return false; }		
	}

	function ValidaFormulari(){
		if(vacio(D_CODI.value) == false) { alert('Codi no pot estar en blanc.'); return false; }		
		if(vacio(D_TITOL.value) == false) { alert('TITOL no pot estar en blanc.'); return false; } 
		if(vacio(D_PLACES.value) == false) { alert('PLACES no pot estar en blanc.'); return false; }
		if(vacio(D_PREU.value) == false) { alert('PREU no pot estar en blanc.'); return false; }
		if(vacio(D_PREUR.value) == false) { alert('PREU REDUIT no pot estar en blanc.'); return false; }
		if(vacio(D_HORARIS.value) == false) { alert('HORARIS no pot estar en blanc.'); return false; }
		if(D_CATEGORIA.selectedIndex<0){ alert('CATEGORIA no pot estar en blanc.'); return false; }
		if(vacio(D_DATAAPARICIO.value) == false) { alert('DATA APARICIÓ no pot estar en blanc.'); return false; }
		if(vacio(D_DATADESAPARICIO.value) == false) { alert('DATA DESAPARICIÓ no pot estar en blanc.'); return false; }
		if(vacio(D_DATAFIMATRICULA.value) == false) { alert('DATA FI MATRÍCULA no pot estar en blanc.'); return false; }
		if(vacio(D_DATAINICI.value) == false) { alert('DATA INICI no pot estar en blanc.'); return false; }
		 
		if(validaData(D_DATAAPARICIO.value) == false ) { alert('DATA APRICIÓ té un format incorrecte.'); } 
		if(validaData(D_DATADESAPARICIO.value) == false ) { alert('DATA DESAPRICIÓ té un format incorrecte.'); }
		if(validaData(D_DATAFIMATRICULA.value) == false ) { alert('DATA FI MATRÍCULA té un format incorrecte.'); }
		if(validaData(D_DATAINICI.value) == false ) { alert('DATA INICI té un format incorrecte.'); }
		
		if(validaCodi(D_CODI.value) == false ) { alert('CODI té un format incorrecte.'); }
		 
	}

</script>   
   
    <TD colspan="3" class="CONTINGUT_ADMIN">
        
    <?php include_partial('breadcumb',array('text'=>'MATRICULES')); ?>
        
    <form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST" id="FCERCA">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nova matrícula" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>   

	<?php IF( $MODE == 'CONSULTA' ): ?>      
        
    	<?php IF($SELECT == 2): ?>

	      <DIV class="REQUADRE">
	        <DIV class="TITOL">Llistat d'alumnes</DIV>
	      	<TABLE class="DADES">
	 			<?php 
					if( $ALUMNES->getNbResults() == 0 ):					
						echo '<TR><TD class="LINIA" colspan="3">No hi ha cap alumne amb aquests paràmetres.</TD></TR>';						
					else:					 
						echo '<TR><TD class="TITOL">DNI</TD><TD class="TITOL">Nom</TD></TR>';
						
						$i = 0;						
						foreach($ALUMNES->getResults() as $A):						
	                      	$PAR = ParImpar($i++);                	
	                    	echo '<TR>							
									<TD class="LINIA">'.link_to($A->getDni(),'gestio/gMatricules?accio=LMA&IDA='.$A->getUsuariid()).'</TD>
								    <TD class="LINIA">'.$A->getNomComplet().'</TD>
							      </TR>';
							                		                 															                		                 															
	                    endforeach;
	                  
	                 endif;                     
	             ?>      
	              <TR><TD colspan="3" class="TITOL"><?php echo gestorPagines($ALUMNES);?></TD></TR>    	
	      	</TABLE>      
	      </DIV>

	     <?php else: ?>

	      <DIV class="REQUADRE">
	        <DIV class="TITOL">Llistat de cursos </DIV>
	      	<TABLE class="DADES">
	 			<?php 
					if( $CURSOS->getNbResults() == 0 ):
						echo '<TR><TD class="LINIA" colspan="3">No hi ha cap curs amb aquests paràmetres.</TD></TR>';
					else: 
						echo '<TR><TD class="TITOL">CODI</TD><TD class="TITOL">NOM</TD><TD class="TITOL">DATA INICI</TD><TD class="TITOL">PLACES</TD></TR>';
						$i = 0;
						foreach($CURSOS->getResults() as $C):
	                      	$PAR = ParImpar($i++);
	                      	echo '<TR>							
									<TD class="LINIA">'.link_to($C->getCodi(),'gestio/gMatricules?accio=LMC&IDC='.$C->getIdcursos()).'</TD>
									<TD class="LINIA">'.$C->getTitolcurs().'</TD>
									<TD class="LINIA">'.$C->getDatainici('d/m/Y').'</TD>
									<TD class="LINIA">'.$C->countMatriculats($IDS).'/'.$C->getPlaces().'</TD>
								  </TR>';                		                 															                		                 															
	                    endforeach;
	                 endif;                     
	             ?>      
	              <TR><TD colspan="4" class="TITOL"><?php echo gestorPagines($CURSOS);?></TD></TR>    	
	      	</TABLE>      
	      </DIV>

	     <?php endif; ?>

  <?php ELSEIF( $MODE == 'MAT_USUARI' ):  ?>

 	<form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST" id="form_sel_user">
	    <DIV class="REQUADRE">	    
	    	<table class="FORMULARI" width="100%">                            
	 			<?php echo $FMatricula; ?>	 		
                <tr>
	 			<td colspan="2" class="dreta"><br />
	 				<?php echo link_to('Crea nou usuari','gestio/gMatricules?accio=ADD_USER'); ?> o 	            		
	            	<?php echo submit_tag('Segueix matriculant...',array('name'=>'BSELCURS','class'=>'BOTO_ACTIVITAT')) ?>
	            </td>
                </tr>
	 		      
	        </table>
	     </DIV>
     </form>	

  <?php ELSEIF( $MODE == 'MAT_NOU_USUARI' ):  ?>

 	<form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST">
	    <DIV class="REQUADRE">	    
	    <div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gMatricules'); ?></div>
	    	<table class="FORMULARI" width="100%">
	 			<?php echo $FUsuari; ?>	 		
	 			<td colspan="2" class="dreta"><br>
	 				<?php echo submit_tag('Guarda',array('name'=>'BSAVENEWUSER','class'=>'BOTO_ACTIVITAT')) ?>	            			            	
	            </td>
	 		      
	        </table>
	     </DIV>
     </form>	

  <?php ELSEIF( $MODE == 'NOU' ):  ?>
  
 	<form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST">
	    <DIV class="REQUADRE">	    
	    	<table class="DADES">
	 			<?php 
					if( sizeof($CURSOS) == 0 ):
						echo '<TR><TD class="LINIA" colspan="3">No hi ha cap curs actiu.</TD></TR>';
					else: 
						echo '<TR><TD class="TITOL"></TD><TD class="TITOL">CODI</TD><TD class="TITOL">NOM</TD><TD class="TITOL">DATA INICI</TD><TD class="TITOL">PREU</TD><TD class="TITOL">PLACES</TD></TR>';
						$i = 0;
                        echo input_hidden_tag('IDM',$IDM);                        
						foreach($CURSOS as $C):
	                      	$PAR = ParImpar($i++);
	                      	$nMatriculats = $C->countMatriculats($IDS); 
	                      	if($nMatriculats >= $C->getPlaces()):
	                      	
	                      		$BACKGROUND = " style=\"background:red\"";
	                      		$nMatriculats = $C->getPlaces();
	                      		
	                      	else:

	                      		$BACKGROUND = " style=\"background:green\"";	                      		
	                      	
	                      	endif;
	                      	
	                      	echo '<TR >							
	                      			<TD class="LINIA">'.radiobutton_tag('IDC', $C->getIdcursos(), true).'</TD>
									<TD class="LINIA">'.$C->getCodi().'</TD>
									<TD class="LINIA">'.$C->getTitolcurs().' ('.$C->getHoraris().')</TD>
									<TD class="LINIA">'.$C->getDatainici('d/m/Y').'</TD>
									<TD class="LINIA">'.$C->getPreu().'/'.$C->getPreur().'</TD>
									<TD class="LINIA" '.$BACKGROUND.'>'.$nMatriculats.'/'.$C->getPlaces().'</TD>
								  </TR>';                		                 															                		                 															
	                    endforeach;
	                    echo '<td colspan="6" class="dreta"><br>';	                    	            		
	            		echo submit_tag('Segueix matriculant -->',array('name'=>'BSAVECURS','class'=>'BOTO_ACTIVITAT'));
	            		echo '</td>';
	                    
	                 endif;                     
	             ?>      
	        </table>
	     </DIV>
     </form>  

  <?php ELSEIF( $MODE == 'VALIDACIO_CURS' ):  ?>  
  <?php         
         //Si la matricula es paga amb Targeta de crèdit, passem al TPV, altrament mostrem el comprovant                     
        if($MATRICULA->getPagat() > 0 && ( $MATRICULA->getTpagament() == MatriculesPeer::PAGAMENT_TARGETA || $MATRICULA->getTpagament() == MatriculesPeer::PAGAMENT_TELEFON ) ):
            $URL = OptionsPeer::getString('TPV_URL',$IDS);
            echo '<FORM name="COMPRA" action="'.$URL.'" method="POST" target="TPV">';         	 
            //$RET .= '<FORM name="COMPRA" action="https://sis-t.sermepa.es:25443/sis/realizarPago" method="POST" target="TPV">';
            //$RET .= '<form name="COMPRA" action="https://sis.sermepa.es/sis/realizarPago" method="POST" target="TPV">';             
            foreach($TPV as $K => $T) echo input_hidden_tag($K,$T);             
        else:         
            echo '<form method="post" action="'.url_for('gestio/gMatricules').'">';
            echo input_hidden_tag('IDM',$IDM);          	                  
        endif;

	?>  
  
 	
	    <DIV class="REQUADRE">	 
	    	<?php $CURS   = $MATRICULA->getCursos();?>
	    	<?php $USUARI = $MATRICULA->getUsuaris();?>	    	   	    	
	    	<?php $CURS_PLE_TEXT = ($CURS_PLE)?" (EN ESPERA)":"";    ?>	    	
	    	<table class="MATRICULES" width="100%">
	    		<tr><th class="TITOL" colspan="3">RESGUARD DE MATRÍCULA</th></tr>
	    		<tr><th>DNI: </th><td colspan="2"><?php echo $USUARI->getDni(); ?></td></tr>
	    		<tr><th>Nom: </th><td colspan="2"><?php echo $USUARI->getNomComplet(); ?></td></tr>	    		
	    		<tr><th>Pagament: </th><td colspan="2"><?php echo $MATRICULA->getTpagamentString(); ?></td></tr>
	    		<tr><th>Import: </th><td colspan="2"><?php echo $MATRICULA->getPagat(); ?>€</td></tr>
	    		<tr><th>Data: </th><td colspan="2"><?php echo $MATRICULA->getDatainscripcio(); ?></td></tr>
	    		<tr><th>Reducció: </th><td colspan="2"><?php echo $MATRICULA->getTreduccioString(); ?></td></tr>
	    		<tr><th class="TITOL">CODI</th><th class="TITOL">NOM DEL CURS</th><th class="TITOL">PREU</th></tr>	    		
	    		<tr><td><?php echo $CURS->getCodi(); ?></td><td><?php echo $CURS->getTitolcurs().$CURS_PLE_TEXT; ?></td><td><?php echo $MATRICULA->getPagat(); ?>€</td></tr>
	    		<td colspan="3" class="dreta"><br />	                    	            		
	            	<?php echo submit_tag('Segueix matriculant -->',array('name'=>'BPAGAMENT','class'=>'BOTO_ACTIVITAT')); ?>
	            </td>	    		
	        </table>
	     </DIV>
     </form>  

 <?php elseif( $MODE == 'PAGAMENT' ):  ?>  
 	
 	<div class="REQUADRE">	    
        <div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gMatricules?accio=CA'); ?></div>
            <?php   
                if($MISSATGE == 'OK'):
                    echo "La matrícula s'ha realitzat correctament.<br /> Prem ".link_to('aquí','gestio/gMatricules?accio=P&IDP='.$IDM)." per veure el reguard.";
                else:
                    echo "Hi ha hagut algun problema fent la matrícula. Si us plau, torna-ho a intentar.";            
                endif;
            ?>
    </div>
 	 	  
  <?php elseif( $MODE == 'EDICIO' ): ?>

 	<form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST">
	    <DIV class="REQUADRE">
	    <div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gMatricules'); ?></div>	    
	    	<table class="FORMULARI" width="100%">
                <tr><th width="200px">&nbsp;</th><td>&nbsp;</td></tr>
	 			<?php echo $FMATRICULA; ?>
                <tr>      
	 			<td colspan="2" class="dreta"><br>
					<?php include_partial('botonera',array('element'=>'la matrícula'))?>	            			            	
	            </td>
                </tr>
	        </table>
	     </DIV>
     </form>
 
  <?php ELSEIF( $MODE == 'LMATRICULES' ): ?>
  
  	     <DIV class="REQUADRE">
	        <DIV class="TITOL">Llistat de matriculats </DIV>
	      	<TABLE class="DADES">
	 			<?php 
					if( sizeof($MATRICULES) == 0):
						echo '<TR><TD class="LINIA" colspan="3">No hi ha cap matrícula amb aquests paràmetres.</TD></TR>';
					else: 
						echo '<TR><TD class="TITOL">DNI</TD><TD class="TITOL">NOM</TD><TD class="TITOL">DATA INICI</TD></TR>';
						$i = 0;
						foreach($MATRICULES as $M):
				            $C = $M->getCursos();
				            $U = $M->getUsuaris();
				            $TEXT_REDUCCIO ="";
				            $PREU = $M->getPagat();				            
				            echo '<TR>
									<TD class="LINIA" width="15%">'.link_to($U->getDni(),'gestio/gMatricules?accio=E&IDM='.$M->getIdmatricules()).'</TD>
									<TD class="LINIA" width="40%"><b>'.$U->getNomComplet().'</b><BR />'.$U->getTelefonString().' | '.$M->getDatainscripcio().'<br />'.$U->getEmail().'</TD>
									<TD class="LINIA" width="45%">'.$C->getCodi().' '.$C->getTitolcurs().' ('.$PREU.'€'.$TEXT_REDUCCIO.') <br />
								                     		       '.MatriculesPeer::getEstatText($M->getEstat()).' '.$M->getComentari().' '.
				            										'<a href="'.url_for('gestio/gMatricules?accio=P&IDP='.$M->getIdmatricules()).'"><img src="'.$BASE.'images/template/printer.png'.'" /></a>
								                     		       </TD>							
								  </TR>';                		                 															                		                 															
	                   endforeach; 	                  
	                 endif;       
	            ?>
	      	</TABLE>      
	      </DIV>
        
  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    

<?php 

	function ParImpar($i)
	{
		if($i % 2 == 0) return "PAR";
		else return "IPAR";
	}
	
	
	function gestorPagines($O)
	{
	  if($O->haveToPaginate())
	  {       
	     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gMatricules?PAGINA='.$O->getPreviousPage());
	     echo " ";
	     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gMatricules?PAGINA='.$O->getNextPage());
	  }
	}

?>

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
    .MAtrICULES th { font-size:12px; font-weight:bold; }

 </style>



<script type="text/javascript">

	$(document).ready( function() { 
		$('#cerca_select').change( function() {
			$('#FCERCA').append('<input type="hidden" name="BCERCA"></input>').submit(); 			
		});        

        $('#form_sel_user').validate({
                rules:{
                    "autocomplete_matricules_usuari[Usuaris_UsuariID]": { required: true },
                },
                messages: {
                    "autocomplete_matricules_usuari[Usuaris_UsuariID]": { required: "<br />Escriu un DNI o nom i escull-lo del llistat. Si no apareix, prem a crea un usuari nou." }
                }            
        });

        $('#form_usuari').validate({            
                rules:{
                    "usuaris[DNI]": { required: true, rangelength: [9, 9] },
                    "usuaris[Passwd]": { required: true },
                    "usuaris[Nom]": { required: true },
                    "usuaris[Cog1]": { required: true },
                    "usuaris[Cog2]": { required: false },
                    "usuaris[Email]": { required: true , email: true },
                    "usuaris[Adreca]": { required: true },
                    "usuaris[CodiPostal]": { required: true , number: true },
                    "usuaris[Poblacio]": { required: true },
                    "usuaris[Poblaciotext]": { required: function(){ return ($('#usuaris_Poblacio option:selected').val() == 227); } },
                    "usuaris[Telefon]": { required: false },
                    "usuaris[Mobil]": { required: function(){ return ($('#usuaris_Telefon').val().length == 0); }},
                    "usuaris[captcha2]": { required: true }                                        
                },
                messages: {
                    "usuaris[DNI]": { rangelength: "<br />Format: 00000000A o X0000000A." }
                }
        });    
              
	});
	
</script>
   
    <td colspan="3" class="CONTINGUT_ADMIN">
        
    <?php include_partial('breadcumb',array('text'=>'MATRICULES')); ?>
        
    <form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST" id="FCERCA">
	    <div class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nova matrícula" />
	            	</td>
	            </tr>
	        </table>
	     </div>
     </form>   

	<?php IF( $MODE == 'CONSULTA' ): ?>      
        
    	<?php IF($SELECT == 2): ?>

	      <div class="REQUADRE">
	        <div class="TITOL">Llistat d'alumnes</div>
	      	<table class="DADES">
	 			<?php 
					if( $ALUMNES->getNbResults() == 0 ):					
						echo '<tr><td class="LINIA" colspan="3">No hi ha cap alumne amb aquests paràmetres.</td></tr>';						
					else:					 
						echo '<tr><td class="TITOL">DNI</td><td class="TITOL">Nom</td></tr>';
						
						$i = 0;						
						foreach($ALUMNES->getresults() as $A):						
	                      	$PAR = ParImpar($i++);                	
	                    	echo '<tr>							
									<td class="LINIA">'.link_to($A->getdni(),'gestio/gMatricules?accio=LMA&IDA='.$A->getUsuariid()).'</td>
								    <td class="LINIA">'.$A->getNomComplet().'</td>
							      </tr>';
							                		                 															                		                 															
	                    endforeach;
	                  
	                 endif;                     
	             ?>      
	              <tr><td colspan="3" class="TITOL"><?php echo gestorPagines($ALUMNES);?></td></tr>    	
	      	</table>      
	      </div>

	     <?php else: ?>

	      <div class="REQUADRE">
	        <div class="TITOL">Llistat de cursos </div>
	      	<table class="DADES">
	 			<?php 
					if( $CURSOS->getNbResults() == 0 ):
						echo '<tr><td class="LINIA" colspan="3">No hi ha cap curs amb aquests paràmetres.</td></tr>';
					else: 
						echo '<tr><td class="TITOL">CODI</td><td class="TITOL">NOM</td><td class="TITOL">DATA INICI</td><td class="TITOL">PLACES</td></tr>';
						$i = 0;
						foreach($CURSOS->getresults() as $C):
	                      	$PAR = ParImpar($i++);
	                      	echo '<tr>							
									<td class="LINIA">'.link_to($C->getCodi(),'gestio/gMatricules?accio=LMC&IDC='.$C->getIdcursos()).'</td>
									<td class="LINIA">'.$C->getTitolcurs().'</td>
									<td class="LINIA">'.$C->getdatainici('d/m/Y').'</td>
									<td class="LINIA">'.$C->countMatriculats($IDS).'/'.$C->getPlaces().'</td>
								  </tr>';                		                 															                		                 															
	                    endforeach;
	                 endif;                     
	             ?>      
	              <tr><td colspan="4" class="TITOL"><?php echo gestorPagines($CURSOS);?></td></tr>    	
	      	</table>      
	      </div>

	     <?php endif; ?>

  <?php ELSEIF( $MODE == 'MAT_USUARI' ):  ?>

 	<form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST" id="form_sel_user">
	    <div class="REQUADRE">	    
	    	<table class="FORMULARI" width="100%">                            
	 			<?php echo $FMatricula; ?>	 		
                <tr>
	 			<td colspan="2" class="dreta"><br />
	 				<?php echo link_to('Crea nou usuari','gestio/gMatricules?accio=ADD_USER'); ?> o 	            		
	            	<?php echo submit_tag('Segueix matriculant...',array('name'=>'BSELCURS','class'=>'BOTO_ACTIVITAT')) ?>
	            </td>
                </tr>
	 		      
	        </table>
	     </div>
     </form>	

  <?php ELSEIF( $MODE == 'MAT_NOU_USUARI' ):  ?>

 	<form action="<?php echo url_for('gestio/gMatricules') ?>" id="form_usuari" method="POST">
	    <div class="REQUADRE">	    
	    <div class="OPCIO_FINEStrA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gMatricules'); ?></div>
	    	<table class="FORMULARI" width="100%">
	 			<?php echo $FUsuari; ?>	 		
	 			<td colspan="2" class="dreta"><br>
	 				<?php echo submit_tag('Guarda',array('name'=>'BSAVENEWUSER','class'=>'BOTO_ACTIVITAT')) ?>	            			            	
	            </td>
	 		      
	        </table>
	     </div>
     </form>	

  <?php ELSEIF( $MODE == 'NOU' ):  ?>
  
 	<form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST">
	    <div class="REQUADRE">	    
	    	<table class="DADES">
	 			<?php 
					if( sizeof($CURSOS) == 0 ):
						echo '<tr><td class="LINIA" colspan="3">No hi ha cap curs actiu.</td></tr>';
					else: 
						echo '<tr><td class="TITOL"></td><td class="TITOL">CODI</td><td class="TITOL">NOM</td><td class="TITOL">DATA INICI</td><td class="TITOL">PREU</td><td class="TITOL">PLACES</td></tr>';
						$i = 0;
                        echo input_hidden_tag('IDM',$IDM);
                        
                        //Per cada curs, mostrem les places lliures                        
						foreach($CURSOS as $C):
	                      	$PAR = ParImpar($i++);
	                      	$nMatriculats = $C->countMatriculesActives($IDS); 
	                      	if(!$C->isPle()):
	                      	
	                      		$BACKGROUND = " style=\"background:red\"";
	                      		$nMatriculats = $C->getPlaces();
	                      		
	                      	else:

	                      		$BACKGROUND = " style=\"background:green\"";	                      		
	                      	
	                      	endif;
	                      	
	                      	echo '<tr >							
	                      			<td class="LINIA">'.radiobutton_tag('IDC', $C->getIdcursos(), true).'</td>
									<td class="LINIA">'.$C->getCodi().'</td>
									<td class="LINIA">'.$C->getTitolcurs().' ('.$C->getHoraris().')</td>
									<td class="LINIA">'.$C->getdatainici('d/m/Y').'</td>
									<td class="LINIA">'.$C->getPreu().'/'.$C->getPreur().'</td>
									<td class="LINIA" '.$BACKGROUND.'>'.$nMatriculats.'/'.$C->getPlaces().'</td>
								  </tr>';                		                 															                		                 															
	                    endforeach;
	                    echo '<td colspan="6" class="dreta"><br>';	                    	            		
	            		echo submit_tag('Segueix matriculant -->',array('name'=>'BSAVECURS','class'=>'BOTO_ACTIVITAT'));
	            		echo '</td>';
	                    
	                 endif;                     
	             ?>      
	        </table>
	     </div>
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
  
 	
	    <div class="REQUADRE">	 
	    	<?php $CURS   = $MATRICULA->getCursos();?>
	    	<?php $USUARI = $MATRICULA->getUsuaris();?>	    	   	    	
	    	<?php $CURS_PLE_TEXT = ($CURS_PLE)?" (EN ESPERA)":"";    ?>	    	
	    	<table class="MATRICULES" width="100%">
	    		<tr><th class="TITOL" colspan="3">RESGUARD DE MAtrÍCULA</th></tr>
	    		<tr><th>DNI: </th><td colspan="2"><?php echo $USUARI->getdni(); ?></td></tr>
	    		<tr><th>Nom: </th><td colspan="2"><?php echo $USUARI->getNomComplet(); ?></td></tr>	    		
	    		<tr><th>Pagament: </th><td colspan="2"><?php echo $MATRICULA->getTpagamentString(); ?></td></tr>
	    		<tr><th>Import: </th><td colspan="2"><?php echo $MATRICULA->getPagat(); ?>€</td></tr>
	    		<tr><th>Data: </th><td colspan="2"><?php echo $MATRICULA->getdatainscripcio(); ?></td></tr>
	    		<tr><th>Reducció: </th><td colspan="2"><?php echo $MATRICULA->gettreduccioString(); ?></td></tr>
	    		<tr><th class="TITOL">CODI</th><th class="TITOL">NOM DEL CURS</th><th class="TITOL">PREU</th></tr>	    		
	    		<tr><td><?php echo $CURS->getCodi(); ?></td><td><?php echo $CURS->getTitolcurs().$CURS_PLE_TEXT; ?></td><td><?php echo $MATRICULA->getPagat(); ?>€</td></tr>
	    		<td colspan="3" class="dreta"><br />	                    	            		
	            	<?php echo submit_tag('Segueix matriculant -->',array('name'=>'BPAGAMENT','class'=>'BOTO_ACTIVITAT')); ?>
	            </td>	    		
	        </table>
	     </div>
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
	    <div class="REQUADRE">
	    <div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gMatricules'); ?></div>	    
	    	<table class="FORMULARI" width="100%">
                <tr><th width="200px">&nbsp;</th><td>&nbsp;</td></tr>
	 			<?php echo $FMATRICULA; ?>
                <tr>      
	 			<td colspan="2" class="dreta"><br />
					<?php include_partial('botonera',array('element'=>'la matrícula'))?>	            			            	
	            </td>
                </tr>
	        </table>
	     </div>
     </form>
 
  <?php ELSEIF( $MODE == 'LMATRICULES' ): ?>
  
  	     <div class="REQUADRE">
	        <div class="TITOL">Llistat de matriculats </div>
	      	<table class="DADES">
	 			<?php 
					if( sizeof($MATRICULES) == 0):
						echo '<tr><td class="LINIA" colspan="3">No hi ha cap matrícula amb aquests paràmetres.</td></tr>';
					else: 
						echo '<tr><td class="TITOL">DNI</td><td class="TITOL">NOM</td><td class="TITOL">DATA INICI</td></tr>';
						$i = 0;
						foreach($MATRICULES as $M):
				            $C = $M->getCursos();
				            $U = $M->getUsuaris();
				            $TEXT_REDUCCIO ="";
				            $PREU = $M->getPagat();				            
				            echo '<tr>
									<td class="LINIA" width="15%">'.link_to($U->getdni(),'gestio/gMatricules?accio=E&IDM='.$M->getIdmatricules()).'</td>
									<td class="LINIA" width="40%"><b>'.$U->getNomComplet().'</b><BR />'.$U->getTelefonString().' | '.$M->getdatainscripcio().'<br />'.$U->getEmail().'</td>
									<td class="LINIA" width="45%">'.$C->getCodi().' '.$C->getTitolcurs().' ('.$PREU.'€'.$TEXT_REDUCCIO.') <br />
								                     		       '.MatriculesPeer::getEstatText($M->getEstat()).' '.$M->getComentari().' '.
				            										'<a href="'.url_for('gestio/gMatricules?accio=P&IDP='.$M->getIdmatricules()).'"><img src="'.$BASE.'images/template/printer.png'.'" /></a>
								                     		       </td>							
								  </tr>';                		                 															                		                 															
	                   endforeach; 	                  
	                 endif;       
	            ?>
	      	</table>      
	      </div>
        
  <?php ENDIF; ?>
  
      <div style="height:40px;"></div>
                
    </td>    

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

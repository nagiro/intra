<?php use_helper('Form'); ?>

<script>

	$(document).ready(function() {
		var ok;
		ok = false; 
		$("#FORM_CURSOS").submit(function(){
			$(".class_cursos").each(function(){				
				if(this.checked) ok=true;
			});
			if(!ok) alert('Per poder-vos matricular, heu de seleccionar algun curs'); 
			return ok; 
		});	   
		
		$("#BOTO_SUBMIT_RESERVA").click(ValidaReserves);
		$("#BOTO_NOVA_RESERVA").click(function(){ window.location.href='<?php echo url_for('web/gestio?accio=gr'); ?>'; return false; });
		$("#BOTO_DEL_RESERVA").click(function(){ window.location.href='<?php echo url_for('web/gestio?accio=ar'); ?>'; return false; });		
		
	});
	
    function ActivaBoto(ple){
        if(ple) { alert('El curs al que vol matricular-se no té places disponibles.\nSi vostè ho desitja pot seguir fent la matrícula gratuïtament i entrarà en llista d\'espera.\nSi és acceptat al curs, nosaltres ens posarem en contacte amb vostè i llavors haurà de formalitzar la matrícula correctament si ho desitja.'); }
    }
    
	function ValidaReserves(){
		var espais = true;
		$(".ul_espais:checked").each(function (a){ espais = false; } );						
		if($("#reservaespais_Nom").val().length == 0) { alert("El nom d'activitat no pot estar buit."); return false; }
		if($("#reservaespais_DataActivitat").val().length == 0) { alert("La data d'activitat no pot estar buit."); return false; }
		if($("#reservaespais_HorariActivitat").val().length == 0) { alert("L'hora d'activitat no pot estar buida."); return false; }
		if(espais) { alert("Has d'escollir com a mínim un espai on realitzar l'acte"); return false; }		
		return true;  				
	}
	
</script>

<style>

	.DH { display:block; float:left; padding-top:5px; }

	fieldset { border:3px solid #F3F3F3; margin-right:40px; padding:10px; }
	.MISSAT { color:black; font-weight:bold; font-size:10px; vertical-align:middle; text-align:center; background-color:White; padding-bottom:10px; }
	.CURS { font-size: 12px; padding:5px; vertical-align:bottom;  }
	.LLEGENDA { font-size:12px; font-weight:bold; padding:10px 10px 10px 10px;  }
	TEXTAREA { border:1px solid #CCCCCC; width:90%; }
	.DADES .LINIA .blue { color:blue; }
	.DADES .LINIA .blue:hover { color:blue; }
	.DADES .LINIA .blue:visited { color:blue; }
	.OPCIONS { padding-left:10px; padding-top:5px; }
	.TITOL_CATEGORIA { background-color: #DD9D9A; color:black; font-weight:bold; padding:5px; font-size:10px; }	
	
</style>


   <TD colspan="3" class="CONTINGUT">

	<?php  		        
                
	   switch($MODUL){
	   	  case 'landing_page': landing_page( ); break;
	      case 'gestiona_dades': gestiona_dades( $FUSUARI , $MISSATGE ); break;
	      case 'gestiona_cursos': gestiona_cursos( $CURSOS , $MATRICULES , $MISSATGE , $LCURSOS); break;
	      case 'gestiona_llistes': gestiona_llistes( $LLISTES , $MISSATGE ); break;
	      case 'gestiona_reserves': gestiona_reserves( $FRESERVA , $RESERVES , $MISSATGE ); break;
	      case 'gestiona_verificacio' : gestiona_verificacio( $DADES_MATRICULA , $TPV , $ISPLE ); break;    
	   }
       		
	?>   
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

<?php 

function landing_page(){
?> 

	       
	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Zona privada</LEGEND>
	   	<p>
	   		Benvingut a la seva zona privada de la Casa de Cultura.<br /> 
	   		En aquest espai podrà accedir als serveis personalitzats que hem preparat per vostè.<br />
	   		Per accedir a qualsevol dels serveis podrà fer-ho a través del menú lateral esquerra <b>Zona privada</b> o a través d'aquesta mateixa pàgina.<br /> 
	   		<br />
	   		Actualment hi ha disponibles els següents:<br />
	   		<br />
	   		<div class="OPCIONS"><a class="verd" href="<?php echo url_for('web/gestio?accio=gd') ?>">· Gestionar les seves dedes personals.</a></div>
	   		<div class="OPCIONS"><a class="verd" href="<?php echo url_for('web/gestio?accio=gc') ?>">· Gestionar les seves matrícules o matricular-se a un nou curs.</a></div>
	   		<div class="OPCIONS"><a class="verd" href="<?php echo url_for('web/gestio?accio=gr') ?>">· Reservar un espai de la Casa de Cultura.</a></div>
	   		<div class="OPCIONS"><a class="verd" href="<?php echo url_for('web/gestio?accio=gl') ?>">· Gestionar la seva subscripció a les llistes informatives.</a></div>	   			   		
	   	</p>	   		      
	   
	   </FIELDSET>
	   		
   
   <?php  
} 

function gestiona_dades($FUSUARI,$MISSATGE){
?> 

	<form name="gDades" action="<?php echo url_for('web/gestio?accio=sd') ?>" method="post">
       
	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Dades personals</LEGEND>
	   
		   <TABLE class="FORMULARI">
		   <tr><td width="100px"></td><td><td></tr>
		   <?php echo missatge($MISSATGE); ?>		      
		   <?php echo $FUSUARI; ?>  
		   <TR><TD></TD><TD><br /><br /><?php echo submit_tag('Guardeu els canvis',array('class'=>'BOTO_ACTIVITAT','style'=>'width:150px;')); ?></TD></TR>                      
		   </TABLE>   
	   
	   </FIELDSET>
	   
	</form>	 
   
   <?php  
} 

function gestiona_llistes( $LLISTES , $MISSATGE ){
?>
	<form name="gDades" action="<?php echo url_for('web/gestio?accio=sl') ?>" method="post">
	  
		<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Llistes de correu</LEGEND>
		   
			<table class="FORMULARI">
			
				<?php echo missatge($MISSATGE); ?>
			   
				<?php foreach(LlistesPeer::select() as $K=>$L): ?>
				          
					<TR><TD><?php echo checkbox_tag('LLISTA[]',$K,isset($LLISTES[$K]))?></TD><TD><?php echo $L?></TD></TR>
					      	
				<?php endforeach; ?>
					
			</table>
			         
		</FIELDSET>
	
	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Accions</LEGEND>
	      
		<table class="FORMULARI">
		   
			<TR><TD colspan="2"><?php echo submit_tag('Modifiqueu', array('class'=>'BOTO_ACTIVITAT','style'=>'width:100px;')); ?></TD></TR>
			
		</table>
		         
	   </FIELDSET>

	</form>

   <?php
}

function gestiona_cursos( $CURSOS , $MATRICULES , $MISSATGES , $LCURSOS ) {
   ?>
   <form method="post" action="<?php echo url_for('web/gestio?accio=im') ?>" id="FORM_CURSOS">
   
	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Cursos disponibles actualment </LEGEND>
       	      
	       	<?php $LCURSOS = $LCURSOS->getResults(); ?>
	       	<?php if(empty($LCURSOS)): echo "Actualment no es pot matricular a cap curs. "; ?>
			<?php else: ?>	      
					   <TABLE class="DADES">
						   <tr>
						   	<td class="TITOL" colspan="2">CODI</td>						   	
						   	<td class="TITOL">NOM</td>
						   	<td class="TITOL">PREU</td>
						   	<td class="TITOL" width="70px">INICI</td>
						   	<td class="TITOL">PLACES</td>
						   </tr>
					   <?php $CAT_ANT = ""; ?>   
					   <?php foreach($LCURSOS as $C): ?>
                       <?php if($C->getVisibleweb() == 1): ?>                      
					   <?php    if($CAT_ANT <> $C->getCategoria()): ?>					   
								<TR><TD colspan="6" class="TITOL_CATEGORIA"><?php echo $C->getCategoriaText()?></TD></TR>
					   <?php    endif; ?>
					   <?php       $PLACES = $C->getPlacesArray(); 
                                   $ple = ($PLACES['OCUPADES'] == $PLACES['TOTAL'])?"style=\"background-color:#FFCCCC;\"":"";
                                   $jple = ($PLACES['OCUPADES'] == $PLACES['TOTAL']);                                                          
                       ?>					                       	
					   		<TR>
					      		<TD <?php echo $ple ?>><?php echo radiobutton_tag('D[CURS]',$C->getIdcursos(),false,array('onClick'=>'ActivaBoto('.$jple.');','class'=>'class_cursos '))?></TD>					      		
					      		<TD <?php echo $ple ?>>
					      		
									<a href="#TB_inline?height=480&width=640&inlineId=hidden<?php echo $C->getIdcursos(); ?>&modal=false" class="thickbox">
					      				<?php echo $C->getCodi()?>
					      			</a>
   			      					<div style="display: none;" id="hidden<?php echo $C->getIdcursos() ?>">
                                        <div id="TEXT_WEB">
			      						 <?php echo $C->getDescripcio() ?>
                                        </div>
      								</div>

					      		</TD>
										      							      							      		
					      		<TD <?php echo $ple ?>><?php echo $C->getTitolcurs()?> ( <?php echo $C->getHoraris()?> ) </TD>
					      		<TD <?php echo $ple ?>><?php echo $C->getPreu()?> €</TD>      							
					      		<TD <?php echo $ple ?>><?php echo $C->getDatainici('d-m-Y')?></TD>
					      		<TD <?php echo $ple ?>><?php echo $PLACES['OCUPADES'].'/'.$PLACES['TOTAL']?></TD>
					      	</TR>                		                 										
					   <?php $CAT_ANT = $C->getCategoria(); ?>
                       <?php endif; ?>			   
					   <?php endforeach; ?>        					                         
					   </TABLE>
					   <br /><br />
                       
                       <?php
                       
                        //Mirem que l'usuari es pugui matricular segons les dates de matrícules
                        list($DIA_Y,$DIA_M,$DIA_D) = explode("-",TipusPeer::getDataIniciMatriculaAnticsAlumnes()->getTipusdesc());
                        list($DIT_Y,$DIT_M,$DIT_D) = explode("-",TipusPeer::getDataIniciMatriculaTothom()->getTipusdesc());
                        
                        $DIA_T = mktime(0,0,0,$DIA_M,$DIA_D,$DIA_Y);
                        $DIT_T = mktime(0,0,0,$DIT_M,$DIT_D,$DIT_Y);
                             
                         ?>

                       
					   <TABLE class="FORMULARI" width="100%">					   		
					   		<TR><TD width="100px;" style="font-size:10px;"><b>DESCOMPTE</b></TD><td><?php echo select_tag('D[DESCOMPTE]',options_for_select( MatriculesPeer::selectDescomptesWeb(),MatriculesPeer::REDUCCIO_CAP))?></TD></TR>
					   		<TR><TD width="100px"></TD>
                                <TD>    
                                    <?php
                                                                                
                                        $avui = time();
                                        
                                        if(sizeof($MATRICULES) == 0):
                                            if($avui < $DIT_T):                                                
                                                echo "<div class=\"text\" style=\"font-weight:bold; \">El període de matrícules per a nous alumnes comença el dia ".date('d/m/Y',$DIT_T).'</div>';
                                            else: 
                                                echo "<div>".submit_tag('Matriculeu-me',array('name'=>'BMATRICULA' , 'class'=>'BOTO_ACTIVITAT' , 'style'=>'width:100px')).'</div>';    
                                            endif;                                                                                
                                        else: 
                                            if($avui < $DIA_T):    
                                                echo "<div style=\"font-size:11px; font-weight:bold; \">El període de matrícules per a antics alumnes comença el dia ".date('d/m/Y',$DIA_T).'</div>';
                                            else: 
                                                echo '<div>'.submit_tag('Matriculeu-me',array('name'=>'BMATRICULA' , 'class'=>'BOTO_ACTIVITAT' , 'style'=>'width:100px')).'</div>';
                                            endif;                                         
                                        endif;
                                     ?>
                                     <br />
                                     <div class="text">Si necessita més informació sobre el nou sistema de matrícules, si us plau, cliqui <a href="<?php echo url_for('web/index?accio=mc&node=35'); ?>">aquí</a>.</div>                                                                                                                                                                  
                                </TD>
                            </TR>
					   </TABLE>
					   
			<?php endif; ?>
		            
	   </FIELDSET>
      
	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Cursos matriculats amb anterioritat</LEGEND>
	              
		   <TABLE class="DADES">
		   
		   <?php if(sizeof($MATRICULES)==0): ?>
				<TR><TD>No tenim constància informàtica que hagueu realitzat un curs a la Casa de Cultura. <br />Si no és així, si us plau notifiqueu-nos-ho. </TD></TR>
           <?php else: ?>
                <TR><TD class="titol">CODI</TD>
                    <TD class="titol">NOM</TD>
                    <TD class="titol">ESTAT</TD>
                    <TD class="titol">DATA MATRÍCULA</TD>
                    <TD class="titol">DESCOMPTE</TD></TR>                                   
		   <?php endif; ?>
		   
		   <?php foreach($MATRICULES as $M): ?>
		      <?php $CURSOS = $M->getCursos(); ?>                           
		   		<TR>
		   			<TD>
						<a href="#TB_inline?height=480&width=640&inlineId=hidden<?php echo $CURSOS->getIdcursos(); ?>&modal=false" class="thickbox">
      						<?php echo $CURSOS->getCodi()?>
      					</a>
      					<div style="display:none" id="hidden<?php echo $CURSOS->getIdcursos() ?>">
      						<?php echo $CURSOS->getDescripcio() ?>
      					</div>
      				</TD>		   				   			
		      		<TD><?php echo $CURSOS->getTitolCurs()?></TD>
		      		<TD><?php echo MatriculesPeer::getEstatText( $M->getEstat() )?></TD>
		      		<TD><?php echo $M->getDataInscripcio('d/m/Y H:i')?></TD>
		      		<TD><?php echo MatriculesPeer::textDescomptes($M->getTReduccio()) ?></TD>                                                                                             
			     </TR>                                   
		   <?php endforeach; ?>                              
		   </TABLE>
		      
	   </FIELDSET>
	      	      	   	   	
   	</form>
   
<?php  
}


function gestiona_verificacio($DADES_MATRICULA , $TPV , $ISPLE )
{

     //Si la matricula es paga amb Targeta de crèdit, passem al TPV, altrament mostrem el comprovant     
     if($DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TARGETA || $DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TELEFON ):
     	 
//         echo '<FORM name="COMPRA" action="https://sis-t.sermepa.es:25443/sis/realizarPago" method="POST" target="TPV">';
         echo '<FORM name="COMPRA" action="https://sis.sermepa.es/sis/realizarPago" method="POST" target="TPV">';
         
         foreach($TPV as $K => $T) echo input_hidden_tag($K,$T);
         
     else:
     
        echo '<form method="post" action="gestio/gMatricules">'; 
     	                  
     endif;

     //Carreguem totes les dades de matrícula     
     foreach($DADES_MATRICULA as $K => $V) { $str = "DADES_MATRICULA[".$K."]"; echo input_hidden_tag($str,$V); }
     $IDC = $DADES_MATRICULA['CURS'];     
     $ESPLE = ($ISPLE)?'(EN ESPERA)':'';

	?>
   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Verificació de la matrícula</LEGEND>	

	<TABLE class="FORMULARI" style="magin-right:40px;">
		<TR><TD><b>DNI</b></TD>     <TD><?php echo $DADES_MATRICULA['DNI']; ?></TD></TR>
	    <TR><TD><b>NOM</b></TD>     <TD><?php echo $DADES_MATRICULA['NOM']; ?></TD></TR>
	    <TR><TD><b>PAGAMENT</b></TD><TD><?php echo MatriculesPeer::textPagament($DADES_MATRICULA['MODALITAT']); ?></TD></TR>
	    <TR><TD><b>IMPORT</b></TD>  <TD><?php echo $DADES_MATRICULA['PREU'].'€'; ?></TD></TR>
	    <TR><TD><b>DATA</b></TD>    <TD><?php echo $DADES_MATRICULA['DATA']; ?></TD></TR>
	    <TR><TD><b>DESCOMPTE</b></TD>  <TD><?php echo MatriculesPeer::textDescomptes($DADES_MATRICULA['DESCOMPTE']); ?></TD></TR>
	    <TR><TD><b>CURS</b></TD>  <TD>
	    <TABLE width="100%" class="FORMULARI">                  								
	    	<?php $CURS = CursosPeer::retrieveByPK($DADES_MATRICULA['CURS']);      ?>                  								
	        <TR>
	        	<TD><?php echo $CURS->getCodi(); ?></TD>
	            <TD><?php echo $CURS->getTitolcurs().' '.$ESPLE; ?></TD>
	            <TD><?php echo $CURS->CalculaPreu($DADES_MATRICULA['DESCOMPTE']).'€'; ?></TD>
			</TR>                  								                  								                  	                           
		</TABLE>
	    </TD></TR>
		<TR><TD colspan="7"><?php echo submit_tag('Matriculeu-me',array('NAME'=>'BSAVE','style'=>'width:100px')); ?><BR /></TD></TR>                  	                                             	
	</TABLE>			                                  
	</FIELDSET>
	
	</FORM>
<?php  
}

//RESERVA o bé hi ha un registre que editem o un de nou
//RESERVES hi ha un llistat d'objectes reserva
//MISSATGE Missatge que informa d'algun problema o bé que tot ha anat bé

function gestiona_reserves( $FRESERVA , $RESERVES , $MISSATGE = array() ){   
      	                                
	$ESPAIS = explode('@',$FRESERVA->getValue('EspaisSolicitats'));
	$MATERIAL= explode('@',$FRESERVA->getValue('MaterialSolicitat'));
    
	?>
	
	<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Prereserves anteriors</LEGEND>
		<TABLE class="DADES">
     	<TR><TD class="TITOL">Codi reserva</TD><TD class="TITOL">Nom activitat</TD><TD class="TITOL">Data sol·licitud</TD><TD class="TITOL">Estat</TD></TR>
     	
	    <?php if(empty($RESERVES)): ?>
	    <TR><TD colspan="3">No s'han trobat prereserves anteriors</TD></TR>
	    <?php endif; ?> 
     
     	<?php foreach($RESERVES as $R):     			
     			echo '<TR>';
     			echo '	<TD>'.link_to($R->getCodi(),'web/gestio?accio=gr&idR='.$R->getReservaespaiid()).'</TD>';     			
     			echo '	<TD>'.link_to($R->getNom(),'web/gestio?accio=gr&idR='.$R->getReservaespaiid()).'</TD>';
     			echo '	<TD>'.$R->getDataalta('d/m/Y').'</TD>';
     			echo '	<TD>'.$R->getEstatText().'</TD>';
     			echo '</TR>'; 
		endforeach; ?>
     
     	</TABLE>     
	</FIELDSET>		
	
    <?php 
    
  	if($FRESERVA->getValue('ReservaEspaiID') > 0) $ENABLED = false; else $ENABLED = true;  
	if($ENABLED) echo '<form name="fReserves" id="fReserves" method="post" action="'.url_for('web/gestio?accio=sr').'">';    
             
    ?> 
       	              	           
	<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Prereserva</LEGEND>
        <?php echo $FRESERVA['DataAcceptacioCondicions']->render(); ?>
        <?php echo $FRESERVA['CondicionsCCG']->render(); ?>
		<?php echo $FRESERVA['Estat']->render(); ?>
		<?php echo $FRESERVA['Usuaris_usuariID']->render(); ?>
		<?php echo $FRESERVA['DataAlta']->render(); ?>
		<?php echo $FRESERVA['ReservaEspaiID']->render(); ?>
		<?php echo $FRESERVA['Codi']->render(); ?>	    	    	    
	
        <?php echo missatgeDiv($MISSATGE); ?>
        
	    <div style="clear:both" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Nom de l'activitat</b></span>
	    	<span class="DH"><?php echo $FRESERVA['Nom']->render(); ?></span>
	    </div>
	    	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Proposta de data</b></span>
	    	<span class="DH"><?php echo $FRESERVA['DataActivitat']->render(); ?></span>
	    </div>
	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Proposta d'hores</b></span>
	    	<span class="DH"><?php echo $FRESERVA['HorariActivitat']->render(); ?></span>
	    </div>
	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Espais</b> (<a class="blue" href="<?php echo url_for('web/espais') ?>" target="_NEW">veure'ls</a>)</span>
	    	<span class="DH checkbox_list" style="width:450px"><?php echo $FRESERVA['EspaisSolicitats']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Material</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['MaterialSolicitat']->render(); ?></span>
	    </div>
		
		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Tipus d'acte</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['TipusActe']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Representant a</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['Representacio']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Responsable</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['Responsable']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Organitzadors</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['Organitzadors']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Personal autoritzat</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['PersonalAutoritzat']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Previsio d'assistents</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['PrevisioAssistents']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Enregistrable?</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['isEnregistrable']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>És un cicle?</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['EsCicle']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Comentaris</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['Comentaris']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Condicions</b></span>
	    	<span class="DH checkbox_list"><a class="blue" href="<?php echo url_for('web/espais#condicions') ?>" target="_BLANK">Llegeix les condicions</a><br /><span style="color: gray;"> Hauran de ser acceptades un cop validada la seva prereserva</span> </span>
	    </div>
				
		<div style="clear:both; padding-top:20px;" class="FORMULARI">
			<span class="DH" style="width:150px"></span>
			<span class="DH" style="width:450px">
            
            <?php if($FRESERVA->getObject()->getDataAlta() == ""): ?>
  				 	<button type="submit" id="BOTO_SUBMIT_RESERVA" class="BOTO_ACTIVITAT" style="width:140px" >Sol·liciteu la prereserva</button>  				 	  			  								  					 					
			<?php endif; ?>		        	            
            						 	  				 	  					        		                                   
			</span>
		</div>        
              
	</FIELDSET>
	
	<?php if($ENABLED) echo '</form>'; ?>	 
      		  	
<?php } ?>
<?php 

	function generaData($DIA)
	{

		$ret = ""; list($ANY,$MES,$DIA) = explode("-",$DIA);
		$DATE = mktime(0,0,0,$MES,$DIA,$ANY);
		switch(date('N',$DATE)){
			case '1': $ret = "Dilluns, ".date('d',$DATE); break;  
			case '2': $ret = "Dimarts, ".date('d',$DATE); break;
			case '3': $ret = "Dimecres, ".date('d',$DATE); break;
			case '4': $ret = "Dijous, ".date('d',$DATE); break;
			case '5': $ret = "Divendres, ".date('d',$DATE); break;
			case '6': $ret = "Dissabte, ".date('d',$DATE); break;
			case '7': $ret = "Diumenge, ".date('d',$DATE); break;				
		}
				
		switch(date('m',$DATE)){
			case '01': $ret .= " de gener"; break;
			case '02': $ret .= " de febrer"; break;
			case '03': $ret .= " de març"; break;
			case '04': $ret .= " d'abril"; break;
			case '05': $ret .= " de maig"; break;
			case '06': $ret .= " de juny"; break;
			case '07': $ret .= " de juliol"; break;
			case '08': $ret .= " d'agost"; break;
			case '09': $ret .= " de setembre"; break;
			case '10': $ret .= " d'octubre"; break;
			case '11': $ret .= " de novembre"; break;
			case '12': $ret .= " de desembre"; break;
		}
		
		$ret .= " de ".date('Y',$DATE);
		
		return $ret;
		
	}

	function missatge($MISSATGE)
	{
		if(!empty($MISSATGE))
		{
			echo '<TR>';
		   	echo '<TD></TD><TD class="MISSAT_OK">';
		   	foreach($MISSATGE as $M): echo $M."<BR>";  endforeach;    				
		   	echo '</TD></TR>';			
		}		
	}
    
    function missatgeDiv($MISSATGE)
	{
		if(sizeof($MISSATGE) > 0)
		{			
            echo '<DIV class="FORMULARI"><DIV class="MISSAT_OK" style="clear:both">';		   	
		   	foreach($MISSATGE as $M): echo $M."<BR>";  endforeach;    				
		   	echo '</DIV></DIV>';			
		}		
	}

?>
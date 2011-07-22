<?php use_helper('Form'); ?>

<script>

	$(document).ready(function() {
		$( "#tabs" ).tabs({ cookie: { expires: 1 } });
        $( "#FRESERVES").submit(validaReserves);
        $( "#FORM_CURSOS").submit(validaSeleccio);                
	});
	
    function validaSeleccio()
    {                
        var seleccionat = true;
		$('[name="D[CURS]"]:checked').each(function (a){ seleccionat = false; } );        
        if(seleccionat) { alert("Per poder-se matricular ha d'escollir el curs al que vol matricular-se."); return false; }
        return true;                                                              
    }

    function validaReserves()
    {        
        var espais = true;
		$(".ul_espais:checked").each(function (a){ espais = false; } );
        if($("#reservaespais_Nom").val().length == 0) { alert('Has d\'escriure un nom'); return false; }
        if($("#reservaespais_DataActivitat").val().length == 0) { alert('Has d\'escriure una data per l\'activitat'); return false; }
        if($("#reservaespais_HorariActivitat").val().length == 0) { alert('Has d\'escriure un horari orientatiu per l\'activitat'); return false; }
        if(espais) { alert("Has d'escollir com a mínim un espai on realitzar l'acte"); return false; }
        if($("#reservaespais_TipusActe").val().length == 0) { alert('Has d\'escriure quin tipus d\'acte és'); return false; }
        if($("#reservaespais_Representacio").val().length == 0) { alert('Has d\'escriure a qui representa'); return false; }
        if($("#reservaespais_Responsable").val().length == 0) { alert('Has d\'escriure un responsable de l\'activitat'); return false; }
        if($("#reservaespais_Organitzadors").val().length == 0) { alert('Has d\'escriure qui són els organitzadors'); return false; }
        if($("#reservaespais_PersonalAutoritzat").val().length == 0) { alert('Has d\'escriure el personal autoritzat que paritipcarà a l\'activitat'); return false; }                                                      
    }
    
</script>

<style>
    LEGEND { font-weight:bold; padding-left:10px; padding-right:10px; font-size:12px;  }  

	.DH { display:block; float:left; padding-top:5px; }

	fieldset { border:3px solid #F3F3F3; margin-right:40px; padding:10px; }
	.MISSAT { color:black; font-weight:bold; font-size:10px; vertical-align:middle; text-align:center; background-color:White; padding-bottom:10px; }	
	.TITOL_CATEGORIA { background-color: #DD9D9A; color:black; font-weight:bold; padding:5px; font-size:10px; }	

</style>

   <TD colspan="3" class="CONTINGUT_ADMIN">

	<?php include_partial('breadcumb',array('text'=>'ZONA PRIVADA')); ?>		
   	<?php include_partial('espaiActual',array('IDS'=>$IDS)); ?>

    <?php if($DEFAULT): ?>
		                   	                   	
        <div style=" padding:20px; width:700px; ">    
            <div id="tabs">
            	<ul>
                    <li><a href="#tabs-0">Benvinguda</a></li>                    
            		<li><a href="#tabs-1">Dades</a></li>
            		<li><a href="#tabs-2">Matrícules</a></li>
                    <li><a href="#tabs-3">Reserves</a></li>                            		
                    <li><a href="#tabs-4">Autentificació</a></li>
            	</ul>                        
                <div id="tabs-0"> <?php echo landing_page(); ?> </div>                
                <div id="tabs-1"> <?php echo LlistaDades($FDADES); ?> </div>
            	<div id="tabs-2"> <?php echo LlistaMatricules($LMATRICULES); ?> </div>
            	<div id="tabs-3"> <?php echo LlistaReserves($LRESERVES); ?> </div>              	
                <div id="tabs-4"> <?php echo AutentificacioTab($PARS, $FBI, $ERROR); ?> </div>
                
            </div>
        
        </div>
        
      <?php else:
      
              if(isset($FUSUARI)) echo EditaUsuari($FUSUARI,$MISSATGE);
              //Un cop sé que em vull matricular, em mostra els cursos                 
              if(isset($LCURSOS)) echo LlistaCursos($LCURSOS,$DATA_INICI);
              if(isset($TPV)) echo VerificaMatricula($TPV,$DADES_MATRICULA,$ISPLE,$IDS);                              
              if(isset($FRESERVA)) echo EditaReserva($FRESERVA,$MISSATGE);
              if(isset($MISS)) echo MissatgeWeb($TITOL,$MISS);
              if(isset($FENTITATS)) echo EditaEntitats($FENTITATS);
                                                                    
            endif;                                       
         
      ?>
      
      
      
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

<?php 


    /**
     * Autentificacio Tab. Els canvis aquí també s'han d'aplicar a gConfig
     * @param $PARS ( Paràmetres de la crida a fb_auth)
     * @param $FBI  ( Identificador Facebook de l'usuari si en té, sinó és 0 )
     * @param $ERROR ( Text amb l'error que hem produit ) 
     * */
    function AutentificacioTab($PARS,$FBI,$ERROR)
    {
                                    
        $RET = "<p>Clicant l'enllaç que apareix més avall podràs vincular o desvincular el teu usuari de l'Hospici amb el teu usuari de Facebook. Si els vincules, el teu usuari de Facebook també serà el de l'Hospici i podràs accedir a aquest últim sense haver d'entrar ni l'usuari ni la contrassenya.</p><br />";
         
        if($FBI == 0):
            if(!empty($ERROR)) $RET .= '<div class="error">'.$ERROR.'</div>';
            else $RET .= '<a href="'.$PARS['logUrl'].'">No tens cap usuari vinculat al facebook. Clica per vincular l\'actual.</a>';        
        else:
            $fb   = myUser::getFbObject();                                             
            $FBD  = $fb->api($FBI);
            $RET .= '<a href="'.url_for('@fb_user_unlink').'">Tens un usuari vinculat. Clica per desvincular-lo.</a><br /><br />';
            $RET .= '<img align="middle" src="https://graph.facebook.com/'.$FBI.'/picture"> '.$FBD['name'];                                   
        endif;
        
        
        return $RET;
        
    }


	function missatge_div($MISSATGE)
	{	   
	   $RET = "";
		if(!empty($MISSATGE))
		{
			$RET .= '<div class="MISSAT_OK">';		   	
		   	foreach($MISSATGE as $M): $RET .= $M."<BR>";  endforeach;    				
		   	$RET .= '</DIV>';			
		}		
           
        return $RET;
	}

	function missatge($MISSATGE)
	{
	   $RET = "";
		if(!empty($MISSATGE))
		{
			$RET .= '<TR>';
		   	$RET .= '<TD></TD><TD class="MISSAT_OK">';
		   	foreach($MISSATGE as $M): $RET .= $M."<BR>";  endforeach;    				
		   	$RET .= '</TD></TR>';			
		}		
        
        return $RET;
	}


    function FormulariEntitats($FENTITATS)
    {
    
        $RET = '
        <form name="gDades" action="'.url_for('gestio/uGestio').'" method="post">
           
                <table class="FORMULARI">                    
                '.$FENTITATS.'
                </table>
                <div style="text-align:right">
                    <button type="submit" name="BGUARDACANVIENTITAT" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/house.png').' Canvia de lloc
                    </button>
                </div>                                                              
        </form>';
                     
        return $RET;

    }

    function EditaEntitats($FENTITATS)
    {
    
        $RET = '
        <form name="gDades" action="'.url_for('gestio/uGestio').'" method="post">
           
    	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Dades personals</LEGEND>
    	                               	 	                                    
                <table class="FORMULARI">                    
                '.$FENTITATS.'
                </table>
                <div style="text-align:right">
                    <button type="submit" name="BGUARDACANVIENTITAT" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/house.png').' Canvia de lloc
                    </button>
                </div>
            </FIELDSET>                                                                                                            
        </form>';
                     
        return $RET;

    }

    function EditaUsuari($FUSUARI,$MISSATGE = "")
    {
    
        $RET = '
        <form name="gDades" action="'.url_for('gestio/uGestio').'" method="post">
           
    	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Dades personals</LEGEND>
    	   
    		   <TABLE class="FORMULARI">
    		   <tr><td width="100px"></td><td><td></tr>
               '.missatge($MISSATGE).'		      
    		   '.$FUSUARI.'      		                         
    		   </TABLE>
               
                <div style="text-align:right">
                    <button type="submit" name="BGUARDAUSUARI" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guarda els canvis
                    </button>
                </div>                                                                                                            
                  
    	   
    	   </FIELDSET>
    	   
    	</form>';
        
        return $RET;	 
            
    }


    function VerificaMatricula($TPV,$DADES_MATRICULA,$ISPLE,$IDS)
    {
        
        $RET = "";
        
         //Si la matricula es paga amb Targeta de crèdit, passem al TPV, altrament mostrem el comprovant     
        if($DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TARGETA || $DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TELEFON ):
            $URL = OptionsPeer::getString('TPV_URL',$IDS);
            $RET .= '<FORM name="COMPRA" action="'.$URL.'" method="POST" target="TPV">';         	 
            //$RET .= '<FORM name="COMPRA" action="https://sis-t.sermepa.es:25443/sis/realizarPago" method="POST" target="TPV">';
            //$RET .= '<form name="COMPRA" action="https://sis.sermepa.es/sis/realizarPago" method="POST" target="TPV">';             
            foreach($TPV as $K => $T) $RET .= input_hidden_tag($K,$T);             
        else:         
            $RET .= '<form method="post" action="gestio/uGestio?accio=FI_MATRICULA">';          	                  
        endif;
    
         //Carreguem totes les dades de matrícula     
        foreach($DADES_MATRICULA as $K => $V) { $str = "DADES_MATRICULA[".$K."]"; $RET .= input_hidden_tag($str,$V); }
        $IDC = $DADES_MATRICULA['CURS'];     
        $ESPLE = ($ISPLE)?'(EN ESPERA)':'';
    
         $RET .= '<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Verificació de la matrícula</LEGEND>';	
        
    	 $RET .= ' <TABLE class="FORMULARI" style="magin-right:40px;">
    		        <TR><TD><b>DNI</b></TD>     <TD>'.$DADES_MATRICULA['DNI'].'</TD></TR>
                    <TR><TD><b>NOM</b></TD>     <TD>'.$DADES_MATRICULA['NOM'].'</TD></TR>
                    <TR><TD><b>PAGAMENT</b></TD><TD>'.MatriculesPeer::textPagament($DADES_MATRICULA['MODALITAT']).'</TD></TR>
                    <TR><TD><b>IMPORT</b></TD>  <TD>'.$DADES_MATRICULA['PREU'].'€'.'</TD></TR>
                    <TR><TD><b>DATA</b></TD>    <TD>'.$DADES_MATRICULA['DATA'].'</TD></TR>
                    <TR><TD><b>DESCOMPTE</b></TD>  <TD>'.MatriculesPeer::textDescomptes($DADES_MATRICULA['DESCOMPTE']).'</TD></TR>
                    <TR><TD><b>CURS</b></TD>  <TD>';
        $RET .=     '<TABLE width="100%" class="FORMULARI">';                  								
   	
        $CURS = CursosPeer::retrieveByPK($DADES_MATRICULA['CURS']);                  								
        $RET .= '       <TR>
                	        <TD>'.$CURS->getCodi().'</TD>
                            <TD>'.$CURS->getTitolcurs().' '.$ESPLE.'</TD>
                            <TD>'.$CURS->CalculaPreu($DADES_MATRICULA['DESCOMPTE']).'€'.'</TD>
                			</TR>                  								                  								                  	                           
      		         </TABLE>
    	           </TD></TR>  	 	          
      	          </TABLE>	
                    
                    <div style="text-align:right">
                        <button type="submit" name="BPAGAMATRICULA" class="BOTO_ACTIVITAT" >
                            '.image_tag('template/coins.png').' Finalitzar la matrícula
                        </button>
                    </div>                                         
                    		                                  
    	       </FIELDSET>    	
    	</FORM>';
        
        return $RET;
        
    }

    function EditaReserva($FRESERVA,$MISSATGE ="" )
    {

	$RET = '<form name="fReserves" id="FRESERVES" method="post" action="'.url_for('gestio/uGestio').'">';    
    $RET .= '<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Reserva d\'espais</LEGEND>';
           	              	           	
    if(isset($MISSATGE[0]) && $MISSATGE[0] == '1'):
    
        $RET .= '   <div style="padding:10px; background-color: #FFFFE2; margin-bottom:20px;">                    
                        <b>Sol·licitud enregistrada correctament.</b><br /><br />
                        <span style="font-weight: bold; color:#FF6969; ">ATENCIÓ: Si és una nova sol·licitud, en els propers dies li enviarem un correu on haurà d\'acceptar les condicions o bé anul·lar la reserva. També podrà fer-ho des d\'aquest formulari.</span>                    
                    </div>';
                    
    elseif(isset($MISSATGE[0]) && $MISSATGE[0] == '0'):

        $RET .= '   <div style="padding:10px; background-color: #FFFFE2; margin-bottom:20px;">                    
                        <b>Hi ha hagut algun problema enviant la sol·licitud.</b><br /><br />
                        <span style="font-weight: bold; color:#FF6969; ">Li agrairem que es posi en contacte amb informatica@casadecultura.org. Moltes gràcies.</span>                    
                    </div>';
        
    endif;
        
//    $RET .= '<div class="FORMULARI">'.missatge_div($MISSATGE).'</div>';     

    $RET .= $FRESERVA['ReservaEspaiID']->render();
            
    $RET .= 
        '<div style="clear:both" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Nom de l\'activitat</b></span>
	    	<span class="DH">'.$FRESERVA['Nom']->renderError().$FRESERVA['Nom']->render().'</span>
	    </div>
	    	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Proposta de data</b></span>
	    	<span class="DH">'.$FRESERVA['DataActivitat']->renderError().$FRESERVA['DataActivitat']->render().'</span>
	    </div>
	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Proposta d\'hores</b></span>
	    	<span class="DH">'.$FRESERVA['HorariActivitat']->renderError().$FRESERVA['HorariActivitat']->render().'</span>
	    </div>
	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Espais</b> (<a class="blue" href="'.url_for('web/espais').'" target="_NEW">veure\'ls</a>)</span>
	    	<span class="DH checkbox_list" style="width:450px">'.$FRESERVA['EspaisSolicitats']->renderError().$FRESERVA['EspaisSolicitats']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Material</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['MaterialSolicitat']->renderError().$FRESERVA['MaterialSolicitat']->render().'</span>
	    </div>
		
		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Tipus d\'acte</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['TipusActe']->renderError().$FRESERVA['TipusActe']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Representant a</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['Representacio']->renderError().$FRESERVA['Representacio']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Responsable</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['Responsable']->renderError().$FRESERVA['Responsable']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Organitzadors</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['Organitzadors']->renderError().$FRESERVA['Organitzadors']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Personal autoritzat</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['PersonalAutoritzat']->renderError().$FRESERVA['PersonalAutoritzat']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Previsio d\'assistents</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['PrevisioAssistents']->renderError().$FRESERVA['PrevisioAssistents']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Enregistrable?</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['isEnregistrable']->renderError().$FRESERVA['isEnregistrable']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>És un cicle?</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['EsCicle']->renderError().$FRESERVA['EsCicle']->render().'</span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Comentaris</b></span>
	    	<span class="DH checkbox_list">'.$FRESERVA['Comentaris']->render().'</span>
	    </div>';
        
        
        
        if($FRESERVA->getObject()->getEstat() == ReservaespaisPeer::EN_ESPERA):
        
            $RET .= '<div style="clear: both;" class="FORMULARI">
	    	          <span class="DH" style="width:150px;"><b>Condicions</b></span>
	    	          <span class="DH checkbox_list"><a class="blue" href="'.url_for('web/espais#condicions').'" target="_BLANK">Llegeix les condicions</a><br /><span style="color: gray;"> Hauran de ser acceptades un cop validada la seva prereserva</span> </span>
	               </div>';
        else: 

            $RET .= '<div style="clear:both; padding-top:20px; " class="FORMULARI">
    			         <span class="DH" style="width:150px"></span>
    			         <span class="DH" style="width:450px">
                     </div>';
        
          $RET .= '<div style="clear: both;border-top:1px solid black;" class="FORMULARI">
	    	          <span class="DH" style="width:150px;"><b>Condicions</b></span>
	    	          <span class="DH checkbox_list">'.$FRESERVA['CondicionsCCG']->render().'</span>
	               </div>';                      
        endif; 

        $RET .= '<div style="clear:both; padding-top:20px; " class="FORMULARI">
			         <span class="DH" style="width:150px"></span>
			         <span class="DH" style="width:450px">
                 </div>';
            
        if($FRESERVA->getObject()->getEstat() == ReservaespaisPeer::EN_ESPERA):
	 	 $RET .= '
                <div style="text-align:right">
                    <button type="submit" id="BOTO_SUBMIT_RESERVA" name="BGUARDARESERVA" class="BOTO_ACTIVITAT" />
                        '.image_tag('template/disk.png').' Sol·liciteu la prereserva
                    </button>
                </div>';                                          
        elseif($FRESERVA->getObject()->getEstat() == ReservaespaisPeer::PENDENT_CONFIRMACIO):
        
	 	 $RET .= '
                <div style="text-align:right">
                    <button type="submit" id="BOTO_SUBMIT_RESERVA" name="BACCEPTACONDICIONSRESERVA" class="BOTO_ACTIVITAT" />
                        '.image_tag('template/accept.png').' Accepto les condicions i confirmo la reserva
                    </button>
                    <button type="submit" id="BOTO_SUBMIT_RESERVA" name="BANULACONDICIONSRESERVA" class="BOTO_ACTIVITAT" />
                        '.image_tag('template/cross.png').' No accepto les condicions i anul·lo la reserva
                    </button>
                </div>';                                          
                                                                                  			  					 					
		endif;		     
                    						 	  				 	  					        		                                   
		$RET .= '</span>
		  </div></fieldset></form>';        
        
        return $RET;	 
                
    }


function landing_page(){
?> 	    
        <br />   	   
	   	<p>
	   		Benvingut a la seva zona privada de la Casa de Cultura.<br /> 
	   		En aquest espai podrà accedir als serveis personalitzats que hem preparat per vostè.<br />
	   		Per accedir a qualsevol dels serveis podrà fer-ho a través del menú lateral esquerra <b>Zona privada</b> o a través d'aquesta mateixa pàgina.<br /> 
	   		<br />
	   	</p>	   		      
              
   <?php  
} 
    
    function LlistaDades($FDADES)
    {
    
        $OU = $FDADES->getObject();
        $Nom = $OU->getNomComplet();
        $Adreca = $OU->getAdreca();
        $Ciutat = $OU->getCodipostal(). ' - '.$OU->getPoblacioString();
        $Telefon = $OU->getTelefonString();
        $Email = $OU->getEmail();
    
        $RET = '                       	       	   
    		   <TABLE class="FORMULARI">
    		   <tr><td width="100px"></td><td><td></tr>               
               <tr><td class="TITOL">Nom: </td><td>'.$Nom.'</td>		      
               <tr><td class="TITOL">Correu: </td><td>'.$Email.'</td>
               <tr><td class="TITOL">Telèfon: </td><td>'.$Telefon.'</td>
               <tr><td class="TITOL">Adreça: </td><td>'.$Adreca.'</td>
               <tr><td class="TITOL">Població: </td><td>'.$Ciutat.'</td>    		         		                         
    		   </TABLE>
               
                <div style="text-align:right">
                    <a href="'.url_for('gestio/uGestio?accio=GESTIONA_USUARI').'">                    
                        '.image_tag('template/disk.png').' Editeu les dades
                    </a>
                </div>

    	';
        
        return $RET;	 
                
    }

    function LlistaMatricules($MATRICULES)
    {
                
        $RET = "";
        if(sizeof($MATRICULES)==0):
            $RET .= 'No tenim constància informàtica que hagueu realitzat un curs a aquesta entitat. <br />Si no és així, si us plau notifiqueu-nos-ho.';
        else:
            $RET .= '<TABLE class="DADES">';
            $RET .= '<TR><TD class="titol">CODI</TD>
                         <TD class="titol">NOM</TD>
                         <TD class="titol">ESTAT</TD>
                         <TD class="titol">DATA MATRÍCULA</TD>
                         <TD class="titol">DESCOMPTE</TD></TR>';                                   


            foreach($MATRICULES as $M):
                $CURSOS = $M->getCursos();
    		   	$RET .= '<TR>
    		   			    <TD>
        						<a href="#TB_inline?height=480&width=640&inlineId=hidden'.$CURSOS->getIdcursos().'&modal=false" class="thickbox">'.$CURSOS->getCodi().'</a>
              					<div style="display:none" id="hidden'.$CURSOS->getIdcursos().'">'.$CURSOS->getDescripcio().'</div>
    				        </TD>		   				   			
                            <TD>'.$CURSOS->getTitolCurs().'</TD>
                            <TD>'.MatriculesPeer::getEstatText( $M->getEstat() ).'</TD>
                            <TD>'.$M->getDataInscripcio('d/m/Y H:i').'</TD>
                            <TD>'.MatriculesPeer::textDescomptes($M->getTReduccio()).'</TD>                                                                                             
    			     </TR>';                                   
            endforeach;                              		
            $RET .= '</TABLE>';
        endif;
        
        $RET .= '<br /><div style="text-align:right">
                    <a href="'.url_for('gestio/uGestio?accio=GESTIONA_MATRICULES').'">                    
                        '.image_tag('template/new.png').' Nova matrícula
                    </a>
                 </div>';                                                                                                                            

        return $RET;           
           
    }
    
    function LlistaReserves($RESERVES)
    {
                     	     	
	    if(empty($RESERVES)):
        
            $RET = 'No s\'han trobat prereserves anteriors en aquesta entitat.';
            
        else:
        
            $RET  = '<TABLE class="DADES">';
            $RET .= '<TR><TD class="TITOL">Codi reserva</TD><TD class="TITOL">Nom activitat</TD><TD class="TITOL">Data sol·licitud</TD><TD class="TITOL">Estat</TD></TR>';
         
         	foreach($RESERVES as $R):     			
                $RET .= '   <TR>
                                <TD>'.link_to($R->getCodi(),'gestio/uGestio?accio=GESTIONA_RESERVES&idR='.$R->getReservaespaiid()).'</TD>                            
                                <TD>'.$R->getNom().'</TD>
                                <TD>'.$R->getDataalta('d/m/Y').'</TD>
                                <TD>'.$R->getEstatText().'</TD>                                                        
                            </TR>'; 
    		endforeach;
            $RET .= '</TABLE>';     

        endif;

        $RET .= '<br /><div style="text-align:right">
                    <a href="'.url_for('gestio/uGestio?accio=GESTIONA_RESERVES').'">                    
                        '.image_tag('template/new.png').' Crea una nova reserva                    
                    </a>
                 </div>';                                                                                                                    

        
        return $RET;  
        
    }
    
    function LlistaCursos($LCURSOS,$DATA_INICI)
    {
        
        $RET  = '<form method="post" action="'.url_for('gestio/uGestio').'" id="FORM_CURSOS">';
        $RET .= '<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Cursos disponibles </LEGEND>';        
        $RET .= '<div style="margin-bottom:10px; padding:10p">Atenció: Si el curs es suspèn per motius interns o per falta d\'alumnes, l\'import cobrat serà retornat.</div>';
                                
        if(sizeof($LCURSOS) == 0):
        
            $RET .= 'Actualment no hi ha cap curs disponible.</fieldset></form>';
                            
        else: 
                            
            $RET .= '           
    				<TABLE class="DADES">
                    <tr>
    				    <td class="TITOL" colspan="2">CODI</td>						   	
    					<td class="TITOL">NOM</td>
    					<td class="TITOL">PREU</td>
    					<td class="TITOL" width="70px">INICI</td>
    					<td class="TITOL">PLACES</td>
    				</tr>';
            
    		$CAT_ANT = "";   
    		foreach($LCURSOS as $C):
                if($C->getVisibleweb() == 1):                      
                    if($CAT_ANT <> $C->getCategoria()) $RET .= '<TR><TD colspan="6" class="TITOL_CATEGORIA">'.$C->getCategoriaText().'</TD></TR>';                
                    $PLACES = $C->getPlacesArray(); 
                    $ple = ($PLACES['OCUPADES'] == $PLACES['TOTAL'])?"style=\"background-color:#FFCCCC;\"":"";
                    $jple = ($PLACES['OCUPADES'] == $PLACES['TOTAL']);                                                                                 					                       	
    		   		$RET .= '<TR>
    					       <TD '.$ple.'>'.radiobutton_tag('D[CURS]',$C->getIdcursos(),false,array('onClick'=>'ActivaBoto('.$jple.');','class'=>'class_cursos ')).'</TD>';					      		
    				$RET .= '  <TD '.$ple.'>';
                    $RET .= '       <a href="#TB_inline?height=480&width=640&inlineId=hidden'.$C->getIdcursos().'&modal=false" class="thickbox">
    					      				'.$C->getCodi().'
                                    </a>
    				                <div style="display: none;" id="hidden'.$C->getIdcursos().'">
                                            <div id="TEXT_WEB">
    			      						 '.$C->getDescripcio().'
                                            </div>
          							</div>
      		                    </TD>';
                    $RET .= '<TD '.$ple.'>'.$C->getTitolcurs().' ( '.$C->getHoraris().' ) </TD>';
                    $RET .= '<TD '.$ple.'>'.$C->getPreu().' €</TD>';      							
      		        $RET .= '<TD '.$ple.'>'.$C->getDatainici('d-m-Y').'</TD>';
      		        $RET .= '<TD '.$ple.'>'.$PLACES['OCUPADES'].'/'.$PLACES['TOTAL'].'</TD>';
       	            $RET .= '</TR>';                		                 										
                    $CAT_ANT = $C->getCategoria();
                endif;			   
    		endforeach;        					                         
    		$RET .= '</TABLE><br />';
                    
            $avui = time();                                                                                    
            if($DATA_INICI >= $avui):
                $BOT = "<div class=\"text\" style=\"font-weight:bold; \">El període de matrícules comença el dia ".date('d/m/Y',$DATA_INICI).'.<br /> Encara no es pot matricular.</div>';
            else: 
                $BOT = "";
                //$BOT = "<div>".submit_tag('Matriculeu-me',array('name'=>'BMATRICULA' , 'class'=>'BOTO_ACTIVITAT' , 'style'=>'width:100px')).'</div>';
            endif;                
                    
            $RET .= '   <TABLE class="FORMULARI" width="100%">					   		
                            <TR><TD width="100px;" style="font-size:10px;"><b>DESCOMPTE</b></TD><td>'.select_tag('D[DESCOMPTE]',options_for_select( MatriculesPeer::selectDescomptesWeb(),MatriculesPeer::REDUCCIO_CAP)).'</TD></TR>
    					   	<TR><TD width="100px"></TD>
                                <TD>'.$BOT.'<br />                                                                                                                                                                                                  
                                </TD>
                            </TR>
                        </TABLE>';        
            
            
            if(empty($BOT)):
                $RET .= '<div style="text-align:right">
                            <button type="submit" name="BMATRICULA" class="BOTO_ACTIVITAT">
                                '.image_tag('template/bookmark_document.png').' Matricular-me
                            </button>
                        </div>';
            endif; 
                    
            $RET .= '
                    </fieldset>                                                                
                 </form>                                            
                ';
        endif;      
                     
        return $RET;           
        
     }
     
    function MissatgeWeb($TITOL,$MISS)
    {                        
        $RET  = '<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">'.$TITOL.'</LEGEND>';
        $RET .= '<DIV style="margin-right:20px;"><span class="TITOLAR">'.$MISS.'</span></DIV>';
        $RET .= '</FIELDSET>';
           
        return $RET;        
     }
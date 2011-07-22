<?php use_helper('Form') ?>

<style>
	
	.row { width:500px; } 
	.row_field { width:70%; } 
	.row_title { width:30%; }
	.row_field input { width:100%; }
	input.ul_cat { background-color:white; border:0px; width:20px; }
	li.ul_cat { width:220px; }
	#TD1 td { border: 0px solid #DB9296; padding:0px 2px; font-size:10px; }
	#TD1 { border-collapse:collapse; }
	.LIST2 { padding:10px;  } 
		
</style>
 
 
<TD colspan="3" class="CONTINGUT_ADMIN">	

	<?php include_partial('breadcumb',array('text'=>'HORARI PERSONAL')); ?>
	
    
    <?php if(isset($FPERSONAL)) echo showForm($FPERSONAL,$ERROR,$IDU,$DATE); ?>
    
    <?php if(isset($DADES_DIA_USUARI)) echo showList($DADES_DIA_USUARI,$DIA); ?>
    
    <?php echo showCalendari($DATAI,$CALENDARI); ?>
              	 
     
</TD>
                
<?php 

function menu($seleccionat = 1,$nova = false)
{     
	echo "<TABLE class=\"REQUADRE\"><tr>";
		
	if(!$nova): 
	    if($seleccionat == 1) echo '<td class="SUBMEN1">'.link_to('Dades activitat','gestio/gActivitats?accio=CA').'</td>';
	    else  echo '<td class="SUBMEN">'.link_to('Dades activitat','gestio/gActivitats?accio=CA').'</td>';             
        if($seleccionat == 2) echo '<td class="SUBMEN1">'.link_to('Horaris','gestio/gActivitats?accio=CH').'</td>';
        else echo '<td class="SUBMEN">'.link_to('Horaris','gestio/gActivitats?accio=CH').'</td>';
        if($seleccionat == 3) echo '<td class="SUBMEN1">'.link_to('Descripció','gestio/gActivitats?accio=T').'</td>';
        else echo '<td class="SUBMEN">'.link_to('Descripció','gestio/gActivitats?accio=T').'</td>';
        if($seleccionat == 4) echo '<td class="SUBMEN1">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</td>';
        else echo '<td class="SUBMEN">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</td>';        
      else:
        if($seleccionat == 1) echo '<TD class="SUBMEN1">'.link_to('Dades activitat','gestio/gActivitats?accio=N').'</td>';
	    else  echo '<td class="SUBMEN">'.link_to('Dades activitat','gestio/gActivitats?accio=N').'</td>';
	    if($seleccionat == 4) echo '<TD class="SUBMEN1">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</td>';
        else echo '<td class="SUBMEN">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</td>';                             
      endif;
     
     echo "</tr></table>";
}


  function llistaCalendariH($DATAI, $CALENDARI)
  {
  
  	//Farem la mostra per setmanes
  	$Q		= 3;
  	$W 		= date('W',$DATAI);
  	$dia    = date('d',$DATAI);
	$mes  	= date('m',$DATAI);
	$year 	= date('Y',$DATAI);
  	  	 	
  	//Agafem el dilluns anterior o el mateix dia i el diumenge
  	$dia_setmana = date('N',$DATAI);  	   	  		
  	$primer_dilluns = mktime(0,0,0,$mes,($dia-$dia_setmana+1),$year);
  	$primer_diumenge = mktime(0,0,0,$mes,$dia+(7-$dia_setmana),$year);
  	  	
  	$RET = "<TR><td></td>";
  	for($i = $Q; $i>0;$i--):
  		$RET .= "<TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD>";
  	endfor;
	$RET .= "</TR>";
	
	foreach($CALENDARI as $idU => $DADES):
	
		$RET .= "<TR>";
		$RET .= '<td>'.$DADES['TREBALLADOR'].'</td>';		
		
		$ULTIM_HORARI = $DADES['ULTIM_HORARI'];
		
		$j = 1;               
	    for($i = 0; $i < $Q*7; $i++):
	    	
	    	$style = ""; $marc = ""; $fons = "";
	   
	    	$diaA = mktime(0,0,0,$mes,($dia-$dia_setmana+1)+$i,$year);            
	    
			if( ( $j == 6 || $j == 7 ) ):
				$fons = "background-color: beige;";
				if($j == 7) $j = 1;
				else $j++; 
			else:
				$fons = "background-color: white;";
				$j++;
			endif;  
			
			if(($dia-$dia_setmana+1)+$i == $dia): $style .= 'font-weight:bold;'; endif;             
	
			$SPAN = "";						 
			if(isset($DADES['DIES'][$diaA])):
                				
                $CANVI_HORARI = false;
                $AP = false;  
                                                
				$SPAN = "<span>";
                                
                foreach($DADES['DIES'][$diaA] as $D2):                  
                    //Quan vingui un canvi d'horari aquest quedarà fins que en vingui un altre                
    				if($D2->getTipus() == PersonalPeer::HORARI_USUARI): 					
    					$ULTIM_HORARI = $D2->getText();                          				                                         
    				endif; 
                endforeach;
                                                        
                $SPAN .= '<b>Horari: </b>'.$ULTIM_HORARI; 
    			$SPAN .= '<br />';                                                          
                $index = 1;                                        
                foreach($DADES['DIES'][$diaA] as $D2):
                                                        
                    //Si la línia és de feina, la mostrem 
    				if($D2->getTipus() == PersonalPeer::FEINA):
    					$SPAN .= '<br /><b>'.$index++.' . (T)</b> '.substr($D2->getText(),0,100).'...';
    				endif; 						
                    
                    //Si hi ha un canvi en l'horari, la marquem  
    				if($D2->getTipus() == PersonalPeer::CANVI_HORARI):
    					$SPAN .= '<br /><b>'.$index++.'. (H)</b> '.$D2->getText();
    				endif;
                    
    				//Si no hi és... no apareix el número i requadre en vermell. 
    				//Si hi ha canvi d'horaris, el requadre serà en taronja
    				//Si hi ha feines és en groc fluorescent. 																
    				if($D2->getTipus() == PersonalPeer::AP_FESTA): 
                        $fons = "background-color:red;"; 
                        $AP = true;
    				elseif($D2->getTipus() == PersonalPeer::CANVI_HORARI && !$AP): 
                        $fons = "background-color:orange;"; 
                        $CANVI_HORARI = true;
    				elseif($D2->getTipus() == PersonalPeer::FEINA && !$AP && !$CANVI_HORARI): 
                        $fons = "background-color:yellow;";
    				endif;                     
                    
				endforeach;
                $SPAN .= "</span>";				
				
			else:
			 
				$SPAN = "<span>";				 
				$SPAN .= '<b>Horaris: </b>'.$ULTIM_HORARI; 
				$SPAN .= '<br /><br />';						
				$SPAN .= "</span>";
							
			endif; 
			//Si la persona hi és el marc és verd i si no hi és, el marc és vermell.			             
			$RET .= '<TD class="DIES" style="'.$marc.$fons.$style.'" >'.link_to(date('d',$diaA).$SPAN,"gestio/gPersonal?accio=EDIT_DATE&IDU=".$idU."&DATE=".$diaA, array('class'=>"tt2")).'</TD>';
	                      
	      endfor;
	      $RET .= "</TR>";
	      
	endforeach;
                          
    return $RET;
      
  }

    
  function getSelData($DATAI = NULL)
  {

  	 $DIA = date('d',$DATAI);
     $MES = date('m',$DATAI); 
     $ANY = date('Y',$DATAI);            
     
     $RET = "";
     $RET = link_to($ANY-1,'gestio/gPersonal?DATAI='.mktime(0,0,0,1,1,$ANY-1),array('class'=>'negreta'))." ";
     for($any = $ANY ; $any < $ANY+2 ; $any++ ):
     	$RET .= link_to($any,'gestio/gPersonal?DATAI='.mktime(0,0,0,1,1,$any),array('class'=>'negreta'))." ";
     	for($mes = 1; $mes < 13; $mes++):
     		$RET .= link_to(mesosSimplificats($mes),"gestio/gPersonal?accio=CC&DATAI=".mktime(0,0,0,$mes,1,$any),array('class'=>'mesos_unit'))." ";
     	endfor;     
     endfor;
      
     $RET .= "&nbsp; ".link_to(' - set','gestio/gPersonal?DATAI='.mktime(0,0,0,$MES,$DIA-7,$ANY),array('class'=>'negreta')).' | '.link_to(' + set','gestio/gPersonal?DATAI='.mktime(0,0,0,$MES,$DIA+7,$ANY),array('class'=>'negreta'));
     
     return $RET;
     
  }
  
  function mesos($mes)  
  {
    switch($mes){
      case 1: $text = "Gener"; break;
      case 2: $text = "Febrer"; break;
      case 3: $text = "Març"; break;
      case 4: $text = "Abril"; break;
      case 5: $text = "Maig"; break;
      case 6: $text = "Juny"; break;
      case 7: $text = "Juliol"; break;
      case 8: $text = "Agost"; break;
      case 9: $text = "Setembre"; break;
      case 10: $text = "Octubre"; break;
      case 11: $text = "Novembre"; break;
      case 12: $text = "Desembre"; break;
    }
    
    return $text; //utf8_encode($text);
  
  }
  
  function mesosSimplificats($mes)  
  {
    switch($mes){
      case 1: $text = "G"; break;
      case 2: $text = "F"; break;
      case 3: $text = "M"; break;
      case 4: $text = "A"; break;
      case 5: $text = "M"; break;
      case 6: $text = "J"; break;
      case 7: $text = "J"; break;
      case 8: $text = "A"; break;
      case 9: $text = "S"; break;
      case 10: $text = "O"; break;
      case 11: $text = "N"; break;
      case 12: $text = "D"; break;
    }
    
    return utf8_encode($text);
  
  }
  

  function fletxeta()
  {    
    return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));    
  }

  ?>
  
<?php 

    /**
     * Funció que dibuixa el calendari
     * */
    function showCalendari($DATAI, $CALENDARI){
        $RET = '<DIV class="REQUADRE">
            		<DIV class="TITOL">Horaris laborals<SPAN id="MESOS">'.getSelData($DATAI).'</SPAN></DIV>
            		<table style="border-collapse: collapse;" id="CALENDARI_ACTIVITATS">          
            		'.llistaCalendariH($DATAI,$CALENDARI).'
            		</table>
            	</DIV>';
                
        return $RET;
    }
    
    function showList($DADES_DIA_USUARI,$DIA){
     
        $RET = '<DIV class="REQUADRE">          
                    <DIV class="TITOL">Llistat del dia '.date('Y-m-d',$DIA).' (<a href="'.url_for('gestio/gPersonal?accio=NEW_CHANGE').'">Nova instrucció</a>)</DIV>
                    <TABLE class="DADES">
                    	<TR>				
                    		<TD class="LINIA"><b>TIPUS</b></TD>
                    		<TD class="LINIA"><b>TEXT</b></TD>
                            <TD class="LINIA"><b>CREAT</b></TD>							
                    		<TD class="LINIA"><b>REVISIÓ</b></TD>                								
                    	</TR>';
         
       	 if( sizeof($DADES_DIA_USUARI) == 0 ): $RET .= '<TR><TD colspan="4" class="LINIA">No hi ha cap notificació aquest dia. </TD></TR>'; endif;  
       	 foreach($DADES_DIA_USUARI as $D): 						
         $RET .= ' 		<TR>				
                			<TD class="LINIA">
                                <a href="'.url_for('gestio/gPersonal?accio=EDIT_CHANGE&IDPERSONAL='.$D->getIdpersonal()).'">
                                    '.$D->getTipusString().'</a></TD>
                			<TD class="LINIA">'.$D->getText().'</TD>
                            <TD class="LINIA">'.$D->getUsuarisRelatedByUsuariupdateid()->getNomComplet().'</TD>							
                			<TD class="LINIA">'.$D->getDataRevisio().'</TD>
                 		</TR>';
       	 endforeach;                        	
         $RET .= '  </TABLE>      
                </DIV>';
                    
        return $RET;                                        
    }
    
    function showForm($FPERSONAL,$ERROR,$IDU,$DATE)
    {
        
        $nom  = UsuarisPeer::retrieveByPK($IDU)->getNomComplet();
        $data = date('d-m-Y',$DATE);
        if(!empty($ERROR)){ $ER = '<tr><td class="missat_ko" colspan="2">'; foreach($ERROR as $E): $ER .= $E.'<br />'; endforeach; $ER .= '</td></tr>'; }
        else $ER = '';          	    		    		    
        
        $RET = '   	
              	<form action="'.url_for('gestio/gPersonal').'" method="POST">
        	 	<DIV class="REQUADRE">
        	    <div class="OPCIO_FINESTRA">'.link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gPersonal').'</div>
        	    	<table class="FORMULARI" width="550px">   	    
                        <tr>
                            <td colspan="2" class="TITOL" width="600px">Fitxa laboral per a '.$nom.' el dia '.$data.'</td></tr>        	    	
        	    	        '.$ER.'	
 	                    <tr><td width="100px"></td><td width="500px"></td></tr>	    	
                        '.$FPERSONAL.'                								
                        <tr>
                        	<td></td>
        	            	<td colspan="2" class="dreta">
				                <button type="submit" name="BSAVE" class="BOTO_ACTIVITAT">
		                          '.image_tag('template/disk.png').' Guardar i sortir
                                </button>
	                            <button type="submit" name="BDELETE" class="BOTO_PERILL">
		                          '.image_tag('tango/16x16/status/user-trash-full.png').' Eliminar
	                            </button>

                       	    </td>
        	            </tr>                	 
              		</TABLE>
              	</DIV>
             </form>';         

      return $RET;			   	                                   
    }

?>
  
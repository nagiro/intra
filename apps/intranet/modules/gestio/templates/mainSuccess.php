<style>
  .small { font-size:9px; color:gray;  }
</style>
<td colspan="3" class="CONTINGUT_ADMIN">
     
	<div class="REQUADRE">
		<div class="TITOL">Resum d'avui</div>
      	<table class="DADES">
			<tr><td>Incidències : 	</td><td><?=$NINCIDENCIES?></td>
			<td>Matrícules  : 		</td><td><?=$NMATRICULES?></td>
			<td>Material    : 		</td><td><?=$NMATERIAL?></td>
			<td>Missatges   : 		</td><td><?=$NMISSATGES?></td>
			<td>Feines      : 		</td><td><?=$NFEINES?></td>
			<td>Activitats  : 		</td><td><?=$NACTIVITATS?></td></tr> 	 				    	
      	</table>      
      </div>
	  
	<div class="REQUADRE">
		<div class="TITOL">Missatges d'avui</div>


        <div class="DADES" style="width:650px;">
         <?php  
            $M = $MISSATGES; 
            if( empty($M) ):
               echo '<div>Avui no hi ha cap missatge.</div>';
            else:
                foreach($MISSATGES as $M):
                    $SPAN  = '<span>'.$M->getText().'</span>';
                    if($M->getIsglobal()):
                        echo '  <div style="border-bottom:1px solid #CCCCCC; background-color:#E4F7D9;">
                                    <div style="float:left; width:500px;"><div style="padding:4px">'.link_to(image_tag('intranet/Submenu2.png').' '.$M->getTitol().$SPAN,'gestio/gMissatges?accio=E&IDM='.$M->getMissatgeid().'&CERCA=' , array('class'=>'tt2') ).'</div></div>
                                    <div style="float:left; width:150px;">
                                        <div style="padding:4px"><b>'.$M->getUsuaris()->getNom().' '.$M->getUsuaris()->getCog1().'</b> de '.$M->getSiteNom().'</div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>';                    
                    else:                         
              		    echo '  <div style="border-bottom:1px solid #CCCCCC">                      				
                                    <div style="float:left; width:500px;"><div style="padding:4px">'.link_to(image_tag('intranet/Submenu2.png').' '.$M->getTitol().$SPAN,'gestio/gMissatges?accio=E&IDM='.$M->getMissatgeid().'&CERCA=' , array('class'=>'tt2') ).'</div></div>
                                    <div style="float:left; width:150px;"><div style="padding:4px">'.$M->getUsuaris()->getNom().' '.$M->getUsuaris()->getCog1().'</div></div>
                                    <div style="clear:both"></div>
                 			    </div>';                                  
                    endif;
                endforeach;             
                    
            endif;
                                 
                    ?>     			        
        </div>

<!--        
      	<table class="DADES">
                <?php                
/*                	
                	if(empty($MISSATGES)): echo '<tr><td></td></tr>'; endif; 	
                
					foreach($MISSATGES as $M):
						echo '<tr>';
						$nom_id = "MISS".$M->getMissatgeid();                  								
						echo '	<td width="70%">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' <a href="#TB_inline?height=300&width=500&inlineId='.$nom_id.'&modal=false" class="thickbox tt2">'.$M->getTitol().'<span id="'.$nom_id.'"><p style="font-size:12px; text-align:justify">'.$M->getText().'</p></span></a></td>';																								
						$U = $M->getUsuaris();											
						echo '  <td width="20%">'.$U->getNom().' '.$U->getCog1().'</td>';
						echo '  <td width="10%">'.$M->getPublicacio('d/m/Y').'</td>';
						echo '</tr>';											
					endforeach;                               */
                ?>                                                         
      	</table>
-->                
      </div>



	<div class="REQUADRE">
		<div class="TITOL">Feines i notificacions per avui</div>
      	<table class="DADES">
                <?php

					foreach($NOTIFICACIONS as $F):						
						$SPAN = '<SPAN>'.$F['TEXT'].'</SPAN>';
                        $TIPUS = "N/D";
                        switch($F['TIPUS']){
                            case PersonalPeer::AP_FESTA: $TIPUS = 'Festa'; break;
                            case PersonalPeer::CANVI_HORARI: $TIPUS = 'Horari puntual'; break;
                            case PersonalPeer::HORARI_USUARI: $TIPUS = 'Horari habitual'; break;
                        }                        
						echo '<tr>
								<td width="20%">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' <a href="#" class="tt2">'.$TIPUS.'</td>																								
                                <td><a href="#" class="tt2">'.$F['SUBTEXT'].$SPAN.'</td>                                
								<td width="20%">'.$F['USUARIA'].'</td>
							  </tr>';						
                	endforeach;

                    foreach($INCIDENCIES as $I):						
						$SPAN = '<SPAN>'.$I->getDescripcio().'</SPAN>';
						echo '<tr>
								<td width="20%">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' <a href="#" class="tt2">Incidència</td>																								
                                <td><a href="#" class="tt2">'.$I->getTitol().$SPAN.'</td>                                
								<td width="20%">'.UsuarisPeer::getNom($I->getQuiinforma()).'</td>
							  </tr>';						
                	endforeach;                    
                                                   
					foreach($FEINES as $F):						
						$SPAN = '<SPAN>'.$F['TEXT'].'</SPAN>';                        
                                                                        
                        $DATA = date('d-m-Y',$F['DATA']);                              
                        $SetMana = mktime(0,0,0,date('m',time()),date('d',time())-7,date('Y',time()));                                                
                                                
                        if($DATA == date('d-m-Y',time())) $DATA = 'Avui';
                        elseif(strtotime($DATA) > $SetMana) $DATA = 'Menys de 7 dies ('.$DATA.')';
                        elseif(strtotime($DATA) <= $SetMana) $DATA = 'Fa més d\'una setmana ('.$DATA.')';                        

                        $PAR = url_for('gestio/gPersonal?accio=EDIT_CHANGE&IDU='.$F['IDU'].'&IDPERSONAL='.$F['IDP'].'&DATE='.$F['DATA']);
                        
						echo '<tr>
								<td width="20%">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' <a href="#" class="tt2">Feina</td>
                                <td><a href="'.$PAR.'" class="tt2">'.$F['SUBTEXT'].$SPAN.'</a> <span class="small"> | '.$DATA.'</span></td>                                
								<td width="20%">'.$F['USUARI'].'</td>
							  </tr>';						
                	endforeach;                                    
                                        
                ?>                                                       
      	</table>      
      </div>



         
	<div class="REQUADRE">
		<div class="TITOL">Activitats per avui</div>
      	<table class="DADES">
                <?php                
                
                	if(empty($ACTIVITATS)): echo '<tr><td></td></tr>'; endif;
                
					foreach($ACTIVITATS as $A):						
						echo '<tr>';                      	
						if( strlen( $A['AVIS'] ) > 2 ):  $AVIS = '<a href="#" class="tt2">'.image_tag('tango/32x32/emblems/emblem-important.png', array('size'=>'16x16')).'<span>'.$A['AVIS'].'</span></a>'; else: $AVIS = ""; endif;
	                  	echo '<td>'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' '.$A['NOM_ACTIVITAT'].$AVIS.'</td>';	                    
	                  	echo '<td><span style="font-weight:bold; font-size:10px; color:green;">'.$A['HORA_INICI'].'</span></td>';	                  	
	                  	echo '<td>'.$A['HORA_FI'].'</td>';
	                  	$ESPAIS = "";	  
	                  	$Z = $A['ESPAIS'];                		                  	   
	                  	if(sizeof($A['ESPAIS']) > 0) $ESPAIS = implode('<br />',$Z);
	                    echo '<td><span style="font-weight:bold; font-size:10px; color:#880000;">'.$ESPAIS.'</span></td>';
	                    
	                    $MATERIAL = "";	     	                 	                               	
	                  	if(sizeof($A['MATERIAL']) > 0) $MATERIAL = implode("<BR />",$A['MATERIAL']);
	                    echo '<td>'.$MATERIAL.'</td>';						            
	                    echo '</tr>';												
                	endforeach;
                	
                ?>                                                       
		</table>      
	</div>
      
            
      <div STYLE="height:40px;"></div>
                
    
    
<?php 

function fletxeta()
{
  return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));
}


?>

    <TD colspan="2" class="CONTINGUT">
    
    <?php include_partial('breadcumb',array('text'=>$TITOL)); ?>
    
	<?php
	
     	$titol 		= $DESCRIPCIO->getTMig();
     	$imatge 	= $DESCRIPCIO->getImatge(); 
     	$pdf 		= $DESCRIPCIO->getPdf(); 
     	$descripcio = $DESCRIPCIO->getDMig();
     	
		if(!empty($titol)):
    		echo '<TABLE class="BOX">';
	    	echo '<TR>';  
 			if(!empty($imatge)):	    
 				echo '<TD class="FOTO">'.image_tag('noticies/'.$imatge, array('class'=>'IMG_FOTO')).'</TD>';
 			endif;
	        echo '<TD class="NOTICIA">';
	        if($DESCRIPCIO instanceof Activitats):
				echo '	<DIV class="DATA">';

					$RET = array(); 
					foreach($DESCRIPCIO->getHorarisActius($IDS) as $H):
						$LOHE = $H->getHorarisespaiss(HorarisespaisPeer::getCriteriaActiu(new Criteria(),$IDS));
						$noms = array();
						foreach($LOHE as $OHE):
							$noms[] = $OHE->getNomEspai();
						endforeach;	
						$RET[generaData($H->getDia('Y-m-d')).' a les '.$H->getHoraInici('H:i')] = implode(',',$noms);
						 
					endforeach;

					foreach($RET as $K=>$R):
						echo $K.' ( '.$R.' )<br />';
					endforeach;
				        			                   
				echo '  </DIV>';
			endif;     					        	        
			echo '<DIV class="TITOL">'.$titol.'</DIV>';
	    	echo '<DIV>'.$descripcio.'</DIV>';			    	 					    	
	    	echo '<DIV class="PEU">';
	    	echo 	'<br />';
	    	echo 	link_to('Tornar', url_for('web/index?accio=ret'), array('class'=>'verd','style'=>'float:left; font-weight:bold;'));
 			if(!empty($pdf)): 				 
 				echo link_to(image_tag('intranet/pdf.png', array('style'=>'float:right')),image_path('noticies/'.$pdf , true) , array('target'=>'_NEW')); 				
 			endif;
 			echo '</DIV>';			
			echo '</TD>';
	    	echo '</TR>';		    			    			    			    			    	
	    	echo '</TABLE>';
 		endif;

 	?>
	
		<DIV STYLE="height:40px;"></DIV>
                
    </TD>
    
    <?php    
    
	function generaData($DIA)
	{

		$ret = ""; list($ANY,$MES,$DIA) = explode("-",$DIA);
		$DATE = mktime(0,0,0,$MES,$DIA,$ANY);
		switch(date('N',$DATE)){
			case '1': $ret = "Dl, ".date('d',$DATE); break;  
			case '2': $ret = "Dm, ".date('d',$DATE); break;
			case '3': $ret = "Dc, ".date('d',$DATE); break;
			case '4': $ret = "Dj, ".date('d',$DATE); break;
			case '5': $ret = "Dv, ".date('d',$DATE); break;
			case '6': $ret = "Ds, ".date('d',$DATE); break;
			case '7': $ret = "Dg, ".date('d',$DATE); break;				
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
		
//		$ret .= " de ".date('Y',$DATE);
		
		return $ret;
		
	}


?>
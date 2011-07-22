<?php use_helper('Presentation'); ?>

    <td colspan="2" class="CONTINGUT">
    <?php 

    if(empty($ACTIVITATS_LLISTAT)): echo '<DIV>Aquest dia no hi ha cap activitat pública.<DIV>'; endif;		
		
	foreach($ACTIVITATS_LLISTAT as $A):
     	$titol = $A['DADES']['TITOL']; $imatge = $A['DADES']['IMATGE']; $pdf = $A['DADES']['PDF']; $descripcio = $A['DADES']['TEXT'];
		if(!empty($titol)):               	        	        	       	       	       	    	       	       	       	       	       	       	       	      	   	          	           	   	      		
    		echo '<TABLE class="BOX">';
	    	echo '<TR>';  
 			if(!empty($imatge)):	    
 				echo '<TD class="FOTO">'.image_tag('noticies/'.$imatge, array('class'=>'IMG_FOTO')).'</TD>';
 			endif;
	        echo '<TD class="NOTICIA">';
			echo '	<DIV class="DATA">';
					foreach($A['HORARIS'] as $H): echo implode(',',$H['ESPAIS']).' a les '.$H['HORAI']; endforeach; 		        	      		        			                   
			echo '  </DIV>';			        
			echo '<DIV class="TITOL">'.$titol.'</DIV>';
			$dim = 250;
			echo '<DIV class="TEXT" id="CUR'.$A['DADES']['ID'].'" >'.substr( $descripcio , 0 , $dim).'...</div>';
	    	echo '<DIV class="TEXT AMAGAT" id="DIV'.$A['DADES']['ID'].'" >'.$descripcio.'</DIV>';			    	
 			if(strlen($descripcio) > $dim):		    	
	    		echo '<DIV class="PEU"><a href="#" onClick="visible('.$A['DADES']['ID'].')">'.image_tag('intranet/llegirmes.png', array('style'=>'float:left')).'</a>';
 			endif;
 			if(!empty($pdf)): 
 				echo link_to(image_tag('intranet/pdf.png', array('style'=>'float:right')),image_path('noticies/'.$pdf , true) , array('target'=>'_NEW'));
 			endif;
			echo '</DIV>';
			echo '</TD>';
	    	echo '</TR>';
	    	echo '</TABLE>';
 		endif;     	                
	      	                
	endforeach;
    ?>
      <div style="height:40px;"></div>
                
    </td>
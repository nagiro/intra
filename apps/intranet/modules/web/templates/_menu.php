<script type="text/javascript">

function showElement(theClass) {

	//Create Array of All HTML Tags
	var allHTMLTags=document.getElementsByName(theClass);

	//Loop through all tags using a for loop
	for (i=0; i<allHTMLTags.length; i++) { 
		if(allHTMLTags[i].style.display=="none"){ allHTMLTags[i].style.display="block";	} else { allHTMLTags[i].style.display="none"; }
	}

	return false;
}
	

</script>

<?php if($TIPUS_MENU == 'WEB' || $TIPUS_MENU == 'ADMIN'): ?>
		<TD class="MENU"><center>		      

        <?php echo llistaMenu($MENU,$OBERT)?>
        
<?php    if($TIPUS_MENU == 'ADMIN'): ?>	  	   	  	   		     
<!--		  	   <TR><TD class="SUBMENU_1"><?php echo link_to(image_tag('intranet/Submenu1.png', array('align'=>'ABSMIDDLE')).' Zona privada' , 'web/index', array( 'anchor' => true ))?></TD></TR>
		  	   <TR><TD>
		  	   		<TABLE>
		  	   			<TR><TD class="SUBMENU_2"><?php echo link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;Gestiona dades' , 'web/gestio?accio=gd')?></TD></TR>
				    	<TR><TD class="SUBMENU_2"><?php echo link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;Cursos i matrícules' , 'web/gestio?accio=gc')?></TD></TR>
		  	   	    	<TR><TD class="SUBMENU_2"><?php echo link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;Reserves d\'espais' , 'web/gestio?accio=gr')?></TD></TR>
		   	   	    	<TR><TD class="SUBMENU_2"><?php echo link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;Llistes' , 'web/gestio?accio=gl')?></TD></TR>
		  	   	    	<?php echo AltresApps($USUARI,$IDS); ?>
		  	   	  	</TABLE>
		  	   	</TD></TR>
-->
		  	    <TR><TD id="REGISTRAT"><a href="<?php echo url_for('gestio/uLogin?idS=1')?>" target="_new">ZONA USUARIS</a></TD></TR>		  	   	
		  	  </TABLE>			
	  	   
<?php	   else: ?>
			
			<TR><TD id="REGISTRAT"><a href="<?php echo url_for('gestio/uLogin?idS=1')?>" target="_new">ZONA USUARIS</a></TD></TR></TABLE>				

<?php	   endif; ?>

		</center><br /><br /></TD>
		
<?php	endif;
  
  function llistaMenu($Menu, $OBERT = 0)
  {
  	
  	$Obert = array(1=>false,2=>false,3=>false); $NivellAnt = 0;
  	
  	echo '<TABLE class="MENU_TABLE">';
  	
  	//Creem els inodes
  	foreach($Menu as $M):

		if($M->getNivell() == 1):
		  			   			
  			$Obert['1'] = (array_key_exists($M->getIdnodes(),$OBERT));
  			echo generaURL($M,$Obert['1']);
  			
  		elseif($M->getNivell() == 2):
  		
			if($Obert['1']) echo generaURL($M,$Obert['2']); 	  		
			$Obert['2'] = (array_key_exists($M->getIdnodes(),$OBERT));
			  			
  		elseif($M->getNivell() == 3):
  		
			if($Obert['2'] && $Obert['1']) echo generaURL($M,$Obert['3']);
			$Obert['3'] = (array_key_exists($M->getIdnodes(),$OBERT));
			  			
  		endif;  		
  	  	
  	endforeach;  	
  	

    		
  }

  function generaURL( $NODE , $OBERT = false )
  {
  	$imatge = ($OBERT)?'':'T';
  	$id_nivell = $NODE->getNivell();
    $URL = $NODE->getUrl();  	
  	$URL_MAN = '@web_contingut_man?node='.$NODE->getIdnodes().'&titol='.$NODE->getNomForUrl();
    $URL_AUT = '@web_contingut_auto?node='.$NODE->getIdnodes().'&titol='.$NODE->getNomForUrl();
    $RET = "";

	if($id_nivell == 1):                
	  	if(!empty($URL)): 						$RET = '<TR><TD class="SUBMENU_1">'.link_to(image_tag('intranet/Submenu1'.$imatge.'.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;'.$NODE->getTitolMenu(), $NODE->getUrl(),array('target'=>'_NEW','absolute'=>true)).'</TD></TR>';	  		  
	  	else:
	  		if($NODE->getCategories() == 'cap') $RET = '<TR><TD class="SUBMENU_1">'.link_to(image_tag('intranet/Submenu1'.$imatge.'.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;'.$NODE->getTitolMenu(), $URL_MAN ).'</TD></TR>';
	  		else 								$RET = '<TR><TD class="SUBMENU_1">'.link_to(image_tag('intranet/Submenu1'.$imatge.'.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;'.$NODE->getTitolMenu(), $URL_AUT ).'</TD></TR>'; 		
		endif;		        
	elseif($id_nivell == 2):
	  	if(!empty($URL)): 						$RET = '<TR><TD class="SUBMENU_2">'.link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;'.$NODE->getTitolMenu(), $NODE->getUrl(),array('target'=>'_NEW','absolute'=>true)).'</TD></TR>';	  		  
	  	else:
	  		if($NODE->getCategories() == 'cap') $RET = '<TR><TD class="SUBMENU_2">'.link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;'.$NODE->getTitolMenu(), $URL_MAN ).'</TD></TR>';
	  		else 								$RET = '<TR><TD class="SUBMENU_2">'.link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;'.$NODE->getTitolMenu(), $URL_AUT ).'</TD></TR>'; 		
		endif;				
	elseif($id_nivell == 3):
	  	if(!empty($URL)): 						$RET = '<TR><TD class="SUBMENU_3">'.link_to(image_tag('intranet/Submenu3.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;'.$NODE->getTitolMenu(), $NODE->getUrl(),array('target'=>'_NEW','absolute'=>true)).'</TD></TR>';	  		  
	  	else:
	  		if($NODE->getCategories() == 'cap') $RET = '<TR><TD class="SUBMENU_3">'.link_to(image_tag('intranet/Submenu3.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;'.$NODE->getTitolMenu(), $URL_MAN ).'</TD></TR>';
	  		else 								$RET = '<TR><TD class="SUBMENU_3">'.link_to(image_tag('intranet/Submenu3.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;'.$NODE->getTitolMenu(), $URL_AUT ).'</TD></TR>'; 		
		endif;					
	endif; 
  	   			 
    return $RET; 
  }
    
  function AltresApps($USUARI,$IDS)
  {  	
  	$PERMISOS = UsuarisAppsPeer::getPermisosOO($USUARI,$IDS);    
	echo "<TR><TD class=\"SUBMENU_2\">".image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE'))."&nbsp;&nbsp;&nbsp;Altres aplicacions</TD></TR>";  	 
  	foreach($PERMISOS as $APP):  	        	
  		echo "<TR><TD class=\"SUBMENU_3\">".link_to(image_tag('intranet/Submenu3.png', array('align'=>'ABSMIDDLE')).'&nbsp;&nbsp;'.$APP->getNom() , $APP->getUrl() )."</TD></TR>";
  	endforeach;  	
  }  

?>

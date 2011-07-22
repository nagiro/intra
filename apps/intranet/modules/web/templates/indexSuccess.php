
<tr>
<td colspan="4" style="padding:0px; border:0px;">
    <div class="TIRA_FOTOS">    
    	<?php 	  
    		$i = 1;        
    		foreach($FOTOS as $F):
               if($i > 1 && $i <= sizeof($FOTOS)): echo '<div class="ESPAI">&nbsp;</div>'; endif; 
               echo '<div class="FOTOS">'.image_tag('portada/IMG'.$F.'.jpg' , array('class'=>'IMG_FOTO')).'</div>';
               $i++;        		   
    		endforeach;					
    	?>
    </div>
</td>
</tr>

<tr>
<!-- MENU -->
	
    <?php include_partial('menu', array( 'TIPUS_MENU' => $TIPUS_MENU , 'MENU' => $MENU , 'OBERT' => $OBERT , 'USUARI' => $USUARI , 'IDS' => $IDS ) ); ?>

<!-- FI MENU -->
<!-- CONTINGUT -->

	<?php  
	$calendar = false;    
	switch($ACCIO){
	   case 'web'        : $calendar = true;  include_partial('pagina'  ,  array( 'NODE' => $NODE )); break;
	   case 'gestio'     : $calendar = false; include_partial('gestio'  ,  array( 'MODUL' => $MODUL , 'FUSUARI' => $FUSUARI , 'MISSATGE' => $MISSATGE , 'LLISTES' => $LLISTES , 'FRESERVA' => $FRESERVA , 'RESERVES' => $RESERVES , 'MATRICULES' => $MATRICULES , 'CURSOS' => $CURSOS , 'LCURSOS' => $LCURSOS ) ); break;
	   case 'remember'   : $calendar = false; include_partial('remember',  array( 'ENVIAT' => $ENVIAT , 'ERROR' => $ERROR , 'FREMEMBER' => $FREMEMBER )); break;
	   case 'login'      : $calendar = false; include_partial('login'   ,  array( 'FLogin' => $FLogin , 'ERROR' => $ERROR )); break; 	      
	   case 'noticies'   : $calendar = true;  include_partial('noticies',  array( 'NOTICIES' => $NOTICIES , 'NOTICIA' => $NOTICIA , 'PAGINA' => $PAGINA )); break;
	   case 'verifica'   : $calendar = false; include_partial('gestio'  ,  array( 'MODUL' => $MODUL , 'DADES_MATRICULA' => $DADES_MATRICULA , 'TPV' => $TPV , 'ISPLE' => $ISPLE )); break;
	   case 'registrat'  : $calendar = true;  include_partial('registrats'); break;
	   case 'cursos'	 : $calendar = false; include_partial('cursos' , array('CURSOS'=>$CURSOS,'IDS'=>$IDS)); break;
	   case 'contacte'   : $calendar = false; include_partial('contacte' , array('ENVIAT'=>$ENVIAT , 'FConsulta'=>$FConsulta)); break;
	   case 'registre'   : $calendar = false; include_partial('registre' , array('FUSUARI'=>$FUSUARI, 'ESTAT' => $ESTAT)); break;
	   case 'espais'	 : $calendar = false;  include_partial('espais',array('LLISTAT_ESPAIS'=>$LLISTAT_ESPAIS)); break;
	   case 'missatge'   : $calendar = false; include_partial('missatge',array('MISSATGE'=>$MISSATGE)); break;

	   case 'mostra_activitat'	: $calendar = true; include_partial('mostraActivitat',array( 'LLISTAT_ACTIVITATS'=>$LLISTAT_ACTIVITATS , 'TITOL'=>$TITOL ,'NODE' => $NODE , 'IDS' => $IDS )); break;
       case 'mostra_cicle':       $calendar = true; include_partial('mostraCicle',array( 'CICLE' => $CICLE , 'TITOL' => $TITOL , 'IDS' => $IDS )); break;
       case 'mostra_activitats_cicle': $calendar = true; include_partial('mostraActivitatsCicle',array( 'IDC' => $IDC , 'TITOL' => $TITOL , 'LLISTAT_ACTIVITATS' => $LLISTAT_ACTIVITATS , 'IDS' => $IDS )); break;
       
	   case 'llistat_activitats'	: $calendar = true; include_partial('llistatActivitats',array('LLISTAT_ACTIVITATS'=>$LLISTAT_ACTIVITATS , 'TITOL'=>$TITOL , 'MODE'=>$MODE , 'PAGINA'=>$PAGINA )); break;
   	   case 'llistat_activitats_cerca': $calendar = true; include_partial('llistatActivitatsCerca',array('LLISTAT_ACTIVITATS'=>$LLISTAT_ACTIVITATS , 'TITOL'=>$TITOL , 'MODE'=>$MODE , 'PAGINA'=>$PAGINA )); break;
	   case 'llistatCiclesCategoria': $calendar = true; include_partial('llistatCiclesCategoria',array( 'LLISTAT_CICLES' => $LLISTAT_CICLES , 'TITOL' => $TITOL , 'CAT' => $CAT , 'NODE' => $NODE , 'IDS' => $IDS )); break;
	   case 'llistatActivitatsCicleCategoria': $calendar = true; include_partial('llistatActivitatsCicleCategoria',array( 'LLISTAT_ACTIVITATS' => $LLISTAT_ACTIVITATS , 'NODE' => $NODE , 'CAT' => $CAT , 'IDC' => $IDC , 'TITOL' => $TITOL , 'IDS' => $IDS )); break;

	   
	   case 'showActivitatCategoria': $calendar = true; include_partial('showActivitatCategoria',array( 'DESCRIPCIO' => $DESCRIPCIO , 'TITOL' => $TITOL , 'IDS' => $IDS )); break;
	   case 'mostra_estructura'   	: $calendar = true; include_partial('mostraEstructura',array('TITOL'=>$TITOL,'PAGINA'=>$PAGINA,'NODES'=>$NODES)); break;
	   case 'final_matricula': $calendar = true; include_partial('matricula',array('MISSATGE'=>$MISSATGE)); break;
       
       case 'notfound': $calendar = false; include_partial('notfound',array()); break;
	}
	    	    
    ?>
    	
    
<!-- FI CONTINGUT -->
<!-- CALENDARI -->
    
    <?php

       if($calendar):
    
       include_partial('calendari', array( 	'BANNERS' => $BANNERS , 
    										'DATACAL' => $DATACAL , 
    										'ACTIVITATS_CALENDARI' => $ACTIVITATS_CALENDARI ,
    										'CERCA' => $CERCA , 
                                            'IDS' => $IDS ,
                                             ) ); 
       endif;
   
       ?>
    	
<!-- FI CALENDARI -->
</tr>
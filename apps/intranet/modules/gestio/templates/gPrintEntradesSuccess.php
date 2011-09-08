<?php use_helper('Form'); ?>
<style>
    .row_title { width:100px; }
    .row_field { width:300px; }
</style>
 
    <td colspan="3" class="CONTINGUT_ADMIN">
    
    <?php include_partial('breadcumb',array('text'=>'ENTRADES')); ?>
    

  	<div class="REQUADRE">
  	<div class="TITOL">Llistat d'entrades ( <?php echo link_to('Crear una nova entrada','gestio/gPrintEntrades?accio=NOU'); ?> )</div>
  		<table class="DADES">
  			
                <?php  
                    if( $ENTRADES->getNbResults() == 0 ) echo '<TR><TD colspan="3">No s\'ha trobat cap resultat d\'entre '.EntradesPeer::doCount(new Criteria()).' disponibles.</TD></TR>';
                    else {
                    	echo '<tr><th>Títol</th><th>Venudes</th><th>Recaptació</th><th>Opcions</th></tr>';                        
                      	foreach($ENTRADES->getResults() as $E) {                      		                      	                          	    	                      	                           		
                      		echo "<TR>                      				
                      				<TD	style='width:200px;'>".link_to(image_tag('intranet/Submenu2.png').' '.$E->getTitol(),'gestio/gPrintEntrades?accio=EDITA&IDE='.$E->getIdentrada() )."</TD>
                      				<TD style='width:50px;' class=\"LINIA\">".$E->getVenudes()."</TD>
                      				<TD style='width:50px;' class=\"LINIA\">".$E->getRecaptat()."</TD>                      				
                      				<TD style='width:50px;' class=\"LINIA\">".link_to(image_tag('template/printer.png'),'gestio/gPrintEntrades?accio=PRINT&IDE='.$E->getIdentrada())."</TD>
                      			  </TR>";                      		 
                      	}                    	
                    }
                ?>     			
        <tr><td colspan="4" style="text-align:center">
         
        <?php
        	if ($ENTRADES->haveToPaginate()):
        		if($PAGINA > 1) echo link_to('<-- Veure entrades anteriors', 'gestio/gPrintEntrades?PAGINA='.$ENTRADES->getPreviousPage());
  				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";  
  				if($PAGINA < $ENTRADES->getLastPage()) echo link_to('Veure entrades següents -->', 'gestio/gPrintEntrades?PAGINA='.$ENTRADES->getNextPage());  
			endif; 
		?>
        
        </td></tr>
  		</table>
  	</div>
    
  <?php IF( isset($MODE['NOU']) || isset($MODE['EDICIO']) ): ?>
      
	<form action="<?php echo url_for('gestio/gPrintEntrades') ?>" method="POST">
	
	 	<div class="REQUADRE fb">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gPrintEntrades?accio=C')) ?>
					 	 		
	 		<div class="FORMULARI fb">
	 			<?php echo $FENTRADES ?>	 	
	 			<?php include_partial('botoneraDiv',array('element'=>'l\'entrada')); ?>				
	 		</div>
	 			 	 	
      	</div>
			
	</form>      

	<?php endif;  ?>
               
      <div style="height:40px;"></div>
                
    </td>        
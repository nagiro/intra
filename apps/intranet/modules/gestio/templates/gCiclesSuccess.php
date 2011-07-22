<?php use_helper('Form'); ?>

<script>

    $(document).ready(function(){
        $('#cerca_select').change(function(){
            $('#CERCA').submit();    
        });    
    });
    
    
    
</script>

<STYLE>
.cent { width:100%; }
.noranta { width:90%; }
.cinquanta { width:50%; }
.gray { background-color: #EEEEEE; }
.NOM { width:20%; } 

	.row { width:500px; } 
	.row_field { width:80%; } 
	.row_title { width:20%; }
	.row_field input { width:100%; } 


</STYLE>
   
    <TD colspan="3" class="CONTINGUT_ADMIN">
      
    <?php include_partial('breadcumb',array('text'=>'CICLES')); ?>                      

	<form id="CERCA" action="<?php echo url_for('gestio/gCicles') ?>" method="POST">        
	    <div class="REQUADRE">
            <div class="FORMULARI fb">
                <div style="margin-bottom:4px;">	    	          
	               <?php echo $FCerca ?>       
                   <div style="clear:both;"></div>    
                </div>                     
	            <div>	            	
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nou cicle" />	            	
	            </div>
                <div style="clear:both;"></div>                
	        </div>            
            <div style="clear:both;"></div>
	     </div>
     </form>  


  	<?php IF( isset($MODE['NOU']) || isset($MODE['EDICIO']) ): ?>
      
	<form action="<?php echo url_for('gestio/gCicles') ?>" method="POST" enctype="multipart/form-data">
	
	 	<div class="REQUADRE fb">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gCicles?accio=C')) ?>
					 	 		
	 		<div class="FORMULARI fb">
	 			<?php echo $FCICLES ?>
	 			<?php include_partial('botoneraDiv',array('element'=>'TOTA la descripció')); ?>	 					
	 		</div>
	 			 	 	
      	</div>
			
	</form>      
      
  <?php ELSEIF(isset($LACTIVITATS)): ?>

  	<DIV class="REQUADRE">
  	<DIV class="TITOL">Llistat d'activitats del cicle <?php $FCICLES->getObject()->getNom() ?></DIV>
  		<table class="DADES">
                <?php  
                    if( sizeof($LACTIVITATS) == 0 ) echo '<TR><TD colspan="3">No s\'ha trobat cap resultat.</TD></TR>';
                    else {                
                    	echo '<tr><th>Títol</th></tr>';
                      	foreach($LACTIVITATS as $id => $A) {                                                            		     	                          	
                      		echo "<TR>                      				                      		
                      				<TD class='LINIA'>".link_to(image_tag('intranet/Submenu2.png').' '.$A->getNom(),'gestio/gActivitats?accio=ACTIVITAT&IDA='.$A->getActivitatid() )."</TD>                      				
                      			  </TR>";                      		
                      	}                    	
                    }
                ?>
                
		</table>     			        
           
  <?php ELSE: ?>
  
  	<DIV class="REQUADRE">
  	<DIV class="TITOL">Llistat de cicles (<a href="<?php echo url_for('gestio/gCicles?accio=NOU'); ?>">Afegir nou cicle</a>)</DIV>
  		<table class="DADES">
                <?php
                    if($CICLES->getNbResults() == 0) echo '<TR><TD colspan="3">No s\'ha trobat cap resultat.</TD></TR>';
                    else {                
                    	echo '<tr><th>Títol</th><th># Act</th><th>Data</th><th>Estat</th></tr>';
                      	foreach($CICLES->getResults() as $C) {
                 	        $NACT = $C->getNumActivitats();
                            $idC = $C->getCicleid();
                      		echo "<TR>                      				
                      				<TD class='LINIA'>".link_to(image_tag('intranet/Submenu2.png').' '.$C->getNom(),'gestio/gCicles?accio=EDITA&IDC='.$idC )."</TD>
                      				<TD class='LINIA'>".$NACT."</TD>
                      				<TD class='LINIA'>".$C->getPrimerDia()."</TD>
									<TD class='LINIA'>".(($C->getExtingit())?'Inactiu':'Actiu')."</TD>";
                                    if($NACT > 0) echo "<TD class='LINIA'>".link_to(image_tag('template/text_list_bullets.png').'<span>Llistat d\'activitats pertanyents al cicle</span>','gestio/gCicles?accio=LLISTA&IDC='.$idC,array('class'=>'tt2'))."</TD>";                                         
                                    else echo "<TD class='LINIA'></TD>";
                                    
                            echo "</TR>";                      		
                      	}                    	
                    }
                ?>     			
        <tr><td colspan="5" style="text-align:center">
                 
        <?php if ($CICLES->haveToPaginate()): ?>
          <?php echo link_to('&laquo;', 'gestio/gCicles?PAGINA='.$CICLES->getFirstPage()) ?>
          <?php echo link_to('&lt;', 'gestio/gCicles?PAGINA='.$CICLES->getPreviousPage()) ?>
          <?php $links = $CICLES->getLinks(); foreach ($links as $page): ?>
            <?php echo ($page == $CICLES->getPage()) ? $page : link_to($page, 'gestio/gCicles?PAGINA='.$page) ?>
            <?php if ($page != $CICLES->getCurrentMaxLink()): ?> - <?php endif ?>
          <?php endforeach ?>
          <?php echo link_to('&gt;', 'gestio/gCicles?PAGINA='.$CICLES->getNextPage()) ?>
          <?php echo link_to('&raquo;', 'gestio/gCicles?PAGINA='.$CICLES->getLastPage()) ?>
        <?php endif ?>        	
        
        </td></tr>
  		</table>
  	</DIV>
  	  
  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
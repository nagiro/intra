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
	    
    <?php if(isset($FBUGS)) echo showFormBug( $FBUGS , $IDU , $IDS ); ?>    
    <?php if(isset($FUPGRADES)) echo showFormUpgrade( $FUPGRADES , $IDU , $IDS ); ?>
    <?php if(isset($LUPGRADES)) echo showUpgrades( $LUPGRADES ); ?>
    <?php if(isset($LIMPROVEMENTS)) echo showImprovements( $LIMPROVEMENTS ); ?>
    <?php if(isset($LBUGS)) echo showBugs( $LBUGS ); ?>    
    
                      	      
</TD>
  
<?php 
    
    function showUpgrades($LUPGRADES)
    {
        
        $RET = '
        <DIV class="REQUADRE">
          	<DIV class="TITOL">Llistat de versions ('.link_to('Nova versió','gestio/gTrac?accio=EDIT_UPGRADE').')</DIV>
          		<table class="DADES">';
                                               
                    if($LUPGRADES->getNbResults() == 0) $RET .= '<TR><TD colspan="3">No s\'ha trobat cap resultat.</TD></TR>';
                    else {                
                    	$RET .= '<tr><th>Versió</th><th>Títol</th><th>Data</th></tr>';
                      	foreach($LUPGRADES->getResults() as $OT) {                 	        
                      		$RET .= '   <TR>                      				
                              				<TD class="LINIA">'.$OT->getSolvedversion().'</TD>                          				                          				    									
                                            <TD class="LINIA">'.link_to($OT->getTitle().'<span>'.$OT->getDescription().'</span>','gestio/gTrac?accio=EDIT_UPGRADE&idT='.$OT->getIdtrac(),array('class'=>'tt2')).'</TD>                                        
                                            <TD class="LINIA">'.$OT->getDate('d/m/Y').'</TD>
                                        </TR>';                      		
                      	}                    	
                    }
        $RET .= '<tr><td colspan="3" style="text-align:center">';
                         
        if ($LUPGRADES->haveToPaginate()):
          $RET .= link_to('&laquo;', 'gestio/gCicles?PAGINA='.$LUPGRADES->getFirstPage());
          $RET .= link_to('&lt;', 'gestio/gCicles?PAGINA='.$LUPGRADES->getPreviousPage());
          $links = $LUPGRADES->getLinks(); foreach ($links as $page):
            $RET .= ($page == $LUPGRADES->getPage()) ? $page : link_to($page, 'gestio/gCicles?PAGINA='.$page);
            if ($page != $LUPGRADES->getCurrentMaxLink()): $RET .= '-'; endif;
          endforeach;
          $RET .= link_to('&gt;', 'gestio/gCicles?PAGINA='.$CICLES->getNextPage());
          $RET .= link_to('&raquo;', 'gestio/gCicles?PAGINA='.$CICLES->getLastPage());
        endif;        	

        $RET .= '                
                </td></tr>
          		</table>
          	</DIV></DIV>';
            
        return $RET;

    }

    function showBugs($LUPGRADES)
    {
        
        $RET = '
        <DIV class="REQUADRE">
          	<DIV class="TITOL">Llistat d\'errors ('.link_to('Nou error','gestio/gTrac?accio=EDIT_BUG').')</DIV>
          		<table class="DADES">';
                                               
                    if($LUPGRADES->getNbResults() == 0) $RET .= '<TR><TD colspan="3">No s\'ha trobat cap resultat.</TD></TR>';
                    else {                
                    	$RET .= '<tr><th>Versió</th><th>Títol</th><th>Data</th></tr>';
                      	foreach($LUPGRADES->getResults() as $OT) {                 	        
                      		$RET .= '   <TR>                      				
                              				<TD class="LINIA">'.$OT->getSolvedversion().'</TD>                          				                          				    									
                                            <TD class="LINIA">'.link_to($OT->getTitle().'<span>'.$OT->getDescription().'</span>','gestio/gTrac?accio=EDIT_BUG&idT='.$OT->getIdtrac(),array('class'=>'tt2')).'</TD>
                                            <TD class="LINIA">'.$OT->getDate('d/m/Y').'</TD>
                                        </TR>';                      		
                      	}                    	
                    }
        $RET .= '<tr><td colspan="3" style="text-align:center">';
                         
        if ($LUPGRADES->haveToPaginate()):
          $RET .= link_to('&laquo;', 'gestio/gCicles?PAGINA='.$LUPGRADES->getFirstPage());
          $RET .= link_to('&lt;', 'gestio/gCicles?PAGINA='.$LUPGRADES->getPreviousPage());
          $links = $LUPGRADES->getLinks(); foreach ($links as $page):
            $RET .= ($page == $LUPGRADES->getPage()) ? $page : link_to($page, 'gestio/gCicles?PAGINA='.$page);
            if ($page != $LUPGRADES->getCurrentMaxLink()): $RET .= '-'; endif;
          endforeach;
          $RET .= link_to('&gt;', 'gestio/gCicles?PAGINA='.$CICLES->getNextPage());
          $RET .= link_to('&raquo;', 'gestio/gCicles?PAGINA='.$CICLES->getLastPage());
        endif;        	

        $RET .= '                
                </td></tr>
          		</table>
          	</DIV></DIV>';
            
        return $RET;

    }
    
    function showImprovements($LUPGRADES)
    {
        
        $RET = '
        <DIV class="REQUADRE">
          	<DIV class="TITOL">Llistat de millores ('.link_to('Nova millora','gestio/gTrac?accio=EDIT_IMPROVEMENT').')</DIV>
          		<table class="DADES">';
                                               
                    if($LUPGRADES->getNbResults() == 0) $RET .= '<TR><TD colspan="3">No s\'ha trobat cap resultat.</TD></TR>';
                    else {                
                    	$RET .= '<tr><th>Versió</th><th>Títol</th><th>Data</th></tr>';
                      	foreach($LUPGRADES->getResults() as $OT) {                 	        
                      		$RET .= '   <TR>                      				
                              				<TD class="LINIA">'.$OT->getSolvedversion().'</TD>                          				                          				    									
                                            <TD class="LINIA">'.link_to($OT->getTitle().'<span>'.$OT->getDescription().'</span>','gestio/gTrac?accio=EDIT_IMPROVEMENT&idT='.$OT->getIdtrac(),array('class'=>'tt2')).'</TD>                                        
                                            <TD class="LINIA">'.$OT->getDate('d/m/Y').'</TD>
                                        </TR>';                      		
                      	}                    	
                    }
        $RET .= '<tr><td colspan="3" style="text-align:center">';
                         
        if ($LUPGRADES->haveToPaginate()):
          $RET .= link_to('&laquo;', 'gestio/gCicles?PAGINA='.$LUPGRADES->getFirstPage());
          $RET .= link_to('&lt;', 'gestio/gCicles?PAGINA='.$LUPGRADES->getPreviousPage());
          $links = $LUPGRADES->getLinks(); foreach ($links as $page):
            $RET .= ($page == $LUPGRADES->getPage()) ? $page : link_to($page, 'gestio/gCicles?PAGINA='.$page);
            if ($page != $LUPGRADES->getCurrentMaxLink()): $RET .= '-'; endif;
          endforeach;
          $RET .= link_to('&gt;', 'gestio/gCicles?PAGINA='.$CICLES->getNextPage());
          $RET .= link_to('&raquo;', 'gestio/gCicles?PAGINA='.$CICLES->getLastPage());
        endif;        	

        $RET .= '                
                </td></tr>
          		</table>
          	</DIV></DIV>';
        
        return $RET;

    }    

    
    
    function showFormBug($FBUGS, $IDU, $IDS)
    {
                
        $RET = '   	
              	<form action="'.url_for('gestio/gTrac').'" method="POST">
        	 	<DIV class="REQUADRE">
        	    <div class="OPCIO_FINESTRA">'.link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gTrac').'</div>
                <DIV class="TITOL">Formulari d\'errors o millores</DIV>
        	    	<table class="FORMULARI" width="550px">   	                            	    	
                        '.$FBUGS.'                								
                        <tr>
                        	<td></td>
        	            	<td colspan="2" class="dreta">
				                <button type="submit" name="BSAVEBUG" class="BOTO_ACTIVITAT">
		                          '.image_tag('template/disk.png').' Guardar i sortir
                                </button>
	                            <button type="submit" name="BDELETEBUG" class="BOTO_PERILL">
		                          '.image_tag('tango/16x16/status/user-trash-full.png').' Eliminar
	                            </button>

                       	    </td>
        	            </tr>                	 
              		</TABLE>
              	</DIV>
             </form>';         

      return $RET;			   	                                   
    }

    function showFormUpgrade($FUPGRADE , $IDU, $IDS)
    {
        
        $RET = '   	
              	<form action="'.url_for('gestio/gTrac').'" method="POST">
        	 	<DIV class="REQUADRE">
        	    <div class="OPCIO_FINESTRA">'.link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gTrac').'</div>
                <DIV class="TITOL">Formulari de versions</DIV>    
        	    	<table class="FORMULARI" width="550px">    
                        '.$FUPGRADE.'                								
                        <tr>
                        	<td></td>
        	            	<td colspan="2" class="dreta">
				                <button type="submit" name="BSAVEUPGRADE" class="BOTO_ACTIVITAT">
		                          '.image_tag('template/disk.png').' Guardar i sortir
                                </button>
	                            <button type="submit" name="BDELETEUPGRADE" class="BOTO_PERILL">
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

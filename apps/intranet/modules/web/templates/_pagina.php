<style>
    .enllac_taula_continguts {
        text-decoration:none;
        color: #606060;
        
    }
</style>
    <TD colspan="2" class="CONTINGUT">
    
     <div id="TEXT_WEB">
    <?php 
		
	    if(!$NODE->getIscategoria()):
            $WEB = $NODE->getHtml();
//	    	$WEB = sfConfig::get('sf_web_dir').$NODE->getHtml();
//	    	$P = $NODE->getHtml();    	
//	    	if(!empty($P) && file_exists($WEB)) include($WEB); 
//	    	else echo "Encara no hi ha continguts...";
            echo $WEB;
	    else: 
            //Carregar els nodes que depenen de mi 
            //I dibuixar estructura d'arbre
            //Miro el nivell del node i trec els que tenen després per ordre de nivell superior. 
            $NODES = NodesPeer::getFills($NODE);
            $NIVELL_ACT = $NODE->getNivell();
            $NIVELL_IN  = $NIVELL_ACT;

            echo '<h2>Taula de continguts</h2>';
            echo '<h3>Dins aquest apartat trobarà els següents continguts: </h3>';
                                    
            echo '<ul>';
            echo '<li>'.$NODE->getTitolmenu();
            foreach($NODES as $N):
                                        
                if($NODE->getIsactiva()):  
                                                            
                    if($NIVELL_IN >= $N->getNivell()): break; endif;
                                                                                     
                    if($NIVELL_ACT < $N->getNivell()):
                        echo "<ul>";
                    elseif($NIVELL_ACT > $N->getNivell()):
                        echo '</li></ul>';
                    else: 
                        echo '</li>';                    
                    endif;
                    
                    if($N->getCategories() == 'cap'): 
                        echo '<li><a class="enllac_taula_continguts" href="'.url_for('web/index?accio=mc&node='.$N->getIdnodes()).'">'.$N->getTitolmenu().'</a>';
                    else: 
                        echo '<li><a class="enllac_taula_continguts" href="'.url_for('web/index?accio=ac&node='.$N->getIdnodes()).'">'.$N->getTitolmenu().'</a>';
                    endif; 
                 
                    $NIVELL_ACT = $N->getNivell();
                    
                 endif;
                  
            endforeach;
	    	
	    endif;  
    	
    ?>
      </div>
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

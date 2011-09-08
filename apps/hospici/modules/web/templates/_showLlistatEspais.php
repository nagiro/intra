<script type="text/javascript" src="/js/lightbox/js/jquery.lightbox-0.5.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
   	    $('a.lightbox').lightBox(); 
    });    

</script>
<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php     
     
        $cat_ant = "";
        if(!$LLISTAT_ESPAIS->getNbResults()):
            echo '<div>';                                
            echo '<div class="h_llistat_activitat_titol">No hem trobat cap resultat amb aquests paràmetres.</div>';
            echo '</div>';
            echo '<div style="margin-top:10px; clear:both;"></div>';                                                                                                                                                                    
        else:                        
            foreach($LLISTAT_ESPAIS->getResults() as $OE):                                
                echo '<div style="margin-top:10px; margin-bottom:10px;">';
                    
                    //Si la categoria és diferent a l'anterior la mostrem
                    if($cat_ant <> $OE->getSiteId()):
                        echo '<div class="h_llistat_activitat_tipus_titol">'.$OE->getSiteName().'</div>';
                    endif;
                    
                    echo '<div class="h_llistat_acivitat_titol">
                            <div style="float:left">
                                <a style="font-size:14px;" href="'.url_for('@hospici_espai_detall?idE='.$OE->getEspaiid().'&titol='.$OE->getNomForUrl()).'">'.$OE->getNom().'</a>
                            </div>';
                            
                    //Si apareix aquí és perquè es pot demanar per internet.
                    $url = url_for('@hospici_espai_detall?idE='.$OE->getEspaiid().'&titol='.$OE->getNomForUrl()); 
                    if(isset($AUTH) && $AUTH > 0){
                        echo '  <div style="float:right">
                                    <div class="requadre_mini" style="color:white; background-color:#FFCC00;">
                                        <a name="link_compra" style="text-decoration:none;" href="'.$url.'">Reservar espai</a>
                                    </div>
                                </div>';                    
                    } 
                    else
                    {
                        echo '  <div style="float:right">
                                    <div class="requadre_mini" style="color:white; background-color:#FFCC00;">
                                        <a class="auth" href="'.$url.'" name="link_compra" style="text-decoration:none;">Reservar espai</a>
                                    </div>
                                </div>';                                            
                    }                  
                    
                    echo '</div>';
                    
                    echo '<div style="clear:both">';
                    foreach($OE->getFotos() as $OM):
                        echo '<a class="lightbox" href="/images/multimedia/'.$OM->getLargeImage().'"><img src="/images/multimedia/'.$OM->getUrl().'" height="30" alt="" /></a>';                        
                    endforeach;                     
                    echo '</div>';                   
                    //echo '<div style="clear:both" class="h_llistat_activitat_organitzador">Entitat: '.$OE->getSiteName().'</div>';
                    //echo '<div class="h_llistat_activitat_horari">|&nbsp;&nbsp;+info </div>';
                    
                    echo '<div style="clear:both"></div>';
                echo '</div>';
                echo '<div style="height:1px; background-color:#CCCCCC; clear:both;"></div>';
                $cat_ant = $OE->getSiteId();                                                                                               
            endforeach; 
        endif;
		
        if($LLISTAT_ESPAIS->getLastPage() > $LLISTAT_ESPAIS->getPage()):
            echo '<div class="pagerE">'.setPagerN($LLISTAT_ESPAIS,'@hospici_cercador_espais',false).'</div>';
        else:      
            echo '<div class="pagerE">'.setPagerN($LLISTAT_ESPAIS,'@hospici_cercador_espais',true).'</div>';
        endif;                
    ?>
                        
    </div>
</div>

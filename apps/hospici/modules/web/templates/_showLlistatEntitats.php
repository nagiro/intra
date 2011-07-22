<link rel="stylesheet" type="text/css" media="screen" href="/js/lightbox/css/jquery.lightbox-0.5.css" />
<script type="text/javascript" src="/js/lightbox/js/jquery.lightbox-0.5.js"></script>

<style>    
    .pager { font-size:16px;  }
    .pager a { font-size:16px; color:inherit; text-decoration:inherit;  }
    .pagerE { margin-top:10px; margin-bottom:30px; text-align:center;  }
</style>
<script>

    $(document).ready(function(){
   	    $('a.lightbox').lightBox(); 
    });
    });    

</script>
<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php     
     
        $cat_ant = "";
        if(!$LLISTAT_ENTITATS->getNbResults()):
            echo '<div>';                                
            echo '<div class="h_llistat_activitat_titol">No hem trobat cap resultat amb aquests paràmetres.</div>';
            echo '</div>';
            echo '<div style="margin-top:10px; clear:both;"></div>';                                                                                                                                                                    
        else:                        
            foreach($LLISTAT_ENTITATS->getResults() as $OE):                                
                echo '<div style="margin-top:10px; margin-bottom:10px;">';
                    
                    //Si la categoria és diferent a l'anterior la mostrem
/*                    if($cat_ant <> $OE->getSiteId()):
                        echo '<div class="h_llistat_activitat_tipus_titol">'.$OE->getSiteName().'</div>';
                    endif;
*/                    
                    $url = $OE->getWebUrl();
                    if(empty($url)) $url = "";        
                    else $url = ' | <a style=" font-size:12px;" href="'.url_for($url,true).'">WEB</a>';

                    $logo = SitesPeer::getSiteLogo($OE->getSiteId());
                                                                                                        
                    echo '  <div class="h_llistat_acivitat_titol">
                                <div style="float:left">                            
                                    <img src="'.$logo.'" height="30" alt="" />
                                </div>
                                <div style="float:left; font-size:16px; padding-left:10px;">
                                    '.$OE->getNom().'<br/>
                                    <div style="font-size:12px; color:gray;">
                                    <a href="'.url_for('@hospici_cercador_entitats_activitats?SITE='.$OE->getSiteId()).'">Activitats</a> | 
                                    <a href="'.url_for('@hospici_cercador_entitats_espais?SITE='.$OE->getSiteId()).'">Espais</a> |
                                    <a href="'.url_for('@hospici_cercador_entitats_cursos?SITE='.$OE->getSiteId()).'">Cursos</a>
                                    '.$url.'                                                                      
                                    </div> 
                                </div>
                            </div>';
                                                            
                    echo '<div style="clear:both"></div>';
                echo '</div>';
                echo '<div style="height:1px; background-color:#CCCCCC; clear:both;"></div>';
                $cat_ant = $OE->getSiteId();                                                                                               
            endforeach; 
        endif;
		
        echo '<div class="pagerE">'.setPager($LLISTAT_ENTITATS,'@hospici_cercador_entitats').'</div>';                
    ?>
                        
    </div>
</div>

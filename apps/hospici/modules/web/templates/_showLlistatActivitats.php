<style>    
    .pager { font-size:16px;  }
    .pager a { font-size:16px; color:inherit; text-decoration:inherit;  }
    .pagerE { margin-top:10px; margin-bottom:30px; text-align:center;  }
</style>

<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php 
        $C = new Criteria();
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        $cat_ant = "";
        if(!$LLISTAT_ACTIVITATS->getNbResults()):
            echo '<div>';                                
            echo '<div class="h_llistat_activitat_titol">No hem trobat cap resultat amb aquests paràmetres.</div>';                                
            echo '</div>';
            echo '<div style="margin-top:10px; clear:both;"></div>';                                                                                                                                                                    
        else:                        
            foreach($LLISTAT_ACTIVITATS->getResults() as $OA):
                echo '<div style="margin-top:10px; margin-bottom:10px;">';
                    
                    //Si la categoria és diferent a l'anterior la mostrem
                    if($cat_ant <> $OA->getTipusactivitatIdtipusactivitat()):
                        echo '<div class="h_llistat_activitat_tipus_titol">'.$OA->getNomTipusActivitat().'</div>';
                    endif;
                    
                    echo '<div class="h_llistat_acivitat_titol">
                            <div style="float:left">
                                <a href="'.url_for('@hospici_detall_activitat?idA='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl()).'">'.$OA->getTMig().'</a>
                            </div>';
                            
                    //Si es pot comprar entrada per internet, es mostra. 
                    if($OA->getIsEntrada()):
                        $url = url_for('@hospici_detall_activitat?idA='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl());
                        if(isset($AUTENTIFICAT) && $AUTENTIFICAT > 0):  
                            echo '  <div style="float:right">
                                        <div class="requadre_mini" style="color:white; background-color:#FFCC00;">
                                            <a name="link_compra" style="text-decoration:none;" href="'.$url.'">Reservar entrada</a>                                        
                                        </div>
                                    </div>';
                        else: 
                            echo '  <div style="float:right">
                                        <div class="requadre_mini" style="color:white; background-color:#FFCC00;">
                                            <a class="auth" name="link_compra" style="text-decoration:none;" url="'.$url.'" href="#">Reservar entrada</a>                                        
                                        </div>
                                    </div>';                                                
                        endif;
                    endif;
                    echo '</div>';
                    echo '<div style="clear:both" class="h_llistat_activitat_horari">'.generaHorarisCompactat($OA->getHorariss($C)).'</div>';
                    echo '<div class="h_llistat_activitat_organitzador">|&nbsp;&nbsp;Organitza: '.$OA->getNomSite().'</div>';
                    echo '<div style="clear:both"></div>';
                echo '</div>';
                echo '<div style="height:1px; background-color:#CCCCCC; clear:both;"></div>';
                $cat_ant = $OA->getTipusactivitatIdtipusactivitat();                                                                                               
            endforeach; 
        endif;
		
        echo '<div class="pagerE">'.setPager($LLISTAT_ACTIVITATS,'@hospici_cercador_activitats').'</div>';        
        
    ?>
                        
    </div>
</div>

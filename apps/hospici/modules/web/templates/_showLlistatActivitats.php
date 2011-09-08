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
            $LACT = $LLISTAT_ACTIVITATS->getResults();                    
            foreach($LACT as $OA):                
                echo '<div style="margin-top:10px; margin-bottom:10px;">';
                    
                    //Si la categoria és diferent a l'anterior la mostrem
                    if($cat_ant <> $OA->getTipusactivitatIdtipusactivitat()):
                        echo '<div class="h_llistat_activitat_tipus_titol">'.$OA->getNomTipusActivitat().'</div>';
                    endif;
                    
                    echo '<div class="h_llistat_acivitat_titol">
                            <div style="float:left">
                                <a href="'.url_for('@hospici_detall_activitat?idA='.$OA->getActivitatid().'&titol='.$OA->getNomForUrl()).'">'.$OA->getTMig().'</a>
                            </div>
                                                    
                            <div style="float:right">'.
                                myUser::ph_getEtiquetaActivitats($AUTENTIFICAT, $OA, $ACTIVITATS_AMB_ENTRADES).'
                            </div>';
                    
                    echo '</div>';
                    echo '<div style="clear:both" class="h_llistat_activitat_horari">'.generaHorarisCompactat($OA->getHorariss($C)).'</div>';
                    echo '<div class="h_llistat_activitat_organitzador">|&nbsp;&nbsp;Organitza: '.$OA->getNomSite().'</div>';
                    echo '<div style="clear:both"></div>';
                echo '</div>';
                echo '<div style="height:1px; background-color:#CCCCCC; clear:both;"></div>';
                $cat_ant = $OA->getTipusactivitatIdtipusactivitat();                                                                                               
            endforeach;             
        endif;
        
		if(!empty($LACT)) echo '<div class="pagerE">'.setPagerN($LLISTAT_ACTIVITATS,'@hospici_cercador_activitats',false).'</div>';
        else echo '<div class="pagerE">'.setPagerN($LLISTAT_ACTIVITATS,'@hospici_cercador_activitats',true).'</div>';         
        
    ?>
                        
    </div>
</div>
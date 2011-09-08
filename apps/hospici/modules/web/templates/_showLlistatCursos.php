<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php            
         
        $C = new Criteria();
        $C->addAscendingOrderByColumn(HorarisPeer::DIA);
        $cat_ant = "";
        if(!$LLISTAT_CURSOS->getNbResults()):
            echo '<div>';                                
            echo '<div class="h_llistat_activitat_titol">No hem trobat cap resultat amb aquests paràmetres.</div>';                                
            echo '</div>';
            echo '<div style="margin-top:10px; clear:both;"></div>';                                                                                                                                                                    
        else:
            $LCUR = $LLISTAT_CURSOS->getResults();                        
            foreach($LCUR as $OC):
                $DATA_INICI =  $OC->getDatainici('d').' '.generaMes($OC->getDatainici('m')).' de '.$OC->getDatainici('Y');                
                echo '<div style="margin-top:10px; margin-bottom:10px;">';
                    
                    //Si la categoria és diferent a l'anterior la mostrem
                    if($cat_ant <> $OC->getCategoria()):
                        echo '<div class="h_llistat_activitat_tipus_titol">'.$OC->getCategoriaText().'</div>';
                    endif;
                    
                    echo '<div class="h_llistat_acivitat_titol">
                            <div style="float:left;">
                                <a style="font-size:14px;" href="'.url_for('@hospici_detall_curs?idC='.$OC->getIdcursos().'&titol='.$OC->getNomForUrl()).'">'.$OC->getTitolcurs().' </a><span style="font-size:10px; color:gray;"> ('.$OC->getCodi().')</span>
                            </div>';
                            
                    $url = url_for('@hospici_detall_curs?idC='.$OC->getIdcursos().'&titol='.$OC->getNomForUrl());                        

                    echo '<div style="float:right; margin-top: 5px;">'.myUser::ph_getEtiquetaCursos($AUTH, $OC, $url, $CURSOS_MATRICULATS).'</div>';                      
                                        
                    echo '</div>';
                    echo '<div style="clear:both" class="h_llistat_activitat_horari">Inici: '.$DATA_INICI.'</div>';
                    echo '<div class="h_llistat_activitat_organitzador">|&nbsp;&nbsp;Organitza: '.$OC->getNomSite().'</div>';
                    echo '<div style="clear:both"></div>';
                echo '</div>';
                echo '<div style="height:1px; background-color:#CCCCCC; clear:both;"></div>';
                $cat_ant = $OC->getCategoria();                                                                                               
            endforeach; 
        endif;
		
        if($LLISTAT_CURSOS->getLastPage() > $LLISTAT_CURSOS->getPage()):
            echo '<div class="pagerE">'.setPagerN($LLISTAT_CURSOS,'@hospici_cercador_cursos',false).'</div>';
        else:      
            echo '<div class="pagerE">'.setPagerN($LLISTAT_CURSOS,'@hospici_cercador_cursos',true).'</div>';
        endif;
        
//        if(!empty($LCUR)) echo '<div class="pagerE">'.setPagerN($LLISTAT_CURSOS,'@hospici_cercador_cursos',false).'</div>';
//        else echo '<div class="pagerE">'.setPagerN($LLISTAT_CURSOS,'@hospici_cercador_cursos',true).'</div>';
        
    ?>
                        
    </div>
</div>

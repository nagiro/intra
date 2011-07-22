<style>    
    .pager { font-size:16px;  }
    .pager a { font-size:16px; color:inherit; text-decoration:inherit;  }
    .pagerE { margin-top:10px; margin-bottom:30px; text-align:center;  }
</style>
<script>

    $(document).ready(function(){
        $('[name="link_compra"]').click(function(){
            <?php if(isset($AUTENTIFICAT) && $AUTENTIFICAT > 0): ?>            
                return true;
            <?php else: ?>
                alert('Per poder comprar o reservar entrades heu d\'accedir al vostre usuari o crear-ne un de nou'); 
                return false; 
            <?php endif; ?>            
        });
    });    

</script>
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
            foreach($LLISTAT_CURSOS->getResults() as $OC):
                $DATA_INICI =  $OC->getDatainici('d').' '.generaMes($OC->getDatainici('m')).' de '.$OC->getDatainici('Y');                
                echo '<div style="margin-top:10px; margin-bottom:10px;">';
                    
                    //Si la categoria és diferent a l'anterior la mostrem
                    if($cat_ant <> $OC->getCategoria()):
                        echo '<div class="h_llistat_activitat_tipus_titol">'.$OC->getCategoriaText().'</div>';
                    endif;
                    
                    echo '<div class="h_llistat_acivitat_titol">
                            <div style="float:left">
                                <a href="'.url_for('@hospici_detall_curs?idC='.$OC->getIdcursos().'&titol='.$OC->getNomForUrl()).'">'.$OC->getTitolcurs().'</a>
                            </div>';
                            
                    //Si es pot reservar entrada per internet, es mostra. 
                    if($OC->getIsEntrada()):
                        echo '  <div style="float:right">
                                    <a name="link_compra" style="text-decoration:underline; color:blue; font-size:10px;" href="'.url_for('@hospici_detall_curs?idC='.$OA->getIdCursos().'&titol='.$OC->getNomForUrl()).'">Reservar matrícula</a>
                                </div>';
                    endif;
                    echo '</div>';
                    echo '<div style="clear:both" class="h_llistat_activitat_horari">Inici: '.$DATA_INICI.'</div>';
                    echo '<div class="h_llistat_activitat_organitzador">|&nbsp;&nbsp;Organitza: '.$OC->getNomSite().'</div>';
                    echo '<div style="clear:both"></div>';
                echo '</div>';
                echo '<div style="height:1px; background-color:#CCCCCC; clear:both;"></div>';
                $cat_ant = $OC->getCategoria();                                                                                               
            endforeach; 
        endif;
		
        echo '<div class="pagerE">'.setPager($LLISTAT_CURSOS,'@hospici_cercador_cursos').'</div>';        
        
    ?>
                        
    </div>
</div>

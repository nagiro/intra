<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>    
        
    <?php
     
    if($CURS instanceof Cursos)
    {
                                                            
            $datai      = $CURS->getDatainmatricula('U');            
            $url        = url_for('@hospici_detall_curs?idC='.$CURS->getIdcursos().'&titol='.$CURS->getNomForUrl());
            $MatAntIdi  = CursosPeer::IsAnticAlumne($CURS->getIdcursos(),$CURSOS_MATRICULATS);
            $dataiA     = mktime(0,0,0,9,12,2011);
            $OS         = SitesPeer::retrieveByPK($CURS->getSiteId());
            $nom        = $OS->getNom(); $email = $OS->getEmailString(); $tel = $OS->getTelefonString();
            $ESTAT      = myUser::ph_EstatCurs($AUTH, $CURS, $url, $CURSOS_MATRICULATS);                        
                        
            //Carrego la imatge del site
            $imatge = SitesPeer::getSiteLogo($CURS->getSiteId());            
                                                               
            //Si l'entitat té un pdf, l'hauríem de carregar.                                               
            if(empty($pdf)) $pdf = 0;             
    ?>
			<div style="border:0px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $CURS->getTitolcurs() ?></b><br /><span style="color: gray;"><?php echo $nom; ?></span></div>
				<div style="font-size:10px"><?php // echo generaHoraris($ACTIVITAT->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
				<div style="height:30px;">&nbsp;</div>				
										
				<div style="width:150px; float:left">                    
					<div><img src="<?php echo $imatge ?>" style="width:150px; vertical-align:middle" /></div>
                        
						<div style="margin-top:20px; font-size:10px">
                            <div class="requadre_mini" style="background-color:#A2844A;">
                                <a href="javascript:history.back()">&lt; Torna al llistat de cursos</a>
                            </div>
                        </div>
                        
                        <?php if($pdf > 0): ?>
                            <div class="pdf_cicle" style="margin-top: 5px;">
                                <div class="requadre_mini" style="background-color: #D4A261;">
                                    <a href="/images/cursos/<?php echo $pdf ?>">Baixa't el pdf del curs</a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Inici del marcador de curs -->
                        <div style="margin-top: 5px; margin-bottom:5px;">
                            <?php echo myUser::ph_getEtiquetaCursos($AUTH, $CURS, $url, $CURSOS_MATRICULATS); ?>                                                                                                                                                    
                        </div>
                        <!-- Fi del marcador de curs -->  
                      
                    <div style="margin-top:20px;">
                        <?php echo ph_getAddThisDiv(); ?>
                    </div>
                    
				</div>
                                
				<div style="width:400px; float:left;">
					<div style="padding-left:50px; font-size:10px;">                                                           
						<?php echo $CURS->getDescripcio() ?>

                        <!-- Requadre de compra o reserva d'entrades  -->
                        
                        <div id="matricula" style="margin-top:30px;">                        
               				<div style="clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">MATRICULA'T</div> 
            				<div style="clear:both; background-color:#DFECB6">					
            					<div style="padding:10px; font-size:10px;">
            
                                    <?php


if( $ESTAT == 'NO_AUTENTIFICAT' ){            
    echo '<div>Per poder matricular-vos d\'un curs heu d\'autentificar-vos clicant <a class="auth" href="'.$url.'" >aquí</a>.</div>';
                
}elseif( $ESTAT == 'MATRICULAT' ){
    echo '<div>Vostè ja ha realitzat una reserva o matrícula a aquest curs.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>';
    
}elseif( $ESTAT == 'EN_ESPERA'){
    echo '<div>Vostè està en espera de plaça per aquest curs.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>';
                    
}elseif( $ESTAT == 'ANULADA'){
    echo '<div>Vostè ha realitzat una matrícula en aquest curs, però no hi està matriculat.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>';                   

}elseif( $ESTAT == 'NO_HI_PLACES'){                                    
    echo '<div>Aquest curs ja no té places lliures.<br /><br /> Si vol pot matricular-s\'hi igualment i restarà en llista d\'espera. En el cas que s\'alliberi alguna plaça, que vostè pot ocupar, el trucarem el més aviat possible. Per a més informació, pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al telèfon <b>'.$tel.'</b>.<br /><br />Disculpi les molèsties.</div>';
    
}elseif( $ESTAT == 'NO_HI_HA_RESERVA_LINIA'){
    echo '<div>Aquest curs no disposa de matrícula en línia.<br /><br /> Per poder-s\'hi matricular, ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al telèfon <b>'.$tel.'</b>.<br /><br />Disculpi les molèsties</div>';
                
}elseif( $ESTAT == 'ABANS_PERIODE_MATRICULA_AA_IDIOMES'){                                    
    echo '<div>Vostè podrà matricular-se a aquest curs per internet a partir del dia '.date('d/m/Y',$dataiA).' si vol continuar els estudis d\'idiomes.<br /><br /> Per a més informació pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>';
    
}elseif( $ESTAT == 'ABANS_PERIODE_MATRICULA'){                                    
    echo '<div>Vostè podrà matricular-se a aquest curs per internet a partir del dia '.date('d/m/Y',$datai).'.<br /><br /> Per a més informació pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>';
                    
}elseif( $ESTAT == 'POT_MATRICULAR'){
                                                            
    echo '<form method="post" action="'.url_for('@hospici_nova_matricula').'">';                                            
    
    //Guardem el codi del curs                                                               	                                                                                                         
    echo input_hidden_tag('idC',$CURS->getIdcursos());
    
     ?>
    <div class="taula_dades">
        <div style="padding-top:10px;">
            <div style="float: left; width:120px;"><b>Pagament:</b></div>                                            
            <div style="float: left;">
            <?php
                if( $CURS->getIsEntrada() == CursosPeer::HOSPICI_RESERVA ) echo 'Només reserva <span class="tipMy tip" title="A través del portal es fa la reserva de plaça, a cost 0, i posteriorment l\'entitat organitzadora es posarà en contacte amb vostè per finalitzar la matrícula.">?</span>';
                elseif( $CURS->getIsentrada() == CursosPeer::HOSPICI_RESERVA_TARGETA ) echo 'Targeta de crèdit <span class="tipMy tip" title="A través del portal realitzarà i pagarà la matrícula del curs.">?</span>';
            ?>
            </div>
        </div>

        <div style="padding-top:5px; clear:both;">
            <div style="float: left; width:120px;"><b>Preu: </b></div>
            <div style="float: left;">
            <?php
              
                //Si no hi ha descompte, no ensenyem el preu reduit.
                if(empty($A_Descomptes)) echo "{$CURS->getPreu()} € <span class=\"tipMy tip\" title=\"Preu del curs que haurà d'abonar quan inici el curs o bé tot seguit si el pagament és amb targeta de crèdit.\">?</span>";
                else echo "Estàndard: {$CURS->getPreu()} € / Reduït: {$CURS->getPreur()} € <span class=\"tipMy tip\" title=\"Preu del curs que haurà d'abonar quan l'entitat organitzadora li reclami o bé tot seguit si el pagament és amb targeta de crèdit.\">?</span>";
                
            ?>
            </div>
        </div>

        <div style="padding-top:5px; clear:both;">
            <div style="float: left; width:120px;"><b>Organitza: </b></div>
            <div style="float: left;">                 
                <?php echo $nom ?>                              
            </div>
        </div>

        <div style="padding-top:5px; clear:both;">
            <div style="float: left; width:120px;"><b>Descompte: </b></div>
            <div style="float: left;">
            <?php 
                
                $A_Descomptes = $CURS->h_getDescomptes();
                //Si hi ha descompte al curs, el mostrem
                if(empty($A_Descomptes)) echo 'Cap descompte disponible <span class="tipMy tip" title="Aquest curs té un preu únic.">?</span>';
                else echo select_tag('idD',options_for_select($A_Descomptes,1)).' <span class="tipMy tip" title="Esculli, si s\'escau, el descompte que s\'adeqüi a la seva situació. Aquest haurà de ser demostrat a l\'entitat organitzadora a l\'inici de les classes.">?</span>';
                
            ?>
            </div>
        </div>
        
        <div style="padding-top:10px; clear:both;">
            <?php 
                 
                if( $CURS->getIsEntrada() == CursosPeer::HOSPICI_RESERVA ) echo '<div style="margin-left:220px;"><input style="width: 100px;" type="submit" value="Reserva plaça!" /></div>';
                elseif( $CURS->getIsEntrada() == CursosPeer::HOSPICI_RESERVA_TARGETA ) echo '<div style="margin-left:220px;"><input style="width: 100px;" type="submit" value="Matricula\'m" /></div>';
                                                                            
            ?>
        </div>
    </div>
            
    <?php } ?>                
            				    </div>
                            </div>
                        </div>
                        
                        <!-- Fi Requadre de compra o reserva d'entrades  -->	        													
                        
					</div>					
				</div>
				                                                
                <!-- Fi Requadre de descripció  -->													
			</div>
           
           <!-- Fi de curs -->  
      
      <?php } ?>  
</div>
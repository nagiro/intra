<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php if($ESPAI instanceof Espais){
            $M = $ESPAI->getFotos();
            $imatge = "/images/hospici/hospici100_100.jpg";
            if(isset($M[0]) && $M[0] instanceof Multimedia):
                $imatge = '/images/multimedia/'.$M[0]->getUrl();                            
            endif;  
                                      
     ?>
			<div style="border:0px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $ESPAI->getNom() ?></b></div>
				<div style="font-size:10px"><?php // echo generaHoraris($ACTIVITAT->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
				<div style="height:30px;">&nbsp;</div>				
										
				<div style="width:150px; float:left">                    
					<div><img width="150px" src="<?php echo $imatge ?>" style="vertical-align:middle" /></div>
                        
						<div style="margin-top:20px; font-size:10px">
                            <div class="requadre_mini" style="background-color:#A2844A;">
                                <a href="javascript:history.back()">< Torna al llistat d'espais</a>
                            </div>
                        </div>
                                                                        
                        <?php $url = url_for('@hospici_nova_reserva_espai?idE='.$ESPAI->getEspaiid()); ?>
                        <?php if( isset($AUTH) && $AUTH > 0 ): ?>                                                                           
                            <div style="margin-top: 5px;">
                                <div class="requadre_mini" style="background-color: #FFCC00;">
                                    <a href="<?php echo $url ?>">RESERVA L'ESPAI</a>
                                </div>
                            </div>                                                                                        
                        <?php else: ?>
                            <div style="margin-top: 5px">
                                <div class="requadre_mini" style="background-color: #FFCC00;">                
                                    <a class="auth" url="<?php echo $url ?>" href="#">Autentifica't i reserva</a>
                                </div>
                            </div>
                        <?php endif; ?>                        
                        
                    <div style="margin-top:20px;">
                        <?php echo ph_getAddThisDiv(); ?>
                    </div>
				</div>
                                
				<div style="width:330px; float:left;">
					<div style="padding-left:10px; font-size:10px;">
                        <?php
                            $desc = $ESPAI->getDescripcio();   
                            if(empty($desc)){ echo "Aquest espai no té cap descripció.";  }
                            else echo $desc; 
                        ?>
					</div>
                
        <!-- Inici de requadre d'ocupació d'espais  -->		
                
            <div style="margin-left:40px;">   				
                <div style="padding-top:20px; width:330px; clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">OCUPACIÓ DE L'ESPAI</div> 
				<div style="width:330px; height:170px; clear:both; background-color:#DFECB6">					
					<div style="padding:10px; font-size:10px;">
                                                                    
<?php
                        //Si la data que arriba per paràmetre és 0, agafem el dia d'avui.
                        if(!isset($DATA) || $DATA == 0) $DATA = time();
                        $month = date('m',$DATA); $year  = date('Y',$DATA);
                        $timeant = mktime(0,0,0,$month-1,1,$year); $timepost = mktime(0,0,0,$month+1,1,$year); 
                        $urlAnt = url_for("@hospici_espai_detall_canvi_mes?idE={$ESPAI->getEspaiid()}&titol={$ESPAI->getNomForUrl()}&data=$timeant");
                        $urlPost = url_for("@hospici_espai_detall_canvi_mes?idE={$ESPAI->getEspaiid()}&titol={$ESPAI->getNomForUrl()}&data=$timepost");;
                                                
                        echo '<div style="width:300px;">
                                <a style="font-size:10px; color:gray; text-decoration:none; float:left;" href="'.$urlAnt.'">< Mes anterior</a><a style="float:right;font-size:10px; color:gray; text-decoration:none;" href="'.$urlPost.'">Mes següent ></a></div>';
                        echo    '<div style="clear:both;float:left">'.this_calendari_mes($DATA,$OCUPACIO).'</div>';                                                        
                        $data1 = mktime(0,0,0,date('m',$DATA)+1,1,date('Y',$DATA));                        
                        echo    '<div style="float:left; margin-left:30px;">'.this_calendari_mes($data1,$OCUPACIO2).'</div>';
                        
?>                      
                    <div style="padding-top:10px; clear:both; font-size:10px; color:gray;">* Les dades ofertes per aquest calendari són aproximades.</div>                  
					</div>                    
				</div>
            </div>
                    					
				</div>
				                                                
                <!-- Fi d'ocupació d'espais  -->													
			</div>					   
    <?php } ?>                                                                 
   </div>
</div>



<?php 


    function this_calendari_mes($data,$OCUPACIO = array()){
               
        $RET = ""; 
        $month = date('m',$data);
        $year  = date('Y',$data);
                
        //Agafem el primer dia del mes                        
        $data = mktime(0,0,0,$month,1,$year);
        $blancs = date('w',$data)-1;
        if($blancs == -1) $blancs = 6;
        $RET = '<div style="width:140px; text-align:center; font-weight:bold; background-color:beige;">'.generaMes($month,true).'</div>';                        
        while($blancs-- > 0) $RET .= '<div style="display:block; float:left; width: 20px; text-align:center; ">&nbsp;</div>';                         
        
        $span = "";                    
        for($dia = 1; $dia <= date('t',$data); $dia++){
            
            $t = mktime(0,0,0,$month,$dia,$year);
            $d = ($dia < 10)?'0'.$dia:$dia;                
            $class = '';     
            if(isset($OCUPACIO[$year.'-'.$month.'-'.$d])){
                $span = '<span>Ocupat les següents hores:';
                foreach($OCUPACIO[$year.'-'.$month.'-'.$d] as $e => $A_H):
                    foreach($A_H as $hi => $hf):
                        if($hf > $hi){ $span .= '<br />de '.$hi.' a '.$hf; $class = 'selec'; } 
                    endforeach;
                endforeach;
                $span .= '</span>';
            }
            //Si el dia és dilluns, fem una nova línia                                              
            if(date('w',$t) == 1) $RET .= '<div style="display:block; float:left; width: 20px; text-align:center; clear:both; "><a class="tt2" href="#"><div class="'.$class.'">'.$dia.'</div>'.$span.'</a></div>';
            else $RET .= '<div style="display:block; float:left; width: 20px; text-align:center; "><a class="tt2" href="#"><div class="'.$class.'">'.$dia.'</div>'.$span.'</a></div>';
        }
        
        return $RET;
    }



?>
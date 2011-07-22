<?php use_helper('Form'); ?>
    <TD colspan="2" class="CONTINGUT">

    <?php include_partial('breadcumb',array('text'=>$TITOL)); ?>

    <?php 

    if($LLISTAT_CICLES->getNbResults() == 0): 

		echo '<DIV>No s\'ha trobat cap cicle o activitat pública disponible.<DIV>';

	else: 			    
			
		foreach($LLISTAT_CICLES->getResults() as $C):
		
			$nom_cicle = $C->getTMig();
			$NA = CiclesPeer::getActivitatsCicle( $C->getCicleID() , $IDS );						
			$PA = CiclesPeer::getDataPrimeraActivitat( $C->getCicleID() , $IDS );
			$PF = CiclesPeer::getDataUltimaActivitat( $C->getCicleID() , $IDS );
			$imatge = $C->getImatge();
			$pdf = $C->getPdf();
			$enllac = url_for('web/index?accio=aca&idc='.$C->getCicleID().'&cat='.$CAT.'&NODE='.$NODE); 
			$nom_cicle = '<b><a href="'.$enllac.'">'.$C->getTmig().'</a></b>';
			$desc = $C->getDMig();
			$idC = $C->getCicleID();
			
			?>
				<div style="clear:both;">											
					<div class="df titol_cicle" style="width:150px;">Cicle</div>
					<div class="df titol_cicle" style="width:330px; padding-left:20px;"><?php echo $nom_cicle ?></div>									 
				</div>
				
				<div style="border:2px solid #96BF0D; clear:both; padding:10px;">					
					<div class="df" style="width:150px;">
						<div><?php if($imatge > 0): ?> <img src="<?php echo sfConfig::get('sf_webrooturl').'images/cicles/'.$imatge ?>" style="vertical-align:middle"><?php endif; ?></div>
						<?php if($C->getCicleid() > 1): ?>
							<div style="margin-top:20px;font-size:11px;">Del <?php echo $PA ?> al <?php echo $PF ?></div>
							<div style="margin-top:20px;font-size:11px;">Activitats del cicle: <?php echo $NA ?></div>
						<?php endif; ?>
							<div style="margin-top:0px; font-size:10px"><a href="<?php echo $enllac ?>">Consulta les activitats d'aquest cicle</a></div>
							<div class="pdf_cicle"><?php if($pdf > 0): ?> <br /><a href="<?php echo sfConfig::get('sf_webrooturl').'images/cicles/'.$pdf ?>">Baixa't el pdf</a><?php endif; ?></div>						
					</div>
					<div class="df" style="width:330px;">
					
						<script>						
							function change(idC){
							     
								$("#C" + idC + "-R").click( 
                                        function () {
                                            $(this).hide();
                                            $("#C"+idC).show();                                             
                                            });
                                $( "#C" + idC ).click( 
                                        function () {
                                            $(this).hide();
                                            $("#C"+idC+"-R").show();                                             
                                            });                                                                                                                                                                                            
                                return false; 								
							}
						</script>
										            									
						<div id="<?php echo 'C'.$idC."-R"; ?>" style="padding-left:10px; font-size:11px;">
							<?php echo closetags(substr($desc,0,600).'...'); ?>
							<div>
								<a onClick="change(<?php echo $idC ?>);" >Llegir més</a>
							</div>
						</div>
						<div id="<?php echo 'C'.$idC; ?>" style="display: none; padding-left:10px; font-size:11px;">
							<?php echo closetags($desc); ?>
							<div style="padding-left:10px; font-size:11px;">
								<a onClick="change(<?php echo $idC ?>);" >Llegir menys</a>
							</div>						
						</div>												
						
						
					</div>
					<div style="clear:both">&nbsp;</div>													
				</div>					
				
				<?php 
				
				echo '<div style="clear:both; height:40px;"></div>';
			
		endforeach;
	
	endif;

    ?>
      <DIV STYLE="height:40px;"></DIV>

    </TD>
    

    <?php 
    
	function generaData($DIA)
	{

		$ret = ""; list($ANY,$MES,$DIA) = explode("-",$DIA);
		$DATE = mktime(0,0,0,$MES,$DIA,$ANY);
		switch(date('N',$DATE)){
			case '1': $ret = "Dl, ".date('d',$DATE); break;  
			case '2': $ret = "Dm, ".date('d',$DATE); break;
			case '3': $ret = "Dc, ".date('d',$DATE); break;
			case '4': $ret = "Dj, ".date('d',$DATE); break;
			case '5': $ret = "Dv, ".date('d',$DATE); break;
			case '6': $ret = "Ds, ".date('d',$DATE); break;
			case '7': $ret = "Dg, ".date('d',$DATE); break;				
		}
				
		switch(date('m',$DATE)){
			case '01': $ret .= " de gener"; break;
			case '02': $ret .= " de febrer"; break;
			case '03': $ret .= " de març"; break;
			case '04': $ret .= " d'abril"; break;
			case '05': $ret .= " de maig"; break;
			case '06': $ret .= " de juny"; break;
			case '07': $ret .= " de juliol"; break;
			case '08': $ret .= " d'agost"; break;
			case '09': $ret .= " de setembre"; break;
			case '10': $ret .= " d'octubre"; break;
			case '11': $ret .= " de novembre"; break;
			case '12': $ret .= " de desembre"; break;
		}
		
//		$ret .= " de ".date('Y',$DATE);
		
		return $ret;
		
	}


?>
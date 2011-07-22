<?php use_helper('Form'); ?>
    <TD colspan="2" class="CONTINGUT">

    <?php include_partial('breadcumb',array('text'=>$TITOL)); ?>

    <?php 
						
        $nom_cicle = $CICLE->getTMig();
        $NA = CiclesPeer::getActivitatsCicle( $CICLE->getCicleID() , $IDS );						
        $PA = CiclesPeer::getDataPrimeraActivitat( $CICLE->getCicleID() , $IDS );
        $PF = CiclesPeer::getDataUltimaActivitat( $CICLE->getCicleID() , $IDS );
        $imatge = $CICLE->getImatge();
        $pdf = $CICLE->getPdf();                 
        $desc = $CICLE->getDMig();
        $idC = $CICLE->getCicleID();                
        
        ?>
        
        <div style="border:2px solid #96BF0D; clear:both; padding:10px;">					
        	<div class="df" style="width:150px;">
        		<div><?php if($imatge > 0): ?> <img src="<?php echo sfConfig::get('sf_webrooturl').'images/cicles/'.$imatge ?>" style="vertical-align:middle"><?php endif; ?></div>
        		<?php if($CICLE->getCicleid() > 1): ?>
        			<div style="margin-top:20px;font-size:11px;">Del <?php echo $PA ?> al <?php echo $PF ?></div>
        			<div style="margin-top:20px;font-size:11px;">Activitats del cicle: <?php echo $NA ?></div>
        		<?php endif; ?>
        			<div style="margin-top:0px; font-size:10px"><?php echo getLinkActivitats($CICLE); ?></div>
                    <div style="margin-top:10px; font-size:10px"><?php echo getRetorn($CICLE) ?></div>
        			<div class="pdf_cicle"><?php if($pdf > 0): ?> <br /><a href="<?php echo sfConfig::get('sf_webrooturl').'images/cicles/'.$pdf ?>">Baixa't el pdf</a><?php endif; ?></div>						
        	</div>
        	<div class="df" style="width:330px;">
        	
        		<script>        		
        			function change(idC){ $(".C"+idC).toggle(); }
        		</script>        	   	     
        					
        		<div class="<?php echo 'C'.$idC; ?>" style="padding-left:10px; font-size:11px;">
        			<?php echo closetags(substr($desc,0,600).'...'); ?>
        			<div>
        				<a href="" onClick="change(<?php echo $idC ?>); return false;" >Llegir més</a>
        			</div>
        		</div>
        		<div class="<?php echo 'C'.$idC; ?>" style="display: none; padding-left:10px; font-size:11px;">
        			<?php echo $desc; ?>
        			<div style="padding-left:10px; font-size:11px;">
        				<a href="" onClick="change(<?php echo $idC ?>); return false;" >Llegir menys</a>
        			</div>						
        		</div>												
        		
        		
        	</div>
        	<div style="clear:both">&nbsp;</div>													
        </div>					
        
        <?php 
        
        echo '<div style="clear:both; height:40px;"></div>';						

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
		
		return $ret;
		
	}

    function getRetorn($CICLE)
    {
        return '<a href="javascript:history.back()">Torna al llistat d\'activitats</a>';        
    } 

    function getLinkActivitats($CICLE)
    {            
        $enllac = url_for('web/index?accio=ccact&idC='.$CICLE->getCicleid());
        return '<a href="'.$enllac.'">Veure les activitats</a>';                 
    } 

?>
<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>

 <script>
  $(document).ready(function() {
    $("#tabs").tabs({cookie: { expires: 1 }});
    $("#cerca_MATERIAL_GENERIC").change(function(){ $("#FMATERIALS").submit(); });    
  });
  </script>

<STYLE>

#FDATA { width:80px; }
#CALEN TABLE { border-collapse: collapse; }
#CALEN TD { font-size: 9px; }
.COLOR { background-color:rgb(252,236,182); }
#TITOL_TAULA { font-weight: bold; background-color: #EEEEEE; }
#tabs { margin-top:30px; width:700px; margin-left:20px;  }

</STYLE>
   
    <TD colspan="3" class="CONTINGUT_ADMIN">

	<?php include_partial('breadcumb',array('text'=>'OCUPACIÓ I ESTADÍSTIQUES')); ?>

    <div id="tabs">
        <ul>
            <li><a href="#f1"><span>Ocupació espais</span></a></li>
            <li><a href="#f2"><span>Ocupació material</span></a></li>            
        </ul>
        <div id="f1">
            <?php echo formCercaEspais($CERCA,$IDS); ?>
        </div>
        <div id="f2">
            <?php echo formCercaMaterials($CERCA,$IDS); ?>
        </div>
    </div>


    <?php if(isset($OCUPACIO_ESPAIS)) echo llistatCercaEspais($OCUPACIO_ESPAIS,$ESPAIS); ?>
    <?php if(isset($OCUPACIO_MATERIAL)) echo llistatCercaMaterial($OCUPACIO_MATERIAL,$MATERIAL); ?>    
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    
<?php
 

  function selectMesos()
  {
    $RET = array();
  	for($i = 1; $i < 13; $i++) $RET[$i] = mesos($i);              
    return $RET;          
  }
  
  function selectAnys()
  {
	$RET = array();
	$any = date('Y',time());
	for($i = $any-10 ; $i < $any+4; $i++) $RET[$i] = $i;              
	return $RET;          
  }
  
  
  
  function mesos($mes)  
  {
    switch($mes){
      case 1: $text = "Gener"; break;
      case 2: $text = "Febrer"; break;
      case 3: $text = "Març"; break;
      case 4: $text = "Abril"; break;
      case 5: $text = "Maig"; break;
      case 6: $text = "Juny"; break;
      case 7: $text = "Juliol"; break;
      case 8: $text = "Agost"; break;
      case 9: $text = "Setembre"; break;
      case 10: $text = "Octubre"; break;
      case 11: $text = "Novembre"; break;
      case 12: $text = "Desembre"; break;
    }
    
    return $text;
  
  }
  
  function formCercaEspais( $CERCA ,$IDS ){
    ?>
    <form action="<?php echo url_for('gestio/gEstadistiques') ?>" id="FESPAIS" method="POST">
	    
	    	<table class="FORMULARI" width="100%">
	            <tr><td>
                	<div class="TITOL">Cerca espais</div>
                	<div class="CERCA">
                        <div style="margin-bottom:10px;">
	            		<?php echo select_tag("cerca[ANY]",options_for_select( selectAnys() , $CERCA['ANY'] ) , array('class'=>'cinquanta')); ?>
                        <?php echo select_tag('cerca[MES]',options_for_select( selectMesos() , $CERCA['MES'] , array()) , array('class'=>'cinquanta')); ?>
                        </div>
                        <?php foreach(EspaisPeer::select($IDS,false) as $K=>$V):
                                echo '<div style="float:left; width:210px;">'.checkbox_tag('cerca[ESPAI]['.$K.']',$K,(isset($CERCA['ESPAI'][$K])),array()).$V.' (E'.$K.')</div>';                            
                              endforeach;
                        ?>                                                               	
                		                	                                                                 
                	</div>
              	</td></tr>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA_ESP" value="Prem per buscar" />	            		
	            	</td>
	            </tr>
	        </table>
	    
     </form>                  
     
    <?php     
  }
  
  function formCercaMaterials( $CERCA ,$IDS ){
    ?>
    <form action="<?php echo url_for('gestio/gEstadistiques') ?>" id="FMATERIALS" method="POST">
	    	<table class="FORMULARI" width="100%">
	            <tr><td>
                	<div class="TITOL">Cerca materials</div>
                	<div class="CERCA">
                        <div style="margin-bottom:10px;">
    	            		<?php echo select_tag('cerca[ANY]',options_for_select( selectAnys() , $CERCA['ANY'] ) , array('class'=>'cinquanta')); ?>
                            <?php echo select_tag('cerca[MES]',options_for_select( selectMesos() , $CERCA['MES'] , array()) , array('class'=>'cinquanta')); ?>                	
                    		<?php echo select_tag('cerca[MATERIAL_GENERIC]',options_for_select( MaterialgenericPeer::select($IDS,false,false) , $CERCA['MATERIAL_GENERIC'])); ?>                                        	                                                                 
                        </div>
                    <?php   foreach(MaterialPeer::selectGeneric($CERCA['MATERIAL_GENERIC'], $IDS) as $K=>$V):
                                echo '<div style="float:left; width:210px;">'.
                                        checkbox_tag('cerca[MATERIAL]['.$K.']',$K,(isset($CERCA['MATERIAL'][$K])),array()).' '.$V.' (M'.$K.')</div>';                            
                            endforeach;
                        ?>                                                               	
                    </div>
              	</td></tr>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA_MAT" value="Prem per buscar" />	            		
	            	</td>
	            </tr>
	        </table>
     </form>   
    <?php     
  }
  

  function llistatCercaEspais($RET,$ESPAIS)
  {
    ?>
    <div class="REQUADRE">    
    <div class="titol">Llistat d'espais</div>
    <?php                         
        echo '<div style="background-color:white; width:650px">';                
        $d = 35;
        foreach($RET as $D => $V1):
            echo '<div style="background-color:#CCCCCC; font-weight:bold; clear:left; float:left; width:50px;">'.ph_generaDiaText($D).'</div><div>';
            for($i = 8; $i < 24; $i++){ echo '<div style="background-color:#CCCCCC; float:left; width:'.$d.'px;">'.$i.'</div>';  }
            foreach($V1 as $E => $V2):                   
                echo '<div style="clear:both; float:left; width:50px; background-color:#FFFF99;">
                        <a style="text-decoration:none; color:black;" href="#" class="tt2">E'.$E.'<span>'.$ESPAIS[$E].'</span></a></div>';
                $ult_hor = 0;
                foreach($V2 as $Hi => $Hf):
                    if($ult_hor == 0) echo '<div style="border-top:1px solid #CCCCCC; background-color:#DFF9E1; float:left; width:'.strval(($Hi-8)*$d).'px;">&nbsp;</div>';
                    if($ult_hor <> 0) echo '<div style="border-top:1px solid #CCCCCC; background-color:#DFF9E1; float:left; width:'.strval(($Hi-$ult_hor)*$d).'px;">&nbsp;</div>';
                    if($Hi <> $Hf)    echo '<div style="border-top:1px solid #CCCCCC; background-color:#FFD5D5; float:left; width:'.strval(($Hf-$Hi)*$d).'px;">'.$Hi.'-'.$Hf.'</div>';
                    $ult_hor = $Hf;                    
                endforeach;
                if($ult_hor < 24) echo '<div style="border-top:1px solid #CCCCCC; background-color:#DFF9E1; float:left; width:'.strval((24-$ult_hor)*$d).'px;">&nbsp;</div>';                                
            endforeach;        
            echo '</div>';
        endforeach;                                         
        echo '</div>';                        
    ?>
    
    <div style="clear:both;"></div>  
    </div>
    
    <?php     
  }


  function llistatCercaMaterial($RET,$MATERIAL)
  {
    ?>
    <div class="REQUADRE">    
    <div class="titol">Llistat de material</div>
    <?php                 
        echo '<div style="background-color:white; width:650px">';                
        $d = 35;
        foreach($RET as $D => $V1):
            echo '<div style="background-color:#CCCCCC; font-weight:bold; clear:left; float:left; width:50px;">'.ph_generaDiaText($D).'</div><div>';
            for($i = 8; $i < 24; $i++){ echo '<div style="background-color:#CCCCCC; float:left; width:'.$d.'px;">'.$i.'</div>';  }
            foreach($V1 as $E => $V2):                   
                echo '<div style="clear:both; float:left; width:50px; background-color:#FFFF99;">
                        <a style="text-decoration:none; color:black;" href="#" class="tt2">M'.$E.'<span>'.$MATERIAL[$E].'</span></a></div>';
                $ult_hor = 0;
                foreach($V2 as $Hi => $Hf):
                    if($Hf == 'CESSIO'){
                        echo '<div style="border-top:1px solid #CCCCCC; background-color:#FFD5D5; float:left; width:'.strval(16*$d).'px;">CEDIT</div>';                        
                    }
                    else{
                        if($ult_hor == 0) echo '<div style="border-top:1px solid #CCCCCC; background-color:#DFF9E1; float:left; width:'.strval(($Hi-8)*$d).'px;">&nbsp;</div>';
                        if($ult_hor <> 0) echo '<div style="border-top:1px solid #CCCCCC; background-color:#DFF9E1; float:left; width:'.strval(($Hi-$ult_hor)*$d).'px;">&nbsp;</div>';
                        if($Hi <> $Hf)    echo '<div style="border-top:1px solid #CCCCCC; background-color:#FFD5D5; float:left; width:'.strval(($Hf-$Hi)*$d).'px;">'.$Hi.'-'.$Hf.'</div>';
                        $ult_hor = $Hf;                        
                    } 
                                        
                endforeach;
                if($ult_hor < 24) echo '<div style="border-top:1px solid #CCCCCC; background-color:#DFF9E1; float:left; width:'.strval((24-$ult_hor)*$d).'px;">&nbsp;</div>';                                
            endforeach;        
            echo '</div>';
        endforeach;                                         
        echo '</div>';                        
    ?>
    
    <div style="clear:both;"></div>  
    </div>
    
    <?php     
  }


?>

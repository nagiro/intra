<?php use_helper('Form'); ?>

<script>

	$(document).ready(function() {
		$( "#tabs" ).tabs({ cookie: { expires: 1 } });        
	});
	
</script>

<style>
    LEGEND { font-weight:bold; padding-left:10px; padding-right:10px; font-size:14px;  }  

	.DH { display:block; float:left; padding-top:5px; }

	fieldset { border:3px solid #F3F3F3; margin-right:40px; padding:10px; }
	.MISSAT { color:black; font-weight:bold; font-size:10px; vertical-align:middle; text-align:center; background-color:White; padding-bottom:10px; }	
	.TITOL_CATEGORIA { background-color: #DD9D9A; color:black; font-weight:bold; padding:5px; font-size:10px; }	

</style>

   <TD colspan="3" class="CONTINGUT_ADMIN">

	<?php include_partial('breadcumb',array('text'=>'ZONA PRIVADA')); ?>
    <br />
   	<?php include_partial('espaiActual',array('IDS'=>$IDS)); ?>    		

    <?php if($DEFAULT): ?>
		                   	                   	
        <div style=" padding:20px; width:700px; ">    
            <div id="tabs">
            	<ul>
                    <li><a href="#tabs-0">Benvinguda</a></li>                  		
            	</ul>                        
                <div id="tabs-0"> <?php echo landing_page(); ?> </div>            	
            </div>
        
        </div>
        
      <?php else:
      
              if(isset($MISS)) echo MissatgeWeb($TITOL,$MISS);
                                                                    
            endif;                                       
         
      ?>
      
      
      
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

<?php 

	function missatge($MISSATGE)
	{
	   $RET = "";
		if(!empty($MISSATGE))
		{
			$RET .= '<TR>';
		   	$RET .= '<TD></TD><TD class="MISSAT_OK">';
		   	foreach($MISSATGE as $M): $RET .= $M."<BR>";  endforeach;    				
		   	$RET .= '</TD></TR>';			
		}		
        
        return $RET;
	}
     
    function MissatgeWeb($TITOL,$MISS)
    {                        
        $RET  = '<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">'.$TITOL.'</LEGEND>';
        $RET .= '<DIV style="margin-right:20px;"><span class="TITOLAR">'.$MISS.'</span></DIV>';
        $RET .= '</FIELDSET>';
           
        return $RET;        
     }
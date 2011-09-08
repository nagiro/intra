<script type="text/javascript">

    $(document).ready(function(){
            $("#tabs").tabs({ cookie: { expires: 30 } });
            $.datepicker.setDefaults( $.datepicker.regional["ca"] );      
            $("#di").datepicker({flat:true});             
            $("#df").datepicker({flat:true});
            
            $("#di").change(function(){ $("#formulari").submit(); });    
            $("#df").change(function(){ $("#formulari").submit(); });
            $("#cerca_POBLE").change(function(){ $("#formulari").submit(); });
            $("#cerca_CATEGORIA").change(function(){ $("#formulari").submit(); });
            $("#cerca_SITE").change(function(){ $("#formulari").submit(); });
    });
        
</script>

<div class="h_subtitle_gray">
    CERCADOR D'ACTIVITATS
</div>

<div style="border:1px solid #CCCCCC; border-radius: 5px;">
    <div style="padding: 10px;">
	
    	<div class="taula_dades" id="tabs-1">
    
        <form id="formulari" action="<?php echo url_for('@hospici_cercador_activitats')?>" method="post">
    
            <div style="float: left; width: 600px;">
                <div style="margin: 5px;">
                    <b>Nom de l'activitat</b><br /><input type="text" id="R_TEXT" name="cerca[TEXT]" value="<?php echo $CERCA['TEXT'] ?>" class="input_common" style="width: 570px;" />
                </div>
            </div>                
            <div style="clear:both; float: left;">
                <div style="margin: 5px;">            
                    <b>On?</b><br /><?php echo select_tag('cerca[POBLE]',options_for_select($DESPLEGABLES['SELECT_POBLACIONS'],$CERCA['POBLE']),array('class'=>'input_common','style'=>'width:280px;')); ?>
                </div>
            </div>
            <div style="float: left;">
                <div style="margin: 5px;">            
                    <b>Què?</b><br /><?php echo select_tag('cerca[CATEGORIA]',options_for_select($DESPLEGABLES['SELECT_CATEGORIES'],$CERCA['CATEGORIA']),array('class'=>'input_common','style'=>'width:280px;')); ?>
                </div>
            </div>
            <div style="clear:both; float: left;">
                <div style="margin: 5px;">            
                    <b>Qui?</b><br /><?php echo select_tag('cerca[SITE]',options_for_select($DESPLEGABLES['SELECT_ENTITATS'],$CERCA['SITE']),array('class'=>'input_common','style'=>'width:280px;')); ?>
                </div>
            </div>
            <div style="float: left;">
                <div style="margin: 5px;">            
                    <b>Data inici</b><br /><?php echo input_tag('cerca[DATAI]',$CERCA['DATAI'],array('id'=>'di','class'=>'input_common','style'=>'width: 130px')); ?>
                </div>
            </div>
    
            <div style="float: left;">
                <div style="margin: 5px;">            
                    <b>Data fi</b><br /><?php echo input_tag('cerca[DATAF]',$CERCA['DATAF'],array('id'=>'df','class'=>'input_common','style'=>'width: 130px')); ?>
                </div>
            </div>
                        
            <div style="float: right; margin-right:5px; margin-top:4px;">
                <input type="submit" value="Cerca!" style="height:30px; width:100px;" />                                
            </div>
            
            <div style="clear: both;"></div>                     
        </form>  
    	</div>        
    </div>        
</div>





<?php

function rangDates(){
    $RET = array();
    
    $RET[0] = 'Avui';
    $RET[1] = 'Aquest cap de setmana';
    $RET[2] = 'Aquest mes';
    $RET[3] = 'El mes que ve';
    $RET[4] = 'Dos mesos vista';        
    $RET[5] = 'Rang de dates';
    
    return $RET;                            
}


 ?>
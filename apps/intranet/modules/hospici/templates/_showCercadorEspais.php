<script type="text/javascript">

    $(document).ready(function(){                                                
            $( "#R_ON" ).click(CarregaCategories);
            $( "#R_CAT").click(CarregaDates);        
            $( "#E_ON" ).click(CarregaDatesE);    
            CarregaCategories();
            $( "#RANG" ).hide();
            $( "#RANGE" ).hide();
            $( "#DATA" ).click(RangDeDates);
            $( "#DATAE" ).click(RangDeDatesE);
            RangDeDates();                
            $("#DI").datepicker($.datepicker.regional['ca']);
            $("#DF").datepicker($.datepicker.regional['ca']);
            $("#DIE").datepicker($.datepicker.regional['ca']);
            $("#DFE").datepicker($.datepicker.regional['ca']);
            $( "#tabs" ).tabs({ cookie: { expires: 30 } });                                         
        });

    function RangDeDates(){
        if($( "#DATA" ).val() == 5) { $( "#RANG" ).show(500); } else { $( "#RANG" ).hide(); }
    }
    
    function RangDeDatesE(){
        if($( "#DATAE" ).val() == 5) { $( "#RANGE" ).show(500); } else { $( "#RANGE" ).hide(); } 
    }
    
    /* Carrega les categories d'activitats per població */
    function CarregaCategories(){            
        $("#R_CAT").html('<option>Carregant...</option>');            
        $.post( '<?php echo url_for('hospici/ajaxACT') ?>', 
                { ACCIO: 'POB_ON', TEXT: $("#R_TEXT").val(), ON: $("#R_ON").val(), SEL: '<?php echo $CERCA['CATEGORIA'][0]; ?>' }, 
                function(data){
                    /// Ponemos la respuesta de nuestro script en el DIV recargado                                                    
                    $("#R_CAT").html(data);
                });
    }

    /* Carrega les dates segons s'ha escollit categoria de les activitats segons població */                    
    function CarregaDates(){            
        $("#R_DATA").html('<option>Carregant...</option>');            
        $.post( '<?php echo url_for('hospici/ajaxACT') ?>', 
                { ACCIO: 'POB_QUAN', TEXT: $("#R_TEXT").val(), ON: $("#R_ON").val(), CAT: $("#R_CAT").val(), SEL: '<?php echo $CERCA['DATA'][0]; ?>' }, 
                function(data){
                    /// Ponemos la respuesta de nuestro script en el DIV recargado                                                    
                    $("#R_DATA").html(data);
                });
    }

    /* Carrega les dates segons s'ha escollit categoria de les activitats segons entitat */
    function CarregaDatesE(){            
        $("#DATAE").html('<option>Carregant...</option>');            
        $.post( '<?php echo url_for('hospici/ajaxACT') ?>', 
                { ACCIO: 'ENT_QUAN', TEXT: $("#R_TEXT").val(), ENT: $("#E_ON").val(), SEL: '<?php echo $CERCA['DATA'][0]; ?>' }, 
                function(data){
                    /// Ponemos la respuesta de nuestro script en el DIV recargado                                                    
                    $("#DATAE").html(data);
                });
    }

        
</script>

<div class="h_subtitle_gray">
    CERCADOR D'ESPAIS
</div>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">per ciutat</a></li>
		<li><a href="#tabs-2">per entitat</a></li>			
	</ul>
    
	<div class="taula_dades" id="tabs-1">

    <form action="<?php echo url_for('@hospici_cercador_activitats')?>" method="POST">

        <div style="float: left; width: 600px;">
            <div style="margin: 5px;">
                <b>Nom de l'espai</b><br /><input type="text" id="R_TEXT" name="cerca[TEXT]" value="<?php echo $CERCA['TEXT'] ?>" style="width: 500px;" />
            </div>
        </div>                        

        <div style="clear:both; float: left;">
            <div style="margin: 5px;">            
                <b>On?</b><br /><?php echo select_tag('cerca[POBLE]',options_for_select(ActivitatsPeer::selectPoblesActivitats($CERCA['TEXT']),$CERCA['POBLE'][0]),array('multiple'=>'multiple','style'=>'height:130px; width:180px;','id'=>'R_ON')); ?>
            </div>
        </div>
        <div style="float: left;">            
            <div style="margin: 5px;">            
                <b>Què?</b><br /><?php echo select_tag('cerca[CATEGORIA]',options_for_select(ActivitatsPeer::selectCategoriesActivitats($CERCA['POBLE'][0],$CERCA['TEXT']),$CERCA['CATEGORIA'][0]),array('multiple'=>'multiple','style'=>'height:130px; width:180px;','id'=>'R_CAT')); ?>
            </div>
        </div>
        <div style="float: left;">
            <div style="margin: 5px;">            
                <div style="margin: 5px;">
                Des de: <input type="text" id="DI" name="cerca[DATA_R][DI]" style="height:30px; width:100px;" />
                Fins a: <input type="text" id="DF" name="cerca[DATA_R][DF]" style="height:30px; width:100px;" />
            </div>
            </div>
        </div>
        <div style="clear:both; float: left; width:400px;">
            <div id="RANG" style="float: left; margin-right:5px; margin-top:4px;">
                Des de: <input type="text" id="DI" name="cerca[DATA_R][DI]" style="height:30px; width:100px;" />
                Fins a: <input type="text" id="DF" name="cerca[DATA_R][DF]" style="height:30px; width:100px;" />
            </div>                        
            
            <div id="HORES" style="float: left; margin-right:5px; margin-top:4px;">
                Hora inici: <input type="text" id="HI" name="cerca[HORA_R][DI]" style="height:30px; width:100px;" />
                Hora finalització: <input type="text" id="HF" name="cerca[HORA_R][DF]" style="height:30px; width:100px;" />
            </div>
            
            <div style="float: left; margin-right:5px; margin-top:4px;">
                <input type="hidden" name="cerca[P]" value="1" style="height:30px; width:100px;" />                                                
            </div>
        </div>
        
        <div style="float: right; margin-right:5px; margin-top:4px;">
            <input type="submit" value="Cerca!" style="height:30px; width:100px;" />                                
        </div>
        
        <div style="clear: both;"></div>                     
    </form>  
	</div>
    
    
	<div id="tabs-2" class="taula_dades">
    
    <form action="<?php echo url_for('@hospici_cercador_activitats')?>" method="POST">
    
        <div style="float: left; width: 600px;">
            <div style="margin: 5px;">
                <b>Text clau</b><br /><input type="text" name="cerca[TEXT]" value="<?php echo $CERCA['TEXT'] ?>" style="width: 500px;" />
            </div>
        </div>                
        <div style="clear:both; float: left;">
            <div style="margin: 5px;">            
                <b>Qui?</b><br /><?php echo select_tag('cerca[SITE]',options_for_select(ActivitatsPeer::selectSitesActivitats($CERCA['TEXT']),$CERCA['SITE'][0]),array('multiple'=>'multiple','style'=>'height:130px; width:360px;','id'=>'E_ON')); ?>
            </div>
        </div>
        <div style="float: left;">
            <div style="margin: 5px;">            
                <b>Quan?</b><br /><?php echo select_tag('cerca[DATA]',options_for_select(ActivitatsPeer::selectDatesActivitats(null,null,$CERCA['TEXT'],$CERCA['SITE'][0]),$CERCA['DATA'][0]), array('multiple'=>'multiple','style'=>'height:130px; width:180px;','id'=>'DATAE')); ?>
            </div>
        </div>
        <div style="clear:both; float: left;">
            <div id="RANGE" style="float: left; margin-right:5px; margin-top:4px;">
                Des de: <input type="text" id="DIE" name="cerca[DATA_R][DI]" style="height:30px; width:100px;" />
                Fins a: <input type="text" id="DFE" name="cerca[DATA_R][DF]" style="height:30px; width:100px;" />
            </div>
            
            <div style="float: left; margin-right:5px; margin-top:4px;">
                <input type="hidden" name="cerca[P]" value="1" style="height:30px; width:100px;" />                                                
            </div>
        </div>
        
        <div style="float: right; margin-right:5px; margin-top:4px;">
            <input type="submit" value="Cerca!" style="height:30px; width:100px;" />                                
        </div>

        
        <div style="clear: both;"></div>
    </form>                               
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
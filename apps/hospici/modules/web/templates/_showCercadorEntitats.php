<script type="text/javascript">

    $(document).ready(function(){
            $("#tabs").tabs({ cookie: { expires: 30 } });
            $("#di").datepicker({ flat: true, mode: 'multiple'});
            $("#df").datepicker({ flat: true, mode: 'multiple'});
        });
        
</script>

<div class="h_subtitle_gray">
    CERCADOR D'ENTITATS DE L'HOSPICI
</div>

<div style="border:1px solid #CCCCCC; border-radius: 5px;">
    <div style="padding: 10px;">
    	<div class="taula_dades">
    
        <form action="<?php echo url_for('@hospici_cercador_entitats')?>" method="POST">
    
            <div style="float: left; width: 600px;">
                <div style="margin: 5px;">
                    <b>Text a cercar</b><br /><input type="text" id="R_TEXT" name="cerca[TEXT]" value="<?php echo $CERCA['TEXT'] ?>" class="input_common" style="width: 500px;" />
                </div>
            </div>
            <div style="clear:both; float: left;">
                <div style="margin: 5px;">
                    <b>Població</b><br /><?php echo select_tag( 'cerca[POBLE]', options_for_select( $DESPLEGABLES['SELECT_POBLACIONS'] , $CERCA['POBLE'] ), array('class'=>'input_common','style'=>'width:250px;','id'=>'R_ON' )); ?>
                </div>
            </div>
    
            <div style="float: left;">
                <div style="margin: 5px;">            
                    <b>Categoria</b><br /><?php echo select_tag( 'cerca[CATEGORIA]', options_for_select( $DESPLEGABLES['SELECT_CATEGORIES'] , $CERCA['SITE'] ), array('class'=>'input_common','style'=>'width:250px;','id'=>'R_ON' )); ?>
                </div>
            </div>
    
            <div style="clear:both; float: left; width:400px;">            
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
</div>
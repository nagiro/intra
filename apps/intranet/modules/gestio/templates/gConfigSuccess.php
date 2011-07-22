<?php use_helper('Form') ?>

<style>
	
	.row { width:100px; } 
	.row_field { width:inherit; } 
	.row_title { width:inherit; }
	.row_field input { width:inherit; }
    .fb { float:left; display:block;  }    
		
</style>

<script type="text/javascript">

	$(document).ready(function() {
		$('#tabs').tabs({ cookie: { expires: 1 } });        
        $('#options_option_id').change(ajaxOptions);
        $('#espais_EspaiID').change(function(){ $('#FESPAIS').submit(); });
        $('#materialgeneric_idMaterialGeneric').change(function(){ $('#FMATERIAL').submit(); });                                
	});

    //Funció que captura de quin genèric parlem i busca els disponibles. 
	function ajaxOptions()
	{
		$("#options_valor").val('Carregant...');										
        $.post(
                '<?php echo url_for('gestio/gConfig?accio=AJAX_OPCIO') ?>',  
                { IDO: $('#options_option_id').val() } , 
                function(data) { $("#options_valor").val(data); }
            );                                                
                                                
    }
    	
	</script>


  
<TD colspan="3" class="CONTINGUT_ADMIN">	

	<?php include_partial('breadcumb',array('text'=>'CONFIGURACIÓ')); ?>		
		                   	                   	

    <div class="demo" style=" padding:20px; width:700px; ">    
        <div id="tabs">
        	<ul>
        		<li><a href="#tabs-1">Opcions</a></li>
        		<li><a href="#tabs-2">Espais</a></li>        		
                <li><a href="#tabs-3">Material genèric</a></li>
                <li><a href="#tabs-4">Autentificacions</a></li>
                <li><a href="#tabs-5">Entitat</a></li>
        	</ul>                        
        	<div id="tabs-1"> <?php echo OptionsTab($FOPTIONS); ?> </div>
        	<div id="tabs-2"> <?php echo EspaisTab($FESPAIS); ?> </div>              	
            <div id="tabs-3"> <?php echo MaterialTab($FMATERIAL); ?> </div>
            <div id="tabs-4"> <?php echo AutentificacioTab($PARS,$FBI,$ERROR); ?> </div>
            <div id="tabs-5"> <?php echo EntitatTab($FENTITAT); ?> </div>
        </div>
    
    </div>
    

<DIV STYLE="height:40px;"></DIV>

<?php 

    /**
     * Modificació de les dades de l'entitat. Logo i URL del web. 
     * */
    function EntitatTab($FENTITAT)
    {
                
        $RET = '
            <form id="FENTITAT" action="'.url_for('gestio/gConfig').'" method="POST" enctype="multipart/form-data">         	 	                                    
                <table class="FORMULARI">                    
                '.$FENTITAT.'                    
                </table>
                <div style="text-align:right">
                    <button type="submit" name="BSAVESITE" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guardar i sortir
                    </button>
                </div>                                                                                                            
            </form>';
                     
        return $RET;
        
    }

    /**
     * Autentificacio Tab. Els canvis aquí també s'han d'aplicar a uGestio
     * */
    function AutentificacioTab($PARS,$FBI,$ERROR)
    {
                                    
        $RET = "<p>Clicant l'enllaç que apareix més avall podràs vincular o desvincular el teu usuari de l'Hospici amb el teu usuari de Facebook. Si els vincules, el teu usuari de Facebook també serà el de l'Hospici i podràs accedir a aquest últim sense haver d'entrar ni l'usuari ni la contrassenya.</p><br />";
         
        if($FBI == 0):
            if(!empty($ERROR)) $RET .= '<div class="error">'.$ERROR.'</div>';
            else $RET .= '<a href="'.$PARS['logUrl'].'">No tens cap usuari vinculat al facebook. Clica per vincular l\'actual.</a>';        
        else:
            $fb   = myUser::getFbObject();                                             
            $FBD  = $fb->api($FBI);
            $RET .= '<a href="'.url_for('@fb_user_unlink').'">Tens un usuari vinculat. Clica per desvincular-lo.</a><br /><br />';
            $RET .= '<img align="middle" src="https://graph.facebook.com/'.$FBI.'/picture"> '.$FBD['name'];                                   
        endif;
        
        
        return $RET;
        
    }

    /**
     * Options Tab
     * */
    function OptionsTab($FOPTIONS)
    {
                
        $RET = '
            <form id="FOPTIONS" action="'.url_for('gestio/gConfig').'" method="POST" enctype="multipart/form-data">         	 	                                    
                <table class="FORMULARI">                    
                '.$FOPTIONS.'                    
                </table>
                <div style="text-align:right">
                    <button style="margin-top:10px;" name="EDIT" class="BOTO_ACTIVITAT">
                        '.image_tag('template/find.png').' Consulta
                    </BUTTON>
                    <button style="margin-top:10px;" name="BNEWOPTION" class="BOTO_ACTIVITAT">
                        '.image_tag('template/new.png').' Nova opció
                    </BUTTON>                          
                    <button type="submit" name="BSAVEOPTION" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guardar i sortir
                    </button>
                </div>                                                                                                            
            </form>';
                     
        return $RET;
        
    }


    /**
     * Espais Tab
     * */
    function EspaisTab($FESPAIS = "")
    {
        
        $RET = '
            <form id="FESPAIS" action="'.url_for('gestio/gConfig').'" method="POST" enctype="multipart/form-data">         	 	                                    
                <table class="FORMULARI">                    
                '.$FESPAIS.'                
                </table>';
                                
        $LFMultimedia = $FESPAIS->getFotosEspais();
        $RET .= '<div style="margin-top:20px;">';
        foreach($LFMultimedia as $FMultimedia):                
            $RET .= '<div style="float:left; margin-left:100px;">'.$FMultimedia.'</div>';
        endforeach;
        $OE = $FESPAIS->getObject();
        $RET .= '<div style="float:left; margin-left:100px;">'.MultimediaPeer::initialize(-1,$OE->getSiteId(),EspaisPeer::TABLE_NAME,$OE->getEspaiid(),sizeof($LFMultimedia)+1).'</div>';
        $RET .= '</div><div style="clear:both;"></div>';
                
        $RET .='                                
                <div style="text-align:right; margin-top:20px;">
                    <button style="margin-top:10px;" name="EDIT" class="BOTO_ACTIVITAT">
                        '.image_tag('template/find.png').' Consulta
                    </BUTTON>   
                    <button type="submit" name="BSAVEESPAI" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guardar i sortir
                    </button>
    	            <button type="submit" name="BDELETEESPAI" class="BOTO_PERILL" onClick="return confirm(\'Segur que vols esborrar-lo?\')">
                        '.image_tag('tango/16x16/status/user-trash-full.png').' Eliminar
                    </button>
                </div>                                                                                            
            </form>';
                     
        return $RET;
             
    }

    /**
     * Material Tab
     * */
    function MaterialTab($FMATERIAL = "")
    {
        
        $RET = '
            <form id="FMATERIAL" action="'.url_for('gestio/gConfig').'" method="POST" enctype="multipart/form-data">         	 	                                    
                <table class="FORMULARI">                    
                '.$FMATERIAL.'
                </table>
                <div style="text-align:right">
                    <button style="margin-top:10px;" name="EDIT" class="BOTO_ACTIVITAT">
                        '.image_tag('template/find.png').' Consulta
                    </BUTTON>   
                    <button type="submit" name="BSAVEMATERIAL" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guardar i sortir
                    </button>
    	            <button type="submit" name="BDELETEMATERIAL" class="BOTO_PERILL" onClick="return confirm(\'Segur que vols esborrar-lo?\')">
                        '.image_tag('tango/16x16/status/user-trash-full.png').' Eliminar
                    </button>
                </div>                                                                                            
            </form>';
                     
        return $RET;
             
    }




?>                
<?php use_helper('Form') ?>
<?php $BASE = OptionsPeer::getString('SF_WEBROOT',$IDS); ?>
<script type="text/javascript" src="<?php echo $BASE.'js/jquery.autocompleter.js'; ?>"></script>

<style>

    @import url('<?php echo $BASE.'css/jquery.autocompleter.css'; ?>');	
	.row { width:500px; } 
	.row_field { width:70%; } 
	.row_title { width:30%; }
	.row_field input { width:100%; }
	input.ul_cat { background-color:white; border:0px; width:20px; }
	li.ul_cat { width:220px; }
	#TD1 td { border: 0px solid #DB9296; padding:0px 2px; font-size:10px; }
	#TD1 { border-collapse:collapse; }
	.LIST2 { padding:10px;  } 
		
</style>

<script type="text/javascript">

	$(document).ready(function() {
		$( "#tabs" ).tabs({ cookie: { expires: 1 } });  
	});
    	
	</script>


  
<TD colspan="3" class="CONTINGUT_ADMIN">	

	<?php include_partial('breadcumb',array('text'=>'CONFIGURACIÓ')); ?>		
		                   	                   	

    <div class="demo" style=" padding:20px; width:700px; ">    
        <div id="tabs">
        	<ul>        		        		        		
                <li><a href="#tabs-1">Entitats</a></li>
                <li><a href="#tabs-2">Permisos</a></li>                                                
                <li><a href="#tabs-3">Menús Gestió</a></li>
        	</ul>                        
        	<div id="tabs-1"> <?php echo EntitatsTab($FSITES); ?> </div>
        	<div id="tabs-2"> <?php echo PermisosTab($SITE, $LUSERSITES); ?> </div>              	
            <div id="tabs-3"> <?php echo MenusgestioTab($LMENUSUSUARI, $FMENUUSUARI); ?> </div>
        </div>
    
    </div>
    

<DIV STYLE="height:40px;"></DIV>

<?php 

    /**
     * Entitats Tab
     * */
    function EntitatsTab($FSITES)
    {
                
        $RET = '
            <form id="FSITES" action="'.url_for('gestio/gConfigSuperAdmin').'" method="POST" enctype="multipart/form-data">         	 	                                    
                <table class="FORMULARI">                    
                '.$FSITES.'                    
                </table>
                <div style="text-align:right">
                    <button style="margin-top:10px;" name="EDIT" class="BOTO_ACTIVITAT">
                        '.image_tag('template/find.png').' Consulta
                    </BUTTON>   
                    <button type="submit" name="BSAVESITE" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guardar i sortir
                    </button>
    	            <button type="submit" name="BDELETESITE" class="BOTO_PERILL" onClick="return confirm(\'Segur que vols esborrar-lo?\')">
                        '.image_tag('tango/16x16/status/user-trash-full.png').' Eliminar
                    </button>                    
                </div>                                                                                                            
            </form>';
                     
        return $RET;
        
    }


    /**
     * Permisos Tab
     * */
    function PermisosTab( $SITE , $LUSERSITES = "" )
    {
   
        $RET = '
            <form id="FESPAIS" action="'.url_for('gestio/gConfigSuperAdmin').'" method="POST" enctype="multipart/form-data">
                Site : '.select_tag('SITE',options_for_select(SitesPeer::getSelect(),$SITE));
        $RET .= '<br /><br /><table>';
        $RET .= '<tr><td class="titol">User</td><td class="titol">Nivell</td><td class="titol"></td></tr>';  
        foreach( $LUSERSITES as $OUS ):
            $USUARI = $OUS->getUsuariId();            
            $RET .= '<tr><td>'.select_tag('dades['.$USUARI.'][IDU]',options_for_select(UsuarisPeer::selectAllUsers(),$USUARI)).'</td>';
            $RET .= '<td>'.select_tag('dades['.$USUARI.'][IDN]',options_for_select(NivellsPeer::getSelect(),$OUS->getNivellId())).'</td>';                        
            $RET .= '<td>'.link_to('esborra' , 'gestio/gConfigSuperAdmin?accio=DELETE_USER_SITE&USUARI='.$USUARI.'&SITE='.$SITE).'</td></tr>';
        endforeach;        
        $RET .= '<tr><td>'.select_tag('dades[0][IDU]',options_for_select(UsuarisPeer::selectAllUsers(),0)).'</td>';
        $RET .= '<td>'.select_tag('dades[0][IDN]',options_for_select(NivellsPeer::getSelect(),0)).'</td></tr>';                        
        $RET .= '</table>';
                        
        $RET .='         	 	                                                    
                <div style="text-align:right">
                    <button style="margin-top:10px;" name="BSEARCHUSERSITES" class="BOTO_ACTIVITAT">
                        '.image_tag('template/find.png').' Consulta
                    </BUTTON>                       
                    <button type="submit" name="BSAVEUSERSITE" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guardar i sortir
                    </button>
                </div>                                                                                            
            </form>';
                     
        return $RET;
             
    }

    /**
     * Menus Gestió Tab
     * */
    function MenusgestioTab($LMENUS = "", $FMENUUSUARI)
    {        
        
        $RET = '
            <form id="FMENUS" action="'.url_for('gestio/gConfigSuperAdmin').'" method="POST" enctype="multipart/form-data">
            <table>'.$FMENUUSUARI.'</table>';                
        $RET .= '<br /><br /><table>';        
        
        $RET .= '<tr><td class="titol">Menu</td><td class="titol"></td></tr>';                      
        $RET .= '<tr><td>'.select_tag('dades',options_for_select(GestioMenusPeer::getSelect(),$LMENUS),array('multiple'=>true)).'</td>';                                                
        $RET .= '</table>';
                        
        $RET .='         	 	                                                    
                <div style="text-align:right">
                    <button style="margin-top:10px;" name="BSEARCHUSERSITES" class="BOTO_ACTIVITAT">
                        '.image_tag('template/find.png').' Consulta
                    </BUTTON>                       
                    <button type="submit" name="BSAVEUSERMENU" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                        '.image_tag('template/disk.png').' Guardar i sortir
                    </button>    	            
                </div>                                                                                            
            </form>';
                     
        return $RET;
             
    }

?>
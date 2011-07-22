<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <?php $metas = $sf_response->getMetas();        
        if(!empty($metas)):
            echo html_entity_decode(implode(' ',$metas));                    
        endif;        
   ?>  
  
  <?php $BASE = OptionsPeer::getString('SF_WEBROOT',1); ?>
  <?php $BASE_I = OptionsPeer::getString('SF_WEBROOTURL',1).'images/hospici'; ?>
  
  <!-- Facebook & Twitter -->
    <script src="http://connect.facebook.net/ca_ES/all.js#xfbml=1"></script>
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
  <!-- Facebook & Twitter -->
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/smoothness/jquery-ui-1.7.2.custom.css'; ?>" />   
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/jquery-datepick/jquery.datepick.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/thickbox.css'; ?>" />  
    
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>       
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-ui/js/jquery-datepicker-ca.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery.cookie.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-validate/jquery.validate.min.js' ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-validate/localization/messages_es.js' ?>"></script>
                  
     
<!--[if lt IE 7]>
    <script type="text/javascript" src="/intranet/js/buttonfix.js"></script>
<![endif]-->

  <title>L'Hospici. La Cultura al teu abast!</title>

<style type="text/css">

* { font-family: Myriad Pro, Trebuchet MS, Arial, Sans-Serif; margin:0px; padding:0px; font-size:12px; }

td.checkbox_list { border:1px solid #CCCCCC; background-color: #FFEFD7; }

.checkbox_list li  {	
	display: inline;
	float:left;	
	margin: 0px;
	padding: 0px;
	list-style: none;	
}

.ul_espais input { background-color:white; border:0px; float:left; width:30px; }
.ul_material input { background-color:white; border:0px; float:left; width:30px; }

label.ul_espais { float:left;  width:160px;  }
label.ul_material { float:left; width:50px;  }

li.ul_espais { 		        
    width:200px;    
}

li.ul_material{ 	
	width:100px; 
}

.input_common { background-color:#EEEEEE; border:1px solid #CCCCCC; padding:2px; }

.tt2 { text-decoration:none; color:black; }
.tt2:hover span { margin-top:10px; padding:5px; position: absolute; display: block; background: #fdd; border: 1px solid brown; font-size:10px; font-weight:normal; }  
.tt2 span { display:none; text-align:left; }
.selec { text-decoration: underline;  }

.requadre_missatge { padding:5px; background-color: #FFFEE4; }
.requadre_mini { border-radius:4px; padding:2px; font-size:11px; }
.requadre_mini a { text-decoration:none; color:white; font-size:11px;  }
.requadre_mini a:hover { text-decoration:underline;   }

#taula { width:1024px; margin:0 auto; text-align:left; border:1px solid black;  }
        
.h_left_col { width:200px;float:left; vertical-align: top;  }
.h_middle_col { width:624px; float:left; vertical-align: top; min-height:450px; }
.h_right_col { width:200px; float:left; vertical-align: top;  }
    
.h_col_head , .h_head , .h_head_down { background-color:#3F3F3F; }
.h_head { width:1024px; height:100px }
.h_head_down { width:1024px; height:11px; }    
                        
.h_menu { height:30px; background-image: url('<?php echo $BASE_I.'/menu_gradient.jpg'; ?>'); background-repeat: repeat-x; }
.h_menu_sup_item { font-size:16px; float:left; color:orange; padding:4px 10px; border-right:3px solid orange; list-style-type: none; }
.h_menu_sup_link { color:orange; text-decoration:none; }    
.h_menu_sup_item:hover { background-color:#96BD0D; color: #96BD0D; }
.h_menu_sup_link:hover { color:black; text-decoration:none; }    
            
.h_menu_left { list-style-image: url('<?php echo $BASE_I.'/menu_right_arrow.jpg'; ?>'); list-style-position: inside; }
.h_menu_left a { text-decoration:none; font-weight:bold; color:black;  }
.h_menu_left a:hover { color:#96BD0D; text-decoration:underline;  }
.h_menu_left li { font-size:12px; }

.h_requadre_menu_left { background-color:white; border-radius:10px; text-align:left; }

.h_content { margin-top:20px;  }        

.h_subtitle_gray { font-size:15px; color:#96BC0D; margin-bottom:10px; border-bottom:1px solid #96BC0D;   }

.h_requadre_cercador { /* background-color:#96BD0D; */ height:180px; width:600px; }         
.h_input_requadre_cercador input { margin-top:5px; width:300px;  }
.h_input_requadre_cercador_data input { margin-top:5px; width:143px;  }
.h_input_requadre_cercador select { margin-top:5px; width:300px;  }

.h_requadre_cercador_plegat_titol { float:left; width:70px; font-size:30px; float:left; color:white;  }
.h_requadre_cercador_plegat_text { margin-top:10px; font-size:14px; color:#CCCCCC; float:right;  }

.h_requadre_banners { background-color:white; border:3px solid #96BD0D; height:113px; width:600px; }
.h_requadre_banners_banner { color:#666666; padding:5px; border-right:1px solid #96BD0D; float:left; height:105px; width:117px; }
.h_requadre_banners_banner_text { height:90px;  }
.h_requadre_banners_banner_amplia { height:10px; text-align: right; }
.h_requadre_banners_banner_amplia a { text-decoration:none; color:#AD1C1C; }

.h_requadre_resultats { margin-top:20px; }
.h_requadre_resultats #tabs { height:480px; }

.h_calendari { width:175px; margin:0 auto; }
.h_calendari_menu {  text-align:center; background-color:orange;  }
.h_calendari_dia { color:#FF7F00; float:left; background-color: white; width:25px; text-align:center;  }
.h_calendari_data { color:#888888; float:left; background-color: white; width:25px; text-align:center;  } 
.h_calendari_break { clear:both;  } 


.h_requadre_login { text-align:center; background-color:#3F3F3F; width:175px; margin:0 auto; margin-top:20px; border-radius: 10px; }
.h_requadre_login_inputs { width:150px; margin-left:auto; margin-right:auto; }
.h_requadre_login_inputs input { width:150px; background-color:#8C8C8C; border:0px; margin-bottom:5px; border-radius: 5px; color:white; }
.h_requadre_login_button { width:150px; text-align:right; margin:0 auto; }
.h_requadre_login_button a { color:#FF7F00; text-decoration:none; font-size:14px;  }
.h_requadre_login_button a:hover { color:#96BD0D; text-decoration:none; font-size:14px;  }
.h_requadre_login_text { margin: 0 auto; color:white; width:150px; text-align:left;}
.h_requadre_login_imatge {  }

.h_requadre_login_logged { color:white; text-align:left; padding: 0px 15px;  }
.h_requadre_login_logged li { list-style-type: square; list-style-position: inside;  }
.h_requadre_login_logged a { color:#A9E886; text-decoration: none;  }
.h_requadre_login_logged a:hover { text-decoration: underline;  }

.h_llistat_activitat_tipus_titol { border-radius:5px;  background-color:#CCCCCC; padding:5px; font-weight:bold; margin-bottom:10px;  }    
.h_llistat_activitat_titol a { text-decoration:none; font-weight:bold; font-size:14px; color:black; }
.h_llistat_activitat_titol a:hover { text-decoration:underline; }

.h_llistat_activitat_horari { margin-left:20px; color:green; font-weight:normal; float:left;  }
.h_llistat_activitat_organitzador { color:#888888; margin-left:10px; font-weight:normal; float:left;  }

    .taula_dades { width:600px;  }
    .taula_dades input { border:1px solid #DDDDDD; padding:3px; }
    .taula_dades input:focus { background-color:#EEEEEE; }
    .taula_dades select { border:1px solid #DDDDDD; width:200px; }
    .taula_dades select:focus { background-color:#EEEEEE;  }
    .taula_dades th { text-align:right; width:100px; padding-right:5px; }  

    .taula_llistat { width:600px; border-collapse:collapse;  }
    .taula_llistat th { text-align:left; padding:3px;  }
    .taula_llistat td { text-align:left; padding:3px; }
    .taula_llistat tr:hover { background-color: #EEEEEE;  }    

    .error_list { background-color:#FBFFD5;  color:#DD8275; list-style: none; padding:3px;  }

    .error { color:#ED5C5C;  }
    .tatxat { text-decoration: line-through; }
    .missatge { padding:10px; margin-top: 20px; background-color:#FBFFD5; }
     
</style>

	<style>
        
		label, input { display:block; }
		input.text { margin-bottom:12px; width:95%; padding: .4em; }
		fieldset { padding:0; border:0; margin-top:10px; }
		h1 { font-size: 1.2em; margin: .6em 0; }
		div#users-contain { width: 350px; margin: 20px 0; }
		div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
		div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
		.ui-dialog .ui-state-error { padding: .3em; }
		.validateTips { border: 1px solid transparent; padding: 0.3em; }
	</style>

<script>
    
    $(document).ready(function(){
        
        var url = '';
        
        $("#LOGINSUBMIT").click(function(){ $("#FLOGIN").submit(); });
        
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 310,
			width: 350,
			modal: true,
			buttons: {
				"Entra >>": function() {    					                        
                        $.post(
                            '<?php echo url_for('web/LoginAjax') ?>',
                            { 'login':$("#login").val() , 'pass':$('#password').val() },
                             function(data) {                                                     
                                if(data == 'OK'){ $('#dialog-form').dialog( "close" ); $(location).attr('href',url); }
                                else { alert('Incorrecte'); }                                                           
                             }   
                            );                        
					}				
			},
			close: function() {
				//allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});


		$( ".auth" )
			.click(function() {
                url = $(this).attr('url');
				$( "#dialog-form" ).dialog( "open" );
			});        
        
        
    });

</script>
     
  </head>
  
  <body>
  
    <div style="text-align:center;">  
    <div id="taula">
        <!-- HEADER -->

        <div class="h_head"></div>

        <div class="h_menu">
            <ul>
                <li class="h_menu_sup_item"><a href="<?php echo url_for('@hospici_cercador_activitats') ?>" class="h_menu_sup_link">ACTIVITATS</a></li>

                <li class="h_menu_sup_item"><a href="<?php echo url_for('@hospici_cercador_cursos_inici') ?>" class="h_menu_sup_link">CURSOS</a></li>

                <li class="h_menu_sup_item"><a href="#" class="h_menu_sup_link">CALENDARI</a></li>

                <li class="h_menu_sup_item"><a href="#" class="h_menu_sup_link">EL MEU HOSPICI</a></li>
            </ul>
        </div>

        <div class="h_head_down"></div>                

        <div class="h_content">
            <div class="h_left_col">
                <div class="h_requadre_menu_left">
                    <div style="padding: 0px 10px;">
                
                        <h1 style="margin-bottom: 5px;">L'Hospici, què vol fer avui?</h1>                        
                                 
                        <ul class="h_menu_left">
                            <li>
                                <a href="<?php echo url_for('@hospici_cercador_activitats') ?>">Trobar activitats</a>
                            </li>
                            <li>
                                <a href="<?php echo url_for('@hospici_cercador_cursos_inici') ?>">Trobar cursos</a>
                            </li>
                            <li>
                                <a href="<?php echo url_for('@hospici_cercador_espais') ?>">Trobar espais per reservar</a>
                            </li>            
                            <li>
                                <a href="<?php echo url_for('@hospici_cercador_entitats') ?>">Conèixer entitats</a>
                            </li>
                            <li>
                                <a href="<?php echo url_for('@hospici_usuaris_alta') ?>">Vull ser-ne membre</a>
                            </li>                                                                                                                                                                                                                                                            
                        </ul>
                        
                    </div>
                </div>
            </div>

            <div class="h_middle_col">

                <?php echo $sf_content ?>                            

            </div>
           
            <div id="dialog-form" title="Accedeix a l'Hospici">
            	<form>    
            	<fieldset>
                    <div style="margin-bottom: 10px;">
                        Per poder accedir i realitzar accions a l'Hospici ha d'entrar el seu DNI i contrassenya. Si no recorda la contrassenya cliqui <a href="<?php url_for('@hospici_usuaris_remember') ?>">aquí</a>. Si no té usuari, pot crear-lo <a href="<?php url_for('@hospici_usuaris_alta') ?>">aquí</a>.<br />
                    </div> 
            		<label for="login">DNI: </label>
            		<input type="text" name="login" id="login" class="text ui-widget-content ui-corner-all" />		
            		<label for="password">Contrassenya: </label>
            		<input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all" />
            	</fieldset>
            	</form>
            </div>
            
            <div class="h_right_col">                

                <div class="h_requadre_login">
                    <br />
                    <?php if(!$sf_user->isAuthenticated()): ?>
                    
                        <form id="FLOGIN" action="<?php echo url_for('@hospici_login') ?>" method="POST">
                            <div class="h_requadre_login_inputs">
                                <input type="text"     name="login" /> 
                                <input type="password" name="pass"  />
                            </div>                            
                            <div class="h_requadre_login_button">
                                <a href="#" id="LOGINSUBMIT">Entra &gt;&gt;&gt;</a>
                            </div>
                            <div class="h_requadre_login_button" >
                                <a href="<?php echo url_for('@hospici_usuaris_alta') ?>" style="font-size: 10px;">Nou usuari &gt;&gt;&gt;</a>
                            </div>
                            <div class="h_requadre_login_button" >
                                <a href="<?php echo url_for('@hospici_usuaris_remember'); ?>" style="font-size: 10px;">Recorda contrassenya &gt;&gt;&gt;</a>
                            </div>
                            
                        </form>
                                                                
                    <br />

                    <div class="h_requadre_login_text">
                        Ser soci de l&rsquo;hospici et d&oacute;na dret a veure totes les activitats de les entitats s&ograve;cies de la xarxa.
                        <br />
                        &Eacute;s totalment gratu&iuml;t.
                        <br />
                        Consulta aqu&iacute; les condicions de registre de les teves dades.
                    </div>
                    
                    <?php else: ?>
                    
                        <div class="h_requadre_login_logged">
                            Benvingut,<br /> 
                            <?php echo $sf_user->getSessionPar('username'); ?>
                            
                            <br /><br />
                            
                            Què desitges fer? 
                            <ul>
                                <li><a href="<?php echo url_for('@hospici_usuaris') ?>">Veure les meves dades</a></li>
                                <li><a href="<?php echo url_for('@hospici_cercador_activitats') ?>">Buscar activitats</a></li>
                                <li><a href="<?php echo url_for('@hospici_cercador_cursos') ?>">Buscar cursos</a></li>
                                <li><a href="<?php echo url_for('@hospici_cercador_espais') ?>">Reservar un espai</a></li>
                                <li><a href="<?php echo url_for('@hospici_login') ?>">Sortir</a></li>
                            </ul> 
                            
                        </div>
                        
                    <?php endif; ?>                    
                    <br />
                    <div class="h_requadre_login_imatge">
                        <img src="<?php echo $BASE_I.'/logo_hospici.png'; ?>">
                    </div>
                </div>                
            </div>                        
        </div>
        <div style="clear: both; ">&nbsp;</div>
        <div style="margin-top:30px; height:30px; background-color: #3F3F3F">&nbsp;</div>                
    </div>    
    
</div>
    

    
            
  </body>
</html>

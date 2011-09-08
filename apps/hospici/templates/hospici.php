<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <?php $metas = $sf_response->getMetas();        
            if(!empty($metas)):
                echo html_entity_decode(implode(' ',$metas));
            endif;        
       ?>  
      
      <!-- Facebook & Twitter -->
      <script type="text/javascript" src="http://connect.facebook.net/ca_ES/all.js#xfbml=1"></script>
      <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
      
      <!-- General plugins css -->
      <link rel="stylesheet" type="text/css" media="screen" href="/css/smoothness/jquery-ui-1.7.2.custom.css" />   
      <link rel="stylesheet" type="text/css" media="screen" href="/css/jquery-datepick/jquery.datepick.css" />
      <link rel="stylesheet" type="text/css" media="screen" href="/css/thickbox.css" />  
      <link rel="stylesheet" type="text/css" media="screen" href="/css/TipTip/TipTip.css" />
      <link rel="stylesheet" type="text/css" media="screen" href="/js/lightbox/css/jquery.lightbox-0.5.css" />      
        
      <!-- General plugins js -->      
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>       
      <script type="text/javascript" src="/js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js"></script>
      <script type="text/javascript" src="/js/jquery-ui/js/jquery-datepicker-ca.js"></script>
      <script type="text/javascript" src="/js/jquery.cookie.js"></script>
      <script type="text/javascript" src="/js/jquery-validate/jquery.validate.min.js"></script>
      <script type="text/javascript" src="/js/jquery-validate/localization/messages_es.js"></script>
      <script type="text/javascript" src="/js/TipTip/jquery.tipTip.minified.js"></script>      
    
      <!-- Personal plugins js & css -->
      <script type="text/javascript">
    
        /* Descripció de variables utilitzades als scripts posteriors */
        var h_cursos_loginAjax = '<?php echo url_for('web/LoginAjax'); ?>';
        var h_feedback_Ajax = '<?php echo url_for('web/FeedbackAjax'); ?>';
            
      </script>
      <script type="text/javascript" src="/js/hospici.js"></script>       
      <link rel="stylesheet" type="text/css" media="screen" href="/css/hospici.css" />
      
      <!-- Google Fonts -->      
      <link href="http://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet" type="text/css" />     
      <link href="http://fonts.googleapis.com/css?family=Delius" rel="stylesheet" type="text/css" />                  
         
      <title>L'Hospici. La Cultura al teu abast!</title>

  </head>
  
  <body>      
    
    <div id="feedback-form" title="Deixa un comentari sobre el portal">
    	<form action="#">        	
            <div style="margin-bottom: 10px;">
                Li estarem molt agraïts que ens comuniqui qualsevol error, millora o idea sobre el portal i el seu funcionament.<br />
            </div> 
    		<label for="nom"><b>Nom i Cognoms</b></label>
    		<input type="text" name="nom" id="feedback-nom" class="text ui-widget-content ui-corner-all" />		
    		<label for="mail"><b>Contacte</b></label>
    		<input type="text" name="mail" id="feedback-mail" value="" class="text ui-widget-content ui-corner-all" />
            <label for="comentari"><b>Observació</b></label>
            <textarea name="comentari" id="feedback-comentari" cols="10" rows="10" style="height:200px; width:300px;" class="text ui-widget-content ui-corner-all"></textarea>    	
    	</form>
    </div>


  
    <div style="text-align:center;">  
    
        <div id="taula">
        
            <!-- HEADER -->
    
            <div style="width:1024px; height:140px; background-color:#3f3f3f;">
                <div style="float: left; padding-top:8px; padding-left:10px;"><img src="/images/hospici/logo_hospici.png" alt="" /></div>
                <div style="float: left; font-family: 'Delius',cursive; color:#FF8D00; font-size:60px; padding-top:35px; padding-left:20px;">l'hospici</div>
                <div style="float: left; font-family: 'Gloria Hallelujah', cursive; font-size: 20px; color:#E8E462; padding-top:100px; padding-left:100px;">portal de gestió cultural pels municipis</div>
                <div style="float: right; width:150px; height:100%; "><img alt="" src="/images/hospici/header_decoration.png" /></div>
                <div style="clear: both;"></div>
            </div>
    
            <!-- CONTENT -->
    
            <div class="h_content">
            
                <!-- MENÚ -->
            
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
                                    <a href="<?php echo url_for('@hospici_cercador_formularis') ?>">Formularis</a>
                                </li>                                
                                <li>
                                    <a href="<?php echo url_for('@hospici_usuaris_alta') ?>">Vull ser-ne membre</a>
                                </li>                                                                                                                                                                                                                                                            
                            </ul>
                            
                        </div>
                    </div>
                </div>
    
               <!-- CONTENT -->
    
                <div class="h_middle_col">
    
                    <?php echo $sf_content ?>                            
    
                </div>
               
                <div id="dialog-form" title="Accedeix a l'Hospici">
                	<form action="#">    
                	<fieldset>
                        <div style="margin-bottom: 10px;">
                            Per poder accedir i realitzar accions a l'Hospici ha d'entrar el seu DNI i contrassenya. Si no recorda la contrassenya cliqui <a href="<?php echo url_for('@hospici_usuaris_remember') ?>">aquí</a>. Si no té usuari, pot crear-lo <a href="<?php echo url_for('@hospici_usuaris_alta') ?>">aquí</a>.<br />
                        </div> 
                		<label for="login">DNI: </label>
                		<input type="text" name="login" id="login" class="text ui-widget-content ui-corner-all" />		
                		<label for="password">Contrassenya: </label>
                		<input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all" />
                	</fieldset>
                	</form>
                </div>
    
                <!-- LOGIN -->
                
                <div class="h_right_col">                
    
                    <div class="h_requadre_login">
                        <br />
                        
                        <!-- USUARI NO AUTENTIFICAT -->
                        
                        <?php if(!$sf_user->isAuthenticated()): ?>
                        
                            <form id="FLOGIN" action="<?php echo url_for('@hospici_login') ?>" method="post">
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
                            Ser usuari de l&rsquo;hospici et d&oacute;na dret a accedir a la informació de totes les activitats, cursos i espais de les entitats s&ograve;cies de la xarxa.
                            <br /><br />
                            &Eacute;s totalment gratu&iuml;t.
                            <br />
                            <!-- Consulta aqu&iacute; les condicions de registre de les teves dades. -->
                        </div>
                        
                        <!-- USUARI AUTENTIFICAT -->
                        
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
                                    <li><a href="<?php echo url_for('@hospici_cercador_formularis') ?>">Omplir un formulari</a></li>
                                    <li><a href="<?php echo url_for('@hospici_login') ?>">Sortir</a></li>
                                </ul> 
                                
                            </div>
                            
                        <?php endif; ?>
                                            
                        <br />
                    </div>
                    <div id="feedback" style="margin-left:10px; margin-top:5px; text-align: center; border-radius: 10px; padding:0px 10px; color:#89E886; background-color: #3F3F3F; width:155px;">Deixa un suggeriment</div>                
                </div>                        
            </div>
            <div style="clear: both; ">&nbsp;</div>
            <div style="margin-top:30px; height:30px; background-color: #3F3F3F">&nbsp;</div>
                            
        </div>
                
    </div>

  </body>
</html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  
  <?php $metas = $sf_response->getMetas();
        if(!empty($metas)):
            echo html_entity_decode(implode(' ',$metas));                    
        endif;        
   ?>  
   
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  
  <?php $BASE = OptionsPeer::getString('SF_WEBROOT',1); ?>
  <!-- Facebook & Twitter -->
    <script src="http://connect.facebook.net/ca_ES/all.js#xfbml=1"></script>
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
  <!-- Facebook & Twitter -->

  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/gestio.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/smoothness/jquery-ui-1.7.2.custom.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/jquery-datepick/jquery.datepick.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/thickbox.css'; ?>" />    
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/tiny_mce/tiny_mce.js'; ?>"></script>    
  <script type="text/javascript" src="<?php echo $BASE.'js/thickbox-compressed.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js'; ?>"></script>
    
<!--[if lt IE 7]>
    <script type="text/javascript" src="/intranet/js/buttonfix.js"></script>
<![endif]-->

  <title>Casa de Cultura de la Diputació de Girona</title>
      
  </head>
  <body class="CCG">
  <center>  	
    
    <table class="TAULA">
    <!-- <TR><TD colspan="4" class="DEGRADAT_SUPERIOR"><?php echo image_tag('intranet/DifuminatSuperior.png', array()); ?></TD></TR>  -->   
    <tr>
    	<td class="CAPCALERA" style="width: 256px"><?php echo link_to(image_tag('intranet/logoCCG.png', array('id'=>'logo')),'web/index?accio=no'); ?></td>    	
    	<td class="CAPCALERA" style="padding-left:120px;" colspan="3" >
		<div style="vertical-align:bottom; position:relative; width:768px;">
			<div class="PESTANYA_SUPERIOR">
				<a target="_NEW" href="http://www.casadecultura.org/giroscopi">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_03.png'); ?>" /> 
				</a>
			</div>
			<div class="PESTANYA_SUPERIOR">
				<a target="_NEW" href="http://www.hospici.cat">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_04.png'); ?>" /> 
				</a>
			</div>
            <div class="PESTANYA_SUPERIOR">
				<a target="_NEW" href="<?php echo url_for('web/index?accio=mc&node=43'); ?>">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_09.png'); ?>" /> 
				</a>
			</div>
			<div class="PESTANYA_SUPERIOR">
				<a href="<?php echo url_for('web/espais'); ?>">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_05.png'); ?>" /> 
				</a>
			</div>
			<div class="PESTANYA_SUPERIOR">
				<!-- <a target="_NEW" href="http://www.hospici.cat/cursos_entitat/1"> -->
                <a href="<?php echo url_for('web/cursos'); ?>">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_06.png'); ?>" /> 
				</a>
			</div>
  	        <div class="PESTANYA_SUPERIOR">
				<a href="<?php echo $BASE.'web/index?accio=mc&node=42'; ?>">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_08.png'); ?>" /> 
				</a>
			</div>
			<div class="PESTANYA_SUPERIOR">
				<a href="<?php echo url_for('web/contacte') ?>">
					<img src="<?php echo url_for(sfConfig::get('sf_webrooturl').'images/menu_07.png'); ?>" /> 
				</a>
			</div>
		</div>		    	    		    		    		    	
    	</TD>
	</TR>

    <?php echo $sf_content ?>
        
    <TR><TD colspan="4" class="PEU">CASA DE CULTURA DE GIRONA | Pl. hospital,6. 17002. Girona | T. 972 20 20 13 | <a class="white" href="mailto:informatica@casadecultura.org">E-mails</a> | <a class="white" href="" >Informació legal</a></TD></TR>
    <TR><TD colspan="4" class="DEGRADAT_INFERIOR"></TD></TR>     
    </TABLE>
  </center>
  
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-11029946-1");
pageTracker._trackPageview();
} catch(err) {}</script>  
  
  </body>
</html>

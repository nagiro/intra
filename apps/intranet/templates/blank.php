<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="generator" content="PSPad editor, www.pspad.com" />

    <?php $metas = $sf_response->getMetas();        
        if(!empty($metas)):
            echo html_entity_decode(implode(' ',$metas));                    
        endif;        
   ?>  
  
  <?php $BASE = OptionsPeer::getString('SF_WEBROOT',1); ?>

  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/gestio.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/smoothness/jquery-ui-1.7.2.custom.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/jquery-datepick/jquery.datepick.css'; ?>" />      

  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-1.4.2.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/tiny_mce/tiny_mce.js'; ?>"></script>              
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery.datepick.package-3.7.1/jquery.datepick.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-ui/js/jquery-datepicker-ca.js'; ?>"></script>    
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery.cookie.js'; ?>"></script>          
    
  <title></title>    
  </head>
  <body>
    <?php echo $sf_content ?>
  </body>
</html>
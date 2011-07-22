<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">   

  <?php $BASE = OptionsPeer::getString('SF_WEBROOT',1); ?>
    
  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/gestio.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/smoothness/jquery-ui-1.7.2.custom.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/jquery-datepick/jquery.datepick.css'; ?>" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $BASE.'css/thickbox.css'; ?>" />    

  <!--[if lte IE 7]>
    <link type="text/css" rel="stylesheet" media="all" href="css/screen_ie.css" />
  <![endif]-->

  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-1.4.2.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/tiny_mce/tiny_mce.js'; ?>"></script>            
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js'; ?>"></script>  
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery.datepick.package-3.7.1/jquery.datepick.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery.datepick.package-3.7.1/jquery.datepick-ca.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery.cookie.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-validate/jquery.validate.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo $BASE.'js/jquery-validate/localization/messages_es.js'; ?>"></script>

    
    <script type="text/javascript" src="<?php echo $BASE.'js/buttonfix.js'; ?>"></script>    
    
<!--[if lt IE 7]>
    <script type="text/javascript" src="<?php echo $BASE.'js/buttonfix.js'; ?>"></script>
    <script>alert('El seu navegador és antic. Si us plau instal·lis qualsevol navegador que no sigui Internet Explorer');</script>
<![endif]-->
      
  <link rel="shortcut icon" href="/favicon.ico" />
  
  <title>L'Hospici :: Gestor d'entitats culturals</title>
  
  </head>
  
  <body class="CCG">  
  <center>          
    <TABLE class="TAULA">
<!--  <TR><TD colspan="4" class="DEGRADAT_SUPERIOR"><?php echo image_tag('intranet/DifuminatSuperior.png', array()); ?></TD></TR>  -->
    <TR><TD colspan="4" class="CAPCALERA"><?php echo link_to(image_tag('intranet/logoCCG.png', array('id'=>'logo')),'gestio/ULogin'); ?></TD></TR>
<!--  <TR><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD></TR> -->
    <TR>    
      <TD class="MENU">
      
      <?php
        if($sf_user->getSessionPar('idU') > 0): 
            //Carreguem els menús que podrà veure l'usuari                        
            $LOM = GestioMenusPeer::getMenusUsuari($sf_user->getSessionPar('idU'),$sf_user->getSessionPar('idS'),$sf_user->getSessionPar('idN'));
            $ANT = "";
            echo '<CENTER><TABLE class="MENU_TABLE">';
            foreach($LOM as $OM):
                if($ANT <> $OM->getCategoria()):
                    echo '<TR><TD class="SUBMENU_1">'.imgSub1().' '.$OM->getCategoria().'</TD></TR>';
                    $ANT = $OM->getCategoria();
                endif; 
                echo '<TR><TD class="SUBMENU_2">'.link_to(imgSub2().' '.$OM->getTitol(),$OM->getUrl()).'</TD></TR>';
            endforeach;
            echo '</TABLE></CENTER>';        
        endif; 
      ?>      			                  
      </TD>      
    
    <?php echo $sf_content ?>

    
    </TR>
    <TR><TD colspan="4" class="PEU">CASA DE CULTURA | Pl. hospital,6. 17002. Girona | T. 972 20 20 13 | <a class="white" href="mailto:informatica@casadecultura.org">E-mail</a> | Informació legal</TD></TR>
    <TR><TD colspan="4" class="DEGRADAT_INFERIOR"></TD></TR>     
    </TABLE>
  </center>
  </body>
</html>


<?php 

  function imgSub1()
  {
    return image_tag('intranet/Submenu1T.png', array('align'=>'ABSMIDDLE'));
  }
  
  function imgSub2()
  {
    return image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE'));
  }

?>

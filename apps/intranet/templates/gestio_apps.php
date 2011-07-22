<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">

    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
      
  <link rel="shortcut icon" href="/favicon.ico" />
  
  <title></title>
    <!--    <base href="http://localhost/intranet_dev.php" /> -->  
    <!--   	<base href="http://servidor.casadecultura.cat/intranet/intranet_dev.php" /> -->
  </head>
  <body class="CCG">
  <center>
    <TABLE class="TAULA">
    <TR><TD colspan="4" class="DEGRADAT_SUPERIOR"><?php echo image_tag('intranet/DifuminatSuperior.png', array()); ?></TD></TR>
    <TR><TD class="CAPCALERA"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'logo')); ?></TD><TD class="CAPCALERA"></TD><TD class="MENU_CAPCALERA" style="text-align:right;"></TD><TD class="MENU_CAPCALERA" style="text-align:left;"></TD></TR>
<!--  <TR><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD><TD class="FOTOS"><?php echo image_tag('intranet/logoCCG.png', array('class'=>'IMG_FOTO')); ?></TD></TR> -->
    <TR>    
      <TD class="MENU">
        <CENTER>
          <TABLE class="MENU_TABLE">
            <TR><TD class="SUBMENU_1"><?php echo imgSub1().' DOCUMENTS'; ?></TD></TR>              
              <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Torna directori base','apps/gDocuments?accio=CD&IDD=1'); ?></TD></TR>
			<TR><TD class="SUBMENU_1"><?php echo imgSub1().' APLICACIONS'; ?></TD></TR>
			  <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Surt','web/logout'); ?></TD></TR>
			  <TR><TD class="SUBMENU_2"><?php echo link_to(imgSub2().' Torna a la web','web/index'); ?></TD></TR>			
          </TABLE>
        </CENTER>
        </TD>      
    
    <?php echo $sf_content ?>

    
    </TR>
    <TR><TD colspan="4" class="PEU">CASA DE CULTURA | Pl. hospital,6. 17001. Girona | T. 972 20 20 13 | <a class="white" href="mailto:informatica@casadecultura.org">E-mail</a> | Informació legal</TD></TR>
    <TR><TD colspan="4" class="DEGRADAT_INFERIOR"></TD></TR>     
    </TABLE>
  </center>
  </body>
</html>

<?php 

  function imgSub1()
  {
    return image_tag('intranet/Submenu1.png', array('align'=>'ABSMIDDLE'));
  }
  
  function imgSub2()
  {
    return image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE'));
  }

?>

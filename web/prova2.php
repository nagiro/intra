<?php ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf8" />
	<meta name="author" content="Albert Johé" />

	<title>Casa de Cultura de Girona</title>
</head>

<body>

972 21 02 52
20,17 € (500 a mòbil durant cap de setmana)
(50 min fix a mòbil)
(adsl 10Mb, 12 mesos)
93.295.93.98 (Montse Blanco) 9:30 a 14
M'ha penjat. Quan la torni a trucar li hauré de dir. 


<?php 


/*    preg_match_all('/  <linia>
                            <dia>(.*?)</dia>
                            <diaT>(.*?)</diaT>
                            <subtitol>(.*?)</subtitol>
                            <negreta>(.*?)</negreta>
                            <normal>(.*?)</normal>
                            <link>(.*?)</link>
                            <hora>(.*?)</hora>
                            <lloc>(.*?)</lloc>
                            <organitza>(.*?)</organitza>
                            <entrada>(.*?)</entrada>
                        </linia>                                                                        
                        /')

http://www.spaweditor.com/scripts/regex/index.php
gnosis.cx/publish/programming/regular_expressions.html

*/

$data = '<document>
            <caixa>
                <columna>1</columna>
                <dia>11</dia>
                <diaT>DIMECRES</diaT>
                <subtitol>inund\'Art</subtitol>
                <subactivitat>
                    <negreta>Gaudí. Recerca i creació, a càrrec de Daniel Giralt-Miracl</negreta>
                    <normal>, crític i historiador de l\'art, comissari general de l\'Any Internacional Gaudí. Introducció a la figura i obra de Gaudí.</normal>
                    <link>Link 1</link>
                    <hora>19.30</hora>
                    <lloc>Aula Magna</lloc>
                    <organitza>Aules d\'extensió universitària</organitza>
                    <entrada>Entrada lliure</entrada>                    
                </subactivitat>
                <subactivitat>
                    <negreta>Concert inund\'Art</negreta>
                    <normal>ajfeigjawñio</normal>
                    <link>Link 2</link>
                    <hora>Hora 2</hora>
                    <lloc>Lloc 2</lloc>
                    <organitza>Organitza 2</organitza>
                    <entrada>Entrada 2</entrada>
                </subactivitat>
            </caixa>
            <caixa>
                <columna>2</columna>
                <dia>13</dia>
                <diaT>DIMECRES</diaT>
                <subtitol>SUBTÍTOL</subtitol>
                <subactivitat>
                    <negreta>Negreta 1</negreta>
                    <normal>Normal 1</normal>
                    <link>Link 1</link>
                    <hora>Hora 1</hora>
                    <lloc>Lloc 1</lloc>
                    <organitza>Organitza 1</organitza>
                    <entrada>Entrada 1</entrada>                    
                </subactivitat>
                <subactivitat>
                    <negreta>Negreta 2</negreta>
                    <normal>Normal 2</normal>
                    <link>Link 2</link>
                    <hora>Hora 2</hora>
                    <lloc>Lloc 2</lloc>
                    <organitza>Organitza 2</organitza>
                    <entrada>Entrada 2</entrada>
                </subactivitat>
            </caixa>                
        </document>
                ';


$BASE_WEB = 'http://www.casadecultura.org/phplist/CCG/butlletiSetmanal/';
$BASE_URL = '/home/informatica/www/phplist/CCG/butlletiSetmanal/';

//$BASE_WEB = 'http://localhost/intranet/butlletins/';
//$BASE_URL = 'C:\Documents and Settings\casacultura\Escritorio\htdocs\trunk\intranet\web\butlletins\\';
$NOM_WEB = (strval(date('W',time()))+1).(date('Y',time())).'.html';
$NOM_AGENDA = 'Agenda'.date('mY',time()).".pdf";

    if(empty($_POST)):
    
        echo '<form action="prova2.php" method="POST" enctype="multipart/form-data">';    
        echo '  <textarea name="dades" style="width:800px; height:500px;"></textarea><br />';
        echo '  Butlletí mensual en pdf: <input type="file" name="butlleti" />';
        echo '  <input type="submit" value="Genera" />';
        echo '</form>';    
    
    else: 

        $xml = simplexml_load_string($_POST['dades']);                    
        move_uploaded_file($_FILES['butlleti']['tmp_name'], $BASE_URL.$NOM_AGENDA);            

?>

<center>
<div style="width:640px;">
    <div style="width:640px; font-family:sans-serif; font-size:14px; margin:20px; text-align:center;">
        <span style="font-size: 10px; color:gray;">Si no veu correctament aquest correu cliqui 
            <a href="<?php echo $BASE_WEB.$NOM_WEB; ?>">aqu&iacute;</a>.
        </span>
    </div>
    <div style="width:640px; font-family:sans-serif; font-size:14px; margin:20px; text-align:center;">
        <img width="200px" alt="Logo de la Casa de Cultura de Girona" src="http://www.casadecultura.org/downloads/logos/CCG_BLANC.jpg" />
    </div>
    <div style="font-family: Arial; border-bottom:2px solid #B33330; border-top:2px solid #B33330; margin-top:20px; text-align:left;">
        <div style="font-family: Tahoma; color:#CCCCCC; font-weight:bold; float:left; font-size:40px; text-align:center; margin-right:10px; width:640px;">
            A&nbsp;G&nbsp;E&nbsp;N&nbsp;D&nbsp;A&nbsp;&nbsp;&nbsp; S&nbsp;E&nbsp;T&nbsp;M&nbsp;A&nbsp;N&nbsp;A&nbsp;L
        </div>
        <div style="clear: both;">&nbsp;</div>

        <?php $colant = 0; foreach($xml->caixa as $caixa): ?>
        
            <?php                       
                    if($colant == 0): echo '<div style="width:320px; float:left;">';
                    elseif($colant == 1 && $caixa->columna == 2): echo '</div><div style="float:left; width:300px;">';
                    endif;
                    $colant = $caixa->columna;
            ?>            
            <!-- Notícia -->
            <div style="margin:10px; background-color:#ACD145; width:300px;">
                <div style="padding: 10px; font-size:12px; color:black; font-weight:normal;">
                    <div style="color:white;">
                        <span style="font-size: 18px; color:white; font-weight:bold;">
                            <?php echo $caixa->dia; ?>                            
                        </span>
                        <span style="font-size: 12px; font-weight:bold;">
                            <?php echo strtoupper($caixa->diaT); ?>
                        </span>
                    </div>
                    <div style="font-size: 12px; color:white; font-weight:bold; margin-bottom:5px;">
                        <?php echo strtoupper($caixa->subtitol); ?>
                    </div>
                    <?php $i = 0; foreach($caixa->subactivitat as $subactivitat): ?>
                        <?php $style='margin-bottom:20px;'; if($i++ > 0) $style = 'margin-top: 20px; margin-bottom:10px;'; ?>
                    <div style="<?php echo $style ?>">
                        <a style="text-decoration:inherit; color:black;" target="_NEW" href="<?php echo $subactivitat->link; ?>">
                            <b><?php echo $subactivitat->negreta; ?></b> <?php echo $subactivitat->normal; ?>                                                                
                        </a>
                    </div>
                    <?php if(!empty($subactivitat->hora)): ?>
                    <div>
                        <span style="font-size: 12px; color:white; font-weight:bold;"> HORA </span>
                        <span><?php echo $subactivitat->hora; ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($subactivitat->lloc)): ?>
                    <div>
                        <span style="font-size: 12px; color:white; font-weight:bold;"> LLOC </span>
                        <span> <?php echo $subactivitat->lloc; ?> </span>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($subactivitat->organitza)): ?>
                    <div>
                        <span style="font-size: 12px; color:white; font-weight:bold;"> ORGANITZA </span>
                        <span> <?php echo $subactivitat->organitza; ?> </span>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($subactivitat->entrada)): ?>
                    <div>
                        <span style="font-size: 12px; color:white; font-weight:bold;"> ENTRADA </span>
                        <span> <?php echo $subactivitat->entrada; ?> </span>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>                    
                </div>                
            </div>            
            <?php endforeach; ?>
            <!-- FI Notícia -->
        
        </div>
        
        <div style="clear: both;">&nbsp;</div>
    </div>
    <div style="padding-top:10px; color: black; font-size:20px; text-align:center;"><a style="color: black; text-decoration:inherit;" target="_NEW" href="http://www.casadecultura.cat">http://www.casadecultura.cat</a></div>
    <div style="padding-top:10px; color: black; font-size:14px; text-align:center;"><a style="color: gray; text-decoration:inherit;" target="_NEW" href="<?php echo $BASE_WEB.$NOM_AGENDA; ?>">Descarrega't l'agenda mensual</a></div>
    <div style="margin-top:30px; color: gray; font-size:10px;">En virtut de les lleis vigents en mat&egrave;ria de protecci&oacute; de dades (LOPD) us informem que us hem enviat aquest correu utilitzant les dades de contacte que ens v&agrave;reu facilitar en el seu moment i que v&agrave;rem incorporar al nostre arxiu. Teniu dret a sol&middot;licitar l'acc&eacute;s, la modificaci&oacute; o la cancel&middot;laci&oacute; de les vostres dades, incloent-hi l'adre&ccedil;a de correu electr&ograve;nic, del nostre arxiu enviant un correu a informatica@casadecultura.org o b&eacute; a la secretaria de la Casa de Cultura de Girona.</div>
</div>
</center>

</body>
</html>

<?php 

$HtmlCode= ob_get_contents();
ob_end_flush();
file_put_contents($BASE_URL.$NOM_WEB,$HtmlCode); 

endif;

?>
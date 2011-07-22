<script type="text/javascript" src="<?php echo sfConfig::get('sf_webroot').'js/jqzoom_ev1.0.1/jqzoom_ev1.0.1/js/jquery.jqzoom1.0.1'; ?>">
</script>
<link rel="stylesheet" href="<?php echo sfConfig::get('sf_webroot').'js/jqzoom_ev1.0.1/jqzoom_ev1.0.1/css/jqzoom.css'; ?>" type="text/css" />

<script>

$(document).ready(function(){
	var options = {
		    zoomWidth: 300,
		    zoomHeight: 600,
	        xOffset: 0,
	        yOffset: 50,
	        position: "right",
		    title: false,
		    zoomType: "standard"
		    
	};
		
	$('.MYCLASS').jqzoom(options);
	
});

</script>

<style>

	* { font-family: verdana; font-size: small; }
	
	table.formulari { border-collapse:collapse; border:solid 3px gray; width:800px; }	
	.col1 { width:150px; }
	.col2 { width:225px; }
	.col3 { width:25px;  }
	.col4 { width:100px; }
	.col5 { width:200px; }
	input { border: 1px gray solid; }
	select { border: 1px gray solid; background-color:white; }	
	option { background-color:white; }
	.input { width:100px; }
	.suma { width:20px; }
	.peque { font-size:8px; color:gray; }
	td { padding:5px;  }
	#contenidor { width: 800px; margin:0 auto 0 auto; }
	#centrat { text-align:center; margin-top:100px; }		
	#titol { font-size: x-large; font-family: Verdana; font-weight: bold; }
	#submit { width:200px;}
	#tdsubmit { border-top:1px gray solid; text-align:center; padding:5px;  }
	#formulari { width:800px; }
	#missatge { background-color: <?php echo ($MISSATGE['OK'])?'#79E778':'#E78787'; ?>; padding-left:20px; }
	#imatge { width:500px; }
	a { text-decoration: none; color:black; }
		
</style>

<?php if($ESTAT == 'INICI'): ?>

<center>	
	<img id="imatge" src="<?php echo sfConfig::get('sf_webroot').'images/blogs/Dissenys/biennal/2.jpg'?>" alt="Logo de Biennal 2010"></img>
	<a href="<?php echo url_for('blogs/biennal?ESTAT=BASES') ?>">
	<h1>BIENNAL 2010<br />Prem per entrar</h1>
	</a>
</center>


<?php endif; ?>

<?php if($ESTAT == 'BASES'): ?>

<center>
<table class="hola" id="hola" border="0">
<tr class="hola" id="hola">
<td class="hola" id="hola"></td>
<td class="hola" id="hola" style="width:500px;">
	<a href="<?php echo sfConfig::get('sf_webroot').'images/blogs/Dissenys/biennal/1.jpg'?>" class="MYCLASS"  title="MYTITLE">
		<img id="imatge" src="<?php echo sfConfig::get('sf_webroot').'images/blogs/Dissenys/biennal/1p.jpg'?>" alt="Bases de la Biennal 2010"></img>	
	</a>			
</td>
<td class="hola" id="hola" style="text-align:left">
	<h1>BIENNAL 2010</h1>
	<br />
	<a href="<?php echo sfConfig::get('sf_webroot').'images/blogs/Dissenys/biennal/bases.pdf'?>"><h1>Descarrega't les bases</h1></a>
	<a href="<?php echo url_for('blogs/biennal?ESTAT=FORMULARI') ?>"><h1>Prem per inscriure't-hi</h1></a>
</td>
</tr>
</table>
<center>



<?php endif; ?>


<?php if($ESTAT == 'FORMULARI'): ?>


<div id="centrat">
  <div id="contenidor">
    <span id="titol">Formulari d'inscripció a la Biennal 2010</span>

    <form id="formulari" action="<?php url_for('blogs/biennal'); ?>" method="post" name="formulari" enctype="multipart/form-data"> 
      <table class="formulari">
      	<?php if(isset($MISSATGE)): ?>
        <tr>
        	<td colspan="5" ID="MISSATGE"><?php echo $MISSATGE['TEXT']; ?></td>        	
        </tr>
      	<?php endif; ?>

	        <tr>
	        	<td class="col1">Nom:                </td>
	        	<td class="col2"><input type="text" name="dades[nom]" value="<?php echo $DADES['nom'] ?>"></td>
	        	<td class="col3">&nbsp;</td>
	        	<td class="col4">Cognoms: </td>
	        	<td class="col5"><input type="text" name="dades[cognoms]" value="<?php echo $DADES['cognoms'] ?>"></td>
	        </tr>
	        <tr>
	        	<td class="col1">Domicili: 
	        	<td class="col2"><input type="text" name="dades[domicili]" value="<?php echo $DADES['domicili'] ?>"></td>
	        	<td class="col3">&nbsp;</td>
	        	<td class="col4">Número: </td>
	        	<td class="col5"><input type="text" name="dades[numero]" value="<?php echo $DADES['numero'] ?>"></td>
	        </tr>
	
	        <tr>
	        	<td class="col1">Codi postal: </td>
	        	<td class="col2"><input type="text" name="dades[codi_postal]" value="<?php echo $DADES['codi_postal'] ?>"></td>
	        	<td class="col3">&nbsp;</td>
	        	<td class="col4">Localitat:</td>
	        	<td class="col5"><input type="text" name="dades[localitat]" value="<?php echo $DADES['localitat'] ?>"></td>
	        </tr>
	        <tr>
	        	<td class="col1">Telèfon: </td>
	        	<td class="col2"><input type="text" name="dades[telefon]" value="<?php echo $DADES['telefon'] ?>"></td>
	        	<td class="col3">&nbsp;</td>
	        	<td class="col4">Adreça electrònica: </td>
	        	<td class="col5"><input type="text" name="dades[qreu]" value="<?php echo $DADES['qreu'] ?>"></td>
	        </tr>
	    <?php if(!$ENVIAT):?>     		       
	        <tr>
	        	<td class="col1">Obres presentades**: </td>
	        	<td class="col2"><select name="dades[obres]"><option value="1">Una</option><option value="2">Dues</option><option value="3">Tres</option><option value="4">Quatre</option></option></select></td>
	        	<td class="col3">&nbsp;</td>
	        	<td class="col4">&nbsp;</td>
	        	<td class="col5">&nbsp;</td>
	        </tr>    
	        <tr>
	        	<td class="col1">Obra 1*:</td>
	        	<td colspan="4"><input class="input" type="file" name="arxius[arxiu1]" value="Arxiu1"></td>
	       	</tr>
	
	        <tr>
	        	<td class="col1">Obra 2*:</td>
	        	<td colspan="4"><input class="input" type="file" name="arxius[arxiu2]" value="Arxiu1"></td>
	        </tr>
	        <tr>
	        	<td class="col1">Obra 3*:</td>
	        	<td colspan="1"><input class="input" type="file" name="arxius[arxiu3]" value="Arxiu1"></td>
	        </tr>
	        <tr>
	        	<td class="col1">Obra 4*:</td>
	        	<td colspan="1"><input class="input" type="file" name="arxius[arxiu4]" value="Arxiu1" ></td>
	        </tr>        
	        
	        <tr>
	        	<td id="tdsubmit" colspan="5">
	        		<?php $DINS_PERIODE = (date('Y-m-d',time()) < '2010-04-01'); ?>
	        		<span class="peque">Respon correctament per validar que ets una persona</span>
	        		<br />
	        		<?php echo "$VAL1 sumat a $VAL2 és igual a "?><input class="suma" type="text" name="dades[resultat]" value=""><br />	        		
	        		<br />        		        		
	        		<input id="submit" type="submit" name="submit" value="Envieu el formulari" <?php echo ($DINS_PERIODE)?'ENABLED':'DISABLED'; ?>>
	        		<br />
	        		<?php if(!$DINS_PERIODE): ?>
	        			<span id="missatge">Període de registre de l'1 al 30 de març</span>
	        		<?php endif; ?>
	        	</td>
	        </tr>
 		<?php endif; ?>
      </table>
      <?php if(!$ENVIAT):?>     
      	<div style="text-align:left;"> * Adjunteu un arxiu per obra amb la fotografia, títol, mides, any de realització, preu, instruccions de muntatge...</div> 
      	<div style="text-align:left;">** Si no disposeu de l'obra en format digital o electrònic, podeu lliurar-la o enviar-la per correu postal a <br /> Casa de Cultura (Plaça de l'Hospital, 6)</div>
      <?php endif; ?>

		</form>
  </div>
  </div>
  
<?php endif; ?>
<?php $BASE = OptionsPeer::getString('SF_WEBROOT',1); ?>
<script type="text/javascript" src="<?php echo $BASE.'js/fonts/cufon-yui.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $BASE.'js/fonts/myriad/Myriad_Pro_400.font.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $BASE.'js/fonts/bauhaus/Bauhaus_93_400.font.js'; ?>"></script>

<script type="text/javascript">

	Cufon.replace('.col_content .title', { fontFamily: 'Bauhaus 93' });
	Cufon.replace('.col_content .subtitle', { fontFamily: 'Myriad Pro' });
	Cufon.replace('.col_content .subtitle2', { fontFamily: 'Myriad Pro' });
	Cufon.replace('.col_footer .footer', { fontFamily: 'Myriad Pro' });
	Cufon.replace('.col_footer .tags', { fontFamily: 'Bauhaus 93' });	
	Cufon.replace('.more', { fontFamily: 'Bauhaus 93' });
	Cufon.replace('.FORMULARI .TITOL', { fontFamily: 'Bauhaus 93' });
	Cufon.replace('.FORMULARI .TEXT', { fontFamily: 'Myriad Pro' });
	
	// preload images first (can run before page is fully loaded)
    $(document).ready(function() {

		random();		    	
        
		$(".rollover").hover(
				function() { this.src = this.src.replace("_A","_B"); },
				function() { this.src = this.src.replace("_B","_A"); }
			);
				
		$("#BOTO_FORM_1").click(function(){
			if(valida1()) { $("#form1").submit(); return true; }
			else { return false; }
		});
		
		$("#BOTO_FORM_2").click(function(){
			if(valida2()) { $("#form2").submit(); return true; }
			else { return false; }
		});
				
		$(function() {
			$("#datepicker").datepicker({ 
								dateFormat: 'yy-mm-dd' , 
								monthNames: ['Gener', 'Febrer', 'Març', 'Abril', 'Maig', 'Juny', 'Juliol', 'Agost', 'Setembre', 'Octubre', 'Novembre', 'Desembre'] ,
								firstDay: 1,
								dayNamesMin: ['Dg', 'Dll', 'Dm', 'Dc', 'Dj', 'Dv', 'Ds']
								 });
		});
					
	 });


	function random()
	{
		
    	var rand1 = Math.floor((10)*Math.random()) + 1;
    	var rand2 = Math.floor((10)*Math.random()) + 1;    	

    	$("#val1h").val(rand1);
		$("#val2h").val(rand2);
		$("#val1").html(rand1);
		$("#val2").html(rand2);
		
	}
	
	 
	function valida1()
	{					
		if(!validaEmail($("#email").val())){ alert('El correu electrònic no és correcte.'); return false; }		
		if($("#nom_cognoms_contacte").val().length == 0){ alert('Has d\'entrar un nom de contacte'); return false; }
		if(parseInt($("#val1h").val()) + parseInt($("#val2h").val()) != parseInt($("#resultat").val())) { random(); alert('La suma no és correcta'); return false; }
		return true;		
	}
	
	function valida2()
	{					
		if($("#titol_acte").val().length == 0){ alert('Has d\'entrar un títol.'); return false; }
		if($("#ciutat_acte").val().length == 0){ alert('Has d\'entrar una ciutat.'); return false; }		
		if($("#datepicker").val().length == 0){ alert('Has d\'entrar una data a l\'esdeveniment.'); return false; }
		if(!comprueba_extension($("#arxiu").val())) { return false; }
		return true;					
	}

	function validaEmail(str)
	{
		return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);					
	}
	
	function comprueba_extension(archivo) {
	   extensiones_permitidas = new Array(".jpg");
	   mierror = "";
	   if (!archivo) {
	      //Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario
	      // mierror = "No has escollit cap arxiu";
	      return true;
	   }else{
	      //recupero la extensión de este nombre de archivo
	      extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
	      //alert (extension);
	      //compruebo si la extensión está entre las permitidas
	      permitida = false;
	      for (var i = 0; i < extensiones_permitidas.length; i++) {
	         if (extensiones_permitidas[i] == extension) {
	         permitida = true;
	         break;
	         }
	      }
	      if (!permitida) {
	         mierror = "Només es poden carregar arxius amb extensió: " + extensiones_permitidas.join();	         
	       } 
	       else 
	       { 
	       	return true; 
	       }	    
	   }
	   //si estoy aqui es que no se ha podido submitir
	   alert (mierror);
	   return false;
	} 	
	 
	
</script>


<style>
	table.principal { width:1024px; border:0px solid black; margin-top:20px; }
	a { color: #E95D0F; text-decoration:none; }	
	.main_title { height:200px; }
	.left-col { width:162px; }
	.right-col { width:850px; }
	.content { background-color: #FFFFFF; text-align:left; vertical-align:top; }
	.col_white { width:70px; }
	.col_content { width: 190px; }
	.col_content .title { font-size:26px; color:#162983; }
	.col_content .image { width:70px; margin-right:8px; margin-bottom:5px;}
	.col_content .subtitle { font-size:14px; color:#162983;  }
	.col_content .subtitle2 { font-size:14px; color:#006AB2;  }
	.col_content .text { margin-top:15px; margin-bottom:15px; font-size:12px; color:black; text-align:left; }
	.col_content { height: 180px; }
	.col_footer { height: 50px; }	
	.col_footer .footer { color: #E95D0F; font-size:14px; text-align:right; }		
	.col_footer .tags { color: #E95D0F; font-size:16px; font-weight:bold; text-align:right; }	
	.row_sep { height: 25px; }	
	table.list { width:100%; }
	.more { color:#162983; font-size:14px; }
	.more a { color:#162983; font-size:14px; text-decoration:none; }
	.more a:hover { color: #5063BA; }
	.boto { border:0px; background-color:white; }
	.boto:hover { border:0px; background-color:white; }
	.boto:visited {border:0px; background-color:white; }		
	.image_gran { width:200px; margin-right:20px; margin-bottom:15px; }
	.right { text-align:right; padding-right:100px; }
	.FORMULARI {  }

	.FORMULARI .TEXT { font-size:14px; color:#162983;  }
	.FORMULARI .TITOL { font-size:16px; color:#162983; }
	.FORMULARI .textarea { font-size:16px; color:#162983; }
	.FORMULARI input { font-size:14px; vertical-align:middle; }
	.FORMULARI select { font-size:14px; vertical-align:middle; }
	
	
	
	div.falso { position: absolute; top: -2px; left: 0px; z-index: 0; }
	input.file { position: relative; filter:alpha(opacity: 0); opacity: 0; z-index: 1; }
	
	form label { 
	display: inline;  /* block float the labels to left column, set a width */
	float: left;	 
	padding: 0;
	padding-left:5px;	
	margin: 5px 0 0; /* set top margin same as form input - textarea etc. elements */
	text-align: left; 
	} 
	
	form input { display: inline; float:left; }
	
						
</style>

<center>
<table class="principal">
<tr>
	<td class="left-col main_title"><a href="<?php echo url_for('@noticies_culturals?MODE=CONTINGUT') ?>"><?php echo image_tag('blogs/Dissenys/noticies_culturals/blog_02.png')?></a></td>
	<td class="right-col main_title"><?php echo image_tag('blogs/Dissenys/noticies_culturals/blog_03.png')?></td>
</tr>
<tr>
	<td class="left-col" style="vertical-align:top; padding-top:40px;">
		<a href="<?php echo url_for('@noticies_culturals?MODE=CONTINGUT&PAGE_ID='.$PAGE_ID_QUE_ESTA_PASSANT) ?>"><?php echo image_tag('blogs/Dissenys/noticies_culturals/B1_A.png',array('class'=>'rollover','alt'=>'Què està passant?'))?></a><br />
		<a href="<?php echo url_for('@noticies_culturals?MODE=CONTINGUT&PAGE_ID='.$PAGE_ID_QUE_PASSARA) ?>"><?php echo image_tag('blogs/Dissenys/noticies_culturals/B2_A.png',array('class'=>'rollover','alt'=>'Què passarà?'))?></a><br />
		<a href="<?php echo url_for('@noticies_culturals?MODE=CONTINGUT&PAGE_ID='.$PAGE_ID_QUE_HA_PASSAT) ?>"><?php echo image_tag('blogs/Dissenys/noticies_culturals/B3_A.png',array('class'=>'rollover','alt'=>'Què ha passat?'))?></a><br />			
	</td>
	<td class="right-col content">
	<?php if($MODE == 'CONTINGUT'): ?>				
		<?php if(isset($NOTICIA)): printEntry($NOTICIA); else: printEntries($NOTICIES); endif; ?>
	<?php elseif($MODE == 'FORM1'): ?>				
		<?php echo printForm1($FORM1); ?>		
	<?php elseif($MODE == 'FORM2'): ?>
		<?php echo printForm2($FORM2); ?>
	<?php elseif($MODE == 'FORM_OK'): ?>
		<?php echo printFormOK(); ?>
	<?php endif; ?>
	</td>
</tr>
<tr>
	<td colspan="2" class="right-col">
	<?php if($MODE == 'CONTINGUT'): ?>				
		<a href="<?php echo url_for('@noticies_culturals?MODE=FORM1') ?>"> <?php echo image_tag('blogs/Dissenys/noticies_culturals/blog_12.png')?> </a></td>
	<?php elseif($MODE == 'FORM1'): ?>						
		<?php echo image_tag('blogs/Dissenys/noticies_culturals/form_foot_1.png')?></td>		
	<?php elseif($MODE == 'FORM2'): ?>
		<?php echo image_tag('blogs/Dissenys/noticies_culturals/form_foot_1.png')?></td>
	<?php endif; ?>
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
		La informació recollida en aquest blog ha estat facilitada directament per les pròpies entitats.
	</td>
</tr>
</table>	
</center>


<?php 


	function printForm1($FORM)
	{
				
		?>
		<form id="form1" method="POST" action="<?php echo url_for('@noticies_culturals?MODE=FORM2'); ?>" enctype="multipart/form-data">
	
		<div class="FORMULARI">
		
			<div class="TITOL"> DADES DE L'ENTITAT I PERSONA QUE ENVIA LA INFORMACIÓ </div>			
			<div class="TEXT" > Abans de seguir endavant amb el formulari, cal que ens faciliteu les vostres dades de contacte </div>			
			<div style="margin-top:20px;" class="TITOL">Nom de l'entitat, empresa, institució organisme responsable<br />
				<input style="width:840px" type="text" name="dades[nom_entitat]" value="<?php echo $FORM['nom_entitat']; ?>" />
			</div>			
			<div style="clear:both; padding-top:22px;"><span class="TITOL">Dades de la persona responsable</span></div>
			<br />
			<div style="clear:both;">
				<label style="width:150px"><span class="TEXT">Nom i cognoms </span></label>
					<input style="width:690px" type="text" id="nom_cognoms" name="dades[nom_cognoms]" value="<?php echo $FORM['nom_cognoms']; ?>" />
			</div>
						
			<div style="clear:both;">
				<label style="width:400px"><span class="TEXT">Lloc que ocupa a l'entitat, empresa, institució o orgnisme </span></label>
						<input style="width:440px;" type="text" name="dades[lloc_ocupa]" value="<?php echo $FORM['lloc_ocupa']; ?>" />
			</div>
			
			<div style="clear:both; padding-top:22px;" class="TITOL">Dades de la persona de contacte (dades de contacte per a possibles comunicacions)</div>			
			<div style="clear:both; margin-top:10px;">
				<label style="width:150px;"><span class="TEXT">Nom i cognoms </span></label>
					<input style="width:690px;" type="text" id="nom_cognoms_contacte" name="dades[nom_cognoms_contacte]" value="<?php echo $FORM['nom_cognoms_contacte']; ?>" />
			</div>	

			<div style="clear:both;">			
				<label style="width:150px;"><span class="TEXT">Adreça </span></label>
					<input style="width:300px;" type="text" name="dades[adreca]" value="<?php echo $FORM['adreca']; ?>" />
				<label style="width:150px;"><span class="TEXT"> Codi Postal</span></label>
					<input style="width:235px;" type="text" name="dades[codi_postal]" value="<?php echo $FORM['codi_postal']; ?>" />
			</div>
			<div style="clear:both;">
				<label style="width:150px;"><span class="TEXT">Municipi</span></label>
						<input style="width:300px;" type="text" name="dades[municipi]" value="<?php echo $FORM['municipi']; ?>" />
				<label style="width:150px;"><span class="TEXT">Comarca</span></label>
						<input style="width:235px;" type="text" name="dades[comarca]" value="<?php echo $FORM['comarca']; ?>" />
			</div>
			<div style="clear:both;">
				<label style="width:150px;"><span class="TEXT">Telèfons</span></label>
						<input style="width:300px;" type="text" name="dades[telefons]" value="<?php echo $FORM['telefons']; ?>" />
				<label style="width:150px;"><span class="TEXT"> Adreça electrònica</span></label>
						<input style="width:235px;" type="text" id="email" name="dades[email]" value="<?php echo $FORM['email']; ?>" />
			</div>
					
			<div style="padding-top:30px; clear:both;">				
				<label style="width:450px;" class="TITOL">Respon correctament per validar: <span class="TITOL" id="val1"></span>&nbsp;sumat a <span class="TITOL" id="val2"></span>&nbsp;és igual a </label>
					<input style="width:50px" type="text" name="dades[resultat]" id="resultat" class="input" />							
			</div>
			<div style="margin-top:20px; clear:both; text-align:right;">				
				<div class="TITOL"><button id="BOTO_FORM_1" class="more boto" >segueix omplint el formulari <?php echo image_tag('blogs/Dissenys/noticies_culturals/cercle.png')?></button></div>
			</div>
			<div style="clear:both; margin-top:30px;">
				<span style="font-size:10px;" class="text">Les seves dades seran incorporades a un fitxer titularitat de la Fundació Casa de Cultura amb la finalitat de gestionar els seus serveis i activitats. La Casa de Cultura es compromet a complir els seus deures de mantenir reserva i d’adoptar les mesures legalment previstes i les tècnicament necessàries per evitar-ne un accés a qualsevol classe de tractament no autoritzat. No seran cedides a terceres persones sense el seu consentiment. En qualsevol cas vostè pot exercir els seus drets d’accés, rectificació i cancel•lació tot adreçant-se a: Sr/a. Director/a de la casa de Cultura, Plaça de l’Hospital 6, 17002 Girona, telèfon 972 202 013 i correu electrònic: secretaria@casadecultura.cat
					<br /><br />La Casa de Cultura es guarda el dret a no publicar notícies que no hagin estat ben tractades i no es responsabilitza de la correcció de textos. La notícia es publicarà exactament com l'envieu.				
				</span>
			</div>										
		</div>
								
		<input type="hidden" id="val1h" value=""></input>
		<input type="hidden" id="val2h" value=""></input>
		</form>
		
		<?php 
	}

	function printForm2($FORMULARI)
	{
		?>		
		<form id="form2" action="<?php echo url_for('@noticies_culturals?MODE=ENVIA_FINALITZA') ?>" method="POST" enctype="multipart/form-data">
		
		
		<div class="FORMULARI">
			<div style="clear:both; padding-top:5px; ">
				<label style="width:150px" class="TITOL">TÍTOL</label>
					<input style="width:700px" id="titol_acte" type="text" name="dades[titol]" maxlength="30">
			</div>
			<div style="clear:both; padding-top:5px; ">
				<label style="width:150px" class="TITOL">Subtítol</label>
					<input style="width:700px" type="text" name="dades[subtitol1]">
			</div>		

			<div style="clear:both; padding-top:5px;">
				<label style="width:150px" class="TITOL">Ciutat</label>
					<input style="width:300px" id="ciutat_acte" size="10" type="text" name="dades[ciutat_acte]">
				<label style="width:150px" class="TITOL">Data de l'acte</label>
					<input style="width:245px" type="text" id="datepicker" name="dades[dia_acte]">									
			</div>		
			
			<div style="clear:both; padding-top:5px;">
				<label style="width:150px" class="TITOL">Pagina web</label>
					<input style="width:700px" type="text" name="dades[web]">												
			</div>		
	
			<div style="clear:both; padding-top:5px;">
				<label style="width:150px" class="TITOL">Imatge</label>
					<input style="width:300px" type="file" name="arxius[arxiu]" id="arxiu">
				<label style="width:150px" class="TITOL">Tipus de notícia</label>
					<?php echo TipusSelect() ?>									
			</div>
			
			<div style="clear:both; padding-top:5px;">
				<label style="width:150px" class="TITOL">Text</label>
					<textarea style="width:700px" rows="20" name="dades[text]"></textarea>												
			</div>														
		
			<div style="clear:both; text-align:right; padding-top:20px;" class="TITOL">
				<button name="ENVIA_FINALITZA" id="BOTO_FORM_2" class="more boto" >finalitza i envia el formulari<?php echo image_tag('blogs/Dissenys/noticies_culturals/cercle.png')?></button>
			</div>
			
			<div style="clear:both; text-align:justify; padding-top:20px;">			
				<span style="font-size:10px;" class="text">Les seves dades seran incorporades a un fitxer titularitat de la Fundació Casa de Cultura amb la finalitat de gestionar els seus serveis i activitats. La Casa de Cultura es compromet a complir els seus deures de mantenir reserva i d’adoptar les mesures legalment previstes i les tècnicament necessàries per evitar-ne un accés a qualsevol classe de tractament no autoritzat. No seran cedides a terceres persones sense el seu consentiment. En qualsevol cas vostè pot exercir els seus drets d’accés, rectificació i cancel•lació tot adreçant-se a: Sr/a. Director/a de la casa de Cultura, Plaça de l’Hospital 6, 17002 Girona, telèfon 972 202 013 i correu electrònic: secretaria@casadecultura.cat</span>
			</div>
		</form>
		
		<?php 
	}

	
	function printFormOK()
	{
		?>
				
		<table class="FORMULARI" width="100%">
		<tr><td class="TITOL">El formulari ha estat enviat correctament.</td></tr>									
		</table>
		
		<?php 
	}
	
	
	function TipusSelect()
	{
		
		$ret  = '';
		$ret .= '<select class="input" name="dades[tipus]">';
		$ret .= '<option class="input" value="Espectacle">Espectacle</option>';
		$ret .= '<option class="input" value="Exposició">Exposició</option>';
		$ret .= '<option class="input" value="Infantil">Infantil</option>';
		$ret .= '<option class="input" value="Novetat editorial">Novetat editorial</option>';
		$ret .= '<option class="input" value="Oferta per a programadors">Oferta per a programadors</option>';
		$ret .= '<option class="input" value="Formació per a tècnics">Formació per a tècnics</option>';
		$ret .= '<option class="input" value="Conferència o debat">Conferència o debat</option>';
		$ret .= '<option class="input" value="Altres">Altres</option>';
		$ret .= '</select>';
		
		return $ret;
		
	}
	

	function printEntry($NOTICIA)
	{
		
		$OOM = $NOTICIA->getAppBlogMultimediaEntriessJoinAppBlogsMultimedia(new Criteria());						
		if(isset($OOM[0])):
			$OOM = $OOM[0]->getAppBlogsMultimedia();
			$img = '<img class="image_gran" align="LEFT" src="'.$BASE.'images/blogs/'.$OOM->getUrl().'" alt="'.$OOM->getDesc().'" />';
			$text2 = $NOTICIA->getBody();				
			$text = $img.$text2;
		else:
			$text2 = $NOTICIA->getBody(); 
			$text = $text2;					
		endif; 
		
		echo '<table><tr><td style="font-size:14px; text-align:justify; line-height:25px;">';	
		echo $text;
		echo '</td></tr>';
		echo '<tr><td class="more right"><a href="'.url_for('@noticies_culturals').'">Tornar</a></td></tr>';
		echo '</table>';
		
	}
	
	
	function printEntries($PAGES)
	{
				
		$RET = array();
		
		foreach($PAGES->getResults() as $OO):
						
			$OOM = $OO->getAppBlogMultimediaEntriessJoinAppBlogsMultimedia(new Criteria());						
			if(isset($OOM[0])):
				$OOM = $OOM[0]->getAppBlogsMultimedia();
				$img = '<img class="image" align="LEFT" src="'.$BASE.'images/blogs/'.$OOM->getUrl().'" alt="'.$OOM->getDesc().'" />';
				$text2 = substr($OO->getBody(),0,150);				
				$text = $img.$text2.'...';
			else:
				$text2 = substr($OO->getBody(),0,200); 
				$text = $text2.'...';					
			endif; 
						
			$RET[] = fillCell($OO,$text);
															
		endforeach;
						
		for($l = sizeof($RET); $l < 6; $l++):
			$RET[] = fillCell(null,null,true);
		endfor;
		
		$WHITE[0] = '<td class="col_white" rowspan="2">&nbsp;</td>';		
		
		echo '<center>';
		echo '<table class="list">';
		echo '<tr><td style="row_sep" colspan="7">&nbsp;</td></tr>';				
		for($j = 0; $j < 2; $j++):
			for($k=0; $k < 2; $k++):				
				echo '<tr class="col_white" rowspan="3">';				
				for($i = 0; $i < 3 ; $i++):
					if($k==0) echo $WHITE[0]; //Només el 0 perquè tenim un rowspan				
					if(isset($RET[($j*3)+$i])) echo $RET[($j*3)+$i][$k];
				endfor;
				if($k==0) echo $WHITE[0]; //Només el 0 perquè tenim un rowspan				
				echo '</tr>';				
			endfor;						
			echo '</tr><tr><td style="row_sep" colspan="7">&nbsp;</td></tr>'; 			
		endfor;
		if($PAGES->haveToPaginate() && $PAGES->getPage() != $PAGES->getLastPage()):								
			echo '</tr><tr><td style="row_sep" colspan="5">&nbsp;</td>
						<td class="more"><a href="'.url_for('@noticies_culturals?PAGINA='.$PAGES->getNextPage()).'">veure\'n més</a></td>
						<td>&nbsp;</td>
						</tr>';
		endif;
		echo '</tr><tr><td style="row_sep" colspan="7">&nbsp;</td></tr>';
		echo '</table>';
		echo '</center>';
						
	}
	
	
	function fillCell($OO,$text,$blank = false)
	{
						
		$RET = array();
		if(!$blank):						 	
			$RET[0]  = '<td class="col_content">';
			$RET[0] .= '<div class="title">'.$OO->getTitle().'</div>';
			$RET[0] .= '<div class="subtitle">'.$OO->getSubtitle1().'</div>';
			$RET[0] .= '<div class="subtitle2">'.$OO->getSubtitle2().'</div>';						
			$RET[0] .= '<div class="text">'.$text.'</div></td>';
			
			$RET[1]  = '<td class="col_footer"><div class="footer"><a href="'.url_for('@noticies_culturals?NOTICIA_ID='.$OO->getId()).'">+ llegir tota la notícia</a></div>';
			$url = $OO->getUrl();			
			if(strlen($url) > 9) $RET[1] .= '<div class="footer"><a target="_NEW" href="'.$url.'">entrar al web</a></div>';
			$RET[1] .= '<div class="footer tags">'.$OO->getTags().'</div>';
			$RET[1] .= '</td>';
		else: 
			$RET[0] = '<td class="col_content">&nbsp;</td>';
			$RET[1] = '<td class="col_footer">&nbsp;</td>';			
		endif; 
		
		return $RET;
	}

?>

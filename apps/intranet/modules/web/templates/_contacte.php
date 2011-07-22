<?php use_helper('Form')?>
<style>
.LEGEND_CONTACTE { font-size:12px; font-weight:bold; padding:10px 10px 10px 10px; }
FIELDSET { border:2px solid #CCCCCC; padding:10px; margin-right:40px; }
.TITOL_CATEGORIA { background-color: #FFF4F4; color:black; font-weight:bold; padding:5px; }
.TOP   { vertical-align:top;}
input.CONTACTE { border:1px solid #CCCCCC; }
TEXTAREA.CONTACTE { border: 1px solid #CCCCCC; }
.ENVIAT { font-size: 12px; padding-left:10px; padding-bottom: 10px; }
.FORMULARI TH { text-align:right; padding-right:10px; }
</style>

<TD colspan="3" class="CONTINGUT">

<?php if(!$ENVIAT): ?>

	<form action="<?php echo url_for('web/enviaContacte')?>" method="post">
   
		<FIELDSET class="REQUADRE">
            <LEGEND style="padding:5px; font-size:12px; font-weight:bold;">Contacta'ns</LEGEND>   
	    	<TABLE class="FORMULARI">
	    	<TR><TD style="width:100px"></TD><TD></TD></TR>
	    	<?php echo $FConsulta; ?>  	  
			<TR><TD></TD><TD><BR /><?php echo submit_tag('Envia missatge',array('class'=>'BOTO_ACTIVITAT'));?></TD> </TR>
			</TABLE>
	   	</FIELDSET>
	   	
	</form>
   <?php else: ?>
   
   <FIELDSET><LEGEND class="LEGEND LEGEND_CONTACTE">Contacta'ns</LEGEND>   
    <div class="ENVIAT"> Missatge enviat correctament. Segueix <?php echo link_to('navegant.','web/index') ?></div>    
   </FIELDSET>      
   
   <?php endif; ?>
   
   
   
   <DIV STYLE="height:40px;"></DIV>
   
</TD>
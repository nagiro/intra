<script type="text/javascript">
	function visible(idA)
	{
		if($('#DIV'+idA+':hidden').length) $('#DIV'+idA).fadeIn(2000);
		else  $('#DIV'+idA).fadeOut(2000);				
	}
</script>


<style>
	a.tt3:hover span { display:block; }  
	a.tt3 span { display:none; }
</style>

    <TD colspan="2" class="CONTINGUT">
    	<TABLE class="BOX">
    	<TR>
			<TD class="NOTICIA">
				<DIV class="TITOL">Durant el mes <?php echo generaMes($DATA) ?> hi ha <?php echo $QUANTES ?> activitats coincidents de les quals <?php echo sizeof($ACTIVITATS_LLISTAT) ?> són consultables. </DIV>
				<DIV class="TEXT">
					<?php foreach($ACTIVITATS_LLISTAT as $ID => $ACTIVITAT): ?>
					<?php $text = $ACTIVITAT['TEXT'].'<br /><br />'.implode(' - ',$ACTIVITAT['DIES']); ?>
					<div class="TEXT">
						<a href="<?php echo url_for('web/index') ?>" ><?php echo $ACTIVITAT['TITOL'] ?></a>
						<a href="#" onClick="visible('<?php echo $ID ?>')"><?php echo image_tag('intranet/llegirmes.png',array('style'=>'vertical-align:bottom;')) ?> </a>
						<div style="border:1px solid black; padding:5px;" class="AMAGAT" id="DIV<?php echo $ID ?>">
							<?php echo $text ?>
						</div>					
					</div>					
					<?php endforeach; ?>
					</DIV>								
			</TD>
		</TR>
		</TABLE>    
	<?php
    	  		    	 	 			
		
		   	      	
	?>
			         
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    
<?php  

	function generaMes($DATE)
	{
		$ret = "";
		switch(date('m',$DATE)){
			case '01': $ret .= " de gener"; break;
			case '02': $ret .= " de febrer"; break;
			case '03': $ret .= " de març"; break;
			case '04': $ret .= " d'abril"; break;
			case '05': $ret .= " de maig"; break;
			case '06': $ret .= " de juny"; break;
			case '07': $ret .= " de juliol"; break;
			case '08': $ret .= " d'agost"; break;
			case '09': $ret .= " de setembre"; break;
			case '10': $ret .= " d'octubre"; break;
			case '11': $ret .= " de novembre"; break;
			case '12': $ret .= " de desembre"; break;
		}
			
		return $ret;
		
	}
    
?>
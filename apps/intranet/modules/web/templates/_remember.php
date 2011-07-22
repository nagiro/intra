<STYLE>
.BOX TD { PADDING:5PX; }
.CERCA { font-size:10px; }
#registra {  }
</STYLE>

    <TD colspan="3" class="CONTINGUT">
    
		<form action="<?php echo url_for('web/remember') ?>" method="POST" name="form_login">    
		    <DIV class="REQUADRE" style="width:400px">
		    	<table class="FORMULARI">
		    	<?php     if(!$ENVIAT):?>
		    	
					    	   <?php if($ERROR != ""): ?><tr><td class="error" colspan="2"><?php echo $ERROR?></td></tr><?php endif; ?>
					    	   <?php echo $FREMEMBER; ?>					    	   
					           <tr><td width="100px"></td><td><input type="submit" value="Envia'm la contrasenya" name="BREMEMBER" /></td></tr>
					           
			    	<?php else: ?>
			    	
								<tr><td colspan="2">La seva contrasenya li ha estat enviada al correu electrònic que vostè ens va indicar o va donar d'alta.</td></tr>					    	   
			    				    	
			    	<?php endif; ?>  
		       </table>
		    </DIV>
	    </form>   
            
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

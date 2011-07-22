<STYLE>
.BOX TD { PADDING:5PX; }
.CERCA { font-size:10px; }
#registra {  }
</STYLE>

    <TD colspan="3" class="CONTINGUT_ADMIN">
    
		<form action="<?php echo url_for('gestio/uRemember') ?>" method="POST" name="form_login">    
		    <DIV class="REQUADRE" style="width:400px">
		    	<table class="FORMULARI">
		    	<?php     if(!$ENVIAT):?>
		    	
					    	   <?php if($ERROR != ""): ?><tr><td class="error" colspan="2"><?php echo $ERROR?></td></tr><?php endif; ?>
					    	   <?php echo $FREMEMBER; ?>					    	   
					           <tr>
                                <td width="100px"></td>
                                <td>
                                    <button type="submit" class="BOTO_ACTIVITAT" name="BREMEMBER">
                                        <?php echo image_tag('template/email.png').' Envia\'m la contrasenya' ?>                                        
                                    </button>                                                                                                                
                                                                        
                                </td></tr>
					           
			    	<?php else: ?>
			    	
								<tr><td colspan="2">La seva contrasenya li ha estat enviada al correu electrònic que vostè ens va indicar o va donar d'alta.</td></tr>					    	   
			    				    	
			    	<?php endif; ?>  
		       </table>
               <?php echo link_to(image_tag('template/arrow_left.png').' Tornar','gestio/uLogin') ?>
		    </DIV>
	    </form>   
            
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
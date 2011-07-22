<?php use_helper('Form'); ?>
   
    <TD colspan="3" class="CONTINGUT_ADMIN">
      
    <?php include_partial('breadcumb',array('text'=>'CANVI DE LLOC')); ?>                      
      
	<form action="<?php echo url_for('gestio/gChangeSite') ?>" method="POST">
	
	 	<div class="REQUADRE fb">	 						 	 		
	 		<div class="FORMULARI fb">
                <?php echo select_tag('IDS',options_for_select($SITES,$IDS)); ?>	 			
	 			<button class="BOTO_ACTIVITAT" name="BSAVE">Canvia de lloc</button>	 					
	 		</div>	 			 	 	
      	</div>
			
	</form>      
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    
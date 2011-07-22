<?php 

	$text  = (isset($TEXT))?$TEXT:"Cerca:";
	$tipus = (isset($TIPUS))?$TIPUS:'Simple';	


?>

<?php if($tipus == 'Simple'): ?> 

<DIV class="REQUADRE">
    <div class="FORMULARI">
    	
    		<span style="width:30px;"><b>Cerca:</b><br /><?php echo $FCerca['text']->render(); ?></span>
    	
    	
    	<?php foreach($BOTONS as $B): ?>	    			    	
    		<span><button type="submit" name="<?php echo $B['name']; ?>"><?php echo $B['text']; ?></button></span>
    	<?php endforeach; ?>
    	 
    </div>	    	
</DIV>

<?php elseif($tipus == 'Select'): ?>

<DIV class="REQUADRE">
    <div class="FORMULARI">
    	
    		<span style="width:30px;"><b>Cerca:</b><br /><?php echo $FCerca['text']->render(); ?></span>
    		<span style="width:30px;"><?php echo $FCerca['select']->render(); ?></span>    	
    	<?php foreach($BOTONS as $B): ?>	    			    	
    		<span><button type="submit" name="<?php echo $B['name']; ?>"><?php echo $B['text']; ?></button></span>
    	<?php endforeach; ?>
    	 
    </div>	    	
</DIV>
	

<?php endif; ?>
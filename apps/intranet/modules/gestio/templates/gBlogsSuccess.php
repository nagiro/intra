<?php use_helper('Form')?>
 	
 	<script type="text/javascript">
	
	 $(document).ready(function() {				
		$('#APP_MENU').change(updatePage);
		$('#APP_PAGE').change(updateEntry);
		updatePage();
		updateEntry();
		$("#tabs").tabs();
		afegirArxiu();
		$('.hidden1').fadeIn(0);
	 	$('.hidden2').fadeOut(0);
	 });

	function Activa(id)
	{
		$('#hidden1_'+id).fadeOut(0);
	 	$('#hidden2_'+id).fadeIn(500);
	}

	function Desactiva(id)
	{
		$('#hidden2_'+id).fadeOut(0);
	 	$('#hidden1_'+id).fadeIn(500);
	}


	function afegirArxiu()
	{
		var num = parseInt($('#comptador').val())+parseInt(1);
		$('#comptador').attr('value',num);
		$('#files').append('<br /><input type="file" name="arxiu[' + num + ']" /><input type="text" name="desc[' + num + ']" value="Entra una breu descripció..." />');		
		return false; 
	}
	
	function removeArxiu(id)
	{		
		$("#arxiu"+id).remove();
		return false; 		
	}

	
	function updatePage()
	{
		 var MENU_ID = $('#APP_MENU option:selected').val();
		 
		 $.post(
				 '<?php echo url_for('gestio/gBlogs') ?>', 
				 { accio: "AJAX_MENU", APP_MENU: MENU_ID , APP_BLOG: <?php echo $APP_BLOG ?> , APP_PAGE: <?php echo $APP_PAGE ?> },
				   function(data){
					   $('#APP_PAGE').html(data);				     
				   });		 	 
	}

	function updateEntry()
	{
		 var PAGE_ID = $('#APP_PAGE option:selected').val();
		 
		 $.post(
				 '<?php echo url_for('gestio/gBlogs') ?>', 
				 { accio: "AJAX_PAGE", APP_PAGE: PAGE_ID , APP_ENTRY: <?php echo $APP_ENTRY ?> },
				   function(data){
					 $('#APP_ENTRY').html(data);				     
				   });
					 
	}

	function esborraImatge(id)
	{		
		 $.post(
				 '<?php echo url_for('gestio/gBlogs') ?>', 
				 { accio: "DELETE_IMAGE", APP_MULTIMEDIA: id },
				   function(data){
					   $("#img"+id).fadeOut(2000);				     
				   });
	   		 	 
	}

	function SubmitEstat( sel , id )
	{
		
		 $.post(
				 '<?php echo url_for('gestio/gBlogs') ?>', 
				 { accio: "AJAX_ESTAT_FORM", APP_FORM_ENTRY: id, ESTAT: sel.options[sel.selectedIndex].value },
				   function(data){
					   alert(data);				     
				   });		 	 
	}

	function GuardaComentari( id )
	{
		
		 $.post(
				 '<?php echo url_for('gestio/gBlogs') ?>', 
				 { accio: "AJAX_SAVE_OBJECCIONS", APP_FORM_ENTRY: id, OBJECCIONS: $("#objeccio_"+id).val() },
				   function(data){
					   alert(data);				     
				   });		 	 
	}

		
	</script>
	
	<style>
		.hidden2 { border:1px solid gray; }
	</style>
 
    <TD colspan="3" class="CONTINGUT_ADMIN">

	<?php include_partial('breadcumb',array('text'=>'BLOGS')); ?>
	                   	                   
     <form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST">     	
	 	<div class="REQUADRE">		 	            
		 	<div class="titol">
		 		Tractament de blogs 
		 	</div>
		 	<div class="Desplegable">
		 		<select name="APP_BLOG">
		 			<?php echo $BLOGS_ARRAY ?>
		 		</select>	
		 	</div>
		 	<BR />
		 	<input type="submit" value="Veure contingut" class="BOTO_ACTIVITAT" name="B_VIEW_CONTENT">
		 	<input type="submit" value="Edita" class="BOTO_ACTIVITAT" name="B_EDIT_BLOG">
		 	<input type="submit" value="Nou" class="BOTO_ACTIVITAT" name="B_NEW_BLOG">
		 	<input type="submit" value="Veure estadístics" class="BOTO_ACTIVITAT" name="B_VIEW_STADISTICS">		 	
      	</div>
      	</form>

<?php if(isset($FORM_BLOG)): ?>

	<form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST">
	 	<div class="REQUADRE">
	 	<div class="OPCIO_FINESTRA">
	 		<a href="<?php echo url_for('gestio/gBlogs?accio=VB') ?>"><?php echo image_tag('icons/Grey/PNG/action_delete.png') ?></a></div>            
	 	<div class="titol">
	 		Edició de blogs 
	 	</div>
	    	<table class="FORMULARI" width="600px">	    	                  			    
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FORM_BLOG ?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<button name="B_SAVE_BLOG" class="BOTO_ACTIVITAT">Guarda</button>
						<button name="B_DELETE_BLOG" class="BOTO_ACTIVITAT">Elimina</button>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         
     
<?php ENDIF; ?>


<?php if(isset($MENUS_ARRAY)): ?>    

     <form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST">
        <?php echo input_hidden_tag('APP_BLOG',$APP_BLOG); ?>     	
	 	<div class="REQUADRE">
		 	<div class="OPCIO_FINESTRA">
		 		<a href="<?php echo url_for('gestio/gBlogs?accio=VB') ?>"><?php echo image_tag('icons/Grey/PNG/action_delete.png') ?></a></div>            
		 	<div class="titol">
		 		Edició de blogs 
		 	</div>
		 	<div class="Desplegable">
		 		<table>
			 		<tr>
			 			<td>
			 				<select id="APP_MENU" style="width:300px;" name="APP_MENU"><?php echo $MENUS_ARRAY ?></select>
			 			</td>
			 			<td>
			 				<button class="BOTO_ACTIVITAT" name="B_EDIT_MENU">Edita</button>	 				 			 			 		      				 	
			 				<button class="BOTO_ACTIVITAT" name="B_NEW_MENU">Afegeix</button>		 						
			 			</td>
			 		</tr>	
				 	<tr>
				 		<td><select id="APP_PAGE" style="width:300px;" name="APP_PAGE"><?php echo $PAGES_ARRAY ?></select></td>
				 		<td>				 							 					 			
			 				<button class="BOTO_ACTIVITAT" name="B_EDIT_PAGE">Edita</button>	 				 			 			 		      				 	
			 				<button class="BOTO_ACTIVITAT" name="B_NEW_PAGE">Afegeix</button>
			 						 						
				 		</td>
				 	</tr>
				 	<tr>
					 	<td><select id="APP_ENTRY" style="width:300px;" name="APP_ENTRY"><?php echo $ENTRIES_ARRAY ?></select></td>
					 	<td>					 		
			 				<button class="BOTO_ACTIVITAT" name="B_EDIT_ENTRY">Edita</button>
			 				<button class="BOTO_ACTIVITAT" name="B_NEW_ENTRY">Afegeix</button>	 				 			 			 		      				 				 						 									 			
					 	</td>
					</tr>
					<tr>
					 	<td><br /></td>
					 	<td><br /></td>
					</tr>
					<tr>
					 	<td><select id="APP_FORM" style="width:300px;" name="APP_FORM"><?php echo $FORMS_ARRAY ?></select></td>
					 	<td>					 		
			 				<button class="BOTO_ACTIVITAT" name="B_VIEW_FORM">Visualitza</button>			 					 				 			 			 		      				 				 						 									 					 				
					 	</td>
					</tr>
					
					
			 	</table>
		 	</div>
		 		 
      	</div>
      	</form>

<?php ENDIF; ?>
<?php if(isset($FORM_MENU)): ?>    

	<form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST">
	 	<div class="REQUADRE">
	 	<div class="OPCIO_FINESTRA">
	 		<a href="<?php echo url_for('gestio/gBlogs?accio=VIEW_CONTENT') ?>"><?php echo image_tag('icons/Grey/PNG/action_delete.png') ?></a></div>            
	 	<div class="titol">
	 		Editant el menú:  
	 	</div>
	    	<table class="FORMULARI" width="600px">	    	                  			    
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FORM_MENU ?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<button name="B_SAVE_MENU" class="BOTO_ACTIVITAT">Guarda</button>
						<button name="B_DELETE_MENU" class="BOTO_ACTIVITAT">Elimina</button>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         

              
<?php ENDIF; ?>
<?php if(isset($FORM_PAGE)): ?>    

	<form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST">
        <?php echo input_hidden_tag('APP_BLOG',$APP_BLOG); ?>
        <?php echo input_hidden_tag('APP_MENU',$APP_MENU); ?>                        
	 	<div class="REQUADRE">
	 	<div class="OPCIO_FINESTRA">
	 		<a href="<?php echo url_for('gestio/gBlogs?accio=VIEW_CONTENT') ?>"><?php echo image_tag('icons/Grey/PNG/action_delete.png') ?></a></div>            
	 	<div class="titol">
	 		Editant la pàgina:  
	 	</div>
	    	<table class="FORMULARI" width="600px">	    	                  			    
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FORM_PAGE ?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<button name="B_SAVE_PAGE" class="BOTO_ACTIVITAT">Guarda</button>
						<button name="B_DELETE_PAGE" class="BOTO_ACTIVITAT">Elimina</button>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         

              
<?php ENDIF; ?>

<?php if(isset($FORM_ENTRY)): ?>    

	<form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST" enctype="multipart/form-data">
        <?php echo input_hidden_tag('APP_BLOG',$APP_BLOG); ?>
        <?php echo input_hidden_tag('APP_MENU',$APP_MENU); ?>
        <?php echo input_hidden_tag('APP_PAGE',$APP_BLOG); ?>
	 	<div class="REQUADRE">
	 	<div class="OPCIO_FINESTRA">
	 		<a href="<?php echo url_for('gestio/gBlogs?accio=VIEW_CONTENT') ?>"><?php echo image_tag('icons/Grey/PNG/action_delete.png') ?></a></div>            
	 	<div class="titol">
	 		Editant una entrada:  
	 	</div>
	    	<table class="FORMULARI" width="600px">	    	                  			    
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FORM_ENTRY ?>
                <tr>
                	<th>Galeria: </th>
                	<td>
                		<?php echo DibuixaGaleria($GALLERY); ?>                		
                	</td>
                </tr>                								
                
                <tr>
                	<th>Afegir arxius: </th>
                	<td id="files">
                		<input type="hidden" id="comptador" value="1">
                		<span onClick="afegirArxiu();">+</span>
                	</td>
                </tr>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<button name="B_SAVE_ENTRY" class="BOTO_ACTIVITAT">Guarda</button>
						<button name="B_DELETE_ENTRY" class="BOTO_ACTIVITAT">Elimina</button>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         

              
<?php ENDIF; ?>

<?php if(isset($VIEW_FORM_ENTRIES)): ?>    

	 	<div class="REQUADRE">
		 	<div class="OPCIO_FINESTRA">
		 		<a href="<?php echo url_for('gestio/gBlogs?accio=VIEW_CONTENT') ?>"><?php echo image_tag('icons/Grey/PNG/action_delete.png') ?></a>
		 	</div>            
		 	<div class="titol">
		 		Entrades del formulari  
		 	</div>
	    	<table>
	    	<?php 
	    	
                $WEBROOT = OptionsPeer::getString('SF_WEBROOT',$IDS);
            
	    		foreach($VIEW_FORM_ENTRIES as $F):
	    			echo '<tr>';
	    			echo '<td>
	    					<select name="estat" onChange="SubmitEstat(this,'.$F->getId().')">'.
	    			 			options_for_select(AppBlogsFormsEntriesPeer::selectEstats(),$F->getEstat()).
	    					'</select>
	    				  </td>';
	    			echo '<td>';
	    			echo '<div class="hidden1" id="hidden1_'.$F->getId().'">';	    			
	    			echo $F->getId().' | ';
	    			foreach($F->getArrayElements() as $K=>$V):

	    				if(in_array($K,$VIEW_FIELDS)):
	    					echo '<b>'.$V.'</b> | ';
	    				endif;
	    				
	    			endforeach;
	    			echo '<a onClick="Activa('.$F->getId().')"><img src="'.$WEBROOT.'images/template/add.png'.'" /></a>';
	    			$O = $F->getObjeccions();
	    			if(!empty($O)) echo ' <a onClick="Activa('.$F->getId().')"><img src="'.$WEBROOT.'images/template/buildings.png'.'" /></a>';
	    			echo '</div>';
	    			echo '<div class="hidden2" id="hidden2_'.$F->getId().'">';
	    			echo '<a onClick="Desactiva('.$F->getId().')"><img src="'.$WEBROOT.'images/template/add.png'.'" /></a><br />';
	    			foreach($F->getArrayElements() as $K=>$V):
	    				if($K == 'file'):
	    					foreach($V as $V2):	    						
	    						$R = '<a href="'.$WEBROOT.'uploads/formularis/'.$V2.'">'.$V2.'</a>';
	    						echo '<i>'.$K.'</i>: <b>'.$R.'</b> - ';
	    					endforeach;
	    				else: 
	    					echo '<i>'.$K.'</i>: <b>'.$V.'</b> - ';
	    				endif; 
	    			endforeach;	    				    			
	    			echo '<br /><b>Comentaris: </b><textarea id="objeccio_'.$F->getId().'">'.$F->getObjeccions().'</textarea>';
	    			echo '<br /><button name="AJAX_SAVE_OBJECCIONS" onClick="GuardaComentari('.$F->getId().')">Guardar comentari</button>';	    			
	    			echo '</div>';
	    			echo '</td>';
	    			echo '</tr>';
	    		endforeach;	    	
	    	
	    	?>	    	
	    	</table>      		
      	</div>        
              
<?php ENDIF; ?>


<?php if(isset($PAGES_WITHOUT_CONTENT)): ?>    

	<div id="tabs">
	    <ul>
	        <li><a href="#tab-1"><span>Menús</span></a></li>
	        <li><a href="#tab-2"><span>Pàgines</span></a></li>
	        <li><a href="#tab-3"><span>Arbre</span></a></li>
	    </ul>
	    <div id="tab-1">
	        <table class="DADES">
	    	<tr>
	    		<th>ID</th>
	        	<th>NOM</th>
	        	<th>TÉ PAGINA?</th>
	        </tr>
	        <?php 	        
	        	foreach($MENUS_WITHOUT_PAGES as $K=>$OO):
	        		$TE_PAGINA = ($OO['COUNT'])?'Sí':'No';
	        		echo '<tr>
	        				<td>'.$K.'</td>
	        				<td>'.$OO['NAME'].'</td>
	        				<td>'.$TE_PAGINA.'</td>
	        			  </tr>';
	        	endforeach;	        
	        ?>
	        </table>
	    </div>
	    <div id="tab-2">
	    	<table class="DADES">
	    	<tr>
	    		<th>ID</th>
	        	<th>NOM</th>
	        	<th>#ENTRADES</th>
	        </tr>
	        <?php 	        
	        	foreach($PAGES_WITHOUT_CONTENT as $K=>$OO):
	        		echo '<tr>
	        				<td>'.$K.'</td>
	        				<td>'.$OO['NAME'].'</td>
	        				<td>'.$OO['COUNT'].'</td>
	        			  </tr>';
	        	endforeach;	        
	        ?>
	        </table>
	    </div>
	    <div id="tab-3">
	    	<table width="100%" class="DADES">
	        	<?php DibuixaArbre($TREE); ?>
	        </table>
	    </div>
	</div>

<?php ENDIF; ?>

<?php 

	function DibuixaArbre($TREE,$nivell = "") 
	{			
		foreach($TREE as $K => $OO):
			echo '<tr>
					<td width="50px">'.$K.'</td>
					<td>'.$nivell.$OO['NOM'].'</td>
					<td width="150px">Opcions</td></tr>';
			DibuixaArbre($OO['TREE'],$nivell.'&nbsp;&nbsp;&nbsp;');
		endforeach;				
	}


	function DibuixaGaleria($GALLERY)
	{
		
		$RET  = "<table>";
		$RET .= "<tr>";
		
		foreach($GALLERY as $OO):
			$RET .= '<td>
					<a href="#" onClick="esborraImatge('.$OO->getId().')">						
						<img id="img'.$OO->getId().'" width="100px" src="'.sfConfig::get('sf_webroot').'images/blogs/'.$OO->getUrl().'">
					</a>												
					</td>';
		endforeach;
		
		$RET .= "</tr></table>";
		
		return $RET;
                		
	}
	
?>
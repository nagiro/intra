<?php use_helper('Form')?>
<?php use_javascript('/sfFormExtraPlugin/js/jquery.autocompleter.js') ?>
<?php use_stylesheet('/sfFormExtraPlugin/css/jquery.autocompleter.css') ?>
   
   
   <TD colspan="3" class="CONTINGUT">

<?php if($MODE == 'CONSULTA'): ?>  
	<DIV class="REQUADRE">		
	<div class="titol">Contingut a la carpeta : <span style="font-weight:normal"> <?php echo $ACTUAL->getRutaActual() ?> </span></div>		
      	<TABLE class="DADES" width="100%"> 			  
			<?php echo mostraDirectoris($DIRECTORIS,$ACTUAL->getIddirectori(),$ACTUAL->getPare()); ?>
			<?php echo mostraArxius($ACTUAL,$PERMISOS_AL_DIR); ?>		                   	
    	</TABLE>    	         	
	</DIV>
	
<?php ENDIF; ?>

<?php IF($MODE == 'UPLOAD'): ?>

 	<form action="<?php echo url_for('apps/gDocuments') ?>" method="POST" enctype="multipart/form-data">
	    <DIV class="REQUADRE">
	    <div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'apps/gDocuments?accio=CD'); ?></div>
	    <div class="titol">Estàs carregant un arxiu al directori: <span style="font-weight:normal"> <?php echo $ACTUAL->getRutaActual() ?> </span></div>	    
	    	<table class="FORMULARI" width="100%">
	 			<?php echo $FUPLOAD; ?>
	 		
	 			<td colspan="2" class="dreta"><br>
	 				<?php echo submit_tag('Carrega l\'arxiu',array('name'=>'B_SAVE_UPLOAD','class'=>'BOTO_ACTIVITAT')) ?>	            			            	
	            </td>
	 		      
	        </table>
	     </DIV>
     </form>	


<?php ENDIF; ?>

   </TD>


<?php	
	
	function mostraDirectoris($DIRECTORIS,$ACTUAL,$PARE)
	{	
		$RET = "";
		if(!is_null($PARE)):
			$RET .= '<tr>
						<td>'.link_to(image_tag('template/arrow_left.png').'<span>Retorna a la carpeta anterior</span>','apps/gDocuments?accio=CD&IDD='.$PARE,array('class'=>'tt2')).'</td>
						<td></td>						
					 </tr>';
		endif; 
		
		if(isset($DIRECTORIS[$ACTUAL])):	
			foreach($DIRECTORIS[$ACTUAL] as $ID => $NOM):				
				$RET .= '<tr>
							<td>'.link_to(image_tag('template/folder.png').'<span>Obre la carpeta</span>','apps/gDocuments?accio=CD&IDD='.$ID,array('class'=>'tt2')).'</td>
							<td>'.$NOM.'</td>
						 </tr>';				
			endforeach;		
		//else: 
		//	$RET .= '<tr><td>'.link_to('BASE','apps/gDocuments?accio=CD&IDD=0').'</td></tr>';
		endif;
		
		return $RET;
	}
	
	
	function mostraArxius($DIRECTORI_ACTUAL_ID, $PERMISOS_AL_DIR)
	{	
		
		$RET = "";
		
		$ARXIUS = $DIRECTORI_ACTUAL_ID->getAppDocumentsArxiuss();
		
		foreach($ARXIUS as $ARXIU):					
			$RET .= '<tr><td width="60px">';
			
			if($PERMISOS_AL_DIR == NivellsPeer::EDICIO) $RET .= link_to(image_tag('template/blog.png').'<span>Edita el document</span>',url_for('apps/gDocuments?accio=UPLOAD&IDA='.$ARXIU->getIddocument()),array('class'=>'tt2')).' '; 
			$RET .= link_to(image_tag('template/drive_disk.png').'<span>Descarrega\'t el document</span>',sfConfig::get('sf_webroot').sfConfig::get('sf_webappdocuments').$ARXIU->getUrl(),array('class'=>'tt2')).' ';
			if($PERMISOS_AL_DIR == NivellsPeer::EDICIO) $RET .= link_to(image_tag('tango/16x16/places/user-trash.png').'<span>Esborra el document</span>',url_for('apps/gDocuments?accio=DELETE&IDA='.$ARXIU->getIddocument()),array('class'=>'tt2','confirm'=>'Estàs segur que vols esborrar el document?')).' '; 
			$RET .= '</td><td>'.$ARXIU->getNom().'</td></tr>';
											
		endforeach;
		if($PERMISOS_AL_DIR == NivellsPeer::EDICIO):
			$RET .= '<tr>
						<td>'.link_to(image_tag('template/new.png').'<span>Carrega un arxiu nou a aquesta carpeta</span>',url_for('apps/gDocuments?accio=UPLOAD&IDD='.$DIRECTORI_ACTUAL_ID->getIddirectori()),array('class'=>'tt2')).'</td>						
						<td><- Carrega un arxiu nou a aquesta carpeta'.'</td>					
					</tr>';
		endif;
		
		return $RET;
		
	}

?>

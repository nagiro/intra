<?php use_helper('Form')?>

<TD colspan="3" class="CONTINGUT_ADMIN">
          
    <?php include_partial('breadcumb',array('text'=>'ESTRUCTURA')); ?>

    <?php IF($HTML): ?>

	<form action="<?php echo url_for('gestio/gEstructura') ?>" method="post">
      <DIV class="REQUADRE">
        <div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gEstructura'); ?></div>
        <DIV class="TITOL">HTML - <?php echo $FHtml->getObject()->getTitolmenu(); ?></DIV>
      	<TABLE class="DADES">
      		<?php echo $FHtml ?>
      		<tr>
      		<td colspan="2" class="dreta">
				<?php include_partial('botonera',array('element'=>'TOTA l\'agenda','tipus'=>'Guardar','nom'=>'SaveHTML')); ?>      		      		
      		</td></tr>              		
        </TABLE>      
      </DIV>
   </form>
   
  <?php ENDIF; ?>

<?php IF( $NOU || $EDICIO ): ?>

	<form action="<?php echo url_for('gestio/gEstructura') ?>" method="POST">            
	 	<DIV class="REQUADRE">
	 		<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gEstructura'); ?></div>
	    	<table class="FORMULARI" width="500px">
                <?php echo $FNode; ?>                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
						<?php include_partial('botonera',array('element'=>'el node'))?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    

<?php ENDIF; ?>

    <form action="<?php echo url_for('gestio/gEstructura') ?>" method="post">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL"><?php echo link_to(image_tag('tango/32x32/actions/document-new.png', array('size'=>'16x16','alt'=>'Nou node')),'gestio/gEstructura?accio=N'); ?> Estructura</DIV>
	    	<table class="DADES">          
                  <?php echo llistaNodes($NODES); ?>
	        </table>
	     </DIV>
     </form>                
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    
<?php 

function creaOpcions($IDN)
{      
		
  $R  = '<a href="'.url_for('gestio/gEstructura?idN='.$IDN.'&accio=E').'" class="tt2">'.image_tag('tango/32x32/actions/edit-find-replace.png', array('size'=>'16x16','alt'=>'Edita la pàgina')).'<span>Edita les característiques de la pàgina</span></a>';
  if(!NodesPeer::getIsCategoria($IDN) && !NodesPeer::getIsExterna($IDN)) $R .= '<a href="'.url_for('gestio/gEstructura?idN='.$IDN.'&accio=H').'" class="tt2">'.image_tag('tango/32x32/apps/internet-web-browser.png', array('size'=>'16x16','alt'=>'Edita continguts')).'<span>Edita el contingut de la pàgina</span></a>';     
  $R .= '<a onClick="return confirm(\'Segur que vols esborrar la pàgina?\');" href="'.url_for('gestio/gEstructura?idN='.$IDN.'&accio=D').'" class="tt2">'.image_tag('tango/32x32/places/user-trash.png', array('size'=>'16x16','alt'=>'Esborra la pàgina')).'<span>Esborra la pàgina</span></a>'; 
  
  return $R;
}

function llistaNodes( $NODES )
{     
  $Ordre = 1;
  foreach($NODES as $N):
    $Nivell = "";  
    if($N->getNivell() == 1) $imatge = image_tag('tango/32x32/status/folder-open.png', array('align'=>'ABSMIDDLE','size'=>'16x16','alt'=>'Edita o visualitza les dades'));
    else $imatge = image_tag('tango/32x32/actions/document-open.png', array('align'=>'ABSMIDDLE','size'=>'16x16','alt'=>'Edita o visualitza les dades'));
    for($i = $N->getNivell(); $i > 0; $i--) $Nivell .= "&nbsp;&nbsp;&nbsp;&nbsp;";
	$text = $Nivell.$imatge.link_to('&nbsp;&nbsp;'.$N->getTitolmenu(),'gestio/gEstructura?idN='.$N->getIdnodes().'&accio=E');    
    if(!$N->getIsactiva()) $text = '<strike>'.$text.'</strike>';       
    echo '<TR><TD class="LINIA">'.$Ordre.'</TD><TD class="LINIA">'.$text.'</TD><TD class="OPCIONS">'.creaOpcions($N->getIdnodes()).'</TD></TR>';
    $Ordre++;           
  endforeach;
  

}


?>

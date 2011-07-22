<?php use_helper('Form')?>

<script type="text/javascript">

	$(document).ready( function() { 
		$('#cerca_select').change( function() { 
			$('#FCERCA').submit(); 
		});		
	});
    
</script>

<style>

#submit { width:100px; }

</style>

    <TD colspan="3" class="CONTINGUT_ADMIN">
    
	<?php include_partial('breadcumb',array('text'=>'NOTÍCIES')); ?>


	<form action="<?php echo url_for('gestio/gNoticies'); ?>" method="POST" id="FCERCA">
    	<?php include_partial('cerca',array(
    										'TIPUS'=>'Select',
    										'FCerca'=>$FCerca,
    										'BOTONS'=>array(
    														array(
    																'name'=>'BCERCA',
    																'text'=>'Prem per buscar'),
    														array(
    																'name'=>'BNOU',
    																'text'=>'Nova notícia')    														
    													)
    										)
    							); ?>

     </form>  


<?php if($MODE == 'FORMULARI'): ?>
		
		<form action="<?php echo url_for('gestio/gNoticies') ?>" method="POST" enctype="multipart/form-data">
		    <DIV class="REQUADRE">	    
		    <?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gNoticies?accio=CC'))?>
		    	<table class="FORMULARI">
		    		<tr><td width="100px"></td><td></td></tr>	    			    		        
		            <?php echo $FORMULARI ?>
		            <?php $ON = $FORMULARI->getObject(); ?>
		            <?php if($ON->getIdactivitat() > 0): ?>
		            	<?php $nom = ActivitatsPeer::retrieveByPK($ON->getIdactivitat())->getNom(); ?>	            
		            	<tr><td width="100px"><b>Activitat relacionada:</b></td><td><a target="_NEW" href="<?php echo url_for('gestio/gActivitats?accio=ACTIVITAT&IDA='.$ON->getIdactivitat()) ?>"><?php echo $nom ?></a></td></tr>
		            <?php endif;  ?>
		            <tr>		            	
		            	<td colspan="2" class="dreta">
							<?php include_partial('botonera',array('element'=>'la notícia')); ?>		            	
						</td>
		            </tr>
		        </table>
		     </DIV>
	     </form>		

<?php else: ?>

	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Notícies a portada</DIV>
	    	<table class="DADES">
	    	<?php           
                if(sizeof($NOTICIES) == 0 ) { echo '<TR><TD class="LINIA">No hi ha cap notícia activa.</TD></TR>'; }
                else { echo '<tr><td class="TITOL">Títol</td><td class="TITOL">Data publicació</td><td class="TITOL">Data desaparició</td><td class="TITOL">Activa?</td><td class="TITOL">Ordre</td><tr>'; }
                 								                           
                foreach($NOTICIES->getResults() as $N):
                    $Ordre = link_to(image_tag('tango/16x16/actions/go-down.png'),'gestio/gNoticies?accio=O&DOWN=1&idN='.$N->getIdnoticia());
                    $Ordre .= ' '.link_to(image_tag('tango/16x16/actions/go-up.png'),'gestio/gNoticies?accio=O&UP=1&idN='.$N->getIdnoticia());                                                          
					echo '<TR>							
							<TD class="LINIA">'.link_to($N->getTitolnoticia(),'gestio/gNoticies?accio=E&idn='.$N->getIdnoticia()).'</TD>
							<TD class="LINIA">'.$N->getDatapublicacio().'</TD>							
							<TD class="LINIA">'.$N->getDatadesaparicio().'</TD>
							<TD class="LINIA">'.(($N->getActiva())?'Sí':'No').'</TD>							
                            <TD class="LINIA">'.$Ordre.'</TD>
						  </TR>';                		                 															
				endforeach;				
                ?>         
                <TR><TD style="border:0px;" colspan="4"><?php echo setPager($NOTICIES,'gestio/gNoticies?a=a',$PAGINA); ?></TD></TR>       
	        </table>
	     </DIV>                  

	</TD>
	
<?php endif; ?>
	
	
<?php 
	
	function ParImpar($i)
	{
		if($i % 2 == 0) return "PAR";
		else return "IPAR";
	}
	
	
	function gestorPagines($O)
	{
	  if($O->haveToPaginate())
	  {       
	     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gNoticies?PAGINA='.$O->getPreviousPage());
	     echo " ";
	     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gNoticies?PAGINA='.$O->getNextPage());
	  }
	}
	
?>
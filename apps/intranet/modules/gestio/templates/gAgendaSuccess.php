<?php use_helper('Form'); ?>

<style> 
	.row { width:500px; } 
	.row_field { width:80%; } 
	.row_title { width:20%; }
	.row_field input { width:100%; } 
</style>

<script type="text/javascript">

$(document).ready(function() {	
	 $("#id").val(1);																		
	 $("#mesdades").click( function() { creaNovaDada(); });
	 $("#cerca_text").keyup(function() { OmpleCerca(this.value); });
	 
	 <?php 	
	 	if(isset($DADES)): 			 
	 		foreach($DADES as $K => $V):	 			
	 			$T = $V->getTipus(); $D = addslashes($V->getDada()); $N = addslashes($V->getNotes()); $S = AgendatelefonicadadesPeer::getSelectHTML($V->getTipus());	 				
	 			echo "creaNovaDadaVella(".$T.",'".$D."','".$N."','".$S."',".$V->getAgendatelefonicadadesid().");";
	 		endforeach;
	 	endif;
	 		
	 ?>			 
	 
});	

function OmpleCerca(text){	
	$.post(
		"<?php echo url_for('gestio/SearchAjaxAgenda'); ?>",
		{ cerca: text },
		function(data) { $('#LLISTAT_DADES').html(data); });

}


function linia(id, t, d, n, s, idA)
{
	return '			<div id="row['+id+']" class="clear row fb"> ' +
							'<div class="row_title fb">'+  		
								'<span class="fb">&nbsp;' +								
								'</span>' +
							'</div>' +
							'<div class="row_field fb">'+
								'<span class="fb ">' +
									'<input type="hidden" value="'+idA+'" name="Dades['+id+'][id]"></input>' +
						      		'<select name="Dades['+id+'][Select]">'+s+'</select>' +
								'</span>' +
								'<span class="fb" style="padding-left:5px;">' +
									'<input style="width:150px" name="Dades['+id+'][Dada]" value="'+d+'" type="text">' +
								'</span>' +
								'<span class="fb" style="padding-left:5px;">' +
									'<input style="width:120px" name="Dades['+id+'][Notes]" type="text" value="'+n+'">' +
								'</span>' +
								'<span class="fb" style="padding-left:5px;">' +
									'<input style="width:10px" type="button" onClick="esborraLinia('+id+');" id="mesmaterial" value="-"></input>' +
								'</span>' +							
							'</div>' +
						'</div>';		

}

function creaNovaDada()
{
	
	var id = $("#id").val();		
	id = (parseInt(id) + parseInt(1));
	$("#id").val(id);		
				
	var select  = '<?php echo AgendatelefonicadadesPeer::getSelectHTML() ?>';
	$("#taula").append(linia(id, 1,'','',select, 0));
																					
}

function creaNovaDadaVella(t, d, n, s, idA)
{
	
	var id = $("#id").val();		
	id = (parseInt(id) + parseInt(1));
	$("#id").val(id);		
					
	$("#taula").append(linia(id, t, d, n, s, idA));
																				
}


function esborraLinia(id) { $("#row\\["+id+"\\]").remove(); }

</script>
   
    <TD colspan="3" class="CONTINGUT_ADMIN">
    
    <?php include_partial('breadcumb',array('text'=>'AGENDA')); ?>
    
    <form action="<?php echo url_for('gestio/gAgenda') ?>" method="POST" id="FCERCA">
    	<?php include_partial('cerca',array(
    										'TIPUS'=>'Simple',
    										'FCerca'=>$FCerca,
    										'BOTONS'=>array(
    														array(
    																'name'=>'BCERCA',
    																'text'=>'Cerca'),
    														array(
    																'name'=>'BNOU',
    																'text'=>'Nou contacte')    														    														
    														))); ?>
     </form>    

      
  <?php IF( $MODE == 'NOU' || $MODE == 'EDICIO' ): ?>
      
	<form action="<?php echo url_for('gestio/gAgenda') ?>" method="POST">
		            
	 	<div class="REQUADRE fb">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gAgenda?accio=C')) ?>
					 	 		
	 		<div class="FORMULARI fb">
	 			<?php echo $FAgenda?>
	 			<input type="hidden" value="<?php echo sizeof($DADES) ?>" id="id"></input>
	 			<div id="taula">
	 				<input type="button" value="+" id="mesdades" class="clear fb"></input>		 			
	 			</div>
	 		
	 		<?php include_partial('botoneraDiv',array('element'=>"TOTA l\'agenda")); ?>		
	 		</div>
	 			 	 	
      	</div>
      	
     </form>    
    
  <?php ELSE: ?>
      
      <DIV class="REQUADRE">   	  
        <DIV class="TITOL">Llistat contactes</DIV>
      	<TABLE id="LLISTAT_DADES" class="DADES" style="border-collapse: collapse;" >
      		<?php           			 			
				include_partial('listAgenda', array('AGENDES' => $AGENDES, 'IDS' => $IDS));								      		      		
      		?>
			<!-- Aquí hi apareix el llistat que surt de la funció AJAX gestio/SearchAjaxAgenda i Partial( _listAgenda ) -->      	
      	</TABLE>      
      </DIV>
      
              
               
  <?php ENDIF; ?>
               
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>        
    
<?php 

function ParImpar($i)
{
	if($i % 2 == 0) return "PAR";
	else return "IPAR";
}

function getParam( $accio , $AID , $CERCA )
{
    $opt = array();
    if(isset($accio)) $opt[] = "accio=$accio";
    if(isset($AID)) $opt['AID'] = "AID=$AID";
    if(isset($CERCA)) $opt['CERCA'] = "CERCA=$CERCA";
    
    RETURN "?".implode( "&" , $opt);
}

?>

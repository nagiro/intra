<?php use_helper('Form')?>
<style>
.cent { width:100%; }
.vuitanta { width:80%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }

	.row { width:500px; } 
	.row_field { width:80%; } 
	.row_title { width:20%; }
	.row_field input { width:100%; } 

</style>

<script type="text/javascript">

	$(document).ready( function() { 
		$('#cerca_text').change( function() { 
			$('#FCERCA').submit(); 
		});
		$('#FORMSUBMIT').submit(ValidaFormulari);             
                
        $('#sel').click(function(){ 
            $("#dialog").dialog({ 
                    buttons: {                         
                                "Cancel·lar": function(){ $(this).dialog("close"); },
                                "Guardar": function() { 
                                            $.post(
                                                "<?php echo url_for('gestio/gMaterial?accio=AJAX_NEW_GRUP') ?>",
                                                $("#F2").serialize(),
                                                function(data)
                                                { 
                                                    setTimeout("location.reload()", 500);                                                    
                                                }                                           
                                            );                                             
                                            }                                
                            }                                                                               
            }); 
        });        
	});

	function vacio(q){for(i=0;i<q.length;i++){if(q.charAt(i)!=" "){return true}}return false}
	function validaData(q){		
		var userPattern = new RegExp("^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$");		
		if (userPattern.exec(q) == null) return false; else return true;
	}
	
	function validaCodi(q){
		var userPattern = new RegExp("^[A-Za-z]{3}[0-9]{3}\.[0-9]{2}$");		
		if (userPattern.exec(q) == null) return false; else return true;
	}
	

	function ValidaFormulari(){
		if($('#material_Identificador').val().length == 0) { alert('L\'identificador no pot estar buit.'); return false; }
		if($('#material_Nom').val().length == 0) { alert('El nom no pot estar buit.'); return false; }
		return true;				 
	}

</script>   
   
    <TD colspan="3" class="CONTINGUT_ADMIN">
    
    <!-- Trosset pel grup -->
    <div id="dialog" style="display:none">        
        <form id="F2">
            Entra el nou grup: 
            <input type="text" name="GRUP" value="" />            
        </form>
    </div>
    
    
    <?php include_partial('breadcumb',array('text'=>'MATERIAL')); ?>
                
    <form action="<?php echo url_for('gestio/gMaterial') ?>" method="POST" id="FCERCA">
    
    	<?php include_partial('cerca',array(
    										'TIPUS'=>'Simple',
    										'FCerca'=>$FCerca,
    										'BOTONS'=>array(
    														array(
    																'name'=>'BCERCA',
    																'text'=>'Cerca')
    														,
    														array(
    																'name'=>'BNOU',
    																'text'=>'Nou material')
    														)    														
    										)); ?>    
    
     </form>   
    
      
<?php IF( $NOU || $EDICIO ): ?>
      
	<form action="<?php echo url_for('gestio/gMaterial') ?>" method="POST" id="FORMSUBMIT">
 	    
	 	<div class="REQUADRE fb">
		 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gMaterial?accio=L')) ?>
						 	 		
		 		<div class="FORMULARI fb">                    
		 			<?php echo $FMaterial ?>		 		
		 			<?php include_partial('botoneraDiv',array('element'=>'el material')); ?>		
		 		</div>
	 			 	 	
		</div>
 		
     </form>    

<?php ELSE: ?>

      <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat de material</DIV>
      	<TABLE class="DADES">
 			<?php 
				if( empty( $MATERIALS ) ):
					echo '<tr><td class="LINIA" colspan="3">No s\'ha trobat material disponible.</td></tr>';
				else: 
					$i = 0;
                    echo "<tr><td class=\"titol\">Id</td><td class=\"titol\">Nom</td><td class=\"titol\">Unit.</td></tr>";                                                                    
					foreach($MATERIALS->getResults() as $M):
                      	$PAR = ParImpar($i++);
                        $extres = (!$M->getDisponible())?'style="text-decoration: line-through;"':"";                        
                      	echo "<tr>                            
                      			<td class=\"$PAR\" $extres>".link_to($M->getIdentificador(), 'gestio/gMaterial'.getParam('E',$M->getIdmaterial(),$TIPUS,$PAGINA))."</td>
                      			<td class=\"$PAR\" $extres>{$M->getNom()}</td>
                                <td class=\"$PAR\" $extres>{$M->getUnitats()}</td>                      			
                      		  </tr>";
                    endforeach;
                 endif;                     
             ?>      
              <TR><TD colspan="3" class="TITOL"><?php echo gestorPagines($TIPUS , $MATERIALS);?></TD></TR>    	
      	</TABLE>      
      </DIV>

<?php ENDIF; ?>
    
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    

  <?php 

function getParam( $accio = "" , $IDM = "" , $TIPUS = "" , $PAGINA = 1)
{
    $opt = array();
    if(!empty($accio)) $opt[] = "accio=$accio";
    if(!empty($IDM)) $opt['IDM'] = "IDM=$IDM";
    if(!empty($TIPUS)) $opt['TIPUS'] = "TIPUS=$TIPUS";
    if(!empty($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    
    RETURN "?".implode( "&" , $opt);
}

function ParImpar($i)
{
	if($i % 2 == 0) return "PAR";
	else return "IPAR";
}


function gestorPagines($TIPUS , $MATERIALS)
{
  if($MATERIALS->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gMaterial'.getParam(null,null,$TIPUS,$MATERIALS->getPreviousPage()));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gMaterial'.getParam(null,null,$TIPUS,$MATERIALS->getNextPage()));
  }
}

?>
 
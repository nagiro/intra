<?php use_helper('Form')?>
<style>
.LLEGENDA { font-size:12px; font-weight:bold; padding:10px 10px 10px 10px; }
FIELDSET .REQUADRE { border:1px solid #CCCCCC; padding:10px; margin-right:40px; }
.TITOL_CATEGORIA { background-color: #DD9D9A; color:black; font-weight:bold; padding:5px; font-size:10px; }
.TITOL { padding:5px; }
.LINIA { padding:4px; }
#MATRICULACIO { font-size:10px; } 
#VULLMATRICULARME {  }


</style>

<td colspan="3" class="CONTINGUT">
   
    <?php if($CURSOS->getNbResults() == 0): ?>
    <fieldset class="REQUADRE"><legend class="LLEGENDA">Llistat de cursos</legend>
        Actualment no hi ha oberta la matrícula per a cap curs a través d'internet.<br />
        Per a més informació, contacti amb la Casa de Cultura de Girona.
    </fieldset>  
    <?php else: ?>
   
    <fieldset class="REQUADRE"><legend class="LLEGENDA">Llistat de cursos</legend>
       <table class="DADES">
               <tr>
            	<td class="TITOL">Codi</td>
            	<td class="TITOL">Títol</td>
            	<td class="TITOL">Preu</td>
            	<td class="TITOL">Data d'inici</td>
            	<td class="TITOL">Vacants</td>
            </tr>
    
       <?php $CAT_ANT = ""; ?>   
       <?php foreach($CURSOS->getResults() as $C): ?>
       <?php if($C->getVisibleweb() == 1): ?>                      
       <?php    if($CAT_ANT <> $C->getCategoria()): ?>   
    			<tr><td colspan="5" class="TITOL_CATEGORIA"><?php echo $C->getCategoriaText()?></td></tr>
       <?php    endif; ?>
        <?php       $PLACES = CursosPeer::getPlaces($C->getIdcursos(),$IDS); ?>                       	
       		<tr>
          		<td class="LINIA">
                    <div style="clear:both;">
              			<a href="#TB_inline?height=480&width=640&inlineId=hidden<?php echo $C->getIdcursos(); ?>&modal=false" class="thickbox">
              				<?php echo $C->getCodi()?>
              			</a>
              			<div style="display: none;" id="hidden<?php echo $C->getIdcursos() ?>">
                            <div id="TEXT_WEB">
              				  <?php echo $C->getDescripcio() ?>
                            </div>
              			</div>
                    </div>
          		</td>
          		<td class="LINIA"><?php echo $C->getTitolcurs()?> ( <?php echo $C->getHoraris()?> ) </td>
          		<td class="LINIA"><?php echo $C->getPreu()?>€</td>      							
          		<td class="LINIA" width="70px"><?php echo $C->getDatainici('d-m-Y')?></td>
          		<td class="LINIA"><?php echo (intval($PLACES['TOTAL'])-intval($PLACES['OCUPADES'])) ?></td>
          	</tr>                		                 										
       <?php $CAT_ANT = $C->getCategoria(); ?>
       <?php endif; ?>			   			   
       <?php endforeach; ?>                              
       </table>         
       </fieldset>
    
    	<fieldset class="REQUADRE"><legend class="LLEGENDA">Matricula't</legend>
    		<form method="post" action="<?php echo url_for('web/matriculat') ?>">
                <div>
                   Per matricular-se, vostè ha de ser usuari registrat de l'Hospici.<br /> 		   			
                   Per poder-hi accedir si us plau cliqui <a href="<?php echo url_for('gestio/uLogin?idS=1') ?>">aquí</a>.            
                </div>
    		</form>
       </fieldset>
   
   <?php endif; ?>
      
   <div style="height:40px;"></div>
   
</td>
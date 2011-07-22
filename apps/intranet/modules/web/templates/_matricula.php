<style>
	.REQUADRE { width:450px; }
	.LLEGENDA { margin:5px; padding-left:10px; padding-right:10px; font-weight: bold; }
</style>
    <TD colspan="2" class="CONTINGUT">

	<fieldset class="REQUADRE"><legend class="LLEGENDA">Matricula finalitzada</legend>
	<?php if($MISSATGE == 'OK'): ?>
	<p><b>La seva matrícula s'ha realitzat correctament.</b>
	<br /><br />Per poder-la comprovar, vagi a la seva zona privada. Podrà trobar-la a la part inferior del menú lateral esquerra.   
	
	</p>
   	<?php else: ?>
   		<p><b>Hi ha hagut algun problema realitzant la seva matrícula.</b><br /><br />
   		      Si us plau posi's en contacte amb la Casa de Cultura de Girona trucant al telèfon 972.20.20.13 o bé enviant un correu electrònic a informatica@casadecultura.org
   		</p>
   	<?php endif; ?> 
      
      </fieldset>
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
<STYLE>

	.FORMAT td { padding:5px; }
	.FORMAT th { padding:5px; background-color:#CCCCCC; }
	.FORMAT a { text-decoration: none; font-weight:bold; }
	
	.llistat { padding-left:20px; }
	.llistat li { padding-left:20px; list-style: none; padding-top:5px; }
	.llistat A { color:#888888; font-size:10px; text-decoration:none; font-weight:bold; }
	
	
</STYLE>

<TD colspan="2" class="CONTINGUT">
    
	<?php include_partial('breadcumb',array('text'=>$TITOL)); ?>
	<br />
	<h1>En aquest apartat podrà accedir als següents continguts</h1>
	<br />
	<ul class="llistat">
	<?php
		
		$nivell = $PAGINA->getNivell();

		$RET = "";
	
		$seguir = true;
		
		foreach($NODES as $ON):
		
			if( ($ON->getOrdre() > $PAGINA->getOrdre())):

				if($ON->getNivell() <= $PAGINA->getNivell()) $seguir = false;
				
				if($seguir):
			
					$titol = $ON->getTitolmenu();
				
					if($ON->getNivell() > $nivell):				
						$RET .= '<ul>';
					endif;
					
					if($ON->getNivell() < $nivell):
						$RET .= '</ul></li>';
					endif;
					
					if($ON->getNivell() == $nivell):
						$RET .= '</li>';							
					endif; 							
					
					$RET .= '<li><a class="negre" href="'.url_for('web/index?accio=cp&node='.$ON->getIdnodes()).'">'.$titol.'</a>';
									
						
	
					$nivell = $ON->getNivell();
					
				endif;
				
			endif; 
		
		endforeach;
		
		echo $RET;
		
	
	?>
	</ul>
    <DIV STYLE="height:40px;"></DIV>
                
</TD>
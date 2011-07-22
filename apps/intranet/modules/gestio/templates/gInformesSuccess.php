<?php use_helper('Presentation'); ?>

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


   <td colspan="3" class="CONTINGUT_ADMIN">
    
    <?php include_partial('breadcumb',array('text'=>'INFORMES')); ?>
      
        <div class="REQUADRE">
        <div class="TITOL">Informes disponibles</div>
      	<table class="DADES">
      		<tr><th>Nom</th><th>Descripció</th><th>Enllaç</th><th>Parametres</th></tr>
      		<?php if($POTVEURE[1]): ?>
      			<tr><td>Comptabilitat</td><td>Resum de conceptes i factures</td><td><a target="_NEW" href="http://192.168.0.3/comptabilitat/informe_conceptes.php">Anar-hi</a></td><td>Cap</td></tr>
      		<?php endif; ?>
       			<tr>
      				<td>Comptabilitat</td>
      				<td>Resum de matrícules per dia i mitjà pagament</td>
      				<td>---</td>
      				<td>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_METALIC) ?>"> M </a>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_TARGETA) ?>"> Ta </a>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_TELEFON) ?>"> Tf </a>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament='.MatriculesPeer::PAGAMENT_TRANSFERENCIA) ?>"> Tr </a>
      					<a href="<?php echo url_for('gestio/gInformes?accio=MAT_DIA_PAG&mode_pagament=0') ?>"> All </a>
   				</td></tr>
                <tr><td>Programació</td><td>Document Word amb les activitats</td><td><a href="<?php echo url_for('gestio/gInformes?accio=RESUM_ACTIVITATS') ?>">Anar-hi</a></td><td>Cap</td></tr>
                <tr><td>Programació</td><td>Planificació d'ocupació d'espais i material</td><td><a href="<?php echo url_for('gestio/gEstadistiques?accio=CC') ?>">Anar-hi</a></td><td>Cap</td></tr>
      	</table>      
      </div>
      
      
      <?php if(isset($FACTIVITATS)) echo FLlistatWord($FACTIVITATS); ?>
      
      <?php if(isset($DADES)) echo LlistatMatriculats($DADES,$MODE,$accio); ?>
            
      <?php if(isset($LOA,$IDS)) echo LlistatWord($LOA,$IDS); ?>
      
      <div style="height:40px;"></div>
                
    </td>          
      

<!-- Comença el bloc de matrícules per dia -->
<?php 

    function FLlistatWord($FACTIVITATS)
    {        
    	echo ' <form action="'.url_for('gestio/gInformes').'" method="POST">     	    
                    <div class="REQUADRE">';            
        echo '          <div class="FORMULARI">                    
                            '.$FACTIVITATS.'
                            <div class="cl" style="text-align:right; padding-top:40px;">	 	
                                <button type="submit" name="BGENERADOC" class="BOTO_ACTIVITAT">
    				                '.image_tag('template/disk.png').' Genera el llistat
                                </button>  
                            </div>                                       	
                        </div>                                                  		 		        			 	 	
                    </div>     		
                </form>';
                               
    }


    function LlistatMatriculats($DADES,$MODE,$accio)
    {
        $RET = "";
        $TARGETA = ($MODE == MatriculesPeer::PAGAMENT_TARGETA || $MODE == MatriculesPeer::PAGAMENT_TELEFON);
              
        if($accio == 'MAT_DIA_PAG'):
    
        $RET .= '<DIV class="REQUADRE">
                    <DIV class="TITOL">Matrícules pagades per dia</DIV>
          	         <TABLE class="DADES">
          		        <tr>
              			<th>Data</th>
                        <th>Hora</th>
              			<th>Import</th>
              			<th>DNI</th>
              			<th>Nom</th>
              			<th>Curs</th>';
        if($TARGETA) $RET .= '<th># Caixa</th>';            
        $RET .= '</tr>';
  		$DATA = ""; $DATA_ANT = -2; $TOTAL = 0;
  		foreach($DADES as $D):
          		
  		    $DATA = $D['DATA'];
 			$DATA_ANT = ($DATA_ANT == -2)?$D['DATA']:$DATA_ANT;      		      		
  		    if($DATA <> $DATA_ANT):
    			$RET .= '<tr>';
    			$RET .= '<td style="font-weight:bold; background:#F2EAEA;">'.$DATA_ANT.'</td>';
    			$RET .= '<td colspan="6" style="font-weight:bold; background:#F2EAEA;">'.$TOTAL.'</td>';      			      			
          		$RET .= '</tr>';                  				      		
          	endif;      		
                    			      			
            $RET .= '<tr>
              			<td>'.$D['DATA'].'</td>
                        <td>'.$D['HORA'].'</td>';
            
            if($D['ESTAT'] == MatriculesPeer::DEVOLUCIO) $RET .= ' <td>-'.$D['IMPORT'].'</td>';
            else { $RET .= ' <td>'.$D['IMPORT'].'</td>'; $TOTAL += $D['IMPORT']; }
            
            $RET .= '   <td>'.$D['DNI'].'</td>
              			<td>'.$D['NOM'].'</td>
              			<td>'.$D['CURS'].'</td>';
                        
            if($TARGETA) $RET .= '<td>'.$D['ORDER'].'</td>';
            $RET .= '</tr>';          		      		      		      		
      		$DATA_ANT = $DATA; 
        
  		endforeach;    					
        $RET .= '  </TABLE>';      
        $RET .= '</DIV>';
      
        endif;      
        
        return $RET;
    }
    

    function LlistatWord($LOA,$IDS)
    {
        $RET = "";
        $URLWEB = OptionsPeer::getString('SF_WEBROOTURL',$IDS);
        
        foreach($LOA as $OA):
            $img = image_tag('activitats/'.$OA->getImatge());
            $OC = $OA->getCicles(); if($OC instanceof Cicles) $cicle = "Cicle: ".$OC->getTmig();
            $title = $OA->getTmig();
            $body = $OA->getDmig();
            $horaris = generaHoraris($OA->getHorarisOrdenats(HorarisPeer::DIA));
            $link = url_for('gestio/gActivitats?accio=DESCRIPCIO&IDA='.$OA->getActivitatid());
            
            $RET .= "<div style=\"margin-bottom:20px\">                                                
                        <div class=\"title\"><b>{$title}</b> (<a href=\"{$link}\">edita</a>)</div>
                        <div><i>{$cicle}</i></div>
                        <div><i>{$horaris}</i></div>                        
                        <div>{$img}{$body}</div>                                                
                    </div>                                            
                        ";
                        
        endforeach;
        
        $RETF = '<DIV class="REQUADRE">
                    <DIV class="TITOL">Llistat d\'activitats</DIV>
                        <div>'.$RET.'</div></div>';                              
        return $RETF;
    }    
 
 
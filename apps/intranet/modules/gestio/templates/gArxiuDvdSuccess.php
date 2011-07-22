<?php use_helper('Form'); ?>

<STYLE>
.cent { width:100%; }
.noranta { width:90%; }
.cinquanta { width:50%; }
.gray { background-color: #DDDDDD; }
.NOM { width:20%; } 

	.row { width:500px; } 
	.row_field { width:80%; } 
	.row_title { width:20%; }
	.row_field input { width:100%; } 


</STYLE>
   
    <TD colspan="3" class="CONTINGUT_ADMIN">
      
    <?php include_partial('breadcumb',array('text'=>'TAULELL')); ?>
    
    <form action="<?php echo url_for('gestio/gArxiuDvd') ?>" method="POST" id="FCERCA">
    	<?php include_partial('cerca',array(
    										'TIPUS'=>'Simple',
    										'FCerca'=>$FCerca,
    										'BOTONS'=>array(
    														array(
    																'name'=>'BCERCA',
    																'text'=>'Prem per buscar')
    													)
    										)
    							); ?>
     </form>                      
  
  	<DIV class="REQUADRE">
  	<DIV class="TITOL">Llistat de DVDs i Arxius</DIV>
  		<table class="DADES">
                <?php 
                    if( empty( $DVDS ) ) echo '<TR><TD colspan="3">No s\'ha trobat cap resultat d\'entre '.ArxiuDvdPeer::doCount(new Criteria()).' disponibles.</TD></TR>';
                    else { 
                       $dif = "";
                       echo '<TR><TH>Tipus</TH><TH>Volum</TH><TH>Nom</TH><TH>Directori</TH><TH>Data creació</TH></TR>';
                       foreach($DVDS as $D):
							echo '<tr><td>'.$D->getTipus().'</td>';
							echo '<td>'.$D->getVolum().'</td>';							
							echo '<td>'.$D->getNom().'</td>';
							echo '<td>'.$D->getUrl().'</td>';
							echo '<td>'.$D->getDataCreacio('Y-m-d').'</td></tr>';
                       endforeach;                       
                   	}
                ?>     			
  		</table>
  	</DIV>
  	   
      <DIV STYLE="height:40px;"></DIV>
                
<!--    </TD> -->    
    
    

<?php 
  
  function diaSetmana($date)
  {
  	
  	list($d,$m,$Y) = explode("-",$date);
  	$dia = date('N',mktime(0,0,0,$m,$d,$Y));
  	
  	switch($dia){
  		case 1: return 'Dilluns';   break;
  		case 2:	return 'Dimarts';   break;
  		case 3:	return 'Dimecres';  break;
  		case 4:	return 'Dijous';    break;
  		case 5:	return 'Divendres'; break;
  		case 6:	return 'Dissabte';  break;
  		case 7:	return 'Diumenge';  break;
  	}
  }
?>

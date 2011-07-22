<?php use_helper('Form'); ?>

<style>
.cent { width:100%; }
.noranta { width:90%; }
.cinquanta { width:50%; }
.gray { background-color: #EEEEEE; }
.NOM { width:20%; } 

	.row { width:500px; } 
	.row_field { width:80%; } 
	.row_title { width:20%; }
	.row_field input { width:100%; } 


</style>
   
    <td colspan="3" class="CONTINGUT_ADMIN">
      
    <?php include_partial('breadcumb',array('text'=>'TAULELL')); ?>
    
    <form action="<?php echo url_for('gestio/gMissatges') ?>" method="POST" id="FCERCA">
    	<?php include_partial('cerca',array(
    										'TIPUS'=>'Simple',
    										'FCerca'=>$FCerca,
    										'BOTONS'=>array(
    														array(
    																'name'=>'BCERCA',
    																'text'=>'Prem per buscar'),
    														array(
    																'name'=>'BNOU',
    																'text'=>'Nou missatge')
    													)
    										)
    							); ?>
     </form>
            
          

  <?php IF( isset($MODE['NOU']) || isset($MODE['EDICIO']) ): ?>
      
	<form action="<?php echo url_for('gestio/gMissatges') ?>" method="POST">
	
	 	<div class="REQUADRE fb">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gMissatges?accio=C')) ?>
					 	 		
	 		<div class="FORMULARI fb">
	 			<?php echo $FMissatge ?>
	 			<?php if($FMissatge->getObject()->getUsuarisUsuariid() == $IDU || isset($MODE['NOU']))	include_partial('botoneraDiv',array('element'=>'el missatge')); ?>		
	 		</div>
	 			 	 	
      	</div>
			
	</form>      
      
  <?php ELSE: ?>
  
  	<div class="REQUADRE">
  	<div class="TITOL">Llistat de missatges (<a href="<?php echo url_for('gestio/gMissatges?accio=SF'); ?>">Veure missatges futurs</a>)</div>
        <div class="DADES" style="width:650px;">
         <?php  
            if( $MISSATGES->getNbResults() == 0 ) echo '<div>No s\'ha trobat cap resultat d\'entre '.MissatgesPeer::doCount(MissatgesPeer::getCriteriaActiu(new Criteria(),$IDS)).' disponibles.</div>';
            else { 
                    $dif = "";
                    foreach($MISSATGES->getResults() as $M) {                        
                  	    if($dif != $M->getPublicacio('d/m/Y')):
                  	    	echo '<div style="height:20px; clear:both;"></div>';
                  	    	echo '<div class="gray" style="padding:4px; border-bottom:1px solid #CCCCCC;"><b>'.diaSetmanaText($M->getPublicacio('Y-m-d')).' </b></div>';                      	    	
                  	    endif; 
                  		$SPAN  = '<span>'.$M->getText().'</span>';
                        
                        if($M->getIsglobal()):

                      		echo '<div style="border-bottom:1px solid #CCCCCC; background-color:#E4F7D9;">                      				
                      				<div style="float:left; width:500px;"><div style="padding:4px">'.link_to(image_tag('intranet/Submenu2.png').' '.$M->getTitol().$SPAN,'gestio/gMissatges'.getParam( 'E' , $M->getMissatgeid() , $CERCA ) , array('class'=>'tt2') ).'</div></div>
                      				<div style="float:left; width:150px;">
                                        <div style="padding:4px"><b>'.$M->getUsuaris()->getNom().' '.$M->getUsuaris()->getCog1().'</b> de 
                                        '.$M->getSiteNom().'</div>
                                    </div>
                                    <div style="clear:both"></div>
                      			  </div>';
                        
                        else: 
                        
                      		echo '<div style="border-bottom:1px solid #CCCCCC">                      				
                      				<div style="float:left; width:500px;"><div style="padding:4px">'.link_to(image_tag('intranet/Submenu2.png').' '.$M->getTitol().$SPAN,'gestio/gMissatges'.getParam( 'E' , $M->getMissatgeid() , $CERCA ) , array('class'=>'tt2') ).'</div></div>
                      				<div style="float:left; width:150px;"><div style="padding:4px">'.$M->getUsuaris()->getNom().' '.$M->getUsuaris()->getCog1().'</div></div>
                                    <div style="clear:both"></div>
                      			  </div>';
                                  
                        endif;
                  		$dif = $M->getPublicacio('d/m/Y');  
                  	}                    	
                }
                    ?>     			
            <div style="text-align:center; padding:5px;">
            	<?php echo setPager($MISSATGES,'gestio/gMissatges?a=a',$PAGINA); ?>         
            </div>                
        
        </div>
        
  	</div>
  	  
  <?php ENDIF; ?>
  
      <div style="height:40px;"></div>
                
<!--    </td> -->    
    
    

<?php 
  
  function getParam( $accio , $IDM , $CERCA )
  {
      $opt = array();
      if(isset($accio)) $opt[] = "accio=$accio";
      if(isset($IDM)) $opt['IDM'] = "IDM=$IDM";
      if(isset($CERCA)) $opt['CERCA'] = "CERCA=$CERCA";
      
      RETURN "?".implode( "&" , $opt);
  }
  
 
  function diaSetmanaText($DIA){
  		
		$ret = ""; list($ANY,$MES,$DIA) = explode("-",$DIA);		
		$DATE = mktime(0,0,0,$MES,$DIA,$ANY);
		switch(date('N',$DATE)){
			case '1': $ret = "Dilluns, ".date('d',$DATE); break;  
			case '2': $ret = "Dimarts, ".date('d',$DATE); break;
			case '3': $ret = "Dimecres, ".date('d',$DATE); break;
			case '4': $ret = "Dijous, ".date('d',$DATE); break;
			case '5': $ret = "Divendres, ".date('d',$DATE); break;
			case '6': $ret = "Dissabte, ".date('d',$DATE); break;
			case '7': $ret = "Diumenge, ".date('d',$DATE); break;				
		}
				
		switch(date('m',$DATE)){
			case '01': $ret .= " de gener"; break;
			case '02': $ret .= " de febrer"; break;
			case '03': $ret .= " de març"; break;
			case '04': $ret .= " d'abril"; break;
			case '05': $ret .= " de maig"; break;
			case '06': $ret .= " de juny"; break;
			case '07': $ret .= " de juliol"; break;
			case '08': $ret .= " d'agost"; break;
			case '09': $ret .= " de setembre"; break;
			case '10': $ret .= " d'octubre"; break;
			case '11': $ret .= " de novembre"; break;
			case '12': $ret .= " de desembre"; break;
		}
		
		$ret .= " de ".date('Y',$DATE);
		
		return $ret;
  
	}
  
  
  function diaSetmana($date)
  {
  	
  	list($d,$m,$Y) = explode("-",$date);
  	$dia = date('N',mktime(0,0,0,$m,$d,$Y));
  	
  	switch($dia){
  		case 1: return 'DILLUNS';   break;
  		case 2:	return 'DIMARTS';   break;
  		case 3:	return 'DIMECRES';  break;
  		case 4:	return 'DIJOUS';    break;
  		case 5:	return 'DIVENDRES'; break;
  		case 6:	return 'DISSABTE';  break;
  		case 7:	return 'DIUMENGE';  break;
  	}
  	
  }

?>

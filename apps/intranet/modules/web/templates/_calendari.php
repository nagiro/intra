<?php use_helper('Form')?>
<style>

    #destacats{
        font-size:12px; 
        font-weight:bold; 
        text-align:center;                 
        background-color:#CCCCCC; 
        color:#606060;        
    }
    
    #titol_noticia { 
        color: #999999; 
        font-weight:bold; 
        font-size:10px; 
        padding-top:10px; 
    }
    
    #contingut_noticia { 
        text-align:right;
        padding-bottom:10px; 
        border-bottom:2px solid #CCCCCC;         
    }
    
    .div_taula .HIHAACTIVITAT { color:yellow; font-weight: bold; }

</style>
<TD class="CALENDARI">
	<CENTER>

	<form action="<?php echo url_for('web/index') ?>" method="POST" name="form_calendari">
    	
      <TABLE class="CAL">      
        <TR><TD><input style="width:140px; color:gray;" value="Escriu per cercar..." type="text" name="CERCA"></input>
        		<?php echo submit_image_tag('intranet/lupa.png',array('value'=>'BCERCA','name'=>'BCERCA')) ?>         		
        		<br /><br />
        	</TD>
        </TR>                         
        <TR><TD><?php getCalendari( $DATACAL , $ACTIVITATS_CALENDARI , $CERCA ); ?></TD></TR>
        <TR><TD id="destacats">DESTACATS</TD></TR>
                                 
 		<?php 
		
			foreach($BANNERS as $B):
                									
				$URL = (empty($B['URL']) || is_null($B['URL']))?'web/index':$B['URL'];                                
				try{
                    echo '<TR><TD id="titol_noticia">&raquo; '.$B['Nom'].'</TD></TR>';
    				echo '<TR><TD id="contingut_noticia">'.link_to(
    									image_tag(
    										'banners/'.$B['IMG'] , 
    										array('class'=>'BANNER')), 
    										url_for( $URL , true ), 
    									array('target' => '_NEW' )).
    					'</TD></TR>';
                    } catch (Exception $e){echo 'Caught exception: '.$URL,  $e->getMessage(), "\n";}
			endforeach;
	
		?>
        
      </TABLE>      
    </CENTER>      
    </TD>


<?php 

function getCalendari( $DATA , $ACTIVITATS_CALENDARI , $CERCA ){

  $mes = date('m',$DATA);
  $any = date('Y',$DATA);
  
  $MesAnterior = mktime( 0 , 0 , 0 , date( 'm' , $DATA ) - 1 , 1 , date( 'Y' , $DATA ) );
  $MesSeguent  = mktime( 0 , 0 , 0 , date( 'm' , $DATA ) + 1 , 1 , date( 'Y' , $DATA ) );
  $DataMesActual = mktime( 0 , 0 , 0 , date( 'm' , $DATA ) , 1 , date( 'Y' , $DATA ) );
  
  echo '<DIV class="div_taula">';
  echo '<table class="t_calendari">';  
  echo '<tr>
          <td width="25" style="background-color:white;" class="titol">'.link_to('&lt;',"web/index?accio=cdc&DATACAL=$MesAnterior").'</td>
          <td colspan="5" style="background-color:white;" class="titol">'.link_to(mesos($mes).' '.$any,'web/index'.getParam('c','mensual',$DataMesActual)).'</td>         
          <td width="25" style="background-color:white;" class="titol">'.link_to('&gt;',"web/index?accio=cdc&DATACAL=$MesSeguent").'</td>
        </tr>';
  echo '<tr>
          <td width="25" class="dies">Dll</td>
          <td width="25" class="dies">Dm</td>
          <td width="25" class="dies">Dc</td>
          <td width="25" class="dies">Dj</td>
          <td width="25" class="dies">Dv</td>
          <td width="25" class="dies">Ds</td>
          <td width="25" class="dies">Dg</td>
        </tr>';


  $diaInicial    = date( 'N' , mktime( 0 , 0 , 0  , $mes , 1 , $any ) );
  $setmanaActual = date( 'W' , mktime( 0 , 0 , 0  , date( 'm' , time() ) , date( 'd' , time() ) , date( 'Y' , time() ) ) );
  $diesMes       = date( 't' , mktime( 0 , 0 , 0  , $mes , 1 , $any ) );
  
  for($i = 1; $i < 7 ; $i++):             //Setmanes que caben a un calendari
    echo '<tr>'; 
    for($j = 1; $j < 8 ; $j++ ):          //Dia de la setmana      
      
      $diaA = (($i-1)*7)+$j+1-$diaInicial; 
      $class = ""; $valor = "";
            
      $setmanaIterator = date( 'W' , mktime( 0 , 0 , 0 , $mes , $diaA , $any ) );
      
      //Si és cap de setmana ho posem en negreta
//      if( $j == 7 || $j == 6 ) $class = 'bold';
      
      //Si la setmana actual és a la que estem, ho marquem amb vermell      
      if( $setmanaActual == $setmanaIterator ) $class .= ' selsetmana'; else $class .= ' numeros';  
      
      //Finalment omplim el dia si hi ha número
      if( ( $i==1 && $diaInicial > $j ) || ( $diesMes < $diaA )) $valor = "&nbsp;";
      else $valor = $diaA;
    
      if( $valor <> "&nbsp;" ) {                 
      	$valor = link_to( $valor , 'web/index'.getParam('ca','',mktime(0,0,0,$mes,$diaA,$any)));
      	if(isset($ACTIVITATS_CALENDARI[date('Y-m-d',mktime(0,0,0,$mes,$diaA,$any))])) $class .= ' HIHAACTIVITAT';
      }
                 
      echo '<td width="25" class="'.$class.'">'.$valor.'</td>';
      
    endfor;
    echo '</tr>';
  endfor;
  
  echo '</table></DIV>';
}

function getParam($ACCIO , $CERCA , $DATA)
{
   $RET = array();
   
   if(!empty($ACCIO)) $RET['accio'] = "accio=$ACCIO";
   if(!empty($CERCA)) $RET['CERCA'] = "CERCA=$CERCA";
   if(!empty($DATA))  $RET['DATACAL'] = "DATACAL=$DATA";
   
   return "?".implode('&',$RET);  
}

function mesos($mes)
{
  switch($mes){
    case '1': return 'Gener';
    case '2': return 'Febrer';
    case '3': return 'Març';
    case '4': return 'Abril';
    case '5': return 'Maig';
    case '6': return 'Juny';
    case '7': return 'Juliol';
    case '8': return 'Agost';
    case '9': return 'Setembre';
    case '10': return 'Octubre';
    case '11': return 'Novembre';
    case '12': return 'Desembre';  
  }
}



?>

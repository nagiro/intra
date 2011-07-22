<?php use_helper('DateForm'); ?>
<?php use_helper('Date'); ?>

<STYLE>
#HORA { width: 50px; }
.NOTICIA { vertical-align: top; }
.COL2 { vertical-align: top; padding-left:40px; width:60%; }
.CALENDARI { font-size: 12px; border-collapse:collapse; }
.CALENDARI A { text-decoration:none; color:black; }
.CALENDARI A:hover { text-decoration:none; color:black; font-weight: bolder; }
.CALENDARI A:visited {text-decoration:none; color:black; }
#TIME { border: 1px gray solid; }
SELECT {  border: 1px gray solid; background-color: rgb(250,254,218); margin:2px; }
#HORA { border: 1px whitesmoke solid; background-color: rgb(250,254,218); margin:2px; }
#DIA { border: 1px whitesmoke solid; background-color: white; margin:2px; }
</STYLE>

 

<script type="text/javascript">   
       
/*   $(document).ready(function(){
    alert('hello');
    $('#HORA').change(function(){ alert($(this).text());} );          
   });  
  
  
  
  function canvia($val)
  {    
    alert("asdf"+$val.text());    
  }
*/
</script>

    <TD colspan="3" class="CONTINGUT_ADMIN" style="padding-left:30px;">    
    
      <?php echo nice_form_tag('gestio/gHoraris',array('method'=>'post')); ?>
    
         
    <TABLE width="100%"><TR><TD>

        <TABLE class="BOX2">
          <TR><TD class="NOTICIA">                
                  <DIV class="TITOL">Calendari d'activitats</DIV>
                  <TABLE class="CALENDARI">
                  <?php                 
                    
                    $DATA = explode("-",$DATAI);
                    $MES = intval($DATA[1]); 
                    $ANY = intval($DATA[0]);                                                            
                    echo llistaCalendariV($DI , $MES, $ANY , $VARIAMES , $VARIAANY , $PAGINA , $IDA , $ACCIO);
  
                  ?>
                  </TABLE>                                                                  
              </TD>
          </TR>
        </TABLE>
      </TD>
      <TD class="COL2">
        <TABLE class="BOX2">
            <TR><TD class="NOTICIA">                
                    <DIV class="TITOL">Calendari d'activitats</DIV>
                    <?php echo input_hidden_tag('ACCIO','S'); ?>
                    <?php echo input_hidden_tag('IDA',$ACTIVITAT->getActivitatid()); ?>
                    <TABLE class="DADES" width="100%">
                      <TR><TD class="LINIA"> Hora Muntatge </TD><TD><?php echo input_tag('DI[HORAPRE]',$DI['HORAPRE'],array('id'=>'HORA')); ?></TD></TR>
                      <TR><TD class="LINIA"> Hora Inici </TD><TD><?php echo input_tag('DI[HORAI]',$DI['HORAI'],array('id'=>'HORA')); ?> </TD></TR>                    
                      <TR><TD class="LINIA"> Hora Fi </TD><TD><?php echo input_tag('DI[HORAF]',$DI['HORAF'],array('id'=>'HORA')); ?> </TD></TR>
                      <TR><TD class="LINIA"> Hora Desmuntatge</TD><TD><?php echo input_tag('DI[HORAPOST]',$DI['HORAPOST'],array('id'=>'HORA')); ?> </TD></TR>
                      <TR><TD class="LINIA"> Espais <br /> <?php echo select_tag('DI[ESPAIS]',options_for_select(EspaisPeer::select(),$DI['ESPAIS']), array('multiple'=>true)); ?> </TD> <TD class="LINIA"> Material <br /> <?php echo select_tag('DI[MATERIAL]',options_for_select(MaterialgenericPeer::select(),$DI['MATERIAL']), array('multiple'=>true)); ?> </TD> </TR>                             
                    </TABLE>
                    <?php echo submit_tag('SEGUIR...',array('name'=>'Seguir')); ?>
                    <?php  ?>
                    <?php IF($LEVEL1):
                            //Mostrem per tots els dies, els espais reservats i el material. 
                            echo '<BR /><BR />';                            
                            echo '<table class="DADES" border="1">';                                                        
                            foreach($LINIA as $K=>$L):                                                            
                              echo '<TR>';
                              echo '<TD>';                                                
                                    if(isset($ERRORS[$K]['DATA'])) echo '<div class="ERRORS">'.$ERRORS[$K]['DATA'].'</DIV><br />';                                    
                                    if(isset($ERRORS[$K]['DIA'])) echo '<div class="ERRORS">'.$ERRORS[$K]['DIA'].'</DIV>';                                    
                              echo  input_tag("D[$K][DIA]",$L['DIA'],array('id'=>'DIA')).'<br />'.
                                    input_tag("D[$K][HORAPRE]",$L['HORAPRE'],array('id'=>'HORA')).' - '.
                                    input_tag("D[$K][HORAI]",$L['HORAI'],array('id'=>'HORA')).' - '.                                                                        
                                    input_tag("D[$K][HORAF]",$L['HORAF'],array('id'=>'HORA')).' - '.
                                    input_tag("D[$K][HORAPOST]",$L['HORAPOST'],array('id'=>'HORA')).
                                  '</TD>';                              
                              echo '<TD>';
                                    if(isset($ERRORS[$K]['ESPAIS'])) echo '<div class="ERRORS">'.$ERRORS[$K]['ESPAIS'].'</DIV><br />'; 
                                    foreach($L['ESPAIS'] as $E) echo select_tag("D[$K][ESPAIS][]",options_for_select(EspaisPeer::select(),$E,array('include_blank' => true)), array('multiple'=>false)).'<br />'; echo '</TD>';
                              echo '<TD>'; foreach($L['MATERIAL'] as $M) echo select_tag("D[$K][MATERIAL][]",options_for_select(MaterialgenericPeer::select(),$M,array('include_blank' => true)), array('multiple'=>false)).'<BR />'; echo '</TD>';                                                                                          
                              echo '</TR>';
                              
                            endforeach;
                            echo '</table>';
                            echo submit_tag('Afegir extres',array('name'=>'Extra'));                                                                                                                  
                            echo submit_tag('Guardar',array('name'=>'Save'));
                          ENDIF; ?>
                                                                                                                         
                </TD>
            </TR>
          </TABLE>
      </TD>
      </TR></TABLE>  
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    
    
<!-- FI CONTINGUT -->
<!-- CALENDARI -->
 <!-- >
    <TD class="CALENDARI">          
      
    </TD>
-->
<!-- FI CALENDARI -->

<?php 

function creaOpcions($IDA , $ACCIO , $PAGINA , $VARIAMES , $VARIAANY )
{  

  //Opció de veure i modificar si té múltiples horaris
  //Opció per editar l'activitat
  //Opció per veure les tasques assignades (Amb Data)
   
  
  $R  = link_to(image_tag('tango/32x32/actions/edit-find-replace.png', array('size'=>'16x16','alt'=>'Edita o visualitza una activitat')),'gestio/gUsuaris'.getPar($PAGINA,$IDA,'E',NULL,NULL,NULL,$VARIAMES,$VARIAANY));  
  $R .= link_to(image_tag('tango/32x32/actions/mail-forward.png', array('size'=>'16x16','alt'=>'Edita o visualitza les dades')),'gestio/gUsuaris'.getPar($PAGINA,$IDA,'L',NULL,NULL,NULL,$VARIAMES,$VARIAANY));
  $R .= link_to(image_tag('tango/32x32/categories/applications-accessories.png', array('size'=>'16x16','alt'=>'Edita o visualitza les dades')),'gestio/gUsuaris'.getPar($PAGINA,$IDA,'C',NULL,NULL,NULL,$VARIAMES,$VARIAANY));  
  
  return $R;
}


function getPar($PAGINA = NULL, $IDA = NULL, $ACCIO = NULL , $ANY = NULL , $MES = NULL , $DIA = NULL , $VARIAMES = NULL , $VARIAANY = NULL )
{
    $A = "";    
    if(!is_null($PAGINA))   $A[] = 'PAGINA='.$PAGINA;
    if(!is_null($IDA))      $A[] = 'IDA='.$IDA;
    if(!is_null($ACCIO))    $A[] = 'ACCIO='.$ACCIO;
    if(!is_null($ANY))      $A[] = 'ANY='.$ANY;
    if(!is_null($MES))      $A[] = 'MES='.$PAGINA;
    if(!is_null($DIA))      $A[] = 'DIA='.$DIA;    
    if(!is_null($VARIAMES)) $A[] = 'VARIAMES='.$VARIAMES;
    if(!is_null($VARIAANY)) $A[] = 'VARIAANY='.$VARIAANY;
    if(!empty($A)) return '?'.implode('&',$A); 
    else return '';
    
}


  function llistaCalendariH($mes = null, $year = null, $CALENDARI = NULL, $VARIAMES = NULL, $VARIAANY = NULL, $PAGINA , $IDA , $ACCIO )
  {
    
    //Agafo un mes... marco els dies blanc i començo a escriure
    if($mes==null) $mes = date("m",time());
    if($year == NULL) $year = date('Y',time());        
    $mesI = $mes; $any = $year;
  	$mesF = date('m',mktime(0,0,0,$mes+12,1,$year));		
  
    $mesF = $mesI+6;                    //De moment només sumem 3 mesos
    if($mesF > 12) $mesF = $mesF-12;      
         
    $RET = "<TR><TD></TD>";
    for($i = 6; $i>0; $i--):
      $RET .= "<TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD>";
    endfor;
    $RET .= "</TR>";
    
    for($mes = $mesI; $mes < $mesF; $mes++):
      
      $dies = cal_days_in_month(CAL_GREGORIAN, $mes, $any );                            //Mirem quants dies té el mes      
      $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes , 1 , $any) , 0 );       //Marquem quants blancs volem tenir      
      if($diaSetmana == 0) $blancs = 6-1; else  $blancs = $diaSetmana-2;
      
      if($mes % 2) $background = "beige"; else $background = "white";                   //Mirem el color del fons
      $RET .= "<TR><TD>".mesos($mes)."</TD>";
      
      for($dia = 0; $dia < 40; $dia++):                                             //Generem el calendari
        $diaA = $dia-$blancs;
        if($dia <= $blancs || $diaA > $dies):                                        //Si és blanc el marquem com a tal i si el dia ha passat el màxim de dies del mes no el marquem
          $RET .= "<TD></TD>";
        else:                                  
          $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes , $diaA , $any) , 0 );
          if( $diaSetmana == 6 || $diaSetmana == 0) $background="beige"; else $background = "white"; 
          if(isset($CALENDARI[intval($any)][intval($mes)][intval($diaA)])) $background = "RED";
          
          $RET .= '<TD class="DIES" style="background-color:'.$background.'; text-align:center;">'.link_to($diaA,"gestio/gActivitats".getPar($PAGINA , $IDA , 'C' , $any , $mes , $diaA , $VARIAMES , $VARIAANY ))
                  .' '.checkbox_tag('DIES[]',mktime(0,0,0,$mes,$dia,$any),false).
                  '</TD>';          
                              
        endif;    
      endfor;
      $RET .= "</TR>";
      if($mes == 12) $any = $any+1;
    endfor;
          
    return $RET;
      
  }

  function llistaCalendariV($DI , $mes = null, $year = null, $VARIAMES = NULL, $VARIAANY = NULL, $PAGINA , $IDA , $ACCIO )
  {

    if($mes==null) $mes = date("m",time());
    if($year == NULL) $year = date('Y',time());        
    $mesI = $mes; $any = $year; $anyF = $year;
  	$mesF = date('m',mktime(0,0,0,$mes+12,1,$year));		
  
    $mesF = $mesI+6;                    //De moment només sumem 3 mesos
    if($mesF > 12) { $mesF = $mesF-12; $anyF = $any+1; }      
         
    $RET = "<TR><TD></TD><TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD></TR>";

//    01 02 03 04 05 06 00 
//    Dl Dm Dc Dj Dv Ds Dg
//MES          01 02 03 04
//    05 06 07 08 09 10 11
//    12 13 14 15 16 17 18
//    19 20 21 22 23 24 25
//    26 27 28 29 30 01 02
//MES 03 04 05 06 07 08 09

    $blancs = 1; $dia = 1; $sincronitzat = false;
    
    while($mes < $mesF && $any <= $anyF):

      $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes , $dia , $any) , 0 ); 
      if($diaSetmana == 1): $RET .= '</TR><TR><TD>'.mesos($mes).'</TD>'; endif;
      
      //Anem dibuixant espais en blanc fins que sincronitzem
      if($blancs <> $diaSetmana && !$sincronitzat):
        
        $RET .= "<TD></TD>";
        if($blancs == 7) $blancs = 0; //Si el primer dia és diumenge
        else $blancs++; 
                          
      else:         
        $sincronitzat = true;
                        
        if( $mes % 2 <> 0) $background="beige"; else $background = "white";
        if( $diaSetmana == 6 || $diaSetmana == 0) $background="burlywood";                         
        if(in_array(mktime(0,0,0,$mes,$dia,$any),$DI['DIES'])):                        //Si el dia el tenim seleccionat el marquem
          $RET .= '<TD class="DIES" style="background-color:'.$background.'; text-align:right;">'.$dia.' '.checkbox_tag('DI[DIES][]',mktime(0,0,0,$mes,$dia,$any),true).
                  '</TD>';                                                    
        else: 
          $RET .= '<TD class="DIES" style="background-color:'.$background.'; text-align:right;">'.$dia.' '.checkbox_tag('DI[DIES][]',mktime(0,0,0,$mes,$dia,$any),false).
                  '</TD>';                                                            
        endif;
        
        if(cal_days_in_month(CAL_GREGORIAN, $mes, $any ) <= $dia){ $dia = 1; if(++$mes > 12) $any++; }
        else $dia++;
        
      endif;
  
    endwhile;
        
    return $RET;
      
  
  }



  function mesos($mes)  
  {
    switch($mes){
      case 1: $text = "Gener"; break;
      case 2: $text = "Febrer"; break;
      case 3: $text = "Març"; break;
      case 4: $text = "Abril"; break;
      case 5: $text = "Maig"; break;
      case 6: $text = "Juny"; break;
      case 7: $text = "Juliol"; break;
      case 8: $text = "Agost"; break;
      case 9: $text = "Setembre"; break;
      case 10: $text = "Octubre"; break;
      case 11: $text = "Novembre"; break;
      case 12: $text = "Desembre"; break;
    }
    
    return utf8_encode($text);
  
  }

  function fletxeta()
  {
    return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));
  }


?>

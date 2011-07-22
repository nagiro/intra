<?php use_helper('Form')?>

<style>

	.DH { display:block; float:left; padding-top:5px; }

	fieldset { border:3px solid #F3F3F3; margin-right:40px; padding:10px; }
	.MISSAT { color:black; font-weight:bold; font-size:10px; vertical-align:middle; text-align:center; background-color:White; padding-bottom:10px; }
	.CURS { font-size: 12px; padding:5px; vertical-align:bottom;  }
	.LLEGENDA { font-size:12px; font-weight:bold; padding:10px 10px 10px 10px;  }
	TEXTAREA { border:1px solid #CCCCCC; width:90%; }
	.DADES .LINIA .blue { color:blue; }
	.DADES .LINIA .blue:hover { color:blue; }
	.DADES .LINIA .blue:visited { color:blue; }
	.OPCIONS { padding-left:10px; padding-top:5px; }
	.TITOL_CATEGORIA { background-color: #DD9D9A; color:black; font-weight:bold; padding:5px; font-size:10px; }	
	
</style>


<script type="text/javascript">

	function vacio(q){for(i=0;i<q.length;i++){if(q.charAt(i)!=" "){return true}}return false}  

	function ValidaReserva(){	
		if(valida_nif_cif_nie(fRegistre.usuaris_DNI.value) < 1) { alert("El DNI entrat no és correcte. \nRecordi escriure el format 99999999A. "); return false; }		
		if(vacio(fRegistre.usuaris_Passwd.value)== false){ alert("Has d\'entrar una contrasenya"); return false; }
		if(vacio(fRegistre.usuaris_Nom.value)== false){ alert("Has d'omplir el nom"); return false; }
		if(vacio(fRegistre.usuaris_Cog1.value)== false){ alert("Has d'omplir el primer cognom"); return false; }
		if(vacio(fRegistre.usuaris_Cog2.value)== false){ alert("Has d'omplir el segon cognom"); return false; }
		if(isValidEmail(fRegistre.usuaris_Email.value) == false){ alert("L'adreça de correu electrònic és incorrecta"); return false; }
		if(vacio(fRegistre.usuaris_Adreca.value)== false){ alert("Has d'omplir l'adreça postal"); return false; }
		if(vacio(fRegistre.usuaris_CodiPostal.value)== false){ alert("Has d'omplir el codi postal"); return false; }
		if(fRegistre.usuaris_Poblacio.selectedIndex<1){ alert("Has d'escollir alguna població"); return false; }				
		if(vacio(fRegistre.usuaris_Telefon.value)== false){ alert("Has d'omplir el telèfon"); return false; }
		
		return true;
			
	}

	function isValidEmail(str) {
   		return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
	}

	//Retorna: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF error, -2 = CIF error, -3 = NIE error, 0 = ??? error
	function valida_nif_cif_nie(a) 
	{	
		var temp=a.toUpperCase();
		var cadenadni="TRWAGMYFPDXBNJZSQVHLCKE";
	 
		if (temp!==''){
			if ((!/^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$/.test(temp) && !/^[T]{1}[A-Z0-9]{8}$/.test(temp)) && !/^[0-9]{8}[A-Z]{1}$/.test(temp)){return 0;}
			if (/^[0-9]{8}[A-Z]{1}$/.test(temp))
			{posicion = a.substring(8,0) % 23;letra = cadenadni.charAt(posicion);var letradni=temp.charAt(8);if (letra == letradni){return 1;}else{return -1;}}
			suma = parseInt(a[2])+parseInt(a[4])+parseInt(a[6]);
			for (i = 1; i < 8; i += 2){temp1 = 2 * parseInt(a[i]);temp1 += '';temp1 = temp1.substring(0,1);temp2 = 2 * parseInt(a[i]);temp2 += '';temp2 = temp2.substring(1,2);if (temp2 == ''){temp2 = '0';}suma += (parseInt(temp1) + parseInt(temp2));}
			suma += '';
			n = 10 - parseInt(suma.substring(suma.length-1, suma.length));
			if (/^[KLM]{1}/.test(temp)){if (a[8] == String.fromCharCode(64 + n)){return 1;}else{return -1;}}
			if (/^[ABCDEFGHJNPQRSUVW]{1}/.test(temp)){temp = n + '';if (a[8] == String.fromCharCode(64 + n) || a[8] == parseInt(temp.substring(temp.length-1, temp.length))){return 2;}else{return -2;}}
			if (/^[T]{1}/.test(temp)){if (a[8] == /^[T]{1}[A-Z0-9]{8}$/.test(temp)){return 3;}else{return -3;}} 
			if (/^[XYZ]{1}/.test(temp)){pos = str_replace(['X', 'Y', 'Z'], ['0','1','2'], temp).substring(0, 8) % 23;if (a[8] == cadenadni.substring(pos, pos + 1)){return 3;}else{return -3;}}
		}
 
		return 0;
	}

</script>

<TD colspan="3" class="CONTINGUT">

<?php if($ESTAT == 'ALTA_OK'):?>


   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Registre de nou usuari</LEGEND>   
	   <div>
	   		Usuari donat d'alta correctament.<br />
	   		Cliqui <?php echo link_to('aquí',url_for('web/login'))?><a> si vol accedir al portal de la Casa de Cultura de Girona.   
	   </div>	   	      
   </FIELDSET>


<?php else: ?>
   
   <form action="<?php echo url_for('web/registrat')?>" method="post" name="fRegistre" onSubmit="return ValidaReserva(this);">
      
   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Registre de nou usuari</LEGEND>   
   <TABLE class="FORMULARI">
   <tr><td width="100px"></td><td><td></tr>
   	<?php
   	   
	   if($ESTAT == 'DUPLICAT') echo '<TR><TD class="ERROR" colspan="2">L\'usuari ja existeix.<br /> Si vol que li enviem la contrasenya al seu correu cliqui '.link_to('aquí','web/remember',array('class'=>'taronja')).'<BR /><BR /></TD></TR>';              	               
	   echo $FUSUARI;
	       	
    ?>
   <TR><TD></TD><TD><br /><br /><?php echo submit_tag('Registra\'m',array('class'=>'BOTO_ACTIVITAT','style'=>'width:100px;')); ?></TD></TR> 
   </TABLE>
      
   </FIELDSET>       


   
   </FORM>	
 
 <?php endif; ?>
 
   <DIV STYLE="height:40px;"></DIV>
   
</TD>
<STYLE>
.T1 { display:block; width:100px; float:left;  }
.T2 { display:block; width:200px; float:left; }
.T3	{ width:120px; font-size:10px; }
.content { padding:20px; }
.REQUADRE { margin:0px; }
</STYLE>

    <TD colspan="3" class="CONTINGUT">
        
		<form action="<?php echo url_for('gestio/login') ?>" method="POST" name="form_login">    
		    <DIV class="REQUADRE" style="width:500px">
		    	<div class="FORMULARI" style="width:500px;">
		    	<?php if($ERROR != ""): ?><div class="error" style="padding-bottom:10px;"><?php echo $ERROR?></div><?php endif; ?>          		    	
			    	<div>	
			    			<span class="T1"><b>DNI: </b></span>
			    			<span><?php echo $FLogin['nick']->render(); ?></span>
			    	</div>
			    	<div style="clear:both;">	
			    			<span class="T1"><b>Contrasenya: </b></span>
			    			<span><?php echo $FLogin['password']->render(); ?></span>
			    	</div>
			    	
			    	<?php $missatge = "Segueixi si vostè estar segur que: \\n 1.- No ha estat alumne de la Casa de Cultura. \\n 2.- Vostè no té cap usuari creat. \\n Si no n\'està segur, si us plau, cliqui cancel·lar i contacti amb la Casa de Cultura trucant al telèfon 972.20.20.13 o bé enviant un correu a informatica@casadecultura.org."; ?>
			    	
			    	<div style="clear:both; padding-top:20px;">
	            		<button type="submit" style="width: 120px;" name="form_login" class="BOTO_ACTIVITAT">Cliqueu per accedir</button>	            		
	            		<button style="width: 130px;" onClick="return confirm('<?php echo $missatge ?>')" type="submit" class="BOTO_ACTIVITAT" name="form_login_new" class="web">Creeu un compte nou*</button>
	            		<button style="width: 120px;" type="submit" name="form_login_remember" class="BOTO_ACTIVITAT">Recordar contrasenya</button>		            					    	
			    	</div>
			    	
			    	<div style="clear:both; padding-top:20px;">
			    		<p style="color:gray; font-size:10px; text-align:justify;">
			    			* Només hauran de crear un compte nou aquells usuaris que no hagin cursat cap curs amb anterioritat a la Casa de Cultura de Girona. 
			    			  Si vostè n'ha cursat algun i no sap o no recorda la seva contrasenya premi a <b>Recordar contrasenya</b> o bé posi's en contacte amb la Casa de Cultura de Girona trucant al telèfon 972.20.20.13 o enviant un correu a informatica@casadecultura.org. 			    			
			    		</p>	            				            					    	
			    	</div>
			    </div>
		    	
		    </DIV>
		    			    	
	    </form>   
            
      <DIV STYLE="height:40px;"></DIV>
    
       
    </TD>
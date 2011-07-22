<script type="text/javascript">

	 $(document).ready(function() {

	   $( "#tabs" ).tabs({ cookie: { expires: 1 } });

         $('#new_user').validate({            
                rules:{
                    "usuaris[DNI]": { required: true, rangelength: [9, 9] },
                    "usuaris[Passwd]": { required: true },
                    "usuaris[Nom]": { required: true },
                    "usuaris[Cog1]": { required: true },
                    "usuaris[Cog2]": { required: false },
                    "usuaris[Email]": { required: true , email: true },
                    "usuaris[Adreca]": { required: true },
                    "usuaris[CodiPostal]": { required: true , number: true },
                    "usuaris[Poblacio]": { required: false },
                    "usuaris[Poblaciotext]": { required: function(){ return ($('#usuaris_Poblacio option:selected').val() == 227); } },
                    "usuaris[Telefon]": { required: false },
                    "usuaris[Mobil]": { required: function(){ return ($('#usuaris_Telefon').val().length == 0); }}                                        
                },
                messages: {
                    "usuaris[DNI]": { rangelength: "<br />Format: 00000000A o X0000000A." }
                }
         });
    });
                                     
</script>

<STYLE>

.T1 { display:block; width:100px; float:left;  }
.T2 { display:block; width:200px; float:left; }
.T3	{ width:120px; font-size:10px; }
.content { padding:20px; }
.REQUADRE { margin:0px; }
LEGEND { font-weight:bold; padding-left:10px; padding-right:10px; font-size:12px;  }

</STYLE>

    <TD colspan="3" class="CONTINGUT_ADMIN">
    
    <?php if(!isset($FUSUARI)): ?>    
        
		<form action="<?php echo url_for('gestio/uLogin') ?>" method="POST">    
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
                    <div style="clear:both; margin-top:10px;">	
			    			<span class="T1"><b>Entitat: </b></span>
			    			<span><?php echo $FLogin['site']->render(); ?></span>
			    	</div>
			    	
			    	<?php $missatge = "Segueixi si vostè estar segur que: \\n 1.- No ha estat alumne de la Casa de Cultura. \\n 2.- Vostè no té cap usuari creat. \\n Si no n\'està segur, si us plau, cliqui cancel·lar i contacti amb la Casa de Cultura trucant al telèfon 972.20.20.13 o bé enviant un correu a informatica@casadecultura.org."; ?>
			    	
			    	<div style="clear:both; padding-top:20px;">
	            		<button type="submit" style="width: 120px;" name="BLOGIN" class="BOTO_ACTIVITAT" value="Cliqueu per accedir" />Cliqueu per accedir </button>	            			            		
                        <button type="submit" style="width: 120px;" name="BNEWUSER" class="BOTO_ACTIVITAT" value="Nou usuari" />Nou usuari</button>
	            		<button type="submit" style="width: 120px;" name="BREMEMBER" class="BOTO_ACTIVITAT" value="Recordar contrasenya" />Recordar contrasenya</button>
                        <div style=" float:right; padding-top: 0px;">                        
                            <a href="<?php echo $FB['logUrl'] ?>">
                                <?php echo image_tag('facebook_login_button.png'); ?>
                            </a>
                        </div>     					    			                               
			    	</div>
			    	
			    </div>
		    	
		    </DIV>
		    			    	
	    </form>   
            
      <DIV STYLE="height:40px;"></DIV>
    
    
    <?php else: ?>

		<form id="new_user" action="<?php echo url_for('gestio/uLogin') ?>" method="POST">    
		                		    			    	
        	   <FIELDSET class="REQUADRE" style="width:500px;">
                <LEGEND class="LLEGENDA">Nou usuari</LEGEND>
        	      
                    <table class="FORMULARI">                    
                        <?php echo $FUSUARI ?>
                    </table>
                    <div style="text-align:right">
                        <button type="submit" name="BSAVENEWUSER" class="BOTO_ACTIVITAT" >
                            <?php echo image_tag('template/accept.png').' Vull ser usuari/a' ?>
                        </button>                        
                        
                    </div>
                    <?php echo link_to(image_tag('template/arrow_left.png').' Tornar','gestio/uLogin') ?>
                
                </FIELDSET>                                                                                                            
		    			    	
	    </form>   
            
      <DIV STYLE="height:40px;"></DIV>

    <?php endif; ?>
       
    </TD>
<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = sfConfig::get('sf_webrooturl').'images/hospici'; ?>
 
<script type="text/javascript">

	 $(document).ready(function() {
	   
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
                "usuaris[Mobil]": { required: function(){ return ($('#usuaris_Telefon').val().length == 0); }},
                "usuaris[captcha2]": { required: true }                                        
            },
            messages: {
                "usuaris[DNI]": { rangelength: "<br />Format: 00000000A o X0000000A." }
            }
     });
    });
                                     

</script> 
 
<div class="h_subtitle_gray">
    NOU MEMBRE DE L'HOSPICI
</div>

<?php if($SECCIO == 'INICI'): ?>

<div>
    Benvingut a l'Hospici.<br /><br /> 
    Si està veient aquesta pàgina és perquè vostè vol ser membre o bé ha clicat l'enllaç <b>Vull ser-ne membre</b>. 
    Aquest procés és gratuït i només haurà d'emplenar els formularis que li apareixen a continuació. 
    Un cop fet això ja podrà utilitzar tots els serveis que oferim.<br />
    <br />                      
</div>

<div style="margin-bottom: 50px;">
    <form id="new_user" action="<?php echo url_for('@hospici_usuaris_alta') ?>" method="post">
        <table class="taula_dades">
            <?php echo $FUSUARI; ?>
        <tr><td></td><td style="padding-top:20px; text-align: right;"><input type="submit" value="Dona'm d'alta" /></td></tr>        
        </table>    
    </form>

</div>

<?php endif; ?>

<?php if($SECCIO == 'GUARDAT'): ?>

<div style="margin-bottom: 50px;">
    <div style="padding:10px; margin-top: 20px; background-color:#FBFFD5;">
        El seu usuari ha estat creat correctament. <br />
        Per poder-lo començar a utilitzar, si us plau, cliqui <?php echo link_to('aquí','@hospici_usuaris'); ?> o bé entri amb les seves dades al portal. <br />
        En cas que no pugui accedir, si us plau envii un correu a informatica@casadecultura.org.<br />
        Moltes gràcies. 
    </div>
</div>

<?php endif; ?>
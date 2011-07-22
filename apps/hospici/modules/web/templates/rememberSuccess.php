<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = sfConfig::get('sf_webrooturl').'images/hospici'; ?>
 
<script type="text/javascript">

	 $(document).ready(function() {
	   
     $('#remember_password').validate({            
            rules:{
                "remember[DNI]": { required: true, rangelength: [9, 9] },
                "remember[captcha2]": { required: true }
            },
            messages: {
                "remember[DNI]": { rangelength: "<br />Format: 00000000A o X0000000A." }
            }
     });
    });
                                     

</script> 
 
<div class="h_subtitle_gray">
    RECORDATORI DE CONTRASSENYA
</div>

<?php if($SECCIO == 'INICI' || $SECCIO == 'ERROR_DNI_VALIDACIO'): ?>

<div>
    Benvingut a l'Hospici.<br /><br /> 
    Si està veient aquesta pàgina és perquè no recorda la seva contrassenya d'accés a l'Hospici o bé ha clicat l'enllaç <b>Recorda contrassenya</b>. 
    Ompli el formulari que li apareixerà més avall i li enviarem al seu correu electrònic la nova contrassenya.
    <br />                      
</div>

<div style="margin-bottom: 50px;">
    <form id="remember_password" action="<?php echo url_for('@hospici_usuaris_remember') ?>" method="POST">
        <table class="taula_dades">
            <?php echo $FREMEMBER; ?>
        <tr><td></td><td style="padding-top:20px; text-align: right;"><input type="submit" value="Envia'm la contrassenya" /></td></tr>        
        </table>    
    </form>

</div>

<?php endif; ?>

<?php if($SECCIO == 'ENVIADA'): ?>

<div style="margin-bottom: 50px;">
    <div class="missatge">
        Li hem enviat la seva contrassenya al seu correu electrònic.<br />
        En el cas que no la rebi en uns minuts, si us plau envii un correu a informatica@casadecultura.org.<br />
        Moltes gràcies. 
    </div>
</div>

<?php endif; ?>

<?php if($SECCIO == 'ERROR_ENVIAMENT'): ?>

<div style="margin-bottom: 50px;">
    <div class="missatge">
        Hi ha hagut algun problema enviant-li el correu electrònic.<br />
        En el cas que no el rebi en uns minuts, si us plau envii un correu a informatica@casadecultura.org.<br />
        Moltes gràcies. 
    </div>
</div>

<?php endif; ?>
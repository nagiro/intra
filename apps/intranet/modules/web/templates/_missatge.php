<STYLE>
.EXPLICACIO { font-size:14px; }
.TITOLAR { font-size:16px; font-weight: bold; }
</STYLE>

    <TD colspan="3" class="CONTINGUT">
    
     <?php 

        switch($MISSATGE)
        {
        
         case '1': ?><DIV style="margin-right:20px;"><span class="TITOLAR">L'usuari no s'ha trobat.</span><BR /><br /><span class="EXPLICACIO">Truqueu al 972 20 20 13 o bé envieu un correu electrònic a informatica@casadecultura.org per informar de l'incidència.</span></DIV><?php break;
         case '2': ?><DIV style="margin-right:20px;"><span class="TITOLAR">Missatge enviat correctament.</span><br /><br /><span class="EXPLICACIO"> Si abans de 24 hores no ha rebut un correu amb la contrasenya a la seva bústia, si us plau comuniqui-ho a la Casa de Cultura de Girona.</span></DIV><?php break;
         default: ?><DIV style="margin-right:20px;"><span class="TITOLAR"><?php echo $MISSATGE ?></span></DIV><?php break;     

        }
     ?>
   
      <DIV STYLE="height:80px;"></DIV>
                
    </TD>
   
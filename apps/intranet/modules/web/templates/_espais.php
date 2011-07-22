<?php use_javascript('thickbox-compressed.js')?>

	<style>
	
		.fotoEspai { height:50px; }
		.Text TD { padding:5px; vertical-align: top; }
		.llistat { list-style: disc; }
		.llistat li { margin-bottom:5px; }
		.col1 { float:left; display:block; width:100px; clear:left; margin-bottom:10px; }
		.col2 { display:block; width:300px; float:left; margin-bottom:10px; }
		.col3 { margin-left:100px; float:left; display:block; margin-top:10px; clear:left; }
		.fi { height:30px; clear:both; }
		div { font-size:11px; }		  
	
	</style>

    <td colspan="3" id="TEXT_WEB" class="CONTINGUT">

	<div style="padding-right:40px; text-align:left;">

		<h2> Espais de la Casa de Cultura de Girona</h2>	
		<p> La Fundació Casa de Cultura de Girona, a més de la seva oferta d’activitats, ofereix un servei de cessió d’espais a persones i entitats que ho requereixin. Per demanar la utilització dels espais del Centre podeu consultar la disponibilitat de sales i equips així com les condicions de cessió a la Secretaria o en aquesta mateixa pàgina web. Cal formalitzar la sol·licitud omplint un formulari que es pot presentar a la Casa de Cultura (Plaça Hospital, 6. Girona) o tramitar en línia. Podeu accedir al formulari clicant als enllaços que trobareu a la descripció de cadascun dels espais o sol·licitar-lo a la mateixa Casa de Cultura. </p>
	    
	    <br />
		<br />
		
        <?php 
            foreach($LLISTAT_ESPAIS as $OE):
                if($OE->getIsllogable()){
                    echo '<h3>'.$OE->getNom().'</h3>';
    	            echo $OE->getDescripcio();    
    	            echo '<div class="col1">Fotografies: </div>';
                    echo '<div class="col2">';
                    foreach($OE->getFotos() as $OM):
                        $URL = OptionsPeer::getString('SF_WEBROOT',1).'images/multimedia/'.$OM->getUrl();
                        $URL_L = str_replace('.jpg','-L.jpg',$OE->getSiteid());                                        
                        echo '<a class="thickbox" title="'.$OE->getNom().'" href="'.$URL_L.'">
                              <img class="fotoEspai" src="'.$URL.'" /></a>';       
                    endforeach;                
                    echo '</div>';
                    echo '<div class="col3">'.link_to("Sol·licitar cessió d'espais",'gestio/uGestio?accio=GESTIONA_RESERVES').'</div>';
            		echo '<div class="fi">&nbsp;</div>';	  		                    
              }
            endforeach;
        
        ?>
<!--         
	    <h3>Auditori Josep Viader</h3>
	    <div class="col1">Situació: </div>		<div class="col2">Planta baixa</div>    
	    <div class="col1">Aforament: </div>		<div class="col2">110 persones</div>
	    <div class="col1">Escenari: </div>		<div class="col2">Òval de 36 metres quadrats</div>	    
	    <div class="col1">Equipament: </div>	<div class="col2"><ul><li>Piano Steinway and sons de gran cua</li><li>Megafonia</li><li>Taula de so digital de 16 canals</li><li>Aire condicionat</li></ul></div>
	    <div class="col1">Fotografies: </div>	<div class="col2"><?php echo generaImatge('Auditori.jpg','Auditori. Vista general'); ?></div>
		<div class="col3"><?php echo link_to("Sol·licitar cessió d'espais",'gestio/uGestio?accio=GESTIONA_RESERVES') ?> </div>
		<div class="fi">&nbsp;</div>	  				
		

	    <h3>Aula Magna</h3>
	    <div class="col1">Situació: </div>		<div class="col2">Primer pis</div>    
	    <div class="col1">Aforament: </div>		<div class="col2">148 persones</div>
	    <div class="col1">Escenari: </div>		<div class="col2">Rectangular de 15 metres quadrats</div>	    
	    <div class="col1">Equipament: </div>	<div class="col2"><ul><li/>Piano Grotian-Steinweg de gran cua<li />Megafonia<li />Taula de so de 6 canals<li />Pantalla de cinema i projector<li />Aire condicionat<li />Opcional: 	Portàtil, Projector, DVD, Internet</ul></div>
	    <div class="col1">Fotografies: </div>	<div class="col2"><?php echo generaImatge('AulaMagna.jpg','Aula Magna. Vista general'); ?></div>
		<div class="col3"><?php echo link_to("Sol·licitar cessió d'espais",'gestio/uGestio?accio=GESTIONA_RESERVES') ?> </div>
		<div class="fi">&nbsp;</div>	  				

	    <h3>Aula B</h3>
	    <div class="col1">Situació: </div>		<div class="col2">Primer pis</div>    
	    <div class="col1">Aforament: </div>		<div class="col2">100 persones</div>
	    <div class="col1">Escenari: </div>		<div class="col2">Rectangular de 15 metres quadrats</div>	    
	    <div class="col1">Equipament: </div>	<div class="col2"><ul><li/>Megafonia<li />Taula de so de 8 canals<li />Opcional: 	Portàtil, Projector, DVD, Internet</ul></div>	    
		<div class="col1">Fotografies: </div>	<div class="col2"><?php echo generaImatge('AulaB.jpg','Aula B. Vista general'); ?></div>
		<div class="col3"><?php echo link_to("Sol·licitar cessió d'espais",'gestio/uGestio?accio=GESTIONA_RESERVES') ?> </div>	    
		<div class="fi">&nbsp;</div>

	    <h3>Aula C</h3>
	    <div class="col1">Situació: </div>		<div class="col2">Primer pis</div>    
	    <div class="col1">Aforament: </div>		<div class="col2">40 persones</div>
	    <div class="col1">Escenari: </div>		<div class="col2">Rectangular de 15 metres quadrats</div>	    
	    <div class="col1">Equipament: </div>	<div class="col2">Opcional: Portàtil, Projector, DVD, Internet</div>	    
		<div class="col1">Fotografies: </div>	<div class="col2"><?php echo generaImatge('AulaC.jpg','Aula C. Vista general'); ?></div>
		<div class="col3"><?php echo link_to("Sol·licitar cessió d'espais",'gestio/uGestio?accio=GESTIONA_RESERVES') ?> </div>	    
		<div class="fi">&nbsp;</div>

	    <h3>Aules 1,2,3,4,5,6 i 7</h3>
	    <div class="col1">Situació: </div>		<div class="col2">Segon pis</div>    
	    <div class="col1">Aforament: </div>		<div class="col2">Entre 20 i 50 persones</div>	    	    
	    <div class="col1">Equipament: </div>	<div class="col2"><ul><li/>Portàtil<li />Projector<li />DVD<li />Internet (Aula 2)</ul></div>	    
		<div class="col1">Fotografies: </div>	<div class="col2"><?php echo generaImatge('Aula1.jpg','Aula 1. Vista general'); ?><?php echo generaImatge('Aula2.jpg','Aula 2. Vista general'); ?><?php echo generaImatge('Aula3.jpg','Aula 3. Vista general'); ?><?php echo generaImatge('Aula4.jpg','Aula 4. Vista general'); ?><?php echo generaImatge('Aula5.jpg','Aula 5. Vista general'); ?><?php echo generaImatge('Aula6.jpg','Aula 6. Vista general'); ?><?php echo generaImatge('Aula7.jpg','Aula 7. Vista general'); ?></div>
		<div class="col3"><?php echo link_to("Sol·licitar cessió d'espais",'gestio/uGestio?accio=GESTIONA_RESERVES') ?> </div>	    
		<div class="fi">&nbsp;</div>
-->	  	 
        <a name="condicions"></a>	
		<h3>Condicions de cessió i ús</h3>
		<p>
			<ul class="llistat" type="circle">
            
<li>1. La cessió d’espais es factura segons els trams indicats en les tarifes. En el cas que una cessió superi la durada prevista d’ocupació de l’espai, cada hora de més es facturarà a 30 euros o s’aplicarà el tram de tarifa immediatament superior, tant en ús comercial com en ús cultural.  En tot cas, sempre s’aplicarà la mesura que sigui més avantatjosa per a l’usuari.
</li><li>2. A partir de les 21 hores, cada hora o fragment d’hora que superi el temps de cessió de l’espai tindrà un cost de 30 euros (40 en cap de setmana), tant en tarifa cultural com en tarifa comercial. 
</li><li>3. La cessió d’espai significa una disponibilitat de sales i de material però no pressuposa l’assistència permanent dels tècnics de la Casa de Cultura a l’acte programat. Aquesta assistència anirà a  càrrec de l’organitzador de l’acte.
</li><li>4. En cas de requerir assistència tècnica continuada, el sol·licitant haurà de contractar serveis professionals. La Casa de Cultura pot facilitar-li el contacte amb els seus proveïdors habituals
</li><li>5. En cap de setmana o festius, la cessió d’espais té un preu de partida de 150 euros en concepte d’assistència i obertura del centre fora dels dies i horaris habituals d’activitat per a mitja jornada i de 250 euros per a jornada completa. Aquesta clàusula s’aplica tant en tarifa comercial com cultural. El preu de lloguer de l’espai se sumarà a les quantitats indicades anteriorment.
</li><li>6. La cessió d’un espai no obliga la Casa de Cultura a incloure l’activitat acollida en el material de difusió, ni imprès ni electrònic, de la seva programació de la Casa de Cultura. 
</li><li>7. No es consideraran, en principi, les sol·licituds que tinguin una previsió superior als 90 dies.
</li><li>8. La Casa de Cultura es reserva el dret de suspendre una sol·licitud aprovada quan concorrin raons de força major o per coincidència amb activitat pròpia de la Fundació Casa de Cultura. En aquest cas proposarà una alternativa als organitzadors de l’acte suspès amb la màxima antelació possible.
</li><li>9. Els desperfectes per ús indegut dels aparells o instal·lacions aniran càrrec del sol·licitant.
</li><li>10. La Casa de Cultura de Girona es reserva el dret de denegar la cessió d’un espai a qualsevol activitat que contradigui els seus objectius fundacionals o no s’ajusti a la seva programació cultural.
</li><li>11. Els serveis de cessió inclouen el de neteja i seguretat bàsics, i el de la responsabilitat civil. Segons la naturalesa de l'activitat proposada, la Casa de Cultura de Girona pot demanar al sol·licitant que es faci càrrec de serveis extraordinaris (assegurança, serveis mèdics, serveis tècnics professionals per a la manipulació d’equips audiovisuals, etc.)
</li><li>12. La venda de productes o serveis necessitarà d'autorització expressa de la Casa de Cultura.
</li><li>13. El sol·licitant en nom propi o dels organitzadors (si és el cas) garanteix que l’activitat programada respectarà el compliment dels drets i deures en matèria de propietat intel·lectual en relació a les obres, interpretacions o activitats que es portin a terme, i assumirà les despeses que se’n puguin derivar.
</li><li>14. La Casa de Cultura de Girona no es fa responsable de rètols o altres elements publicitaris enganxats o dipositats en espais no autoritzats.
</li><li>15. Les dades personals que el sol·licitant faciliti quedaran enregistrades en un fitxer titularitat de la Fundació Casa de Cultura creat per a gestionar les activitats que s’hi porten a terme. La Casa de Cultura es compromet a complir els seus deures de mantenir reserva i d’adoptar les mesures legalment previstes i tècnicament necessàries per evitar-ne un accés o qualsevol classe de tractament no autoritzat. En qualsevol cas el titular de les dades pot exercir els seus drets d’accés, rectificació i cancel·lació tot adreçant-se a: Sr/a. Director/a de la Casa de Cultura, Plaça de l’Hospital 6, 17002 GIRONA, telèfon al 972 202 013 i correu electrònic  secretaria@casadecultura.org.
</li>
                        
            
			</ul>
	    </p>

        <a name="tarifes"></a>	
		<h3>Tarifes de cessió d'espais</h3>        
        <p>En horari de dilluns a divendres, de 9 a 21 hores</p>
		<p>
            <style>
                .taula_preus { border-collapse: collapse; width:700px; text-align:right; }
                .taula_preus th { background-color:#CCCCCC; padding:5px; text-align:left;  }
                .taula_preus .subtitol { background-color:#DDDDDD; padding:5px; font-weight:bold;   }
                .taula_preus td { border-bottom:1px solid #EEEEEE;  }                
            
            </style>
            <table class="taula_preus">                
                <tr><th colspan="4">TARIFA CULTURAL</th></tr>
                <tr><td class="subtitol"></td><td class="subtitol">Fins a tres hores</td><td class="subtitol">Mitja jornada</td><td class="subtitol">Jornada completa</td></tr>
                <tr><td>Auditori Josep Viader</td>  <td>100€</td><td>150€</td><td>225€</td></tr>
                <tr><td>Aula Magna</td>             <td> 75€</td><td>125€</td><td>175€</td></tr>
                <tr><td>Aula B</td>                 <td> 60€</td><td> 90€</td><td>125€</td></tr>
                <tr><td>Aula C</td>                 <td> 40€</td><td> 60€</td><td>85€</td></tr>
                <tr><td>Aules 2n pis</td>           <td> 30€</td><td> 45€</td><td>65€</td></tr>
                <tr><td>Sala Domènech Fita</td>     <td> 60€</td><td> 90€</td><td>125€</td></tr>
                <tr><td>Pati</td>                   <td> 75€</td><td>125€</td><td>175€</td></tr>                                                
            </table>
            <br /><br />
            <table class="taula_preus">
                <tr><th colspan="4">TARIFA COMERCIAL</th></tr>
                <tr><td class="subtitol"></td><td class="subtitol">Fins a tres hores</td><td class="subtitol">Mitja jornada</td><td class="subtitol">Jornada completa</td></tr>
                <tr><td>Auditori Josep Viader</td>  <td>200€</td><td>300€</td><td>450€</td></tr>
                <tr><td>Aula Magna</td>             <td>150€</td><td>225€</td><td>325€</td></tr>
                <tr><td>Aula B</td>                 <td>100€</td><td>150€</td><td>200€</td></tr>
                <tr><td>Aula C</td>                 <td> 75€</td><td>110€</td><td>150€</td></tr>
                <tr><td>Aules 2n pis</td>           <td> 50€</td><td> 75€</td><td>100€</td></tr>
                <tr><td>Sala Domènech Fita</td>     <td>100€</td><td>150€</td><td>200€</td></tr>
                <tr><td>Pati</td>                   <td>120€</td><td>180€</td><td>325€</td></tr>
            </table>
            <br /><br />
            <table class="taula_preus">
                <tr><th colspan="3">LLOGUER DE MATERIAL</th></tr>
                <tr><td class="subtitol">APARELLS AUDIOVISUALS.</td><td class="subtitol">TARIFA CULTURAL</td><td class="subtitol">TARIFA COMERCIAL</td></tr>                
                <tr><td>Projector </td>                 <td>30€</td><td>60€</td></tr>
                <tr><td>Aparell reproductor</td>        <td>15€</td><td>30€</td></tr>
                <tr><td>Piano Auditori</td>             <td>50€</td><td>100€</td></tr>
                <tr><td>Piano Aula Magna</td>           <td>35€</td><td>70€</td></tr>
                <tr><td>Pantalla de retroprojecció</td> <td>30€</td><td>60€</td></tr>
                <tr><td colspan="3">Si l’ús dels pianos requereix un afinació no programada, el cost anirà a càrrec dels usuaris.</td></tr>                                                                
            </table>  
	    </p>
        
        <br />
        <br />
        <a name="criteris"></a>	
		<h3>Criteris</h3>
        <br />
        <p style="text-align: justify;">
            <span style="font-weight: bold;">Aplicació de tarifa comercial</span><br />
            En principi, es considerarà activitat comercial tota aquella generada per una entitat privada amb afany de lucre. És possible, tanmateix, que les entitats o empreses privades sol·licitin espais o serveis per a una activitat d’interès general. En aquest cas, és possible autoritzar l’activitat amb exempció de despeses. La Casa de Cultura es reserva el dret d’autoritzar o denegar aquesta exempció.
            <br /><br /> 
            Es consideraran activitats comercials també aquelles que, provenint de l’àmbit públic o privat, no s’adrecin a la ciutadania en general i per a les quals calgui una matrícula, és a dir, que generin un ingressos. És el cas de jornades, congressos, cursos...</p>
        </p>            

        <p style="text-align: justify;">
            <span style="font-weight: bold;">Aplicació de tarifa cultural</span><br />
            S’aplica la tarifa cultural a aquelles cessions d’espai a entitats i activitats d’interès social, cultural i/o sense afany de lucre.
            <br /><br /> 
            Aquestes activitats poden demanar l’exempció de despeses, que la Fundació Casa de Cultura aprovarà o desestimarà d’acord amb els seus criteris de programació i objectius fundacionals.
        </p>

        <p style="text-align: justify;">
            <span style="font-weight: bold;">Diputació de Girona i organismes vinculats</span><br />
            Tots els organismes dependents –directament o indirecta- de la Diputació de Girona estan exempts del pagament de despeses però han de sol·licitar els espais o serveis de manera formalitzada.
            <br /><br />            
            En cap cas, la dependència o vinculació amb la Diputació de Girona suposa un tracte preferencial en relació als compromisos ja adquirits o en relació a la pròpia activitat de la Fundació.
        </p>
        
   </div>
   
      <div style="height:80px;"></div>
                
    </td>
    
    
   <?php 
   
   
   function generaImatge($nom,$titol){
	   return link_to(image_tag("intranet/espais/$nom" , array('class'=>'fotoEspai')), image_path("intranet/espais/$nom" , true),array('class'=>'thickbox', 'title'=>$titol));	   	
   }
   
      
   ?>
   

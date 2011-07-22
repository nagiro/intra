<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = sfConfig::get('sf_webrooturl').'images/hospici'; ?>
 

<?php include_partial('hospici/showCercadorActivitats',array('CERCA'=>$CERCA,'VISIBLE'=>($MODE <> 'DETALL'))); ?>
<?php if(!$MODE == 'INICIAL') include_partial('hospici/showDestacats'); ?>                
<?php if($MODE == 'DETALL') include_partial('hospici/showDetallActivitat',array('ACTIVITAT'=>$ACTIVITAT, 'LHO'=>$LHO, 'AUTENTIFICAT'=>$AUTENTIFICAT)); ?>                
<?php if($MODE == 'CERCA') include_partial('hospici/showLlistatActivitats',array('LLISTAT_ACTIVITATS'=>$LLISTAT_ACTIVITATS, 'AUTENTIFICAT'=>$AUTENTIFICAT)); ?>    


<?php 

    function getCalendari()
    {
        echo '
        <div class="h_calendari">
                    <div class="h_calendari_menu">
                        &lt;&lt;&lt; T&iacute;tol calendari &gt;&gt;&gt;
                    </div>

                    <div class="h_calendari_dia">
                        Dl
                    </div>

                    <div class="h_calendari_dia">
                        Dm
                    </div>

                    <div class="h_calendari_dia">
                        Dc
                    </div>

                    <div class="h_calendari_dia">
                        Dj
                    </div>

                    <div class="h_calendari_dia">
                        Dv
                    </div>

                    <div class="h_calendari_dia">
                        Ds
                    </div>

                    <div class="h_calendari_dia">
                        Dg
                    </div>

                    <div class="h_calendari_break"></div>

                    <div class="h_calendari_data">
                        01
                    </div>

                    <div class="h_calendari_data">
                        02
                    </div>

                    <div class="h_calendari_data">
                        03
                    </div>

                    <div class="h_calendari_data">
                        04
                    </div>

                    <div class="h_calendari_data">
                        05
                    </div>

                    <div class="h_calendari_data">
                        06
                    </div>

                    <div class="h_calendari_data">
                        07
                    </div>

                    <div class="h_calendari_break"></div>

                    <div class="h_calendari_data">
                        08
                    </div>

                    <div class="h_calendari_data">
                        09
                    </div>

                    <div class="h_calendari_data">
                        10
                    </div>

                    <div class="h_calendari_data">
                        11
                    </div>

                    <div class="h_calendari_data">
                        12
                    </div>

                    <div class="h_calendari_data">
                        13
                    </div>

                    <div class="h_calendari_data">
                        14
                    </div>

                    <div class="h_calendari_break"></div>

                    <div class="h_calendari_data">
                        15
                    </div>

                    <div class="h_calendari_data">
                        16
                    </div>

                    <div class="h_calendari_data">
                        17
                    </div>

                    <div class="h_calendari_data">
                        18
                    </div>

                    <div class="h_calendari_data">
                        19
                    </div>

                    <div class="h_calendari_data">
                        20
                    </div>

                    <div class="h_calendari_data">
                        21
                    </div>

                    <div class="h_calendari_break"></div>

                    <div class="h_calendari_data">
                        22
                    </div>

                    <div class="h_calendari_data">
                        23
                    </div>

                    <div class="h_calendari_data">
                        24
                    </div>

                    <div class="h_calendari_data">
                        25
                    </div>

                    <div class="h_calendari_data">
                        26
                    </div>

                    <div class="h_calendari_data">
                        27
                    </div>

                    <div class="h_calendari_data">
                        28
                    </div>

                    <div class="h_calendari_break"></div>

                    <div class="h_calendari_data">
                        29
                    </div>

                    <div class="h_calendari_data">
                        30
                    </div>

                    <div class="h_calendari_data">
                        31
                    </div>

                    <div class="h_calendari_data">
                        .
                    </div>

                    <div class="h_calendari_data">
                        .
                    </div>

                    <div class="h_calendari_data">
                        .
                    </div>

                    <div class="h_calendari_data">
                        .
                    </div>
                </div>';
    }

?>
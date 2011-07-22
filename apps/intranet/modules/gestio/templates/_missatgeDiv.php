<style>
    .MISSATGE_FORM td { background-color: LightYellow; }
    .MISSATGE_FORM li { list-style: none; background-color: LightYellow; padding:5px; font-weight: bold; }
</style>
<?php if(sizeof($MISS) > 0): ?>
<div class="MISSATGE_FORM">    
    <ul>
    <?php                         
        foreach($MISS as $M):
            echo '<li class="MISSATGE_FORM">'.$M.'</li>';
        endforeach;
    ?>        
    </ul>
<?php endif; ?>
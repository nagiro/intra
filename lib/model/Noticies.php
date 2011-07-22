<?php

class Noticies extends BaseNoticies
{
    public function getNomForUrl()
    {
        $Nom = $this->getTitolnoticia();
        return myUser::text2url($Nom);
    }
}

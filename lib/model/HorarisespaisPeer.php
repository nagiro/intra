<?php

/**
 * Subclass for performing query and update operations on the 'horarisespais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class HorarisespaisPeer extends BaseHorarisespaisPeer
{
    
    static public function getCriteriaActiu($C,$idS)
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;    
    }
    
	static public function delHorari($idH)
	{
		$C = new Criteria();
		$C->add(self::HORARIS_HORARISID,$idH);
		foreach(self::doSelect($C) as $H):
			$H->delete();
		endforeach;
	}
}

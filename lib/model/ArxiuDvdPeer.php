<?php

class ArxiuDvdPeer extends BaseArxiuDvdPeer
{
	static public function cerca($text)
	{
		
		$C = new Criteria();		
		$C2 = $C->getNewCriterion( self::VOLUM , '%'.$text.'%' , CRITERIA::LIKE );
		$C3 = $C->getNewCriterion( self::NOM , '%'.$text.'%' , CRITERIA::LIKE );
		$C4 = $C->getNewCriterion( self::URL , '%'.$text.'%' , CRITERIA::LIKE );
		$C5 = $C->getNewCriterion( self::COMENTARI , '%'.$text.'%' , CRITERIA::LIKE );
		$C2->addOr($C3); $C2->addOr($C4); $C2->addOr($C5); $C->add($C2);

		return self::doSelect($C);
		
	}
}

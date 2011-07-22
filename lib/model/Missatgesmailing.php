<?php

class Missatgesmailing extends BaseMissatgesmailing
{
	public function getLlistes()
	{
		return $this->getMissatgesllistess();
	}
	
	public function getLlistesEnviament()
	{
		$C = new Criteria();
		$C->add(MissatgesllistesPeer::IDMISSATGESLLISTES,$this->getIdmissatge());
		$C->addJoin(LlistesPeer::IDLLISTES, MissatgesllistesPeer::LLISTES_IDLLISTES);
		return LlistesPeer::doSelect($C);
	}
	
	public function getDataEnviament($idl)
	{
				
		$OMISSATGE = MissatgesllistesPeer::retrieveByPK($this->getIdmissatge(), $idl);		
		if( $OMISSATGE instanceof Missatgesllistes ):					
			return $OMISSATGE->getEnviat('d-m-Y');						 		
		else:		
			return null;
		endif; 
		
	}
}

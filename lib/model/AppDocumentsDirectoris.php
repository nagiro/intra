<?php

class AppDocumentsDirectoris extends BaseAppDocumentsDirectoris
{

	public function __toString()
	{
		return $this->getNom();
	}
	
	public function getRutaActual()
	{
		$RET  = $this->getNom();
		$ODIR = $this;
		$FI   = true; 
		
		while($FI){
			$PARE = $ODIR->getPare();
			$ODIR = AppDocumentsDirectorisPeer::retrieveByPK($PARE);
			if($ODIR instanceof AppDocumentsDirectoris):
				$RET = $ODIR->getNom().' / '.$RET;
			else: 
				$FI = false;
			endif; 								
		}
		
		return $RET;
		
	}
	
}

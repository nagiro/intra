<?php

/**
 * Subclass for representing a row from the 'tasques' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Tasques extends BaseTasques
{
   
   public function FeinaFeta()
   {                   
            
      $this->setIsfeta(($this->getIsfeta())?false:true);
      $this->save();
      
   }
      
}

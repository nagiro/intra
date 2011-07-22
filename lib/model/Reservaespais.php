<?php

/**
 * Subclass for representing a row from the 'reservaespais' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Reservaespais extends BaseReservaespais
{
   
   public function check()
   {
      $E = array();
      if(empty($this->espaissolicitats)) $E[] = 'Has de reservar algun espai.';
      if(empty($this->nom)) $E[] = 'Has de donar un nom a l\'activitat.';
      if(empty($this->dataactivitat)) $E[] = 'Has d\'entrar una data per l\'activitat';
      if(empty($this->horariactivitat)) $E[] = 'Has d\'entrar un horari per l\'activitat';
      
      return $E;
   }


   public function getMaterialString()
   {
    
    $sol = array();
    $material = explode('@',$this->getMaterialsolicitat());
    
    foreach($material as $M):
        switch($M){
            case '1': $sol[] = 'Portàtil'; break;
            case '2': $sol[] = 'Projector'; break;
            case '3': $sol[] = 'DVD'; break; 
            case '4': $sol[] = 'Microfonia'; break;  
        }
    endforeach;
    
    if(sizeof($sol) == 0) return 'No s\'ha sol·licitat material.';
    else return implode(' , ',$sol);
       
   }
   
   public function getEspais()
   {
      $sol = array();
      $espais = explode('@',$this->espaissolicitats);
      foreach($espais as $E):
         $ESPAI = EspaisPeer::initialize( $E , $this->getSiteId() );         
         $sol[$ESPAI->getEspaiid()] = $ESPAI->getNom();
      endforeach;
      return implode('<br />',$sol);
   }

   public function getEspaisString()
   {
      $sol = array();
      $espais = explode('@',$this->espaissolicitats);
      foreach($espais as $E):
         $ESPAI = EspaisPeer::initialize( $E , $this->getSiteId() )->getObject();         
         $sol[$ESPAI->getEspaiid()] = $ESPAI->getNom();
      endforeach;
      return implode(' , ',$sol);
   }
   
   public function getEstatText()
   {
      switch($this->getEstat()){
         case ReservaespaisPeer::EN_ESPERA: return 'En espera';
         case ReservaespaisPeer::ACCEPTADA: return 'Acceptada';
         case ReservaespaisPeer::DENEGADA: return 'Denegada';
         case ReservaespaisPeer::ANULADA:  return 'Anul·lada';
         case ReservaespaisPeer::PENDENT_CONFIRMACIO: return 'Pendent acceptar condicions';
         case ReservaespaisPeer::ESBORRADA: return 'Esborrada';
   		}
   }
   
   public function setAcceptada()
   {
     if($this->getEstat() == ReservaespaisPeer::PENDENT_CONFIRMACIO):
         $this->setDataacceptaciocondicions(date('Y-m-d',time()));
         $this->setEstat(ReservaespaisPeer::ACCEPTADA);
         $this->save();
        return true;
     else: 
        return false;  
     endif;  
   }

   public function setRebutjada()
   {
     if($this->getEstat() == ReservaespaisPeer::PENDENT_CONFIRMACIO):
         $this->setDataacceptaciocondicions(date('Y-m-d',time()));
         $this->setEstat(ReservaespaisPeer::ANULADA);
         $this->save();
         return true; 
     else: 
        return false; 
     endif; 
     
   }
   
}

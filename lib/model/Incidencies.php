<?php

/**
 * Subclass for representing a row from the 'incidencies' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Incidencies extends BaseIncidencies
{
  public function getEstatText()
  {
     switch($this->estat)
     {
        case IncidenciesPeer::ESTAT_ESPERA: return 'En espera'; break;
        case IncidenciesPeer::ESTAT_TREBALLANTHI: return 'Treballant-hi'; break;
        case IncidenciesPeer::ESTAT_RESOLT: return 'Resolt'; break;
        default: break;
     }
  }
}

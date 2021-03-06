<?php

require 'lib/model/om/BaseEspaisExterns.php';


/**
 * Skeleton subclass for representing a row from the 'espais_externs' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 02/25/11 13:45:05
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class EspaisExterns extends BaseEspaisExterns {

    public function setInactiu()
    {
        $this->setActiu(false);
        $C = new Criteria();
        $C->add(HorarisespaisPeer::IDESPAIEXTERN, $this->getIdespaiextern());
        foreach(HorarisespaisPeer::doSelect() as $OHE):
            $OHE->setInactiu();
        endforeach;
    }

} // EspaisExterns

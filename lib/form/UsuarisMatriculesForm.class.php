<?php

/**
 * Usuaris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class UsuarisMatriculesForm extends UsuarisForm
{
    
  public function setup()
  {

  	parent::setup();
  	        
    $this->setWidget('Nivells_idNivells',new sfWidgetFormInputHidden());
    $this->setWidget('Habilitat', new sfWidgetFormInputHidden());         

  }  
    
}

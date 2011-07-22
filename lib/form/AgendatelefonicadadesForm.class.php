<?php

/**
 * Agendatelefonicadades form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AgendatelefonicadadesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'AgendaTelefonicaDadesID'             => new sfWidgetFormInputHidden(),
      'AgendaTelefonica_AgendaTelefonicaID' => new sfWidgetFormPropelChoice(array('model' => 'Agendatelefonica', 'add_empty' => false, 'method'=>'hola')),
      'Tipus'                               => new sfWidgetFormChoice(array('choices'=> AgendatelefonicadadesPeer::select())),
      'Dada'                                => new sfWidgetFormInputText(),
      'Notes'                               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'AgendaTelefonicaDadesID'             => new sfValidatorPropelChoice(array('model' => 'Agendatelefonicadades', 'column' => 'AgendaTelefonicaDadesID', 'required' => false)),
      'AgendaTelefonica_AgendaTelefonicaID' => new sfValidatorPropelChoice(array('model' => 'Agendatelefonica', 'column' => 'AgendaTelefonicaID')),
      'Tipus'                               => new sfValidatorString(array('required' => false)),
      'Dada'                                => new sfValidatorString(array('required' => false)),
      'Notes'                               => new sfValidatorString(array('required' => false)),
    ));
        
    $this->widgetSchema->setNameFormat("agendatelefonicadades[%s]");
    $this->widgetSchema->setFormFormatterName('Span');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);            

    unset($this['AgendaTelefonica_AgendaTelefonicaID']);
    
//    parent::setup();
  }

  
  public function getModelName()
  {
    return 'Agendatelefonicadades';
  }
}

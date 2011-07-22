<?php

/**
 * Descripcions form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseDescripcionsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idDescripcions'         => new sfWidgetFormInputHidden(),
      'Activitats_ActivitatID' => new sfWidgetFormPropelChoice(array('model' => 'Activitats', 'add_empty' => false)),
      'Descripcio'             => new sfWidgetFormTextarea(),
      'Tipus'                  => new sfWidgetFormInputText(),
      'Activa'                 => new sfWidgetFormInputText(),
      'Imatge'                 => new sfWidgetFormTextarea(),
      'PDF'                    => new sfWidgetFormTextarea(),
      'PublicaWEB'             => new sfWidgetFormInputText(),
      'tCurt'                  => new sfWidgetFormTextarea(),
      'dCurt'                  => new sfWidgetFormTextarea(),
      'tMig'                   => new sfWidgetFormTextarea(),
      'dMig'                   => new sfWidgetFormTextarea(),
      'tComplet'               => new sfWidgetFormTextarea(),
      'dComplet'               => new sfWidgetFormTextarea(),
      'tipusEnviament'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idDescripcions'         => new sfValidatorPropelChoice(array('model' => 'Descripcions', 'column' => 'idDescripcions', 'required' => false)),
      'Activitats_ActivitatID' => new sfValidatorPropelChoice(array('model' => 'Activitats', 'column' => 'ActivitatID')),
      'Descripcio'             => new sfValidatorString(array('required' => false)),
      'Tipus'                  => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Activa'                 => new sfValidatorInteger(array('required' => false)),
      'Imatge'                 => new sfValidatorString(array('required' => false)),
      'PDF'                    => new sfValidatorString(array('required' => false)),
      'PublicaWEB'             => new sfValidatorInteger(),
      'tCurt'                  => new sfValidatorString(),
      'dCurt'                  => new sfValidatorString(),
      'tMig'                   => new sfValidatorString(),
      'dMig'                   => new sfValidatorString(),
      'tComplet'               => new sfValidatorString(),
      'dComplet'               => new sfValidatorString(),
      'tipusEnviament'         => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('descripcions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Descripcions';
  }


}

<?php

/**
 * EspaisExterns form base class.
 *
 * @method EspaisExterns getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEspaisExternsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idEspaiextern' => new sfWidgetFormInputHidden(),
      'Poble'         => new sfWidgetFormPropelChoice(array('model' => 'Poblacions', 'add_empty' => false)),
      'Nom'           => new sfWidgetFormTextarea(),
      'Adreca'        => new sfWidgetFormTextarea(),
      'Contacte'      => new sfWidgetFormTextarea(),
      'actiu'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idEspaiextern' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdespaiextern()), 'empty_value' => $this->getObject()->getIdespaiextern(), 'required' => false)),
      'Poble'         => new sfValidatorPropelChoice(array('model' => 'Poblacions', 'column' => 'idPoblacio')),
      'Nom'           => new sfValidatorString(),
      'Adreca'        => new sfValidatorString(),
      'Contacte'      => new sfValidatorString(),
      'actiu'         => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('espais_externs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EspaisExterns';
  }


}

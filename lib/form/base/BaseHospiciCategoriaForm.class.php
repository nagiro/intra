<?php

/**
 * HospiciCategoria form base class.
 *
 * @method HospiciCategoria getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHospiciCategoriaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'categoria_id' => new sfWidgetFormInputHidden(),
      'tipus'        => new sfWidgetFormInputText(),
      'nom'          => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'categoria_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getCategoriaId()), 'empty_value' => $this->getObject()->getCategoriaId(), 'required' => false)),
      'tipus'        => new sfValidatorString(array('max_length' => 1)),
      'nom'          => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('hospici_categoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciCategoria';
  }


}

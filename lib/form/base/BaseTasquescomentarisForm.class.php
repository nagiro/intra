<?php

/**
 * Tasquescomentaris form base class.
 *
 * @method Tasquescomentaris getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTasquescomentarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idTasquesComentaris' => new sfWidgetFormInputHidden(),
      'Tasques_TasquesID'   => new sfWidgetFormPropelChoice(array('model' => 'Tasques', 'add_empty' => false)),
      'Comentari'           => new sfWidgetFormTextarea(),
      'Data_2'              => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'idTasquesComentaris' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdtasquescomentaris()), 'empty_value' => $this->getObject()->getIdtasquescomentaris(), 'required' => false)),
      'Tasques_TasquesID'   => new sfValidatorPropelChoice(array('model' => 'Tasques', 'column' => 'TasquesID')),
      'Comentari'           => new sfValidatorString(),
      'Data_2'              => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('tasquescomentaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tasquescomentaris';
  }


}

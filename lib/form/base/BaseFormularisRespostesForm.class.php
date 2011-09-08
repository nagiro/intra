<?php

/**
 * FormularisRespostes form base class.
 *
 * @method FormularisRespostes getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFormularisRespostesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idFormularisRespostes' => new sfWidgetFormInputHidden(),
      'idUsuaris'             => new sfWidgetFormInputText(),
      'idFormularis'          => new sfWidgetFormInputText(),
      'dades'                 => new sfWidgetFormTextarea(),
      'registrat'             => new sfWidgetFormDateTime(),
      'site_id'               => new sfWidgetFormInputText(),
      'actiu'                 => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idFormularisRespostes' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdformularisrespostes()), 'empty_value' => $this->getObject()->getIdformularisrespostes(), 'required' => false)),
      'idUsuaris'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'idFormularis'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'dades'                 => new sfValidatorString(),
      'registrat'             => new sfValidatorDateTime(array('required' => false)),
      'site_id'               => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'actiu'                 => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('formularis_respostes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'FormularisRespostes';
  }


}

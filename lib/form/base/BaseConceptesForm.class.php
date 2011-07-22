<?php

/**
 * Conceptes form base class.
 *
 * @method Conceptes getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseConceptesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ConcepteID' => new sfWidgetFormInputHidden(),
      'Any'        => new sfWidgetFormInputText(),
      'Capitol'    => new sfWidgetFormTextarea(),
      'Apartat'    => new sfWidgetFormTextarea(),
      'Concepte'   => new sfWidgetFormTextarea(),
      'Quantitat'  => new sfWidgetFormInputText(),
      'site_id'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ConcepteID' => new sfValidatorChoice(array('choices' => array($this->getObject()->getConcepteid()), 'empty_value' => $this->getObject()->getConcepteid(), 'required' => false)),
      'Any'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'Capitol'    => new sfValidatorString(array('required' => false)),
      'Apartat'    => new sfValidatorString(array('required' => false)),
      'Concepte'   => new sfValidatorString(array('required' => false)),
      'Quantitat'  => new sfValidatorNumber(array('required' => false)),
      'site_id'    => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('conceptes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Conceptes';
  }


}

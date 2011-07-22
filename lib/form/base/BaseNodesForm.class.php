<?php

/**
 * Nodes form base class.
 *
 * @method Nodes getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNodesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idNodes'     => new sfWidgetFormInputHidden(),
      'TitolMenu'   => new sfWidgetFormTextarea(),
      'HTML'        => new sfWidgetFormTextarea(),
      'isCategoria' => new sfWidgetFormInputText(),
      'isPhp'       => new sfWidgetFormInputText(),
      'isActiva'    => new sfWidgetFormInputText(),
      'Ordre'       => new sfWidgetFormInputText(),
      'Nivell'      => new sfWidgetFormInputText(),
      'Url'         => new sfWidgetFormTextarea(),
      'Categories'  => new sfWidgetFormInputText(),
      'site_id'     => new sfWidgetFormInputText(),
      'actiu'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idNodes'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdnodes()), 'empty_value' => $this->getObject()->getIdnodes(), 'required' => false)),
      'TitolMenu'   => new sfValidatorString(array('required' => false)),
      'HTML'        => new sfValidatorString(array('required' => false)),
      'isCategoria' => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'isPhp'       => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'isActiva'    => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'Ordre'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'Nivell'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'Url'         => new sfValidatorString(),
      'Categories'  => new sfValidatorString(array('max_length' => 100)),
      'site_id'     => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'       => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('nodes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Nodes';
  }


}

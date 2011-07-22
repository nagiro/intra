<?php

/**
 * Noticies form base class.
 *
 * @method Noticies getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNoticiesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idNoticia'       => new sfWidgetFormInputHidden(),
      'TitolNoticia'    => new sfWidgetFormInputText(),
      'TextNoticia'     => new sfWidgetFormTextarea(),
      'DataPublicacio'  => new sfWidgetFormDate(),
      'Activa'          => new sfWidgetFormInputText(),
      'Imatge'          => new sfWidgetFormInputText(),
      'Adjunt'          => new sfWidgetFormInputText(),
      'idActivitat'     => new sfWidgetFormInputText(),
      'DataDesaparicio' => new sfWidgetFormDate(),
      'Ordre'           => new sfWidgetFormInputText(),
      'site_id'         => new sfWidgetFormInputText(),
      'actiu'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idNoticia'       => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdnoticia()), 'empty_value' => $this->getObject()->getIdnoticia(), 'required' => false)),
      'TitolNoticia'    => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'TextNoticia'     => new sfValidatorString(array('required' => false)),
      'DataPublicacio'  => new sfValidatorDate(array('required' => false)),
      'Activa'          => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'Imatge'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'Adjunt'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'idActivitat'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'DataDesaparicio' => new sfValidatorDate(array('required' => false)),
      'Ordre'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'site_id'         => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'           => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('noticies[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Noticies';
  }


}

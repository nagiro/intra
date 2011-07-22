<?php

/**
 * HospiciDocuments form base class.
 *
 * @method HospiciDocuments getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHospiciDocumentsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'document_id' => new sfWidgetFormInputHidden(),
      'url'         => new sfWidgetFormTextarea(),
      'nom'         => new sfWidgetFormTextarea(),
      'descripcio'  => new sfWidgetFormTextarea(),
      'tags'        => new sfWidgetFormTextarea(),
      'data_alta'   => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'document_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getDocumentId()), 'empty_value' => $this->getObject()->getDocumentId(), 'required' => false)),
      'url'         => new sfValidatorString(),
      'nom'         => new sfValidatorString(),
      'descripcio'  => new sfValidatorString(),
      'tags'        => new sfValidatorString(),
      'data_alta'   => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('hospici_documents[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciDocuments';
  }


}

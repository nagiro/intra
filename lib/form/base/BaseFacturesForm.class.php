<?php

/**
 * Factures form base class.
 *
 * @method Factures getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFacturesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'FacturaID'              => new sfWidgetFormInputHidden(),
      'Proveidors_ProveidorID' => new sfWidgetFormPropelChoice(array('model' => 'Proveidors', 'add_empty' => false)),
      'Conceptes_ConcepteID'   => new sfWidgetFormPropelChoice(array('model' => 'Conceptes', 'add_empty' => false)),
      'DataFactura'            => new sfWidgetFormDate(),
      'Quantitat'              => new sfWidgetFormInputText(),
      'NumFactura'             => new sfWidgetFormTextarea(),
      'DataPagament'           => new sfWidgetFormDate(),
      'ModalitatPagament'      => new sfWidgetFormTextarea(),
      'SubConcepte'            => new sfWidgetFormTextarea(),
      'TipusComptable'         => new sfWidgetFormTextarea(),
      'Text'                   => new sfWidgetFormTextarea(),
      'ValidaUsuari'           => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'ValidatData'            => new sfWidgetFormDate(),
      'site_id'                => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'FacturaID'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getFacturaid()), 'empty_value' => $this->getObject()->getFacturaid(), 'required' => false)),
      'Proveidors_ProveidorID' => new sfValidatorPropelChoice(array('model' => 'Proveidors', 'column' => 'ProveidorID')),
      'Conceptes_ConcepteID'   => new sfValidatorPropelChoice(array('model' => 'Conceptes', 'column' => 'ConcepteID')),
      'DataFactura'            => new sfValidatorDate(array('required' => false)),
      'Quantitat'              => new sfValidatorNumber(array('required' => false)),
      'NumFactura'             => new sfValidatorString(array('required' => false)),
      'DataPagament'           => new sfValidatorDate(array('required' => false)),
      'ModalitatPagament'      => new sfValidatorString(array('required' => false)),
      'SubConcepte'            => new sfValidatorString(array('required' => false)),
      'TipusComptable'         => new sfValidatorString(array('required' => false)),
      'Text'                   => new sfValidatorString(array('required' => false)),
      'ValidaUsuari'           => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'ValidatData'            => new sfValidatorDate(array('required' => false)),
      'site_id'                => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('factures[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Factures';
  }


}

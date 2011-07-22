<?php

/**
 * Material form base class.
 *
 * @method Material getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMaterialForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMaterial'                        => new sfWidgetFormInputHidden(),
      'MaterialGeneric_idMaterialGeneric' => new sfWidgetFormPropelChoice(array('model' => 'Materialgeneric', 'add_empty' => false)),
      'Nom'                               => new sfWidgetFormTextarea(),
      'Descripcio'                        => new sfWidgetFormTextarea(),
      'Responsable'                       => new sfWidgetFormTextarea(),
      'Ubicacio'                          => new sfWidgetFormTextarea(),
      'DataCompra'                        => new sfWidgetFormDate(),
      'Identificador'                     => new sfWidgetFormTextarea(),
      'NumSerie'                          => new sfWidgetFormTextarea(),
      'DataGarantia'                      => new sfWidgetFormDate(),
      'DataRevisio'                       => new sfWidgetFormDate(),
      'Cedit'                             => new sfWidgetFormTextarea(),
      'DataCessio'                        => new sfWidgetFormDate(),
      'DataRetorn'                        => new sfWidgetFormDate(),
      'NumFactura'                        => new sfWidgetFormTextarea(),
      'Preu'                              => new sfWidgetFormInputText(),
      'NotesManteniment'                  => new sfWidgetFormTextarea(),
      'DataBaixa'                         => new sfWidgetFormDate(),
      'DataReparacio'                     => new sfWidgetFormDate(),
      'Disponible'                        => new sfWidgetFormInputText(),
      'AltaRegistre'                      => new sfWidgetFormDate(),
      'isTransferible'                    => new sfWidgetFormInputText(),
      'isAdministratiu'                   => new sfWidgetFormInputText(),
      'site_id'                           => new sfWidgetFormInputText(),
      'actiu'                             => new sfWidgetFormInputText(),
      'unitats'                           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idMaterial'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdmaterial()), 'empty_value' => $this->getObject()->getIdmaterial(), 'required' => false)),
      'MaterialGeneric_idMaterialGeneric' => new sfValidatorPropelChoice(array('model' => 'Materialgeneric', 'column' => 'idMaterialGeneric')),
      'Nom'                               => new sfValidatorString(array('required' => false)),
      'Descripcio'                        => new sfValidatorString(array('required' => false)),
      'Responsable'                       => new sfValidatorString(array('required' => false)),
      'Ubicacio'                          => new sfValidatorString(array('required' => false)),
      'DataCompra'                        => new sfValidatorDate(array('required' => false)),
      'Identificador'                     => new sfValidatorString(array('required' => false)),
      'NumSerie'                          => new sfValidatorString(array('required' => false)),
      'DataGarantia'                      => new sfValidatorDate(array('required' => false)),
      'DataRevisio'                       => new sfValidatorDate(array('required' => false)),
      'Cedit'                             => new sfValidatorString(array('required' => false)),
      'DataCessio'                        => new sfValidatorDate(array('required' => false)),
      'DataRetorn'                        => new sfValidatorDate(array('required' => false)),
      'NumFactura'                        => new sfValidatorString(array('required' => false)),
      'Preu'                              => new sfValidatorNumber(array('required' => false)),
      'NotesManteniment'                  => new sfValidatorString(array('required' => false)),
      'DataBaixa'                         => new sfValidatorDate(array('required' => false)),
      'DataReparacio'                     => new sfValidatorDate(array('required' => false)),
      'Disponible'                        => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'AltaRegistre'                      => new sfValidatorDate(array('required' => false)),
      'isTransferible'                    => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'isAdministratiu'                   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'                           => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'                             => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'unitats'                           => new sfValidatorInteger(array('min' => -32768, 'max' => 32767)),
    ));

    $this->widgetSchema->setNameFormat('material[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Material';
  }


}

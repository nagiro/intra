<?php

/**
 * Cursos form base class.
 *
 * @method Cursos getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCursosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idCursos'        => new sfWidgetFormInputHidden(),
      'TitolCurs'       => new sfWidgetFormTextarea(),
      'isActiu'         => new sfWidgetFormInputText(),
      'Places'          => new sfWidgetFormInputText(),
      'Codi'            => new sfWidgetFormTextarea(),
      'Descripcio'      => new sfWidgetFormTextarea(),
      'Preu'            => new sfWidgetFormInputText(),
      'Preur'           => new sfWidgetFormInputText(),
      'Horaris'         => new sfWidgetFormTextarea(),
      'Categoria'       => new sfWidgetFormTextarea(),
      'OrdreSortida'    => new sfWidgetFormInputText(),
      'DataAparicio'    => new sfWidgetFormDate(),
      'DataDesaparicio' => new sfWidgetFormDate(),
      'DataFiMatricula' => new sfWidgetFormDate(),
      'DataInici'       => new sfWidgetFormDate(),
      'VisibleWEB'      => new sfWidgetFormInputText(),
      'site_id'         => new sfWidgetFormInputText(),
      'actiu'           => new sfWidgetFormInputText(),
      'activitat_id'    => new sfWidgetFormInputText(),
      'isEntrada'       => new sfWidgetFormInputText(),
      'PDF'             => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'idCursos'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdcursos()), 'empty_value' => $this->getObject()->getIdcursos(), 'required' => false)),
      'TitolCurs'       => new sfValidatorString(array('required' => false)),
      'isActiu'         => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'Places'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'Codi'            => new sfValidatorString(array('required' => false)),
      'Descripcio'      => new sfValidatorString(array('required' => false)),
      'Preu'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'Preur'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'Horaris'         => new sfValidatorString(array('required' => false)),
      'Categoria'       => new sfValidatorString(array('required' => false)),
      'OrdreSortida'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'DataAparicio'    => new sfValidatorDate(array('required' => false)),
      'DataDesaparicio' => new sfValidatorDate(array('required' => false)),
      'DataFiMatricula' => new sfValidatorDate(array('required' => false)),
      'DataInici'       => new sfValidatorDate(array('required' => false)),
      'VisibleWEB'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'         => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'           => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'activitat_id'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'isEntrada'       => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'PDF'             => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('cursos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cursos';
  }


}

<?php

/**
 * Matricules form base class.
 *
 * @method Matricules getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMatriculesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMatricules'     => new sfWidgetFormInputHidden(),
      'Usuaris_UsuariID' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'Cursos_idCursos'  => new sfWidgetFormPropelChoice(array('model' => 'Cursos', 'add_empty' => true)),
      'Estat'            => new sfWidgetFormInputText(),
      'Comentari'        => new sfWidgetFormTextarea(),
      'DataInscripcio'   => new sfWidgetFormDateTime(),
      'Pagat'            => new sfWidgetFormInputText(),
      'tReduccio'        => new sfWidgetFormInputText(),
      'tPagament'        => new sfWidgetFormInputText(),
      'site_id'          => new sfWidgetFormInputText(),
      'actiu'            => new sfWidgetFormInputText(),
      'tpv_operacio'     => new sfWidgetFormInputText(),
      'tpv_order'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idMatricules'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdmatricules()), 'empty_value' => $this->getObject()->getIdmatricules(), 'required' => false)),
      'Usuaris_UsuariID' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'Cursos_idCursos'  => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos', 'required' => false)),
      'Estat'            => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'Comentari'        => new sfValidatorString(array('required' => false)),
      'DataInscripcio'   => new sfValidatorDateTime(array('required' => false)),
      'Pagat'            => new sfValidatorNumber(array('required' => false)),
      'tReduccio'        => new sfValidatorInteger(array('min' => -32768, 'max' => 32767)),
      'tPagament'        => new sfValidatorInteger(array('min' => -32768, 'max' => 32767)),
      'site_id'          => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'            => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'tpv_operacio'     => new sfValidatorString(array('max_length' => 20)),
      'tpv_order'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('matricules[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Matricules';
  }


}

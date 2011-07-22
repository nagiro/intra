<?php

/**
 * AppDocumentsPermisos form base class.
 *
 * @method AppDocumentsPermisos getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppDocumentsPermisosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idUsuari'        => new sfWidgetFormInputHidden(),
      'idArxiu'         => new sfWidgetFormInputHidden(),
      'idNivell'        => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
      'DataModificacio' => new sfWidgetFormDate(),
      'site_id'         => new sfWidgetFormInputText(),
      'actiu'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idUsuari'        => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'idArxiu'         => new sfValidatorPropelChoice(array('model' => 'AppDocumentsArxius', 'column' => 'idDocument', 'required' => false)),
      'idNivell'        => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells', 'required' => false)),
      'DataModificacio' => new sfValidatorDate(),
      'site_id'         => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'           => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('app_documents_permisos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppDocumentsPermisos';
  }


}

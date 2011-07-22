<?php

/**
 * AppDocumentsPermisosDir filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAppDocumentsPermisosDirFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idNivell'    => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
      'site_id'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'idNivell'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Nivells', 'column' => 'idNivells')),
      'site_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('app_documents_permisos_dir_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppDocumentsPermisosDir';
  }

  public function getFields()
  {
    return array(
      'idUsuari'    => 'ForeignKey',
      'idDirectori' => 'ForeignKey',
      'idNivell'    => 'ForeignKey',
      'site_id'     => 'Number',
    );
  }
}

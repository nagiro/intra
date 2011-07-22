<?php

/**
 * AppDocumentsDirectoris filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAppDocumentsDirectorisFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'                             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Pare'                            => new sfWidgetFormPropelChoice(array('model' => 'AppDocumentsDirectoris', 'add_empty' => true)),
      'site_id'                         => new sfWidgetFormFilterInput(),
      'app_documents_permisos_dir_list' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'Nom'                             => new sfValidatorPass(array('required' => false)),
      'Pare'                            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori')),
      'site_id'                         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'app_documents_permisos_dir_list' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_documents_directoris_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addAppDocumentsPermisosDirListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(AppDocumentsPermisosDirPeer::IDDIRECTORI, AppDocumentsDirectorisPeer::IDDIRECTORI);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AppDocumentsPermisosDirPeer::IDUSUARI, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AppDocumentsPermisosDirPeer::IDUSUARI, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'AppDocumentsDirectoris';
  }

  public function getFields()
  {
    return array(
      'idDirectori'                     => 'Number',
      'Nom'                             => 'Text',
      'Pare'                            => 'ForeignKey',
      'site_id'                         => 'Number',
      'app_documents_permisos_dir_list' => 'ManyKey',
    );
  }
}

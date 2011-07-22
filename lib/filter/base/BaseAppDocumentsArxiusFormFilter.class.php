<?php

/**
 * AppDocumentsArxius filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAppDocumentsArxiusFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idDirectori'                 => new sfWidgetFormPropelChoice(array('model' => 'AppDocumentsDirectoris', 'add_empty' => true)),
      'Nom'                         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'url'                         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'DataCreacio'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'site_id'                     => new sfWidgetFormFilterInput(),
      'app_documents_permisos_list' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'idDirectori'                 => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori')),
      'Nom'                         => new sfValidatorPass(array('required' => false)),
      'url'                         => new sfValidatorPass(array('required' => false)),
      'DataCreacio'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'site_id'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'app_documents_permisos_list' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_documents_arxius_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addAppDocumentsPermisosListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(AppDocumentsPermisosPeer::IDARXIU, AppDocumentsArxiusPeer::IDDOCUMENT);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AppDocumentsPermisosPeer::IDUSUARI, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AppDocumentsPermisosPeer::IDUSUARI, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'AppDocumentsArxius';
  }

  public function getFields()
  {
    return array(
      'idDocument'                  => 'Number',
      'idDirectori'                 => 'ForeignKey',
      'Nom'                         => 'Text',
      'url'                         => 'Text',
      'DataCreacio'                 => 'Date',
      'site_id'                     => 'Number',
      'app_documents_permisos_list' => 'ManyKey',
    );
  }
}

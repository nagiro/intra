<?php

/**
 * Apps filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAppsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Url'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'           => new sfWidgetFormFilterInput(),
      'usuaris_apps_list' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'Nom'               => new sfValidatorPass(array('required' => false)),
      'Url'               => new sfValidatorPass(array('required' => false)),
      'site_id'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'usuaris_apps_list' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('apps_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addUsuarisAppsListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(UsuarisAppsPeer::APP_ID, AppsPeer::APP_ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UsuarisAppsPeer::USUARI_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UsuarisAppsPeer::USUARI_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Apps';
  }

  public function getFields()
  {
    return array(
      'app_id'            => 'Number',
      'Nom'               => 'Text',
      'Url'               => 'Text',
      'site_id'           => 'Number',
      'usuaris_apps_list' => 'ManyKey',
    );
  }
}

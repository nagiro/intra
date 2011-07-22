<?php

/**
 * Sites filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseSitesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'usuaris_sites_list' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nom'                => new sfValidatorPass(array('required' => false)),
      'usuaris_sites_list' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sites_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addUsuarisSitesListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(UsuarisSitesPeer::SITE_ID, SitesPeer::SITE_ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UsuarisSitesPeer::USUARI_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UsuarisSitesPeer::USUARI_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Sites';
  }

  public function getFields()
  {
    return array(
      'site_id'            => 'Number',
      'nom'                => 'Text',
      'usuaris_sites_list' => 'ManyKey',
    );
  }
}

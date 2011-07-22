<?php

/**
 * GestioMenus filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseGestioMenusFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'titol'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'url'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'categoria'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ordre'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'actiu'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'usuaris_menus_list' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'titol'              => new sfValidatorPass(array('required' => false)),
      'url'                => new sfValidatorPass(array('required' => false)),
      'categoria'          => new sfValidatorPass(array('required' => false)),
      'ordre'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'actiu'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'usuaris_menus_list' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('gestio_menus_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addUsuarisMenusListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(UsuarisMenusPeer::MENU_ID, GestioMenusPeer::MENU_ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UsuarisMenusPeer::USUARI_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UsuarisMenusPeer::USUARI_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'GestioMenus';
  }

  public function getFields()
  {
    return array(
      'menu_id'            => 'Number',
      'titol'              => 'Text',
      'url'                => 'Text',
      'categoria'          => 'Text',
      'ordre'              => 'Number',
      'actiu'              => 'Number',
      'usuaris_menus_list' => 'ManyKey',
    );
  }
}

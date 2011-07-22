<?php

/**
 * Llistes filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseLlistesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'isActiva'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'               => new sfWidgetFormFilterInput(),
      'missatgesllistes_list' => new sfWidgetFormPropelChoice(array('model' => 'Missatgesmailing', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'Nom'                   => new sfValidatorPass(array('required' => false)),
      'isActiva'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'site_id'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'missatgesllistes_list' => new sfValidatorPropelChoice(array('model' => 'Missatgesmailing', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('llistes_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addMissatgesllistesListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(MissatgesllistesPeer::LLISTES_IDLLISTES, LlistesPeer::IDLLISTES);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(MissatgesllistesPeer::IDMISSATGESLLISTES, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(MissatgesllistesPeer::IDMISSATGESLLISTES, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Llistes';
  }

  public function getFields()
  {
    return array(
      'idLlistes'             => 'Number',
      'Nom'                   => 'Text',
      'isActiva'              => 'Number',
      'site_id'               => 'Number',
      'missatgesllistes_list' => 'ManyKey',
    );
  }
}

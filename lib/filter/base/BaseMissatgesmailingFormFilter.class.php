<?php

/**
 * Missatgesmailing filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseMissatgesmailingFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'titol'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'text'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'data_alta'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'site_id'               => new sfWidgetFormFilterInput(),
      'missatgesllistes_list' => new sfWidgetFormPropelChoice(array('model' => 'Llistes', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'titol'                 => new sfValidatorPass(array('required' => false)),
      'text'                  => new sfValidatorPass(array('required' => false)),
      'data_alta'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'site_id'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'missatgesllistes_list' => new sfValidatorPropelChoice(array('model' => 'Llistes', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('missatgesmailing_filters[%s]');

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

    $criteria->addJoin(MissatgesllistesPeer::IDMISSATGESLLISTES, MissatgesmailingPeer::IDMISSATGE);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(MissatgesllistesPeer::LLISTES_IDLLISTES, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(MissatgesllistesPeer::LLISTES_IDLLISTES, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Missatgesmailing';
  }

  public function getFields()
  {
    return array(
      'idMissatge'            => 'Number',
      'titol'                 => 'Text',
      'text'                  => 'Text',
      'data_alta'             => 'Date',
      'site_id'               => 'Number',
      'missatgesllistes_list' => 'ManyKey',
    );
  }
}

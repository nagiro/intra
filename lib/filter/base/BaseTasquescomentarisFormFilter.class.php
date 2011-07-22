<?php

/**
 * Tasquescomentaris filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseTasquescomentarisFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Tasques_TasquesID'   => new sfWidgetFormPropelChoice(array('model' => 'Tasques', 'add_empty' => true)),
      'Comentari'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Data_2'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'Tasques_TasquesID'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tasques', 'column' => 'TasquesID')),
      'Comentari'           => new sfValidatorPass(array('required' => false)),
      'Data_2'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('tasquescomentaris_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tasquescomentaris';
  }

  public function getFields()
  {
    return array(
      'idTasquesComentaris' => 'Number',
      'Tasques_TasquesID'   => 'ForeignKey',
      'Comentari'           => 'Text',
      'Data_2'              => 'Date',
    );
  }
}

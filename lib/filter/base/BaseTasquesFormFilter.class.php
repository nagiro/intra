<?php

/**
 * Tasques filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseTasquesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Activitats_ActivitatID' => new sfWidgetFormPropelChoice(array('model' => 'Activitats', 'add_empty' => true)),
      'QuiMana'                => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'QuiFa'                  => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'Titol'                  => new sfWidgetFormFilterInput(),
      'Accio'                  => new sfWidgetFormFilterInput(),
      'Reaccio'                => new sfWidgetFormFilterInput(),
      'Estat'                  => new sfWidgetFormFilterInput(),
      'Aparicio'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Desaparicio'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'DataResolucio'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'isFeta'                 => new sfWidgetFormFilterInput(),
      'AltaRegistre'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'Activitats_ActivitatID' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Activitats', 'column' => 'ActivitatID')),
      'QuiMana'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'QuiFa'                  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'Titol'                  => new sfValidatorPass(array('required' => false)),
      'Accio'                  => new sfValidatorPass(array('required' => false)),
      'Reaccio'                => new sfValidatorPass(array('required' => false)),
      'Estat'                  => new sfValidatorPass(array('required' => false)),
      'Aparicio'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Desaparicio'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'DataResolucio'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'isFeta'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'AltaRegistre'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('tasques_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tasques';
  }

  public function getFields()
  {
    return array(
      'TasquesID'              => 'Number',
      'Activitats_ActivitatID' => 'ForeignKey',
      'QuiMana'                => 'ForeignKey',
      'QuiFa'                  => 'ForeignKey',
      'Titol'                  => 'Text',
      'Accio'                  => 'Text',
      'Reaccio'                => 'Text',
      'Estat'                  => 'Text',
      'Aparicio'               => 'Date',
      'Desaparicio'            => 'Date',
      'DataResolucio'          => 'Date',
      'isFeta'                 => 'Number',
      'AltaRegistre'           => 'Date',
    );
  }
}

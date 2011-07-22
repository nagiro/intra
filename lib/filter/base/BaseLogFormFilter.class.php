<?php

/**
 * Log filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseLogFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'UsuariID'    => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'Accio'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Model'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'DadesBefore' => new sfWidgetFormFilterInput(),
      'DadesAfter'  => new sfWidgetFormFilterInput(),
      'Data'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'UsuariID'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'Accio'       => new sfValidatorPass(array('required' => false)),
      'Model'       => new sfValidatorPass(array('required' => false)),
      'DadesBefore' => new sfValidatorPass(array('required' => false)),
      'DadesAfter'  => new sfValidatorPass(array('required' => false)),
      'Data'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('log_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Log';
  }

  public function getFields()
  {
    return array(
      'Id'          => 'Number',
      'UsuariID'    => 'ForeignKey',
      'Accio'       => 'Text',
      'Model'       => 'Text',
      'DadesBefore' => 'Text',
      'DadesAfter'  => 'Text',
      'Data'        => 'Date',
    );
  }
}

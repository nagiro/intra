<?php

/**
 * Missatges filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseMissatgesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Usuaris_UsuariID' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'Titol'            => new sfWidgetFormFilterInput(),
      'Text'             => new sfWidgetFormFilterInput(),
      'Date'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Publicacio'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'site_id'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Usuaris_UsuariID' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'Titol'            => new sfValidatorPass(array('required' => false)),
      'Text'             => new sfValidatorPass(array('required' => false)),
      'Date'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Publicacio'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'site_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('missatges_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Missatges';
  }

  public function getFields()
  {
    return array(
      'MissatgeID'       => 'Number',
      'Usuaris_UsuariID' => 'ForeignKey',
      'Titol'            => 'Text',
      'Text'             => 'Text',
      'Date'             => 'Date',
      'Publicacio'       => 'Date',
      'site_id'          => 'Number',
    );
  }
}

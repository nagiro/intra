<?php

/**
 * Proveidors filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseProveidorsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'NIF'         => new sfWidgetFormFilterInput(),
      'Nom'         => new sfWidgetFormFilterInput(),
      'Telefon'     => new sfWidgetFormFilterInput(),
      'CE'          => new sfWidgetFormFilterInput(),
      'CC'          => new sfWidgetFormFilterInput(),
      'CP'          => new sfWidgetFormFilterInput(),
      'Adreca'      => new sfWidgetFormFilterInput(),
      'Alta'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Ciutat'      => new sfWidgetFormFilterInput(),
      'site_id'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'NIF'         => new sfValidatorPass(array('required' => false)),
      'Nom'         => new sfValidatorPass(array('required' => false)),
      'Telefon'     => new sfValidatorPass(array('required' => false)),
      'CE'          => new sfValidatorPass(array('required' => false)),
      'CC'          => new sfValidatorPass(array('required' => false)),
      'CP'          => new sfValidatorPass(array('required' => false)),
      'Adreca'      => new sfValidatorPass(array('required' => false)),
      'Alta'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Ciutat'      => new sfValidatorPass(array('required' => false)),
      'site_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('proveidors_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Proveidors';
  }

  public function getFields()
  {
    return array(
      'ProveidorID' => 'Number',
      'NIF'         => 'Text',
      'Nom'         => 'Text',
      'Telefon'     => 'Text',
      'CE'          => 'Text',
      'CC'          => 'Text',
      'CP'          => 'Text',
      'Adreca'      => 'Text',
      'Alta'        => 'Date',
      'Ciutat'      => 'Text',
      'site_id'     => 'Number',
    );
  }
}

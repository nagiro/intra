<?php

/**
 * Entrades filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseEntradesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'titol'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'subtitol'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'data'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lloc'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'preu'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'venudes'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'recaptat'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'localitats' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'titol'      => new sfValidatorPass(array('required' => false)),
      'subtitol'   => new sfValidatorPass(array('required' => false)),
      'data'       => new sfValidatorPass(array('required' => false)),
      'lloc'       => new sfValidatorPass(array('required' => false)),
      'preu'       => new sfValidatorPass(array('required' => false)),
      'venudes'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'recaptat'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'localitats' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'site_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('entrades_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Entrades';
  }

  public function getFields()
  {
    return array(
      'idEntrada'  => 'Number',
      'titol'      => 'Text',
      'subtitol'   => 'Text',
      'data'       => 'Text',
      'lloc'       => 'Text',
      'preu'       => 'Text',
      'venudes'    => 'Number',
      'recaptat'   => 'Number',
      'localitats' => 'Number',
      'site_id'    => 'Number',
    );
  }
}

<?php

/**
 * Agendatelefonicadades filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAgendatelefonicadadesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'AgendaTelefonica_AgendaTelefonicaID' => new sfWidgetFormPropelChoice(array('model' => 'Agendatelefonica', 'add_empty' => true)),
      'Tipus'                               => new sfWidgetFormFilterInput(),
      'Dada'                                => new sfWidgetFormFilterInput(),
      'Notes'                               => new sfWidgetFormFilterInput(),
      'site_id'                             => new sfWidgetFormFilterInput(),
      'actiu'                               => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'AgendaTelefonica_AgendaTelefonicaID' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Agendatelefonica', 'column' => 'AgendaTelefonicaID')),
      'Tipus'                               => new sfValidatorPass(array('required' => false)),
      'Dada'                                => new sfValidatorPass(array('required' => false)),
      'Notes'                               => new sfValidatorPass(array('required' => false)),
      'site_id'                             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'actiu'                               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('agendatelefonicadades_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agendatelefonicadades';
  }

  public function getFields()
  {
    return array(
      'AgendaTelefonicaDadesID'             => 'Number',
      'AgendaTelefonica_AgendaTelefonicaID' => 'ForeignKey',
      'Tipus'                               => 'Text',
      'Dada'                                => 'Text',
      'Notes'                               => 'Text',
      'site_id'                             => 'Number',
      'actiu'                               => 'Number',
    );
  }
}

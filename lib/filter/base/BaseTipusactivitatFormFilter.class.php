<?php

/**
 * Tipusactivitat filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseTipusactivitatFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Nom'              => new sfValidatorPass(array('required' => false)),
      'site_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('tipusactivitat_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tipusactivitat';
  }

  public function getFields()
  {
    return array(
      'idTipusActivitat' => 'Number',
      'Nom'              => 'Text',
      'site_id'          => 'Number',
    );
  }
}

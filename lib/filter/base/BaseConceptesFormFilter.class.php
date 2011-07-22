<?php

/**
 * Conceptes filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseConceptesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Any'        => new sfWidgetFormFilterInput(),
      'Capitol'    => new sfWidgetFormFilterInput(),
      'Apartat'    => new sfWidgetFormFilterInput(),
      'Concepte'   => new sfWidgetFormFilterInput(),
      'Quantitat'  => new sfWidgetFormFilterInput(),
      'site_id'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Any'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Capitol'    => new sfValidatorPass(array('required' => false)),
      'Apartat'    => new sfValidatorPass(array('required' => false)),
      'Concepte'   => new sfValidatorPass(array('required' => false)),
      'Quantitat'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'site_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('conceptes_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Conceptes';
  }

  public function getFields()
  {
    return array(
      'ConcepteID' => 'Number',
      'Any'        => 'Number',
      'Capitol'    => 'Text',
      'Apartat'    => 'Text',
      'Concepte'   => 'Text',
      'Quantitat'  => 'Number',
      'site_id'    => 'Number',
    );
  }
}

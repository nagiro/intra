<?php

/**
 * Nodes filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseNodesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'TitolMenu'   => new sfWidgetFormFilterInput(),
      'HTML'        => new sfWidgetFormFilterInput(),
      'isCategoria' => new sfWidgetFormFilterInput(),
      'isPhp'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'isActiva'    => new sfWidgetFormFilterInput(),
      'Ordre'       => new sfWidgetFormFilterInput(),
      'Nivell'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Url'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Categories'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'TitolMenu'   => new sfValidatorPass(array('required' => false)),
      'HTML'        => new sfValidatorPass(array('required' => false)),
      'isCategoria' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'isPhp'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'isActiva'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Ordre'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Nivell'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Url'         => new sfValidatorPass(array('required' => false)),
      'Categories'  => new sfValidatorPass(array('required' => false)),
      'site_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('nodes_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Nodes';
  }

  public function getFields()
  {
    return array(
      'idNodes'     => 'Number',
      'TitolMenu'   => 'Text',
      'HTML'        => 'Text',
      'isCategoria' => 'Number',
      'isPhp'       => 'Number',
      'isActiva'    => 'Number',
      'Ordre'       => 'Number',
      'Nivell'      => 'Number',
      'Url'         => 'Text',
      'Categories'  => 'Text',
      'site_id'     => 'Number',
    );
  }
}

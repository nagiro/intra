<?php

/**
 * Cicles filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseCiclesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'      => new sfWidgetFormFilterInput(),
      'Imatge'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'PDF'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tCurt'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dCurt'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tMig'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dMig'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tComplet' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dComplet' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'extingit' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Nom'      => new sfValidatorPass(array('required' => false)),
      'Imatge'   => new sfValidatorPass(array('required' => false)),
      'PDF'      => new sfValidatorPass(array('required' => false)),
      'tCurt'    => new sfValidatorPass(array('required' => false)),
      'dCurt'    => new sfValidatorPass(array('required' => false)),
      'tMig'     => new sfValidatorPass(array('required' => false)),
      'dMig'     => new sfValidatorPass(array('required' => false)),
      'tComplet' => new sfValidatorPass(array('required' => false)),
      'dComplet' => new sfValidatorPass(array('required' => false)),
      'extingit' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'site_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('cicles_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cicles';
  }

  public function getFields()
  {
    return array(
      'CicleID'  => 'Number',
      'Nom'      => 'Text',
      'Imatge'   => 'Text',
      'PDF'      => 'Text',
      'tCurt'    => 'Text',
      'dCurt'    => 'Text',
      'tMig'     => 'Text',
      'dMig'     => 'Text',
      'tComplet' => 'Text',
      'dComplet' => 'Text',
      'extingit' => 'Number',
      'site_id'  => 'Number',
    );
  }
}

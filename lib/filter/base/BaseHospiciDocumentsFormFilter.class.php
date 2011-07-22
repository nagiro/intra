<?php

/**
 * HospiciDocuments filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseHospiciDocumentsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcio'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tags'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'data_alta'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'url'         => new sfValidatorPass(array('required' => false)),
      'nom'         => new sfValidatorPass(array('required' => false)),
      'descripcio'  => new sfValidatorPass(array('required' => false)),
      'tags'        => new sfValidatorPass(array('required' => false)),
      'data_alta'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('hospici_documents_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciDocuments';
  }

  public function getFields()
  {
    return array(
      'document_id' => 'Number',
      'url'         => 'Text',
      'nom'         => 'Text',
      'descripcio'  => 'Text',
      'tags'        => 'Text',
      'data_alta'   => 'Date',
    );
  }
}

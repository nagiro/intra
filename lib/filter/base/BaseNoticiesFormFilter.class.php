<?php

/**
 * Noticies filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseNoticiesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'TitolNoticia'    => new sfWidgetFormFilterInput(),
      'TextNoticia'     => new sfWidgetFormFilterInput(),
      'DataPublicacio'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Activa'          => new sfWidgetFormFilterInput(),
      'Imatge'          => new sfWidgetFormFilterInput(),
      'Adjunt'          => new sfWidgetFormFilterInput(),
      'idActivitat'     => new sfWidgetFormFilterInput(),
      'DataDesaparicio' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Ordre'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'TitolNoticia'    => new sfValidatorPass(array('required' => false)),
      'TextNoticia'     => new sfValidatorPass(array('required' => false)),
      'DataPublicacio'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Activa'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Imatge'          => new sfValidatorPass(array('required' => false)),
      'Adjunt'          => new sfValidatorPass(array('required' => false)),
      'idActivitat'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'DataDesaparicio' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Ordre'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'site_id'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('noticies_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Noticies';
  }

  public function getFields()
  {
    return array(
      'idNoticia'       => 'Number',
      'TitolNoticia'    => 'Text',
      'TextNoticia'     => 'Text',
      'DataPublicacio'  => 'Date',
      'Activa'          => 'Number',
      'Imatge'          => 'Text',
      'Adjunt'          => 'Text',
      'idActivitat'     => 'Number',
      'DataDesaparicio' => 'Date',
      'Ordre'           => 'Number',
      'site_id'         => 'Number',
    );
  }
}

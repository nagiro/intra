<?php

/**
 * Cursos filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseCursosFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'TitolCurs'       => new sfWidgetFormFilterInput(),
      'isActiu'         => new sfWidgetFormFilterInput(),
      'Places'          => new sfWidgetFormFilterInput(),
      'Codi'            => new sfWidgetFormFilterInput(),
      'Descripcio'      => new sfWidgetFormFilterInput(),
      'Preu'            => new sfWidgetFormFilterInput(),
      'Preur'           => new sfWidgetFormFilterInput(),
      'Horaris'         => new sfWidgetFormFilterInput(),
      'Categoria'       => new sfWidgetFormFilterInput(),
      'OrdreSortida'    => new sfWidgetFormFilterInput(),
      'DataAparicio'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'DataDesaparicio' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'DataFiMatricula' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'DataInici'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'VisibleWEB'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'TitolCurs'       => new sfValidatorPass(array('required' => false)),
      'isActiu'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Places'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Codi'            => new sfValidatorPass(array('required' => false)),
      'Descripcio'      => new sfValidatorPass(array('required' => false)),
      'Preu'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Preur'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Horaris'         => new sfValidatorPass(array('required' => false)),
      'Categoria'       => new sfValidatorPass(array('required' => false)),
      'OrdreSortida'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'DataAparicio'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'DataDesaparicio' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'DataFiMatricula' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'DataInici'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'VisibleWEB'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'site_id'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('cursos_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cursos';
  }

  public function getFields()
  {
    return array(
      'idCursos'        => 'Number',
      'TitolCurs'       => 'Text',
      'isActiu'         => 'Number',
      'Places'          => 'Number',
      'Codi'            => 'Text',
      'Descripcio'      => 'Text',
      'Preu'            => 'Number',
      'Preur'           => 'Number',
      'Horaris'         => 'Text',
      'Categoria'       => 'Text',
      'OrdreSortida'    => 'Number',
      'DataAparicio'    => 'Date',
      'DataDesaparicio' => 'Date',
      'DataFiMatricula' => 'Date',
      'DataInici'       => 'Date',
      'VisibleWEB'      => 'Number',
      'site_id'         => 'Number',
    );
  }
}

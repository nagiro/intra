<?php

/**
 * Matricules filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseMatriculesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Usuaris_UsuariID' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'Cursos_idCursos'  => new sfWidgetFormPropelChoice(array('model' => 'Cursos', 'add_empty' => true)),
      'Estat'            => new sfWidgetFormFilterInput(),
      'Comentari'        => new sfWidgetFormFilterInput(),
      'DataInscripcio'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Pagat'            => new sfWidgetFormFilterInput(),
      'tReduccio'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tPagament'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Usuaris_UsuariID' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'Cursos_idCursos'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Cursos', 'column' => 'idCursos')),
      'Estat'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Comentari'        => new sfValidatorPass(array('required' => false)),
      'DataInscripcio'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Pagat'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tReduccio'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tPagament'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'site_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('matricules_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Matricules';
  }

  public function getFields()
  {
    return array(
      'idMatricules'     => 'Number',
      'Usuaris_UsuariID' => 'ForeignKey',
      'Cursos_idCursos'  => 'ForeignKey',
      'Estat'            => 'Number',
      'Comentari'        => 'Text',
      'DataInscripcio'   => 'Date',
      'Pagat'            => 'Number',
      'tReduccio'        => 'Number',
      'tPagament'        => 'Number',
      'site_id'          => 'Number',
    );
  }
}

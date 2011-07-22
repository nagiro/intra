<?php

/**
 * Reservaespais filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseReservaespaisFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Representacio'            => new sfWidgetFormFilterInput(),
      'Responsable'              => new sfWidgetFormFilterInput(),
      'PersonalAutoritzat'       => new sfWidgetFormFilterInput(),
      'PrevisioAssistents'       => new sfWidgetFormFilterInput(),
      'EsCicle'                  => new sfWidgetFormFilterInput(),
      'Comentaris'               => new sfWidgetFormFilterInput(),
      'Estat'                    => new sfWidgetFormFilterInput(),
      'Usuaris_usuariID'         => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'Organitzadors'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'DataActivitat'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'HorariActivitat'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'TipusActe'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Nom'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'isEnregistrable'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'EspaisSolicitats'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'MaterialSolicitat'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'DataAlta'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Codi'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'CondicionsCCG'            => new sfWidgetFormFilterInput(),
      'DataAcceptacioCondicions' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'ObservacionsCondicions'   => new sfWidgetFormFilterInput(),
      'site_id'                  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Representacio'            => new sfValidatorPass(array('required' => false)),
      'Responsable'              => new sfValidatorPass(array('required' => false)),
      'PersonalAutoritzat'       => new sfValidatorPass(array('required' => false)),
      'PrevisioAssistents'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'EsCicle'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Comentaris'               => new sfValidatorPass(array('required' => false)),
      'Estat'                    => new sfValidatorPass(array('required' => false)),
      'Usuaris_usuariID'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'Organitzadors'            => new sfValidatorPass(array('required' => false)),
      'DataActivitat'            => new sfValidatorPass(array('required' => false)),
      'HorariActivitat'          => new sfValidatorPass(array('required' => false)),
      'TipusActe'                => new sfValidatorPass(array('required' => false)),
      'Nom'                      => new sfValidatorPass(array('required' => false)),
      'isEnregistrable'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'EspaisSolicitats'         => new sfValidatorPass(array('required' => false)),
      'MaterialSolicitat'        => new sfValidatorPass(array('required' => false)),
      'DataAlta'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Codi'                     => new sfValidatorPass(array('required' => false)),
      'CondicionsCCG'            => new sfValidatorPass(array('required' => false)),
      'DataAcceptacioCondicions' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'ObservacionsCondicions'   => new sfValidatorPass(array('required' => false)),
      'site_id'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('reservaespais_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Reservaespais';
  }

  public function getFields()
  {
    return array(
      'ReservaEspaiID'           => 'Number',
      'Representacio'            => 'Text',
      'Responsable'              => 'Text',
      'PersonalAutoritzat'       => 'Text',
      'PrevisioAssistents'       => 'Number',
      'EsCicle'                  => 'Number',
      'Comentaris'               => 'Text',
      'Estat'                    => 'Text',
      'Usuaris_usuariID'         => 'ForeignKey',
      'Organitzadors'            => 'Text',
      'DataActivitat'            => 'Text',
      'HorariActivitat'          => 'Text',
      'TipusActe'                => 'Text',
      'Nom'                      => 'Text',
      'isEnregistrable'          => 'Number',
      'EspaisSolicitats'         => 'Text',
      'MaterialSolicitat'        => 'Text',
      'DataAlta'                 => 'Date',
      'Codi'                     => 'Text',
      'CondicionsCCG'            => 'Text',
      'DataAcceptacioCondicions' => 'Date',
      'ObservacionsCondicions'   => 'Text',
      'site_id'                  => 'Number',
    );
  }
}

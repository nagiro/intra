<?php

/**
 * Activitats filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseActivitatsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Cicles_CicleID'                  => new sfWidgetFormPropelChoice(array('model' => 'Cicles', 'add_empty' => true)),
      'TipusActivitat_idTipusActivitat' => new sfWidgetFormPropelChoice(array('model' => 'Tipusactivitat', 'add_empty' => true)),
      'Nom'                             => new sfWidgetFormFilterInput(),
      'Preu'                            => new sfWidgetFormFilterInput(),
      'PreuReduit'                      => new sfWidgetFormFilterInput(),
      'Publicable'                      => new sfWidgetFormFilterInput(),
      'Estat'                           => new sfWidgetFormFilterInput(),
      'Descripcio'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Imatge'                          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'PDF'                             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'PublicaWEB'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tCurt'                           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dCurt'                           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tMig'                            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dMig'                            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tComplet'                        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dComplet'                        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tipusEnviament'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Organitzador'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Categories'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Responsable'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'InfoPractica'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'                         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Cicles_CicleID'                  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Cicles', 'column' => 'CicleID')),
      'TipusActivitat_idTipusActivitat' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tipusactivitat', 'column' => 'idTipusActivitat')),
      'Nom'                             => new sfValidatorPass(array('required' => false)),
      'Preu'                            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'PreuReduit'                      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'Publicable'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Estat'                           => new sfValidatorPass(array('required' => false)),
      'Descripcio'                      => new sfValidatorPass(array('required' => false)),
      'Imatge'                          => new sfValidatorPass(array('required' => false)),
      'PDF'                             => new sfValidatorPass(array('required' => false)),
      'PublicaWEB'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tCurt'                           => new sfValidatorPass(array('required' => false)),
      'dCurt'                           => new sfValidatorPass(array('required' => false)),
      'tMig'                            => new sfValidatorPass(array('required' => false)),
      'dMig'                            => new sfValidatorPass(array('required' => false)),
      'tComplet'                        => new sfValidatorPass(array('required' => false)),
      'dComplet'                        => new sfValidatorPass(array('required' => false)),
      'tipusEnviament'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Organitzador'                    => new sfValidatorPass(array('required' => false)),
      'Categories'                      => new sfValidatorPass(array('required' => false)),
      'Responsable'                     => new sfValidatorPass(array('required' => false)),
      'InfoPractica'                    => new sfValidatorPass(array('required' => false)),
      'site_id'                         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('activitats_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Activitats';
  }

  public function getFields()
  {
    return array(
      'ActivitatID'                     => 'Number',
      'Cicles_CicleID'                  => 'ForeignKey',
      'TipusActivitat_idTipusActivitat' => 'ForeignKey',
      'Nom'                             => 'Text',
      'Preu'                            => 'Number',
      'PreuReduit'                      => 'Number',
      'Publicable'                      => 'Number',
      'Estat'                           => 'Text',
      'Descripcio'                      => 'Text',
      'Imatge'                          => 'Text',
      'PDF'                             => 'Text',
      'PublicaWEB'                      => 'Number',
      'tCurt'                           => 'Text',
      'dCurt'                           => 'Text',
      'tMig'                            => 'Text',
      'dMig'                            => 'Text',
      'tComplet'                        => 'Text',
      'dComplet'                        => 'Text',
      'tipusEnviament'                  => 'Number',
      'Organitzador'                    => 'Text',
      'Categories'                      => 'Text',
      'Responsable'                     => 'Text',
      'InfoPractica'                    => 'Text',
      'site_id'                         => 'Number',
    );
  }
}

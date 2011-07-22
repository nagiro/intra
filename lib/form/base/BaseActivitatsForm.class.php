<?php

/**
 * Activitats form base class.
 *
 * @method Activitats getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseActivitatsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ActivitatID'                     => new sfWidgetFormInputHidden(),
      'Cicles_CicleID'                  => new sfWidgetFormPropelChoice(array('model' => 'Cicles', 'add_empty' => true)),
      'TipusActivitat_idTipusActivitat' => new sfWidgetFormPropelChoice(array('model' => 'Tipusactivitat', 'add_empty' => true)),
      'Nom'                             => new sfWidgetFormTextarea(),
      'Preu'                            => new sfWidgetFormInputText(),
      'PreuReduit'                      => new sfWidgetFormInputText(),
      'Publicable'                      => new sfWidgetFormInputText(),
      'Estat'                           => new sfWidgetFormInputText(),
      'Descripcio'                      => new sfWidgetFormTextarea(),
      'Imatge'                          => new sfWidgetFormTextarea(),
      'PDF'                             => new sfWidgetFormTextarea(),
      'PublicaWEB'                      => new sfWidgetFormInputText(),
      'tCurt'                           => new sfWidgetFormTextarea(),
      'dCurt'                           => new sfWidgetFormTextarea(),
      'tMig'                            => new sfWidgetFormTextarea(),
      'dMig'                            => new sfWidgetFormTextarea(),
      'tComplet'                        => new sfWidgetFormTextarea(),
      'dComplet'                        => new sfWidgetFormTextarea(),
      'tipusEnviament'                  => new sfWidgetFormInputText(),
      'Organitzador'                    => new sfWidgetFormInputText(),
      'Categories'                      => new sfWidgetFormInputText(),
      'Responsable'                     => new sfWidgetFormTextarea(),
      'InfoPractica'                    => new sfWidgetFormTextarea(),
      'site_id'                         => new sfWidgetFormInputText(),
      'actiu'                           => new sfWidgetFormInputText(),
      'isEntrada'                       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ActivitatID'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getActivitatid()), 'empty_value' => $this->getObject()->getActivitatid(), 'required' => false)),
      'Cicles_CicleID'                  => new sfValidatorPropelChoice(array('model' => 'Cicles', 'column' => 'CicleID', 'required' => false)),
      'TipusActivitat_idTipusActivitat' => new sfValidatorPropelChoice(array('model' => 'Tipusactivitat', 'column' => 'idTipusActivitat', 'required' => false)),
      'Nom'                             => new sfValidatorString(array('required' => false)),
      'Preu'                            => new sfValidatorNumber(array('required' => false)),
      'PreuReduit'                      => new sfValidatorNumber(array('required' => false)),
      'Publicable'                      => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'Estat'                           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Descripcio'                      => new sfValidatorString(),
      'Imatge'                          => new sfValidatorString(),
      'PDF'                             => new sfValidatorString(),
      'PublicaWEB'                      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'tCurt'                           => new sfValidatorString(),
      'dCurt'                           => new sfValidatorString(),
      'tMig'                            => new sfValidatorString(),
      'dMig'                            => new sfValidatorString(),
      'tComplet'                        => new sfValidatorString(),
      'dComplet'                        => new sfValidatorString(),
      'tipusEnviament'                  => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'Organitzador'                    => new sfValidatorString(array('max_length' => 250)),
      'Categories'                      => new sfValidatorString(array('max_length' => 100)),
      'Responsable'                     => new sfValidatorString(),
      'InfoPractica'                    => new sfValidatorString(),
      'site_id'                         => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'                           => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'isEntrada'                       => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('activitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Activitats';
  }


}

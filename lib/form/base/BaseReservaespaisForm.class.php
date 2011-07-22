<?php

/**
 * Reservaespais form base class.
 *
 * @method Reservaespais getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseReservaespaisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ReservaEspaiID'           => new sfWidgetFormInputHidden(),
      'Representacio'            => new sfWidgetFormTextarea(),
      'Responsable'              => new sfWidgetFormTextarea(),
      'PersonalAutoritzat'       => new sfWidgetFormTextarea(),
      'PrevisioAssistents'       => new sfWidgetFormInputText(),
      'EsCicle'                  => new sfWidgetFormInputText(),
      'Comentaris'               => new sfWidgetFormTextarea(),
      'Estat'                    => new sfWidgetFormInputText(),
      'Usuaris_usuariID'         => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'Organitzadors'            => new sfWidgetFormTextarea(),
      'DataActivitat'            => new sfWidgetFormTextarea(),
      'HorariActivitat'          => new sfWidgetFormTextarea(),
      'TipusActe'                => new sfWidgetFormTextarea(),
      'Nom'                      => new sfWidgetFormTextarea(),
      'isEnregistrable'          => new sfWidgetFormInputText(),
      'EspaisSolicitats'         => new sfWidgetFormTextarea(),
      'MaterialSolicitat'        => new sfWidgetFormTextarea(),
      'DataAlta'                 => new sfWidgetFormDateTime(),
      'Codi'                     => new sfWidgetFormInputText(),
      'CondicionsCCG'            => new sfWidgetFormTextarea(),
      'DataAcceptacioCondicions' => new sfWidgetFormDateTime(),
      'ObservacionsCondicions'   => new sfWidgetFormTextarea(),
      'site_id'                  => new sfWidgetFormInputText(),
      'actiu'                    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ReservaEspaiID'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getReservaespaiid()), 'empty_value' => $this->getObject()->getReservaespaiid(), 'required' => false)),
      'Representacio'            => new sfValidatorString(array('required' => false)),
      'Responsable'              => new sfValidatorString(array('required' => false)),
      'PersonalAutoritzat'       => new sfValidatorString(array('required' => false)),
      'PrevisioAssistents'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'EsCicle'                  => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'Comentaris'               => new sfValidatorString(array('required' => false)),
      'Estat'                    => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Usuaris_usuariID'         => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'Organitzadors'            => new sfValidatorString(),
      'DataActivitat'            => new sfValidatorString(),
      'HorariActivitat'          => new sfValidatorString(),
      'TipusActe'                => new sfValidatorString(),
      'Nom'                      => new sfValidatorString(),
      'isEnregistrable'          => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'EspaisSolicitats'         => new sfValidatorString(),
      'MaterialSolicitat'        => new sfValidatorString(),
      'DataAlta'                 => new sfValidatorDateTime(array('required' => false)),
      'Codi'                     => new sfValidatorString(array('max_length' => 10)),
      'CondicionsCCG'            => new sfValidatorString(array('required' => false)),
      'DataAcceptacioCondicions' => new sfValidatorDateTime(array('required' => false)),
      'ObservacionsCondicions'   => new sfValidatorString(array('required' => false)),
      'site_id'                  => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'                    => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('reservaespais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Reservaespais';
  }


}

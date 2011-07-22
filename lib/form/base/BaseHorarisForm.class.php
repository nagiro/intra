<?php

/**
 * Horaris form base class.
 *
 * @method Horaris getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHorarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'HorarisID'              => new sfWidgetFormInputHidden(),
      'Activitats_ActivitatID' => new sfWidgetFormPropelChoice(array('model' => 'Activitats', 'add_empty' => false)),
      'Dia'                    => new sfWidgetFormDate(),
      'HoraInici'              => new sfWidgetFormTime(),
      'HoraFi'                 => new sfWidgetFormTime(),
      'HoraPre'                => new sfWidgetFormTime(),
      'HoraPost'               => new sfWidgetFormTime(),
      'Avis'                   => new sfWidgetFormTextarea(),
      'Espectadors'            => new sfWidgetFormInputText(),
      'Places'                 => new sfWidgetFormInputText(),
      'Titol'                  => new sfWidgetFormInputText(),
      'Preu'                   => new sfWidgetFormInputText(),
      'PreuR'                  => new sfWidgetFormInputText(),
      'Estat'                  => new sfWidgetFormInputText(),
      'Responsable'            => new sfWidgetFormTextarea(),
      'site_id'                => new sfWidgetFormInputText(),
      'actiu'                  => new sfWidgetFormInputText(),
      'isEntrada'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'HorarisID'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getHorarisid()), 'empty_value' => $this->getObject()->getHorarisid(), 'required' => false)),
      'Activitats_ActivitatID' => new sfValidatorPropelChoice(array('model' => 'Activitats', 'column' => 'ActivitatID')),
      'Dia'                    => new sfValidatorDate(array('required' => false)),
      'HoraInici'              => new sfValidatorTime(array('required' => false)),
      'HoraFi'                 => new sfValidatorTime(array('required' => false)),
      'HoraPre'                => new sfValidatorTime(array('required' => false)),
      'HoraPost'               => new sfValidatorTime(array('required' => false)),
      'Avis'                   => new sfValidatorString(),
      'Espectadors'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'Places'                 => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'Titol'                  => new sfValidatorString(array('max_length' => 255)),
      'Preu'                   => new sfValidatorNumber(),
      'PreuR'                  => new sfValidatorNumber(),
      'Estat'                  => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'Responsable'            => new sfValidatorString(),
      'site_id'                => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'actiu'                  => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'isEntrada'              => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('horaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Horaris';
  }


}

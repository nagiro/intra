<?php

/**
 * Cluber form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCluberForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idClubber'          => new sfWidgetFormInputHidden(),
      'Nivells_idNivells'  => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => false)),
      'Entitats_EntitatID' => new sfWidgetFormPropelChoice(array('model' => 'Entitats', 'add_empty' => false)),
      'Usuaris_UsuariID'   => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'Habilitat'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idClubber'          => new sfValidatorPropelChoice(array('model' => 'Cluber', 'column' => 'idClubber', 'required' => false)),
      'Nivells_idNivells'  => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells')),
      'Entitats_EntitatID' => new sfValidatorPropelChoice(array('model' => 'Entitats', 'column' => 'EntitatID')),
      'Usuaris_UsuariID'   => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'Habilitat'          => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cluber[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cluber';
  }


}

<?php

/**
 * UsuarisApps form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class UsuarisAppsForm extends sfFormPropel
{
	
  public function setup()
  {
    $this->setWidgets(array(
      'usuari_id' => new sfWidgetFormInputHidden(),
      'app_id'    => new sfWidgetFormChoice(array('choices'=>AppsPeer::select())),
      'nivell_id' => new sfWidgetFormChoice(array('choices' => NivellsPeer::getSelect())),
    ));

    $this->setValidators(array(
      'usuari_id' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'app_id'    => new sfValidatorPropelChoice(array('model' => 'Apps', 'column' => 'app_id', 'required' => false)),
      'nivell_id' => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuaris_apps[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarisApps';
  }
	
}

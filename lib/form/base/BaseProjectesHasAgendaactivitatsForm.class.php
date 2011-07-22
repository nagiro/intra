<?php

/**
 * ProjectesHasAgendaactivitats form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProjectesHasAgendaactivitatsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Projectes_idProjectes'                         => new sfWidgetFormInputHidden(),
      'AgendaActivitats_AgendaActivitatsActivitatsID' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'Projectes_idProjectes'                         => new sfValidatorPropelChoice(array('model' => 'Projectes', 'column' => 'idProjectes', 'required' => false)),
      'AgendaActivitats_AgendaActivitatsActivitatsID' => new sfValidatorPropelChoice(array('model' => 'Agendaactivitats', 'column' => 'AgendaActivitatsActivitatsID', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('projectes_has_agendaactivitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProjectesHasAgendaactivitats';
  }


}

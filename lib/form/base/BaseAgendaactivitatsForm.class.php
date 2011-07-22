<?php

/**
 * Agendaactivitats form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAgendaactivitatsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'AgendaActivitatsActivitatsID'        => new sfWidgetFormInputHidden(),
      'Cluber_idClubber'                    => new sfWidgetFormPropelChoice(array('model' => 'Cluber', 'add_empty' => false)),
      'Titol'                               => new sfWidgetFormTextarea(),
      'Text'                                => new sfWidgetFormTextarea(),
      'Date'                                => new sfWidgetFormDate(),
      'Lloc'                                => new sfWidgetFormTextarea(),
      'HoraI'                               => new sfWidgetFormTime(),
      'HoraF'                               => new sfWidgetFormTime(),
      'Link'                                => new sfWidgetFormTextarea(),
      'Ciutat'                              => new sfWidgetFormTextarea(),
      'projectes_has_agendaactivitats_list' => new sfWidgetFormPropelChoice(array('model' => 'Projectes','multiple'=>true)),
    ));

    $this->setValidators(array(
      'AgendaActivitatsActivitatsID'        => new sfValidatorPropelChoice(array('model' => 'Agendaactivitats', 'column' => 'AgendaActivitatsActivitatsID', 'required' => false)),
      'Cluber_idClubber'                    => new sfValidatorPropelChoice(array('model' => 'Cluber', 'column' => 'idClubber')),
      'Titol'                               => new sfValidatorString(array('required' => false)),
      'Text'                                => new sfValidatorString(array('required' => false)),
      'Date'                                => new sfValidatorDate(array('required' => false)),
      'Lloc'                                => new sfValidatorString(array('required' => false)),
      'HoraI'                               => new sfValidatorTime(array('required' => false)),
      'HoraF'                               => new sfValidatorTime(array('required' => false)),
      'Link'                                => new sfValidatorString(array('required' => false)),
      'Ciutat'                              => new sfValidatorString(array('required' => false)),
      'projectes_has_agendaactivitats_list' => new sfValidatorPropelChoice(array('model' => 'Projectes', 'required' => false, 'multiple'=>true)),
    ));

    $this->widgetSchema->setNameFormat('agendaactivitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agendaactivitats';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['projectes_has_agendaactivitats_list']))
    {
      $values = array();
      foreach ($this->object->getProjectesHasAgendaactivitatss() as $obj)
      {
        $values[] = $obj->getProjectesIdprojectes();
      }

      $this->setDefault('projectes_has_agendaactivitats_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveProjectesHasAgendaactivitatsList($con);
  }

  public function saveProjectesHasAgendaactivitatsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['projectes_has_agendaactivitats_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ProjectesHasAgendaactivitatsPeer::AGENDAACTIVITATS_AGENDAACTIVITATSACTIVITATSID, $this->object->getPrimaryKey());
    ProjectesHasAgendaactivitatsPeer::doDelete($c, $con);

    $values = $this->getValue('projectes_has_agendaactivitats_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProjectesHasAgendaactivitats();
        $obj->setAgendaactivitatsAgendaactivitatsactivitatsid($this->object->getPrimaryKey());
        $obj->setProjectesIdprojectes($value);
        $obj->save();
      }
    }
  }

}

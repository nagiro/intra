<?php

/**
 * AppBlogsMultimedia form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AppBlogsMultimediaForm extends BaseAppBlogsMultimediaForm
{
	
  public function setup()
  {
    $this->setWidgets(array(
      'id'                               => new sfWidgetFormInputHidden(),
      'name'                             => new sfWidgetFormInputText(),
      'desc'                             => new sfWidgetFormTextarea(),
      'url'                              => new sfWidgetFormInputText(),
      'date'                             => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'                               => new sfValidatorPropelChoice(array('model' => 'AppBlogsMultimedia', 'column' => 'id', 'required' => false)),
      'name'                             => new sfValidatorString(array('max_length' => 50)),
      'desc'                             => new sfValidatorString(),
      'url'                              => new sfValidatorString(array('max_length' => 255)),
      'date'                             => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_multimedia[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {
    return 'AppBlogsMultimedia';
  }
	  
}

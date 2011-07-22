<?php

/**
 * AppBlogsBlogs form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AppBlogsBlogsForm extends BaseAppBlogsBlogsForm
{
    
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'name'    => new sfWidgetFormInputText(array(),array('style'=>'width:400px;')),
      'date'    => new sfWidgetFormInputHidden(),
      'site_id' => new sfWidgetFormInputHidden(),
      'actiu'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'    => new sfValidatorString(array('max_length' => 50)),
      'date'    => new sfValidatorDate(),
      'site_id' => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_blogs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->widgetSchema->setLabels(array(
        'name' => 'Nom: ',
        'date' => 'Data: ',
    ));
    
  }

  public function getModelName()
  {
    return 'AppBlogsBlogs';
  }
  
}

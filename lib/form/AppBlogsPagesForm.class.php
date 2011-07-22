<?php

/**
 * AppBlogsPages form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AppBlogsPagesForm extends BaseAppBlogsPagesForm
{
	
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'name'    => new sfWidgetFormInputText(array(),array('style'=>'width:300px;')),
      'visible' => new sfWidgetFormChoice(array('choices'=>array(1=>'SÃ­',0=>'No'))),
      'date'    => new sfWidgetFormInputHidden(),
      'type'    => new sfWidgetFormChoice(array('choices'=>AppBlogsPagesPeer::getTypesArray())),
      'blog_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorPropelChoice(array('model' => 'AppBlogsPages', 'column' => 'id', 'required' => false)),
      'name'    => new sfValidatorString(array('max_length' => 40)),
      'visible' => new sfValidatorBoolean(),
      'date'    => new sfValidatorDate(),
      'type'    => new sfValidatorString(array('max_length' => 1)),
      'blog_id' => new sfValidatorPropelChoice(array('model' => 'AppBlogsBlogs', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_pages[%s]');
    
    $this->widgetSchema->setLabels(array(
      'name'    => 'Nom genÃ¨ric: ',
      'visible' => 'Visible? ',     
      'type'    => 'Tipus? ',     
    ));

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }

  public function getModelName()
  {
    return 'AppBlogsPages';
  }
	
}

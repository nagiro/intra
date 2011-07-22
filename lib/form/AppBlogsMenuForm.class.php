<?php

/**
 * AppBlogsMenu form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AppBlogsMenuForm extends BaseAppBlogsMenuForm
{
  public function setup()
  {
  	
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormInputText(array(),array('style'=>'width:300px')),      
      'order'     => new sfWidgetFormInputText(array(),array('style'=>'width:300px')),
      'blog_id'   => new sfWidgetFormInputHidden(),
      'father_id' => new sfWidgetFormChoice(array('choices'=>AppBlogsMenuPeer::getBlogMenusArray($this->getOption('APP_BLOG'),$this->getOption('IDS')))),
      'page_id'   => new sfWidgetFormChoice(array('choices'=>AppBlogsPagesPeer::getBlogPagesArray($this->getOption('APP_BLOG'),$this->getOption('IDS')))),      
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorPropelChoice(array('model' => 'AppBlogsMenu', 'column' => 'id', 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 50)),
      'page_id'   => new sfValidatorPropelChoice(array('model' => 'AppBlogsPages', 'column' => 'id', 'required' => false)),
      'order'     => new sfValidatorInteger(),
      'blog_id'   => new sfValidatorPropelChoice(array('model' => 'AppBlogsBlogs', 'column' => 'id')),
      'father_id' => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_menu[%s]');
    
    $this->widgetSchema->setLabels(array(
      'name'      => 'Nom: ',
      'page_id'   => 'PÃ gina relacionada: ',
      'order'     => 'Ordre: ',      
      'father_id' => 'MenÃº pare: ',        
    ));

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {
    return 'AppBlogsMenu';
  }
	
}

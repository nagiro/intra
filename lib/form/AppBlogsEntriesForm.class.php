<?php

/**
 * AppBlogsEntries form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Joh� i Mart�
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AppBlogsEntriesForm extends BaseAppBlogsEntriesForm
{
	
  public function setup()
  {
    $this->setWidgets(array(
      'id'                               => new sfWidgetFormInputHidden(),
      'page_id'                          => new sfWidgetFormChoice(array('choices'=>AppBlogsPagesPeer::getPagesSelect($this->getOption('APP_BLOG'),$this->getOption('IDS')))),
      'lang'                             => new sfWidgetFormChoice(array('choices'=>array('CA'=>'Català'))),
      'title'                            => new sfWidgetFormInputText(array(),array('style'=>'width:500px')),
      'subtitle1'                        => new sfWidgetFormInputText(array(),array('style'=>'width:500px')),
      'subtitle2'                        => new sfWidgetFormInputText(array(),array('style'=>'width:500px')),
      'body'                             => new sfWidgetFormTextarea(),
      'date'                             => new sfWidgetFormDateTime(array('date'=>array('format'=>'%day%/%month%/%year%'))),
      'tags'							 => new sfWidgetFormInputText(array(),array('style'=>'width:500px')),
      'url'								 => new sfWidgetFormInputText(array(),array('style'=>'width:500px')),   
    ));

    $this->setValidators(array(
      'id'                               => new sfValidatorPropelChoice(array('model' => 'AppBlogsEntries', 'column' => 'id', 'required' => false)),
      'page_id'                          => new sfValidatorPropelChoice(array('model' => 'AppBlogsPages', 'column' => 'id')),
      'lang'                             => new sfValidatorString(array('max_length' => 4)),
      'title'                            => new sfValidatorString(array('max_length' => 255)),
      'subtitle1'                        => new sfValidatorString(array('max_length' => 100, 'required'=>false)),
      'subtitle2'                        => new sfValidatorString(array('max_length' => 100, 'required'=>false)),
      'body'                             => new sfValidatorString(),
      'date'                             => new sfValidatorDateTime(),
      'tags'							 => new sfValidatorString(array('max_length'=> 100)),
      'url'								 => new sfValidatorString(array('max_length'=> 100, 'required'=>false)),
    ));

    $this->widgetSchema->setLabels(array(      
      'page_id'                          => 'Pagina: ',
      'lang'                             => 'Llengua: ',
      'title'                            => 'Títol: ',
      'subtitle1'                        => 'Subtitol: ',
      'subtitle2'                        => 'Subtítol 2: ',
      'body'                             => 'Cos: ',
      'date'                             => 'Data: ',  
      'tags'							 => 'Tags: ',
      'url'								 => 'Enllaç: ',     
    ));
    
    $this->widgetSchema->setNameFormat('app_blogs_entries[%s]');        

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {
    return 'AppBlogsEntries';
  }

}

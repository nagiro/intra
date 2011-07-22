<?php

/**
 * Blogcomentaris form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseBlogcomentarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'BlogComentariID'         => new sfWidgetFormInputHidden(),
      'BlogArticles_ArticlesID' => new sfWidgetFormPropelChoice(array('model' => 'Blogarticles', 'add_empty' => false)),
      'Qui'                     => new sfWidgetFormTextarea(),
      'Comentari'               => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'BlogComentariID'         => new sfValidatorPropelChoice(array('model' => 'Blogcomentaris', 'column' => 'BlogComentariID', 'required' => false)),
      'BlogArticles_ArticlesID' => new sfValidatorPropelChoice(array('model' => 'Blogarticles', 'column' => 'ArticlesID')),
      'Qui'                     => new sfValidatorString(array('required' => false)),
      'Comentari'               => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('blogcomentaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Blogcomentaris';
  }


}

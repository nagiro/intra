<?php

/**
 * Sites form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 */
class SitesSelectForm extends BaseSitesForm
{
    
  public function setup()
  {
    $this->setWidgets(array(      
      'site_id_my'         => new sfWidgetFormChoice(array('choices'=>SitesPeer::getSelectUser($this->getOption('idU')))),
      'site_id'            => new sfWidgetFormChoice(array('choices'=>SitesPeer::getSelect(false))),                  
    ));

    $this->setValidators(array(
      'site_id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getSiteId()), 'empty_value' => $this->getObject()->getSiteId(), 'required' => false)),
      'site_id_my'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getSiteId()), 'empty_value' => $this->getObject()->getSiteId(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sites[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetSchema->setLabels(
        array(
            'site_id'=>"Totes les entitats: ",
            'site_id_my'=>'Entitats on he participat: '));
    
  }

  public function getModelName()
  {
    return 'Sites';
  }
}

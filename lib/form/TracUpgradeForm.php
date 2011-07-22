<?php

/**
 * Trac form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 */
class TracUpgradeForm extends BaseTracForm
{
  public function configure()
  {
                
    $this->setWidgets(array(
      'idTrac'         => new sfWidgetFormInputHidden(),
      'solved_version' => new sfWidgetFormInputText(),      
      'title'          => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),      
      'description'    => new sfWidgetFormTextareaTinyMCE(array()),      
      'type'           => new sfWidgetFormChoice(array('choices'=>array(TracPeer::TYPE_UPGRADE=>'Upgrade'))),      
      'importancy'     => new sfWidgetFormInputHidden(),
      'usuari_id'      => new sfWidgetFormInputHidden(),
      'site_id'        => new sfWidgetFormInputHidden(),
      'actiu'          => new sfWidgetFormInputHidden(),
      'date'          => new sfWidgetFormJQueryDate(array('format'=>'%day% %month% %year%')),             
    ));

    $this->setValidators(array(
      'idTrac'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdtrac()), 'empty_value' => $this->getObject()->getIdtrac(), 'required' => false)),
      'title'          => new sfValidatorString(),
      'description'    => new sfValidatorString(),
      'type'           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'solved_version' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'importancy'     => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'usuari_id'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'site_id'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'actiu'          => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required'=>false)),
      'date'           => new sfValidatorDate(),
    ));
    
    $this->widgetSchema->setLabels(array(      
      'title'          => 'TÃ­tol: ',
      'description'    => 'DescripciÃ³: ',
      'type'           => 'Tipus: ',
      'solved_version' => 'VersiÃ³: ',      
      'date'           => 'Data alta: ',       
    ));        
    
    $this->widgetSchema->setNameFormat('trac[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }
}

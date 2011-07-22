<?php

/**
 * Activitats form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ActivitatsForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ActivitatID'                     => new sfWidgetFormInputHidden(),
      'Nom'                             => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),    
      'Cicles_CicleID'                  => new sfWidgetFormChoice(array('choices'=>CiclesPeer::getSelect($this->getOption('IDS')))),
      'TipusActivitat_idTipusActivitat' => new sfWidgetFormChoice(array('choices'=>TipusactivitatPeer::getSelect($this->getOption('IDS')))),
      'Preu'                            => new sfWidgetFormInputText(),
      'PreuReduit'                      => new sfWidgetFormInputText(),
      'isEntrada'                       => new sfWidgetFormChoice(array('choices'=>array(1=>'SÃ­',0=>'No'))),
      'Estat'                           => new sfWidgetFormChoice(array('choices'=>ActivitatsPeer::getSelectEstats())),
      'Organitzador'				    => new sfWidgetFormInputText(),
      'Responsable'		 			    => new sfWidgetFormInputText(),
      'site_id'                         => new sfWidgetFormInputHidden(array(),array()),
      'actiu'                           => new sfWidgetFormInputHidden(array(),array()),            
      'Publicable'                      => new sfWidgetFormInputHidden(array(),array()),
    ));

    $this->setValidators(array(
      'ActivitatID'                     => new sfValidatorPropelChoice(array('model' => 'Activitats', 'column' => 'ActivitatID', 'required' => false)),
      'Cicles_CicleID'                  => new sfValidatorPropelChoice(array('model' => 'Cicles', 'column' => 'CicleID', 'required' => false)),
      'TipusActivitat_idTipusActivitat' => new sfValidatorPropelChoice(array('model' => 'Tipusactivitat', 'column' => 'idTipusActivitat', 'required' => false)),
      'Nom'                             => new sfValidatorString(array('required' => true)),
      'Preu'                            => new sfValidatorNumber(array('required' => false)),
      'PreuReduit'                      => new sfValidatorNumber(array('required' => false)),
      'Publicable'                      => new sfValidatorInteger(array('required' => false)),
      'Estat'                           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Organitzador'				    => new sfValidatorString(array('required'=>false),array()),
      'Responsable'					    => new sfValidatorString(array('required'=>false),array()),
      'site_id'                         => new sfValidatorPass(),
      'actiu'                           => new sfValidatorPass(),          
      'isEntrada'                       => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setLabels(array(      
      'Nom'                             => 'Nom de l\'activitat: ',    
      'Cicles_CicleID'                  => 'A quin cicle pertany? ',
      'TipusActivitat_idTipusActivitat' => 'Quin format tÃ©? ',
      'Preu'                            => 'Preu: ',
      'PreuReduit'                      => 'Preu reduÃ¯t: ',
      'Publicable'                      => 'Visible al web?',
      'Estat'                           => 'Estat actual: ',
      'Organitzador'				    => 'Organitzador',
      'Responsable'				    	=> 'Responsable',      
      'isEntrada'                       => 'Vendre entrades?',
    ));
    
    
    $this->widgetSchema->setNameFormat('activitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');

  }

  public function getModelName()
  {
    return 'Activitats';
  }

}

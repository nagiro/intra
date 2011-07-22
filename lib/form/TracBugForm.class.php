<?php

/**
 * Trac form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 */
class TracBugForm extends BaseTracForm
{
  public function configure()
  {
            
    $this->setWidgets(array(
      'idTrac'         => new sfWidgetFormInputHidden(),
      'title'          => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'description'    => new sfWidgetFormTextareaTinyMCE(),
      'type'           => new sfWidgetFormChoice(array('choices'=>array(TracPeer::TYPE_BUG=>'Error',TracPeer::TYPE_IMPROVEMENT=>'Millora'))),
      'importancy'     => new sfWidgetFormChoice(array('choices'=>array('1'=>'Alta','2'=>'Mitjana','3'=>'Baixa'))),            
      'usuari_id'      => new sfWidgetFormInputHidden(),
      'site_id'        => new sfWidgetFormInputHidden(),
      'actiu'          => new sfWidgetFormInputHidden(),
      'date'           => new sfWidgetFormDate(),
      'solved_version' => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'idTrac'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdtrac()), 'empty_value' => $this->getObject()->getIdtrac(), 'required' => false)),
      'title'          => new sfValidatorString(),
      'description'    => new sfValidatorString(),
      'type'           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'solved_version' => new sfValidatorDate(array('required' => false)),
      'importancy'     => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'usuari_id'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'site_id'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'actiu'          => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false )),
      'date'           => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('trac[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);    
    
    
        
    $this->widgetSchema->setLabels(array(      
      'title'          => 'TÃ­tol: ',
      'description'    => 'DescripciÃ³: ',
      'type'           => 'Tipus: ',
      'solved_version' => 'Solucionat a: ',
      'importancy'     => 'ImportÃ ncia: ',
      'date'           => 'Data alta: ',       
    ));    
    
  }
}

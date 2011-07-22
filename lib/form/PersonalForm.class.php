<?php

/**
 * Personal form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Joh� i Mart�
 */
class PersonalForm extends sfFormPropel
{
  public function setup()
  {
                     
    $this->setWidgets(array(
      'idPersonal'     => new sfWidgetFormInputHidden(),
      'idUsuari'       => new sfWidgetFormInputHidden(),
      'idData'         => new sfWidgetFormInputHidden(),
      'tipus'          => new sfWidgetFormChoice(array('choices'=>PersonalPeer::getTipusArray())),
      'text'           => new sfWidgetFormTextarea(),      
      'data_alta'      => new sfWidgetFormInputHidden(),
      'data_baixa'     => new sfWidgetFormInputHidden(),
      'usuariUpdateId' => new sfWidgetFormInputHidden(),
      'finalitza'      => new sfWidgetFormChoice(array('choices'=>array( 0=>'No' , 1=>'Sí' )),array()),
      'data_finalitzada' => new sfWidgetFormShowText(array('type'=>'date'),array()),                  
      'revisat'        => new sfWidgetFormChoice(array('choices'=>array( 0=>'No' , 1=>'Sí' )),array()),
      'data_revisio'     => new sfWidgetFormShowText(array('type'=>'date'),array()),            
    ));

    $DR = $this->getObject()->getDatarevisio();    
    $DF = $this->getObject()->getDataFinalitzada();    
    if($DR != null) $this->setWidget('revisat',new sfWidgetFormInputHidden());
    if($DF != null) $this->setWidget('finalitza',new sfWidgetFormInputHidden());   

    $this->setValidators(array(
      'idPersonal'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdpersonal()), 'empty_value' => $this->getObject()->getIdpersonal(), 'required' => false)),
      'idUsuari'       => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'idData'         => new sfValidatorDate(),
      'tipus'          => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'text'           => new sfValidatorString(array('required' => false)),
      'data_revisio'   => new sfValidatorDate(array('required' => false)),
      'data_alta'      => new sfValidatorDateTime(array('required' => false)),
      'data_baixa'     => new sfValidatorDate(array('required' => false)),
      'usuariUpdateId' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'data_finalitzada' => new sfValidatorDate(array('required'=>false),array()),
      'finalitza'      => new sfValidatorPass(array('required'=>false),array()),
      'revisat'        => new sfValidatorPass(array('required'=>false),array()),
    ));

    $this->widgetSchema->setNameFormat('personal[%s]');

    $this->widgetSchema->setLabels(array(            
      'tipus' => 'Tipus',
      'text'   => 'Text',
      'data_revisio' => 'Data revisió: ',      
      'finalitza' => 'Acabada?',
      'revisat' => 'Revisada?',
      'data_finalitzada' => 'Data acabada: '
    ));
            
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }

  public function getModelName()
  {
    return 'Personal';
  }
  
  public function save($conn = null)
  {        
    $this->updateObject();
    $OP = $this->getObject(); 
    
    //Si hem clicat el botó finalitza, guardem el valor de data finalitzada.
    if($this->getValue('finalitza') == true):
        $OP->setDataFinalitzada(date('Y-m-d H:i',time()));
    else: 
        $OP->setDataFinalitzada(null);    
    endif;
    
    //Si hem clicat el botó de revisat, guardem el valor de data de revisió
    if($this->getValue('revisat') == true):
        $OP->setDataRevisio(date('Y-m-d H:i',time()));
    else: 
        $OP->setDataRevisio(null);    
    endif; 
    
    $OP->save();
    
  }
  
}

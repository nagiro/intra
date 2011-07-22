<?php

/**
 * UsuarisSites form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 */
class UsuarisSitesForm extends BaseUsuarisSitesForm
{
    
  public function setup()
  {
            
    $Users = UsuarisPeer::selectAllUsers();
    $idU = $this->getObject()->getUsuariid();
                    
    $this->setWidgets(array(
      'DNI'       => new sfWidgetFormInput( array() , array() ),      
      'usuari_id' => new sfWidgetFormChoice( array('choices'=> $Users ) , array() ),
      'site_id'   => new sfWidgetFormChoice( array('choices' => UsuarisSitesPeer::getSites( $idU , $this->getOption('NEW')) )),      
      'nivell_id' => new sfWidgetFormChoice( array('choices' => NivellsPeer::getSelect()) ),
      'actiu'     => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'DNI'       => new sfValidatorString( array('required'=>true) , array() ),
      'usuari_id' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'site_id'   => new sfValidatorPropelChoice(array('model' => 'Sites', 'column' => 'site_id', 'required' => false)),
      'nivell_id' => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells')),
      'actiu'     => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('usuaris_sites[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }

  public function getModelName()
  {
    return 'UsuarisSites';
  }

}

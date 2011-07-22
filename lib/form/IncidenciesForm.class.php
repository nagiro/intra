<?php

/**
 * Incidencies form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class IncidenciesForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idIncidencia'  => new sfWidgetFormInputHidden(),
      'quiinforma'    => new sfWidgetFormChoice(array('choices'=>UsuarisPeer::selectTreballadors($this->getOption('IDS')))),
      'quiresol'      => new sfWidgetFormChoice(array('choices'=>UsuarisPeer::selectTreballadors($this->getOption('IDS')))),
      'titol'         => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'descripcio'    => new sfWidgetFormTextarea(array(),array('style'=>'width:400px')),
      'estat'         => new sfWidgetFormChoice(array('choices'=>IncidenciesPeer::getEstatSelect())),
      'dataalta'      => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),
      'dataresolucio' => new sfWidgetFormInputHidden(),
      'site_id'       => new sfWidgetFormInputHidden(),
      'actiu'         => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'idIncidencia'  => new sfValidatorPropelChoice(array('model' => 'Incidencies', 'column' => 'idIncidencia', 'required' => false)),
      'quiinforma'    => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'quiresol'      => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'titol'         => new sfValidatorString(array('required' => false)),
      'descripcio'    => new sfValidatorString(array('required' => false)),
      'estat'         => new sfValidatorInteger(),
      'dataalta'      => new sfValidatorDate(array('required'=>false)),
      'dataresolucio' => new sfValidatorDate(array('required'=>false)),
      'site_id'       => new sfValidatorPass(),
      'actiu'         => new sfValidatorPass(),      
    ));

    $this->widgetSchema->setLabels(array(      
      'quiinforma'    => 'Afectat: ',
      'quiresol'      => 'Responsable: ',
      'titol'         => 'Titol: ',
      'descripcio'    => 'DescripciÃ³: ',
      'estat'         => 'Estat: ',
      'dataalta'      => 'Data d\'alta',
      'dataresolucio' => 'Data resoluciÃ³: ',
    ));
    
    $this->widgetSchema->setNameFormat('incidencies[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {
    return 'Incidencies';
  }
  
  public function save($conn = null)
  {
  	
  	parent::save($conn);
  	  	
  	$OI = $this->getObject();
  	$DR = $OI->getDataresolucio();
  	if($OI->getEstat() == IncidenciesPeer::ESTAT_RESOLT && is_null($DR) ):
  		$OI->setDataresolucio(date('Y-m-d',time()));
  	endif;
  	
  	$OI->save();
  	
  }

}

<?php

/**
 * Cessiomaterial form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CessiomaterialRetornForm extends sfFormPropel
{
	
 public function setup()
  {
  	
    $this->setWidgets(array(
      'cessio_id'      => new sfWidgetFormInputHidden(),
      'usuari_id'      => new sfWidgetFormInputHidden(),
      'representant'   => new sfWidgetFormInputHidden(),    
      'data_cessio'    => new sfWidgetFormInputHidden(),
      'data_retorn'    => new sfWidgetFormInputHidden(),
      'estat'          => new sfWidgetFormInputHidden(),
      'retornat'       => new sfWidgetFormInputHidden(),
      'data_retornat'  => new sfWidgetFormDate(array('format'=>'%day%/%month%/%year%')),      
      'estat_retornat' => new sfWidgetFormTextareaTinyMCE(),
      
    ));

    $this->setValidators(array(
      'cessio_id'      => new sfValidatorPropelChoice(array('model' => 'Cessio', 'column' => 'cessio_id', 'required' => false)),
      'usuari_id'      => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'representant'   => new sfValidatorString(array(),array()),    
      'data_cessio'    => new sfValidatorDate(array('required'=>false),array()),
      'data_retorn'    => new sfValidatorDate(array('required'=>false),array()),
      'estat'          => new sfValidatorString(array('required'=>false),array()),
      'retornat'       => new sfValidatorInteger(array('required'=>false),array()),
      'estat_retornat' => new sfValidatorString(array('required'=>false),array()),
      'data_retornat'  => new sfValidatorDate(array('required'=>false),array()),
    ));

    $this->widgetSchema->setLabels(array(      
      'usuari_id'      => 'Cedit a',      
      'data_cessio'    => 'Data cessiÃ³',
      'data_retorn'    => 'Data retorn',
      'estat'          => 'Observacions',
      'retornat'       => 'Retornat?',
      'estat_retornat' => 'Observacions',
      'data_retornat'  => 'Data retornat',
    ));
    
    
    $this->widgetSchema->setNameFormat('cessio[%s]');
    $this->widgetSchema->setFormFormatterName('Span');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {
    return 'Cessio';
  }

}

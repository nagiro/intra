<?php

/**
 * Cursos form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CursosCodiForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idCursos'        => new sfWidgetFormInputHidden(),
      'Codi'			=> new sfWidgetFormChoice(array('choices'=>CursosPeer::getCodisOptions($this->getOption('IDS'))),array('style'=>'width:300px')),
      'CodiT'			=> new sfWidgetFormInputText(array(),array('style'=>'width:100px;')),      
    ));
    
    //      'Codi'            => new sfWidgetFormJQueryAutocompleter(array('config'=>'{ max:100 , width:500 }' , 'url'=>$this->getOption('url'))),

    $this->setValidators(array(
      'idCursos'        => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos', 'required' => false)),
      'Codi'            => new sfValidatorString(array('required' => false)),
      'CodiT'           => new sfValidatorString(array('required' => false)),          
    ));

    
    $this->widgetSchema->setLabels(array(      
      'Codi'            => 'Codi existent: ',
      'CodiT'			=> 'Nou codi:',    
    ));
    
    
    $this->widgetSchema->setNameFormat('cursos_codi[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');
    
  }

  public function getModelName()
  {
    return 'Cursos';
  }

}

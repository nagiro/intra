<?php

/**
 * AppDocumentsArxius form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AppDocumentsArxiusForm extends sfFormPropel
{
		
  public function setup()
  {
  	
  	$file_src = sfConfig::get('sf_webroot').sfConfig::get('sf_webappdocuments').$this->getObject()->getUrl();
  	
    $this->setWidgets(array(
      'idDocument'                  => new sfWidgetFormInputHidden(),
      'idDirectori'                 => new sfWidgetFormInputHidden(),
      'url'                         => new sfWidgetFormInputFileEditableMy(array('file_src'=>$file_src,'edit_mode'=>true,'with_delete'=>false)),
      'Nom'                         => new sfWidgetFormInputText(array(),array('style'=>'width:300px')),    
      'DataCreacio'                 => new sfWidgetFormInputHidden(),      
    ));

    $this->setValidators(array(
      'idDocument'                  => new sfValidatorPropelChoice(array('model' => 'AppDocumentsArxius', 'column' => 'idDocument', 'required' => false)),
      'idDirectori'                 => new sfValidatorPropelChoice(array('model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori', 'required' => false)),
      'Nom'                         => new sfValidatorString(),
      'url'                         => new sfValidatorFile(array('path'=>sfConfig::get('sf_websysroot').sfConfig::get('sf_webappdocuments'),'required'=>false,'mime_type_guessers'=>array())),
      'DataCreacio'                 => new sfValidatorDate(),   
    ));

    $this->widgetSchema->setNameFormat('app_documents_arxius[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->widgetSchema->setLabel('Nom','Nom :');
    $this->widgetSchema->setLabel('url','Arxiu: ');
    $this->setDefault('DataCreacio',date('Y-m-d',time()));
        
  }

  public function getModelName()
  {
    return 'AppDocumentsArxius';
  }
  
  public function save($conn = null)
  {
  	
  	$V = $this->getValues();  	  	
  	$OFITXER = $this->getObject();
  	
	$OFITXER->setNom($V['Nom']);
	$OFITXER->setIddocument($V['idDocument']);
	$OFITXER->setIddirectori($V['idDirectori']);
	$OFITXER->setDatacreacio($V['DataCreacio']);
	$OFITXER->save();		
  	
  	$url = sfConfig::get('sf_websysroot').sfConfig::get('sf_webappdocuments');	  	
  	$nomA = $OFITXER->getIddirectori().'-'.$OFITXER->getIddocument();
  	$file = $this->getValue('url');  	
  	if($file instanceof sfValidatedFile):  		
	  	$nomB = $file->getExtension($file->getOriginalExtension());
	  	$nom = $nomA.$nomB;
	    
	  	for($i = 1; file_exists($url.$nom); $i++){
	  		$nom = $nomA.'('.$i.')'.$nomB;		  		
	  	}
	  		  	
  		$file->save($url.$nom);
	  	$OFITXER->setUrl($nom);
	endif;
  	
	$OFITXER->save();
	  	
  }
	
}

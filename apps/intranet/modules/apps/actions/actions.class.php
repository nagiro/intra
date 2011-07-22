<?php

/**
 * apps actions.
 *
 * @package    intranet
 * @subpackage apps
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class appsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
  
  
  public function executeGDocuments(sfWebRequest $request)
  {
  
    $this->IDS  = $this->getUser()->getSessionPar('idS');  	
    $IDU        = $this->getUser()->getSessionPar('idU');
  	$IDD        = $this->getUser()->ParReqSesForm($request , 'IDD' , 1 );
  	$IDA		= $this->getUser()->ParReqSesForm( $request , 'IDA' , null );  	  	  	
  	$accio      = $this->getUser()->ParReqSesForm( $request , 'accio' , 'CD' );
  	$this->MODE = "CONSULTA";
  	
  	if($request->hasParameter('B_SAVE_UPLOAD')) $accio = 'SAVE_UPLOAD';
  	
  	$this->getUser()->setSessionPar('accio',$accio);
  	
  	switch($accio){
  	
  		//Mostrem el diÃ leg d'upload
  		case 'UPLOAD':
                $this->FUPLOAD = AppDocumentsArxiusPeer::initialize($IDA,$IDD,$this->IDS);  				 				  				  				
  				$this->MODE = 'UPLOAD';
  			break;
  		
  		//Guardem un arxiu que hem carregat. 
  		case 'SAVE_UPLOAD':
                $RP = $request->getParameter('app_documents_arxius');
                $this->FUPLOAD = AppDocumentsArxiusPeer::initialize($IDA,0,$this->IDS);                
  				$this->FUPLOAD->bind($RP,$request->getFiles('app_documents_arxius'));  				
  				if($this->FUPLOAD->isValid()): 
  					$this->FUPLOAD->save();  					  				  				
  					$this->redirect('apps/gDocuments?accio=CD');
  				endif; 				  			
  				$this->MODE = 'UPLOAD';
  			break;
  			
  		//Esborrem un arxiu guardat prÃ¨viament 
  		case 'DELETE':
                $this->FUPLOAD = AppDocumentsArxiusPeer::initialize($IDA,0,$this->IDS)->setInactiu();  				  				
  				$this->redirect('apps/gDocuments?accio=CD'); 	  				  				  								  		  				
  			break;
  			
  		//Fem un canvi de directori o tornem a una pantalla anterior i inicialitzem
  		case 'CD':  				
  				$this->getUser()->setAttribute('IDA',null);
  			break;
  	}
  	
  	$this->ACTUAL = AppDocumentsDirectorisPeer::initialize($IDD,$this->IDS)->getObject();			  	  	
	$this->getUser()->setAttribute('IDD',1);			  		
  	
  	$this->DIRECTORIS = AppDocumentsDirectorisPeer::getDirectoris($IDU,$this->IDS);
  	$this->PERMISOS_AL_DIR = AppDocumentsPermisosDirPeer::getPermis($IDU,$IDD,$this->IDS);
  	  	  
  	$this->setLayout('gestio_apps');
  	
  }
  
}

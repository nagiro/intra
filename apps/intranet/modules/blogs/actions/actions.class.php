<?php

/**
 * blogs actions.
 *
 * @package    intranet
 * @subpackage blogs
 * @author     Albert Joh� i Mart�
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class blogsActions extends sfActions
{
	
	public function executeNoticiesCulturalsLastPosts()
	{
      $this->IDS = 1;       
	  $feed = new sfAtom1Feed();
	
	  $feed->setTitle('Notícies Culturals de Girona');
	  $feed->setLink('http://www.casadecultura.org/noticiesculturals');
	  $feed->setAuthorEmail('giroscopi@casadecultura.org');
	  $feed->setAuthorName('Giroscopi || Casa de Cultura de Girona');
	
	  $feedImage = new sfFeedImage();
	  $feedImage->setFavicon('http://www.casadecultura.cat/images/blogs/Dissenys/noticies_culturals/blog_02.png');
	  $feed->setImage($feedImage);
	
	  $C = new Criteria();
      $C = AppBlogsEntriesPeer::getCriteriaActiu($C,$this->IDS);
      
	  $C->add(AppBlogsEntriesPeer::PAGE_ID, 1);
	  $C->addDescendingOrderByColumn(AppBlogsEntriesPeer::ID);
	  $Q = AppBlogsEntriesPeer::doSelect($C);
  	  $WEBROOTURL = OptionsPeer::getString('SF_WEBROOTURL',$this->IDS);
    
	  foreach ($Q as $post)
	  {
	    $item = new sfFeedItem();
	    $item->setTitle($post->getTitle());
	    $item->setLink($WEBROOTURL.'noticiesculturals?NOTICIA_ID='.$post->getId());
	    $item->setAuthorName('Giroscopi');
	    $item->setAuthorEmail('giroscopi@casadecultura.org');	    
	    $IMG = $post->getImages();
	    if(!$IMG):
	    	$url = "";	    	
	    else: 
	    	$url = '<img width="100px" src="'.$WEBROOTURL.'images/blogs/'.$IMG[0]->getUrl().'">';
	    endif; 
	    
	    $url_web = $WEBROOTURL.'noticiesculturals?NOTICIA_ID='.$post->getId();
        $item->setUniqueId($url_web);
	    
	    $TEXT = "	
	    		 <table border=\"0\"><tr><td>$url</td><td>	    		 
		             <h1>{$post->getTitle()}</h1><br />
		             <h2>{$post->getSubtitle1()}</h2><br />
		             <h3>{$post->getSubtitle2()}</h3><br />
		             <a href=\"{$post->getUrl()}\">Web</a><br />
		             <a href=\"{$url_web}\">Notícia original</a>
		         </td></tr></table>	             
	             ";	    
	             
	    $item->setContent($TEXT);
	
	    $feed->addItem($item);
	  }
	
	  $this->feed = $feed;
	  $this->setLayout('blank');
	  $this->setTemplate('RSS');
	}		
	
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeNoticiesculturals(sfWebRequest $request)
  {
    
  	$this->IDS = 1;
  	$this->PAGE_ID_QUE_ESTA_PASSANT = 1;
  	$this->PAGE_ID_QUE_PASSARA = 2;
  	$this->PAGE_ID_QUE_HA_PASSAT = 3;
  	$this->FORM_ID = 2;   	
  	$this->BLOG_ID = 4;
  	
  	$this->setLayout('blank');
  	$this->PAGE_ID = $this->ParReqSesForm($request,'PAGE_ID',$this->PAGE_ID_QUE_ESTA_PASSANT);
  	$this->NOTICIA_ID = $this->ParReqSesForm($request,'NOTICIA_ID',-1);
  	$this->PAGINA = $request->getParameter('PAGINA',1);
  	$this->MODE = $this->ParReqSesForm($request,'MODE','CONTINGUT');    
  	$this->ERRORS = "";
  	
  	if($this->MODE == 'CONTINGUT' && $request->hasParameter('NOTICIA_ID')):
  	
  		$this->NOTICIA = AppBlogsEntriesPeer::retrieveByPK($request->getParameter('NOTICIA_ID'));
  		$this->MODE = 'CONTINGUT'; 
  		
	elseif($this->MODE == 'CONTINGUT'):
	  	$order = ($this->PAGE_ID == $this->PAGE_ID_QUE_HA_PASSAT)?false:true;
  		$this->NOTICIES = AppBlogsEntriesPeer::getEntries( $this->PAGE_ID , $this->PAGINA , $order , $this->IDS );
  		$this->MODE = 'CONTINGUT';
  		 
  	elseif( $this->MODE == 'FORM1' ):  						
  				  		
  		$this->FORM1 = array(	'nom_entitat' => '',
  								'nom_cognoms' => '',
  								'lloc_ocupa'  => '',
  								'nom_cognoms_contacte' => '',
  								'adreca' => '',
  								'codi_postal' => '',
  								'municipi' => '',
  								'comarca' => '',
  								'telefons' => '',
  								'email' => '',
  						);  		
  						  		  	
  	elseif( $this->MODE == 'FORM2' ):
  	  	
  		$this->DADES = $request->getParameter('dades');
  		
		$this->getUser()->setAttribute('dades',$this->DADES);	  		  		
  	
		$this->FORM2 = array(	'titol' => '',
  								'subtitol1' => '',
  								'ciutat_acte'  => '',
								'dia_acte'  => '',
  								'web' => '',
  								'imatge' => '',
  								'tipus' => '',
  								'resum' => '',  								
  						);
  	
  	elseif( $this->MODE == 'ENVIA_FINALITZA' ):
  	
		if(!$this->getUser()->hasAttribute('dades')) $this->redirect('@noticies_culturals?MODE=FORM1');
		
		$this->getUser()->setAttribute('dades2',$request->getParameter('dades'));		
  		$this->DADES = $this->getUser()->getAttribute('dades');
  		$this->DADES2 = $this->getUser()->getAttribute('dades2');
		
		foreach($this->DADES2 as $K => $E):		
			$this->DADES[$K] = $E;
		endforeach;

	  	AppBlogsFormsPeer::save( $this->FORM_ID , $this->DADES , $request->getFiles() , $this->IDS );
	  	
	  	$this->MODE = 'FORM_OK';
	  	
	elseif( $this->MODE == 'ACTUALITZA' ):
	
		$next_two_month = date('Y-m-d',mktime(0,0,0,date('m',time())+2,date('d',time()),date('Y',time())));
		$next_month = date('Y-m-d',mktime(0,0,0,date('m',time())+1,date('d',time()),date('Y',time())));	  		
		$today = date('Y-m-d',time());
		$previous_month = date('Y-m-d',mktime(0,0,0,date('m',time())-1,date('d',time()),date('Y',time())));
		$previous_two_month = date('Y-m-d',mktime(0,0,0,date('m',time())-2,date('d',time()),date('Y',time())));
		
	  	//Captem els que s'han de migrar del formulari
	  	$C = new Criteria();
        $C = AppBlogsFormsEntriesPeer::getCriteriaActiu($C,$this->IDS);
        
	  	$C->add(AppBlogsFormsEntriesPeer::FORM_ID, $this->FORM_ID);
	  	$C->add(AppBlogsFormsEntriesPeer::ESTAT, AppBlogsFormsEntriesPeer::ESTAT_TRACTAT_MIGRAT_WAIT);
	  	
	  	//Treballem i migrem els camps que hem marcat com "Per publicar"
	  	foreach(AppBlogsFormsEntriesPeer::doSelect($C) as $OO):
	  		$RET = array();
	  		foreach( explode("@@@",$OO->getDades()) as $E ):
	  			$EX = explode("###",$E);
	  			if(isset($EX[0]) && isset($EX[1])):
					list($EXCAMP,$TEXT) = explode("###",$E);
					$RET[$EX[0]] = $EX[1];
				endif; 	
	  		endforeach;
	  		
	  		try{
	  	
                $ON = AppBlogsEntriesPeer::initialize(0,'CA',1,1,$this->IDS)->getObject();          				  				  		
		  		$ON->setTitle($RET['titol']);
		  		$ON->setSubtitle1($RET['subtitol1']);
		  		$ON->setSubtitle2($RET['ciutat_acte'].', '.$this->dataText($RET['dia_acte']));
		  		$ON->setBody($RET['text']);
		  		$ON->setTags($RET['tipus']);
		  		echo stripos($RET['web'],'http://');
		  		if(!stripos($RET['web'],'http://')) $ON->setUrl('http://'.$RET['web']);
		  		else $ON->setUrl($RET['web']);	  		
		  		$ON->setDate($RET['dia_acte']);
		  			  		
		  		$dia = $RET['dia_acte'];
		  		
				if($dia >= $today && $dia < $next_month):
		  			$ON->setPageId($this->PAGE_ID_QUE_ESTA_PASSANT);	  			
				elseif($dia < $today):
					$ON->setPageId($this->PAGE_ID_QUE_HA_PASSAT);
				elseif($dia > $next_month):
					$ON->setPageId($this->PAGE_ID_QUE_PASSARA);
				endif; 			
		  		
				$ON->save(); //Guardem la notícia                					  		
			
			//Guardem les imatges
			if(isset($RET['file'])):
                
                $WEBSYSROOT = OptionsPeer::getString('SF_WEBSYSROOT',$this->IDS);
                
				//Mirem l'extensió de l'arxiu
    			$path_info = pathinfo($WEBSYSROOT.'uploads/formularis/'.$RET['file']);    			    			    			    		
    			
    			//Si l'arxiu és una imatge, el tractem i el posem com a imatge
    			if(strtolower($path_info['extension']) == 'jpg' || strtolower($path_info['extension']) == 'png'): 			
			
    				try{
    					
						$img = new sfImage($WEBSYSROOT.'uploads/formularis/'.$RET['file'],'image/jpeg');
						$img->resize(200,null);				
						$img->saveAs($WEBSYSROOT.'images/blogs/'.$RET['file']);
							
						$OM = AppBlogsMultimediaPeer::initialize(0,$this->IDS)->getObject();
						$OM->setName($RET['file']);
						$OM->setUrl($RET['file']);												
						$OM->save();
                        
                        echo 'ONID:'.$ON->getId();                        
						$OME = AppBlogMultimediaEntriesPeer::initialize($ON->getId(),$OM->getId(),$this->IDS)->getObject()->save();                        						
						
    				} catch(Exception $e){ echo 'hail'; echo $e->getMessage(); echo $e->getCode(); }
    				
				endif;
								
			endif; 
						
			$OO->setEstat(AppBlogsFormsEntriesPeer::ESTAT_TRACTAT_MIGRAT);
			$OO->save();
			
	  		} catch(Exception $e){ echo 'fiodaf'; echo $e->getMessage(); echo $e->getCode(); }
			
  		endforeach;  		
  		  		
  		/**
  		 * Captem els valors que han estat marcats com "Per arxivar" i els passem a "arxivats"
  		 */
  		
	  	$C = new Criteria();
        $C = AppBlogsEntriesPeer::getCriteriaActiu($C,$this->IDS);        
	  	$C->add(AppBlogsFormsEntriesPeer::FORM_ID, $this->FORM_ID);
	  	$C->add(AppBlogsFormsEntriesPeer::ESTAT, AppBlogsFormsEntriesPeer::ESTAT_TRACTAT_EMMAGATZEMAT_WAIT);

	  	foreach(AppBlogsFormsEntriesPeer::doSelect($C) as $OO):
	  		$OO->setEstat(AppBlogsFormsEntriesPeer::ESTAT_TRACTAT_EMMAGATZEMAT);
	  		$OO->save();
	  	endforeach;
	  	
	  	
	  	/**
	  	 * Procès de canvi de lloc les notícies que ja han passat a una altra pàgina
	  	 */
	  	
	  	//Captem les notícies que han de canviar de pàgina... (Actual->Passades)
	  	$C = new Criteria();
        $C = AppBlogsEntriesPeer::getCriteriaActiu($C,$this->IDS);
        
	  	$C->add(AppBlogsEntriesPeer::PAGE_ID,  $this->PAGE_ID_QUE_ESTA_PASSANT);	  	
	  	$C->add(AppBlogsEntriesPeer::DATE, $today, CRITERIA::LESS_THAN); 	  		  	
	  	
	  	foreach(AppBlogsEntriesPeer::doSelect($C) as $OO):
	  		$OO->setPageid($this->PAGE_ID_QUE_HA_PASSAT);
	  		$OO->save();
  		endforeach;
  		
	  	//Captem les notícies que han de canviar de pàgina... (Futures->actual)
	  	$C = new Criteria();
        $C = AppBlogsEntriesPeer::getCriteriaActiu($C,$this->IDS);
        
	  	$C->add(AppBlogsEntriesPeer::PAGE_ID,  $this->PAGE_ID_QUE_PASSARA);	  	
	  	$C->add(AppBlogsEntriesPeer::DATE, $today, CRITERIA::GREATER_THAN); 	  	
	  	$C->add(AppBlogsEntriesPeer::DATE, $next_month, CRITERIA::LESS_THAN); 
	  	
	  	foreach(AppBlogsEntriesPeer::doSelect($C) as $OO):
	  		$OO->setPageid($this->PAGE_ID_QUE_ESTA_PASSANT);
	  		$OO->save();
  		endforeach;
  		
//  		$this->redirect('blogs/noticiesculturals?MODE=CONTINGUT&PAGE_ID='.$this->PAGE_ID_QUE_ESTA_PASSANT);
  		
  	endif; 
  	
  }
  

  public function dataText($data)
  {
  	echo $data;
  	list($any,$mes,$dia) = explode("-",$data);
  	$RET = $dia;
  	
  	switch($mes){
  		case '1' : $RET .= ' de gener de '; break;
  		case '2' : $RET .= ' de febrer de '; break;
  		case '3' : $RET .= ' de març de '; break;
  		case '4' : $RET .= ' d\'abril de '; break;
  		case '5' : $RET .= ' de maig de '; break;
  		case '6' : $RET .= ' de juny de '; break;
  		case '7' : $RET .= ' de juliol de '; break;
  		case '8' : $RET .= ' de agost de '; break;
  		case '9' : $RET .= ' de setembre de '; break;
  		case '10': $RET .= ' d\'octubre de '; break;
  		case '11': $RET .= ' de novembre de '; break;
  		case '12': $RET .= ' de desembre de '; break;
  	}
  	
  	return $RET.$any;
  	
  }
/*  
  public function executeBiennal(sfWebRequest $request)
  {
  	
  	$this->setLayout('blank');
  	$this->DADES = array('nom'=>'','cognoms'=>'','domicili'=>'','numero'=>'','codi_postal'=>'','localitat'=>'','telefon'=>'','qreu'=>'');
  	$this->ENVIAT = false;
  	$this->FORM_ID = 1;  //Aquest formulari és el número 1 quan es va entrar :D
  	
  	if(!$request->hasParameter('ESTAT')) $this->ESTAT = 'INICI';  	
  	else $this->ESTAT = $request->getParameter('ESTAT');
  	  	  	   
  	 
  	if($request->hasParameter('dades')):
    	
  		$this->DADES = $request->getParameter('dades');  		  		  		
  		if($this->DADES['resultat'] == ($this->getUser()->getAttribute('VAL1')+$this->getUser()->getAttribute('VAL2'))):
  			$correcte = AppBlogsFormsPeer::save($this->FORM_ID,$request->getParameter('dades'),$request->getFiles());
	  		if($correcte): 
	  			$this->MISSATGE = array('TEXT' => "Formulari enviat correctament",'OK'=>true);
	  			$this->ENVIAT = true;
	  		else: 
	  			$this->MISSATGE = array('TEXT'=>"Hi ha hagut algun problema guardant...",'OK'=>false);
	  		endif;
  		else: 
	  		$this->MISSATGE = array('TEXT'=>"La suma no és correcta",'OK'=>false);
	  	endif;   		
  	endif;
  	
  	$this->getUser()->setAttribute('VAL1',rand(0,9));
  	$this->getUser()->setAttribute('VAL2',rand(0,9));
  	$this->VAL1 = $this->getUser()->getAttribute('VAL1');
  	$this->VAL2 = $this->getUser()->getAttribute('VAL2');
  	
  }
*/
/*  
  public function executeRSS(sfWebRequest $request)
  {
  	
	$PAGE_ID = AppBlogsPagesPeer::retrieveByPK($request->getParameter('PAGE_ID'));
	$URL = sfConfig::get('sf_webrooturl').'blogs/'.$request->getParameter('URL');
	if($PAGE_ID instanceof AppBlogsPages && !empty($URL)):

		$feed = new sfAtom1Feed();
		$feed->setTitle($PAGE_ID->getName());
		$feed->setLink($URL);
		$feed->setAuthorEmail('informatica@casadecultura.org');
		$feed->setAuthorName('Casa de Cultura de Girona');
		
//		$feedImage = new sfFeedImage();
//		$feedImage->setFavicon('http://www.myblog.com/favicon.ico');
//		$feed->setImage($feedImage);
		
		$c = new Criteria;
		$c->addDescendingOrderByColumn(AppBlogsEntriesPeer::DATE);
		$c->add(AppBlogsEntriesPeer::PAGE_ID, $PAGE_ID->getId());
		$c->setLimit(5);
		$posts = AppBlogsEntriesPeer::doSelect($c);
		
		foreach ($posts as $post)
		{
		
		  $data = mktime(	$post->getDate('H'),
		  					$post->getDate('i'),
		  					$post->getDate('s'),
		  					$post->getDate('m'),
		  					$post->getDate('d'),
		  					$post->getDate('Y'));
		  					
		  $R = $post->getImages();
		  if($R) $text = '<img src="'.sfConfig::get('sf_webrooturl').'images/blogs/'.$R[0]->getUrl().'" align="LEFT">';
		  else $text = "";
			
		  $item = new sfFeedItem();
		  $item->setTitle($post->getTitle());		  
		  $item->setLink($URL.'?NOTICIA_ID='.$post->getId());
		  $item->setAuthorName('Casa de Cultura de Girona');
		  $item->setAuthorEmail('giroscopi@casadecultura.org');
		  $item->setPubdate($data);
		  $item->setUniqueId($post->getId());
		  $text .= '('.$post->getSubtitle1().') - ';
		  $text .= '('.$post->getSubtitle2().') || ';
		  $text .= $post->getBody();
		  		  
		  $item->setDescription($text);
		  		  
		  $feed->addItem($item);
		  
		 }
		
		$this->feed = $feed;  	
		
	endif; 
  }
  
*/  
  

  //Guardem els valors de l'array amb Default[$K]=>$V --> $NOM.$K
  //Exemple: $this->ParReqSesForm($request,'cerca',array('text'=>""));
  public function ParReqSesForm(sfWebRequest $request, $nomCamp, $default = "") 
  {
  	  	
  	$RET = ""; 	    	
  	
  	if(is_array($default)):
  	
	  	//Si existeix el paràmetre carreguem el nom actual
	  	if($request->hasParameter($nomCamp)):
	  	
	  		$CAMP = $request->getParameter($nomCamp);
	  		
	  		//Mirem els elements del formulari i els guardem a la sessió  		  		
	  		foreach( $CAMP as $NOM => $VALOR ):
	  			$this->getUser()->setAttribute($nomCamp.$NOM,$VALOR);  				
	  		endforeach;  				  		  		 
	  		
	  		$RET = $CAMP;  		
	  
	  	//Si no existeix el paràmetre mirem si ja el tenim a la sessió
	  	elseif($this->existeixAtributArray($nomCamp,$default)):
	  		$RET = array();
	  		foreach($default as $NOM => $VALOR):
	  			$RET[$NOM] = $this->getUser()->getAttribute($nomCamp.$NOM);
	  		endforeach;
	  		
	  	//Si no el tenim a la sessió i tampoc l'hem passat per paràmetre carreguem el valor per defecte. 
	  	else: 
	  	
	  		foreach($default as $NOM => $VALOR):
	  			$this->getUser()->setAttribute($NOM.$nomCamp, $default);
	  		endforeach;
	  		
	  		$RET = $default;
	  		
	  	endif;
	  	
	else:
		
		//Si existeix el paràmetre carreguem el nom actual
	  	if($request->hasParameter($nomCamp)):
	  	
	  		$CAMP = $request->getParameter($nomCamp);	  		
	  		$this->getUser()->setAttribute($nomCamp,$CAMP);  					  		  				  		  		 	  		
	  		$RET = $CAMP;  		
	  
	  	//Si no existeix el paràmetre mirem si ja el tenim a la sessió
	  	elseif($this->getUser()->hasAttribute($nomCamp)):
	  		
	  		$RET = $this->getUser()->getAttribute($nomCamp);
	  			  		
	  	//Si no el tenim a la sessió i tampoc l'hem passat per paràmetre carreguem el valor per defecte. 
	  	else:
	  	 	  		  		
	  		$this->getUser()->setAttribute($nomCamp, $default);	  			  	
	  		$RET = $default;
	  		
	  	endif;
	
	endif;
  	
  	return $RET;
  }
    
}

<?php

class AppBlogsFormsPeer extends BaseAppBlogsFormsPeer
{
	
    static public function getCriteriaActiu( $C , $idS )
    {
        $C->add(self::ACTIU, true);
        $C->add(self::SITE_ID, $idS);
        return $C;
    }
        
  	static public function initialize( $idF , $idS )
	{	   
		$OO = AppBlogsFormsPeer::retrieveByPK($idF);            
		if(!($OO instanceof AppBlogsForms)):            			
			$OO = new AppBlogsForms();			
            $OO->setSiteId($idS);        
            $OO->setActiu(true);        						
		endif; 
        
        return new AppBlogsFormsForm($OO,array('IDS'=>$idS));
                
	}        
    
    
	static public function getOptionsForms( $blog_id , $form_id , $idS )
	{

		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
        
		$C->add(self::BLOG_ID, $blog_id);
						
		$Q = self::doSelect($C);				
		$RET = '<option value="-1">('.sizeof($Q).') Escull un formulari...</option>';
		foreach($Q as $OO):
			$SEL = ($OO->getId() == $form_id)?'SELECTED':'';
			$RET .= '<option '.$SEL.' value="'.$OO->getId().'">'.$OO->getName().'</option>';			
		endforeach;
		
		return $RET;		
		
	}
	
	static public function save( $form_id , $dades , $arxius , $idS )
	{
		
		try{			
            //Creem una nova entrada al formulari
			$OO2 = AppBlogsFormsEntriesPeer::initialize( 0 , $idS , $form_id )->getObject();
            $OO2->save();	  			  			  		
	  	  		
	  		//Passem totes les dades a un array
            $RET = array();
	  		foreach($dades as $K=>$V) $RET[$K] = $V;
	  		
            //Si hi ha arxius, els guardem.
	  		if(isset($arxius['arxius'])):
    	  		foreach($arxius['arxius'] as $K=>$V):  		
    	  			if($V['error'] == 0):
    	  				$file_ext = substr($V['name'], strripos($V['name'], '.'));
    	  				$file_name = $OO2->getId().'-'.$K.$file_ext;
    	  				$url = OptionsPeer::getString('SF_WEBSYSROOT',$idS).'uploads/formularis/'.$file_name;
    	  				move_uploaded_file($V['tmp_name'], $url);	  				 
    	  				$RET['file'][] = $file_name;
    	  			endif;     	  		
    	  		endforeach;
	  		endif;
	  		
            //Guardem els camps del formulari en el format de formulari
	  		$SOL = "@@@";
	  		foreach($RET as $K=>$V):
				
	  			if($K == 'file'):
	  				foreach($V as $V2):
	  					$SOL .= 'file###'.$V2.'@@@';
	  				endforeach;
	  			else:	
	  				$SOL .= $K."###".$V.'@@@';
	  			endif;
	  				
	  		endforeach;	  						  			  						
	  		$OO2->setDades($SOL);
	  		$OO2->save();
	  		
		} catch(Exception $e){ mail('informatica@casadecultura.org','Error Formulari Noticies culturals',$form_id.$e->getMessage().serialize($SOL)); return false; }
				
		return true;		
	}
	
	static public function getForms( $blog_id , $num , $idS )
	{
		$C = new Criteria();
        $C = self::getCriteriaActiu($C,$idS);
		$C->add(self::BLOG_ID,$blog_id);
		$OO = self::doSelect($C);
		if($OO instanceof AppBlogsForms):
			if(isset($OO[$num])) return $num;
			else return new AppBlogsForms();
		else: 
			return new AppBlogsForms();  
		endif;
		 
		return self::doSelect($C);
	}
	
	
}

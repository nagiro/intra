<?php

/**
 * Subclass for representing a row from the 'cursos' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Cursos extends BaseCursos
{
  /**
   * Retorna el nombre de matriculats que hi ha a un curs
   *
   * @return INT
   */
  public function countMatriculats($idS)
  {  
     $C = new Criteria();
     $C = MatriculesPeer::getCriteriaActiu($C,$idS); 
     $C->addOr(MatriculesPeer::ESTAT , MatriculesPeer::ACCEPTAT_NO_PAGAT );
     $C->addOr(MatriculesPeer::ESTAT , MatriculesPeer::ACCEPTAT_PAGAT );
     return self::countMatriculess($C);          
  }
  
  public function getMatriculats()
  {
     $C = new Criteria(); 
     $C->addAscendingOrderByColumn(MatriculesPeer::ESTAT);
     return self::getMatriculess($C);
  }
  
  public function getCategoriaText()
  {  	
  	return TipusPeer::retrieveByPk($this->getCategoria())->getTipusDesc();
  }
  
  public function countMatriculesActives($idS)
  {
     $C = new Criteria();
     $C = MatriculesPeer::getCriteriaActiu($C,$idS);          
     $C1 = $C->getNewCriterion(MatriculesPeer::ESTAT, MatriculesPeer::ACCEPTAT_NO_PAGAT );
     $C2 = $C->getNewCriterion(MatriculesPeer::ESTAT , MatriculesPeer::ACCEPTAT_PAGAT );
     $C1->addOr($C2); $C->add($C1);
     $C->add(MatriculesPeer::CURSOS_IDCURSOS, $this->getIdcursos());     
     return MatriculesPeer::doCount($C);
  }
 
  public function isPle()
  {
    $RS = $this->getPlacesArray();
    if($RS['OCUPADES'] < $RS['TOTAL']) return true;
    else return false;    
  }
 
  public function getPlacesArray()
  {
    return CursosPeer::getPlaces($this->getIdcursos(),$this->getSiteId());
  }
  
  public function CalculaPreu($DESCOMPTE)
  {
    return CursosPeer::CalculaPreu($this->getIdcursos(), $DESCOMPTE, $this->getSiteId());
  }
    
  public function getActivitatVinculada()
  {
    $IDA = $this->getActivitatid();    
    $OA = ActivitatsPeer::initialize($IDA,0,$this->getSiteId())->getObject();    
    if($OA->isNew()):
        $OA->setNom($this->getTitolcurs());
        $OA->setCiclesCicleid(null);
        $OA->setTipusactivitatIdtipusactivitat(TipusactivitatPeer::T_CURS);        
        $OA->setPreu($this->getPreu());
        $OA->setPreureduit($this->getPreur());
        $OA->setPublicable(true);
        $OA->setEstat(ActivitatsPeer::ESTAT_ACTIVITAT_ACCEPTADA);        
        $OA->save();
        $this->setActivitatid($OA->getActivitatid());
        $this->save();
    endif;         
    return $OA;
  }
 
  public function getNomSite()
  {    
    return SitesPeer::getNom($this->getSiteId());
  } 
 
  public function getNomForUrl()
  {
    $nom = $this->getTitolcurs();
    return myUser::text2url($nom);        
  } 
    
}

<?php


/**
 * This class defines the structure of the 'sites' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 09/05/11 11:03:13
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class SitesTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.SitesTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('sites');
		$this->setPhpName('Sites');
		$this->setClassname('Sites');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('SITE_ID', 'SiteId', 'TINYINT', true, 4, null);
		$this->addColumn('NOM', 'Nom', 'LONGVARCHAR', true, null, null);
		$this->addColumn('ACTIU', 'Actiu', 'TINYINT', true, 1, 1);
		$this->addColumn('POBLE', 'Poble', 'INTEGER', false, 11, null);
		$this->addColumn('LOGOURL', 'Logourl', 'VARCHAR', false, 255, null);
		$this->addColumn('WEBURL', 'Weburl', 'VARCHAR', false, 255, null);
		$this->addColumn('TELEFON', 'Telefon', 'VARCHAR', false, 30, null);
		$this->addColumn('EMAIL', 'Email', 'VARCHAR', false, 50, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('UsuarisSites', 'UsuarisSites', RelationMap::ONE_TO_MANY, array('site_id' => 'site_id', ), 'CASCADE', 'CASCADE');
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // SitesTableMap

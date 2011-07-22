<?php


/**
 * This class adds structure of 'arxiu_dvd' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 04/07/10 12:22:44
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ArxiuDvdMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ArxiuDvdMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(ArxiuDvdPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ArxiuDvdPeer::TABLE_NAME);
		$tMap->setPhpName('ArxiuDvd');
		$tMap->setClassname('ArxiuDvd');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('TIPUS', 'Tipus', 'VARCHAR', true, 30);

		$tMap->addColumn('VOLUM', 'Volum', 'VARCHAR', false, 30);

		$tMap->addColumn('URL', 'Url', 'LONGVARCHAR', false, null);

		$tMap->addColumn('NOM', 'Nom', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DATA_CREACIO', 'DataCreacio', 'TIMESTAMP', false, null);

		$tMap->addColumn('COMENTARI', 'Comentari', 'LONGVARCHAR', false, null);

	} // doBuild()

} // ArxiuDvdMapBuilder

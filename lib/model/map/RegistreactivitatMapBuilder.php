<?php


/**
 * This class adds structure of 'registreactivitat' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 04/07/10 12:22:46
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class RegistreactivitatMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.RegistreactivitatMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(RegistreactivitatPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(RegistreactivitatPeer::TABLE_NAME);
		$tMap->setPhpName('Registreactivitat');
		$tMap->setClassname('Registreactivitat');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('LOGID', 'Logid', 'INTEGER', true, 11);

		$tMap->addColumn('TIMESTAMP', 'Timestamp', 'TIMESTAMP', false, null);

		$tMap->addColumn('ACCIO', 'Accio', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DADES', 'Dades', 'LONGVARCHAR', false, null);

		$tMap->addColumn('IDUSUARI', 'Idusuari', 'INTEGER', false, 11);

		$tMap->addColumn('TAULA', 'Taula', 'LONGVARCHAR', false, null);

	} // doBuild()

} // RegistreactivitatMapBuilder

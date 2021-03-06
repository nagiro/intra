<?php


/**
 * This class adds structure of 'descripcions' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Jan 28 12:46:13 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class DescripcionsMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.DescripcionsMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(DescripcionsPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(DescripcionsPeer::TABLE_NAME);
		$tMap->setPhpName('Descripcions');
		$tMap->setClassname('Descripcions');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('IDDESCRIPCIONS', 'Iddescripcions', 'INTEGER', true, 11);

		$tMap->addForeignKey('ACTIVITATS_ACTIVITATID', 'ActivitatsActivitatid', 'INTEGER', 'activitats', 'ACTIVITATID', true, 11);

		$tMap->addColumn('DESCRIPCIO', 'Descripcio', 'LONGVARCHAR', false, null);

		$tMap->addColumn('TIPUS', 'Tipus', 'CHAR', false, 1);

		$tMap->addColumn('ACTIVA', 'Activa', 'TINYINT', false, 4);

		$tMap->addColumn('IMATGE', 'Imatge', 'LONGVARCHAR', false, null);

		$tMap->addColumn('PDF', 'Pdf', 'LONGVARCHAR', false, null);

		$tMap->addColumn('PUBLICAWEB', 'Publicaweb', 'TINYINT', true, 1);

		$tMap->addColumn('TCURT', 'Tcurt', 'LONGVARCHAR', true, null);

		$tMap->addColumn('DCURT', 'Dcurt', 'LONGVARCHAR', true, null);

		$tMap->addColumn('TMIG', 'Tmig', 'LONGVARCHAR', true, null);

		$tMap->addColumn('DMIG', 'Dmig', 'LONGVARCHAR', true, null);

		$tMap->addColumn('TCOMPLET', 'Tcomplet', 'LONGVARCHAR', true, null);

		$tMap->addColumn('DCOMPLET', 'Dcomplet', 'LONGVARCHAR', true, null);

		$tMap->addColumn('TIPUSENVIAMENT', 'Tipusenviament', 'TINYINT', true, 4);

	} // doBuild()

} // DescripcionsMapBuilder

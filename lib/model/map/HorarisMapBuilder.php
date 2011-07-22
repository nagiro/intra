<?php


/**
 * This class adds structure of 'horaris' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 04/07/10 12:22:45
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class HorarisMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.HorarisMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(HorarisPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(HorarisPeer::TABLE_NAME);
		$tMap->setPhpName('Horaris');
		$tMap->setClassname('Horaris');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('HORARISID', 'Horarisid', 'INTEGER', true, 11);

		$tMap->addForeignKey('ACTIVITATS_ACTIVITATID', 'ActivitatsActivitatid', 'INTEGER', 'activitats', 'ACTIVITATID', true, 11);

		$tMap->addColumn('DIA', 'Dia', 'DATE', false, null);

		$tMap->addColumn('HORAINICI', 'Horainici', 'TIME', false, null);

		$tMap->addColumn('HORAFI', 'Horafi', 'TIME', false, null);

		$tMap->addColumn('HORAPRE', 'Horapre', 'TIME', false, null);

		$tMap->addColumn('HORAPOST', 'Horapost', 'TIME', false, null);

		$tMap->addColumn('AVIS', 'Avis', 'LONGVARCHAR', true, null);

		$tMap->addColumn('ESPECTADORS', 'Espectadors', 'INTEGER', true, 11);

		$tMap->addColumn('PLACES', 'Places', 'INTEGER', true, 11);

		$tMap->addColumn('TITOL', 'Titol', 'VARCHAR', true, 255);

		$tMap->addColumn('PREU', 'Preu', 'DOUBLE', true, null);

		$tMap->addColumn('PREUR', 'Preur', 'FLOAT', true, null);

		$tMap->addColumn('ESTAT', 'Estat', 'TINYINT', true, 1);

	} // doBuild()

} // HorarisMapBuilder

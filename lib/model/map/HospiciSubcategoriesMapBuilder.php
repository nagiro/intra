<?php


/**
 * This class adds structure of 'hospici_subcategories' table to 'propel' DatabaseMap object.
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
class HospiciSubcategoriesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.HospiciSubcategoriesMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(HospiciSubcategoriesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(HospiciSubcategoriesPeer::TABLE_NAME);
		$tMap->setPhpName('HospiciSubcategories');
		$tMap->setClassname('HospiciSubcategories');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('SUBCATEGORIA_ID', 'SubcategoriaId', 'INTEGER', true, 11);

		$tMap->addColumn('CATEGORIA_ID', 'CategoriaId', 'INTEGER', true, 11);

		$tMap->addColumn('NOM', 'Nom', 'LONGVARCHAR', true, null);

	} // doBuild()

} // HospiciSubcategoriesMapBuilder

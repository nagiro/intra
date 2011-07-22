<?php


/**
 * This class adds structure of 'app_blogs_forms_entries' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 04/07/10 12:22:43
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AppBlogsFormsEntriesMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AppBlogsFormsEntriesMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(AppBlogsFormsEntriesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AppBlogsFormsEntriesPeer::TABLE_NAME);
		$tMap->setPhpName('AppBlogsFormsEntries');
		$tMap->setClassname('AppBlogsFormsEntries');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11);

		$tMap->addColumn('DADES', 'Dades', 'LONGVARCHAR', true, null);

		$tMap->addColumn('DATE', 'Date', 'TIMESTAMP', true, null);

		$tMap->addForeignKey('FORM_ID', 'FormId', 'INTEGER', 'app_blogs_forms', 'ID', true, 11);

		$tMap->addColumn('ESTAT', 'Estat', 'TINYINT', true, 2);

		$tMap->addColumn('OBJECCIONS', 'Objeccions', 'LONGVARCHAR', true, null);

	} // doBuild()

} // AppBlogsFormsEntriesMapBuilder
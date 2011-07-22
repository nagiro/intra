<?php

/**
 * Usuaris filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseUsuarisFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nivells_idNivells'               => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
      'DNI'                             => new sfWidgetFormFilterInput(),
      'Passwd'                          => new sfWidgetFormFilterInput(),
      'Nom'                             => new sfWidgetFormFilterInput(),
      'Cog1'                            => new sfWidgetFormFilterInput(),
      'Cog2'                            => new sfWidgetFormFilterInput(),
      'Email'                           => new sfWidgetFormFilterInput(),
      'Adreca'                          => new sfWidgetFormFilterInput(),
      'CodiPostal'                      => new sfWidgetFormFilterInput(),
      'Poblacio'                        => new sfWidgetFormPropelChoice(array('model' => 'Poblacions', 'add_empty' => true)),
      'Poblaciotext'                    => new sfWidgetFormFilterInput(),
      'Telefon'                         => new sfWidgetFormFilterInput(),
      'Mobil'                           => new sfWidgetFormFilterInput(),
      'Entitat'                         => new sfWidgetFormFilterInput(),
      'Habilitat'                       => new sfWidgetFormFilterInput(),
      'Actualitzacio'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'site_id'                         => new sfWidgetFormFilterInput(),
      'app_documents_permisos_dir_list' => new sfWidgetFormPropelChoice(array('model' => 'AppDocumentsDirectoris', 'add_empty' => true)),
      'app_documents_permisos_list'     => new sfWidgetFormPropelChoice(array('model' => 'AppDocumentsArxius', 'add_empty' => true)),
      'usuaris_apps_list'               => new sfWidgetFormPropelChoice(array('model' => 'Apps', 'add_empty' => true)),
      'usuaris_menus_list'              => new sfWidgetFormPropelChoice(array('model' => 'GestioMenus', 'add_empty' => true)),
      'usuaris_sites_list'              => new sfWidgetFormPropelChoice(array('model' => 'Sites', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'Nivells_idNivells'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Nivells', 'column' => 'idNivells')),
      'DNI'                             => new sfValidatorPass(array('required' => false)),
      'Passwd'                          => new sfValidatorPass(array('required' => false)),
      'Nom'                             => new sfValidatorPass(array('required' => false)),
      'Cog1'                            => new sfValidatorPass(array('required' => false)),
      'Cog2'                            => new sfValidatorPass(array('required' => false)),
      'Email'                           => new sfValidatorPass(array('required' => false)),
      'Adreca'                          => new sfValidatorPass(array('required' => false)),
      'CodiPostal'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Poblacio'                        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Poblacions', 'column' => 'idPoblacio')),
      'Poblaciotext'                    => new sfValidatorPass(array('required' => false)),
      'Telefon'                         => new sfValidatorPass(array('required' => false)),
      'Mobil'                           => new sfValidatorPass(array('required' => false)),
      'Entitat'                         => new sfValidatorPass(array('required' => false)),
      'Habilitat'                       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Actualitzacio'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'site_id'                         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'app_documents_permisos_dir_list' => new sfValidatorPropelChoice(array('model' => 'AppDocumentsDirectoris', 'required' => false)),
      'app_documents_permisos_list'     => new sfValidatorPropelChoice(array('model' => 'AppDocumentsArxius', 'required' => false)),
      'usuaris_apps_list'               => new sfValidatorPropelChoice(array('model' => 'Apps', 'required' => false)),
      'usuaris_menus_list'              => new sfValidatorPropelChoice(array('model' => 'GestioMenus', 'required' => false)),
      'usuaris_sites_list'              => new sfValidatorPropelChoice(array('model' => 'Sites', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuaris_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addAppDocumentsPermisosDirListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(AppDocumentsPermisosDirPeer::IDUSUARI, UsuarisPeer::USUARIID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AppDocumentsPermisosDirPeer::IDDIRECTORI, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AppDocumentsPermisosDirPeer::IDDIRECTORI, $value));
    }

    $criteria->add($criterion);
  }

  public function addAppDocumentsPermisosListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(AppDocumentsPermisosPeer::IDUSUARI, UsuarisPeer::USUARIID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AppDocumentsPermisosPeer::IDARXIU, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AppDocumentsPermisosPeer::IDARXIU, $value));
    }

    $criteria->add($criterion);
  }

  public function addUsuarisAppsListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(UsuarisAppsPeer::USUARI_ID, UsuarisPeer::USUARIID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UsuarisAppsPeer::APP_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UsuarisAppsPeer::APP_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addUsuarisMenusListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(UsuarisMenusPeer::USUARI_ID, UsuarisPeer::USUARIID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UsuarisMenusPeer::MENU_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UsuarisMenusPeer::MENU_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addUsuarisSitesListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(UsuarisSitesPeer::USUARI_ID, UsuarisPeer::USUARIID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UsuarisSitesPeer::SITE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UsuarisSitesPeer::SITE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Usuaris';
  }

  public function getFields()
  {
    return array(
      'UsuariID'                        => 'Number',
      'Nivells_idNivells'               => 'ForeignKey',
      'DNI'                             => 'Text',
      'Passwd'                          => 'Text',
      'Nom'                             => 'Text',
      'Cog1'                            => 'Text',
      'Cog2'                            => 'Text',
      'Email'                           => 'Text',
      'Adreca'                          => 'Text',
      'CodiPostal'                      => 'Number',
      'Poblacio'                        => 'ForeignKey',
      'Poblaciotext'                    => 'Text',
      'Telefon'                         => 'Text',
      'Mobil'                           => 'Text',
      'Entitat'                         => 'Text',
      'Habilitat'                       => 'Number',
      'Actualitzacio'                   => 'Date',
      'site_id'                         => 'Number',
      'app_documents_permisos_dir_list' => 'ManyKey',
      'app_documents_permisos_list'     => 'ManyKey',
      'usuaris_apps_list'               => 'ManyKey',
      'usuaris_menus_list'              => 'ManyKey',
      'usuaris_sites_list'              => 'ManyKey',
    );
  }
}

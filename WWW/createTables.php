<?php
/*////////////////////////////////////////////////////////////////////////////
------------------------------------------------------------------------------
Генерация файлов DB_Dataobject
------------------------------------------------------------------------------
$Id: createTables.php 348 2014-05-21 13:14:35Z xxserg@gmail.com $
////////////////////////////////////////////////////////////////////////////
*/

$conf_dir = '../conf/';

if (file_exists($config = $conf_dir.'config.inc')) {
    chdir($conf_dir);
    include_once $config;
    //print_r($_SERVER);
    //exit;
    
    //include_once '../conf/dbo_conf.inc';

    // Параметры объекта DB_DataObject
    // Для ликвидации конфликта Zend Optimazer и DB_DataObject
    define(DB_DATAOBJECT_NO_OVERLOAD, 0);

    require_once 'PEAR.php';
    //$mdb2_options = &PEAR::getStaticProperty('MDB2','options');
    //$mdb2_options = array('portability' => MDB2_PORTABILITY_ALL);
    //$mdb2_options = array('portability' => 127, 'field_case' => CASE_LOWER, 'seqname_format' => '%s_sequence');


    $db_options = &PEAR::getStaticProperty('DB_DataObject','options');
    $db_options = array(
        'database_'.DB_NAME                  => DB_DSN,
        'database_rurenter'                  => DB_DSN2,
        /*
        'database' => array(
            'phptype'  => 'oci8',
            'dbsyntax' => "Easy Connect",
            'username' => DB_USER,
            'password' => DB_PASS,
            'protocol' => false,
            'hostspec' => DB_HOST,
            'port'     => false,
            'socket'   => false,
            //'database' => DB_NAME,
            'new_link' => false,
            'service'  => DB_NAME, // only in oci8
        ),
        */
        'schema_location'           => PROJECT_ROOT.'conf',
        'class_location'            => PROJECT_ROOT.'DataObjects/',
        'require_prefix'            => '',
        'class_prefix'              => 'DBO_',
        'db_driver'                 => 'MDB2',
        'generator_no_ini'          => true,
        'table_users'              => 'rurenter',
        'table_booking_log'        => 'rurenter',
        'table_guests'             => 'rurenter',
        'table_countries'             => 'rurenter',
        //'dont_die'                => true,
        //'build_views'               => true,
        //'generator_include_regex'   => "/booking_log|query/",
        //'generator_exclude_regex'   => "/^villa$/",
        'generator_include_regex'   => "/^countries/",

    );
    require_once 'DB/DataObject/Generator.php';
    //echo PROJECT_ROOT."\n";
    //exit;
    echo '<pre>';
    DB_DataObject::debugLevel(0);
    $generator = new DB_DataObject_Generator;
    $generator->start();
    echo "DONE\n";
}
else {
    echo "\nERROR! wrong project!\n";
}
?>

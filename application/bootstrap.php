<?php

// Set up the environment
error_reporting(E_ALL);
ini_set('display_errors', true );
date_default_timezone_set( 'Europe/London' );

// Load up Zend_Loader and register the autoload so files will be included as
// required.
require_once( 'Zend/Loader.php' );
Zend_Loader::registerAutoload( );

$registry = new Zend_Registry( array( ), ArrayObject::ARRAY_AS_PROPS );
Zend_Registry::setInstance( $registry );

$config = new Zend_Config_Ini( '../config/config.ini', 'general' );
$registry->configuration = $config;

// Set the default locale to en_GB
Zend_Locale::setDefault( 'en_GB' );

// Set up the front controller
$frontController = Zend_Controller_Front::getInstance();
$frontController->throwExceptions( true );
$frontController->returnResponse( true );
$frontController->setControllerDirectory('../application/controllers');

// Set up the action helpers
Zend_Controller_Action_HelperBroker::addPath( '../application/controllers/helpers' );

// Set the doctype to XHTML 1.0 Strict
$doctypeHelper = new Zend_View_Helper_Doctype();
$doctypeHelper->doctype('XHTML1_STRICT');

$view = new Zend_View( );
$view->setEncoding( 'UTF-8' );
$view->addHelperPath( '../application/views/helpers', 'WhenIsTheF1On_View_Helper_' );
$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer( $view );
Zend_Controller_Action_HelperBroker::addHelper( $viewRenderer );
Zend_Layout::startMvc( array (
    'layoutPath' => '../application/views/layouts',
    'layout' => 'common',
    'pluginClass' => 'WhenIsTheF1On_Layout_Controller_Plugin_Layout'
) );

$db = Zend_Db::factory( $config->db->adapter, $config->db->toArray( ) );
$db->query( "SET NAMES 'utf8'" );
$registry->database = $db;
Zend_Db_Table::setDefaultAdapter( $db );

$response = $frontController->dispatch( );
$response->setHeader( 'Content-Type', 'text/html; charset=UTF-8', true );
$response->sendResponse( );

<?php

if ( !defined( 'PHPUnit_MAIN_METHOD' ) )
{

    define( 'PHPUnit_MAIN_METHOD', 'AllTests::main' );

}

require_once( 'PHPUnit/Framework.php' );
require_once( 'PHPUnit/TextUI/TestRunner.php' );
require_once( 'controllers/AllTests.php' );
require_once( 'models/AllTests.php' );
require_once( 'WhenIsTheF1On/AllTests.php' );

class AllTests
{

    public static function main( )
    {

        PHPUnit_TextUI_TestRunner::run( self::suite( ) );

    }

    public static function suite( )
    {

        $suite = new PHPUnit_Framework_TestSuite( 'When Is The F1 On?' );

        $suite->addTest( Controllers_AllTests::suite( ) );
        $suite->addTest( Models_AllTests::suite( ) );
        $suite->addTest( WhenIsTheF1On_AllTests::suite( ) );

        return $suite;

    }

}

if ( PHPUnit_MAIN_METHOD == 'AllTests::main' )
{

    AllTests::main( );

}
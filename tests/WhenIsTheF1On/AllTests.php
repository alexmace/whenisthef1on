<?php

if ( !defined( 'PHPUnit_MAIN_METHOD' ) )
{

    define( 'PHPUnit_MAIN_METHOD', 'WhenIsTheF1On_AllTests::main' );

}

require_once( 'PHPUnit/Framework.php' );
require_once( 'PHPUnit/TextUI/TestRunner.php' );
require_once( 'WhenIsTheF1On/FormTest.php' );
require_once( 'WhenIsTheF1On/Form/AllTests.php' );
require_once( 'WhenIsTheF1On/Layout/AllTests.php' );

class WhenIsTheF1On_AllTests
{

    public static function main( )
    {

        PHPUnit_TextUI_TestRunner::run( self::suite( ) );

    }

    public static function suite( )
    {

        $suite = new PHPUnit_Framework_TestSuite( 'When Is The F1 On? Library' );

        $suite->addTest( WhenIsTheF1On_Form_AllTests::suite( ) );
        $suite->addTest( WhenIsTheF1On_Layout_AllTests::suite( ) );
        $suite->addTestSuite( 'WhenIsTheF1On_FormTest' );

        return $suite;

    }

}

if ( PHPUnit_MAIN_METHOD == 'WhenIsTheF1On_AllTests::main' )
{

    WhenIsTheF1On_AllTests::main( );

}

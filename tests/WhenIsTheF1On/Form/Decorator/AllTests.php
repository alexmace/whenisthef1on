<?php

if ( !defined( 'PHPUnit_MAIN_METHOD' ) )
{

    define( 'PHPUnit_MAIN_METHOD', 'WhenIsTheF1On_Form_Decorator_AllTests::main' );

}

require_once( 'PHPUnit/Framework.php' );
require_once( 'PHPUnit/TextUI/TestRunner.php' );
require_once( 'WhenIsTheF1On/Form/Decorator/LabelErrorTest.php' );

class WhenIsTheF1On_Form_Decorator_AllTests
{

    public static function main( )
    {

        PHPUnit_TextUI_TestRunner::run( self::suite( ) );

    }

    public static function suite( )
    {

        $suite = new PHPUnit_Framework_TestSuite( 'When Is The F1 On? Library Form Decorator' );

        $suite->addTestSuite( 'WhenIsTheF1On_Form_Decorator_LabelErrorTest' );

        return $suite;

    }

}

if ( PHPUnit_MAIN_METHOD == 'WhenIsTheF1On_Form_Decorator_AllTests::main' )
{

    WhenIsTheF1On_Form_Decorator_AllTests::main( );

}
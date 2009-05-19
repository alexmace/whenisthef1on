<?php

if ( !defined( 'PHPUnit_MAIN_METHOD' ) )
{

    define( 'PHPUnit_MAIN_METHOD', 'Models_AllTests::main' );

}

require_once( 'PHPUnit/Framework.php' );
require_once( 'PHPUnit/TextUI/TestRunner.php' );
require_once( 'models/BroadcastsTest.php' );
require_once( 'models/ChannelsTest.php' );
require_once( 'models/LocationsTest.php' );
require_once( 'models/LogosTest.php' );
require_once( 'models/ProgrammesTest.php' );

class Models_AllTests
{

    public static function main( )
    {

        PHPUnit_TextUI_TestRunner::run( self::suite( ) );

    }

    public static function suite( )
    {

        $suite = new PHPUnit_Framework_TestSuite( 'When Is The F1 On Models' );

        $suite->addTestSuite( 'BroadcastsTest' );
        $suite->addTestSuite( 'ChannelsTest' );
        $suite->addTestSuite( 'LocationsTest' );
        $suite->addTestSuite( 'LogosTest' );
        $suite->addTestSuite( 'ProgrammesTest' );

        return $suite;

    }

}
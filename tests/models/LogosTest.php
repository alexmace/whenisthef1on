<?php

require_once( 'PHPUnit/Extensions/Database/TestCase.php' );
require_once( 'Zend/Config/Ini.php' );
require_once( 'Zend/Db/Table.php' );
require_once( 'Zend/Db/Table/Abstract.php' );
require_once( 'models/Logos.php' );

/**
 * Set of tests for the Logos model
 *
 * @see Logos
 */
class LogosTest extends PHPUnit_Extensions_Database_TestCase
{

    /**
     * Gets the connection for the test.
     *
     * @todo Populate the connection settings from the project configuration
     *       file
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection( )
    {

        $pdo = new PDO( 'mysql:host=localhost;dbname=whenisthef1on_tests',
                        'test-runner', 'testing' );
	return $this->createDefaultDBConnection( $pdo, 'whenisthef1on_tests' );

    }

    /**
     * Gets the test data to populate the database with.
     *
     * @return PHPUnit_Extensions_Database_DataSet_FlatXmlDataSet
     */
    protected function getDataSet( )
    {

    	return $this->createFlatXMLDataSet( dirname( __FILE__ )
                                          . DIRECTORY_SEPARATOR . 'datasets'
                                          . DIRECTORY_SEPARATOR . 'basic.xml' );

    }

    /**
     * Sets up the environment for each test.
     */
    protected function setUp( )
    {

        // If PDO MySQL extension is not available then the test needs to be
        // skipped.
        if ( !extension_loaded( 'pdo_mysql' ) )
        {

            $this->markTestSkipped( 'MySQL PDO Driver is not loaded' );

        }
        else
        {

            // Load data from the config file and use it to create a database
            // adapter for use with the model.
            $config = new Zend_Config_Ini( dirname( __FILE__ ) 
                                         . DIRECTORY_SEPARATOR 
                                         . '../../config/config.ini', 'testing' );
            $db = Zend_Db::factory( $config->db->adapter, $config->db->toArray( ) );
            $db->query( "SET NAMES 'utf8'" );
            Zend_Db_Table::setDefaultAdapter( $db );

            // Call the parent setup, this has to be called to populate the
            // database with the test data.
            parent::setUp( );

        }

    }

    /**
     * Tests that the store function accurately saves the logo information for
     * the channel.
     */
    public function testStore( )
    {

        // Get an instance of the logos model
        $logos = new Logos( );

        // Attempt to store the information about the logo
        $logos->store( 'BBCTwo',
                       'http://www0.rdthdo.bbc.co.uk/services/api/res/images/BBCTwo_small.gif' );

        // Load up data file with data that should be in the database
        $xml_dataset = $this->createFlatXMLDataSet( dirname( __FILE__ )
                                                  . DIRECTORY_SEPARATOR . 'datasets'
                                                  . DIRECTORY_SEPARATOR . 'basic-after-logo-stored.xml' );

        // Test that the broadcast has been recorded correctly
        $this->assertTablesEqual( $xml_dataset->getTable( 'logos' ),
                                  $this->getConnection( )->createDataSet( )->getTable( 'logos' ) );


    }

    /**
     * Tests that when you try and store a duplicate entry it throws an
     * exception
     */
    public function testStoreDuplicate( )
    {

        // Get an instance of the logos model
        $logos = new Logos( );

        // Attempt to store the information about the logo
        $logos->store( 'BBCTwo',
                       'http://www0.rdthdo.bbc.co.uk/services/api/res/images/BBCTwo_small.gif' );

        // Storing it again should cause an exception. Set the expected
        // exception then attempt to store it.
        $this->setExpectedException( 'Zend_Db_Statement_Exception' );
        $logos->store( 'BBCTwo',
                       'http://www0.rdthdo.bbc.co.uk/services/api/res/images/BBCTwo_small.gif' );

    }

    /**
     * Tests that calling the RemoveAll function does indeed remove all of the
     * logos.
     */
    public function testRemoveAll( )
    {

        // Get an instance of the logos model
        $logos = new Logos( );

        // Remove all of the logos
        $logos->removeAll( );

        // Load up data file with data that should be in the database
        $xml_dataset = $this->createXMLDataSet( dirname( __FILE__ )
                                              . DIRECTORY_SEPARATOR . 'datasets'
                                              . DIRECTORY_SEPARATOR . 'empty.xml' );

        // Check that it is in fact empty
        $this->assertTablesEqual( $xml_dataset->getTable( 'logos' ),
                                  $this->getConnection( )->createDataSet( )->getTable( 'logos' ) );

    }

}

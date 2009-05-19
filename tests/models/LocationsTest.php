<?php

require_once( 'PHPUnit/Extensions/Database/TestCase.php' );
require_once( 'Zend/Config/Ini.php' );
require_once( 'Zend/Db/Table.php' );
require_once( 'Zend/Db/Table/Abstract.php' );
require_once( 'models/Locations.php' );

/**
 * Set of tests for the Locations model
 *
 * @see Locations
 */
class LocationsTest extends PHPUnit_Extensions_Database_TestCase
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
     * Tests that the store function accurately saves the location information
     * of a programme.
     */
    public function testStore( )
    {

        // Get an instance of the locations model
        $locations = new Locations( );

        // Attempt to store the information about the location
        $locations->store( 'crid://bbc.co.uk/1178643909', 'real-audio',
                           'http://www.bbc.co.uk/fivelive/live/surestream_sportsextra.ram',
                           '2009-05-21T07:55:00Z', '01:35:00' );

        // Load up data file with data that should be in the database
        $xml_dataset = $this->createFlatXMLDataSet( dirname( __FILE__ )
                                                  . DIRECTORY_SEPARATOR . 'datasets'
                                                  . DIRECTORY_SEPARATOR . 'basic-after-location-stored.xml' );

        // Test that the broadcast has been recorded correctly
        $this->assertTablesEqual( $xml_dataset->getTable( 'locations' ),
                                  $this->getConnection( )->createDataSet( )->getTable( 'locations' ) );


    }

    /**
     * Tests that when you try and store a duplicate entry it throws an
     * exception
     */
    public function testStoreDuplicate( )
    {

        // Get an instance of the locations model
        $locations = new Locations( );

        // Attempt to store the information about the location
        $locations->store( 'crid://bbc.co.uk/1178643909', 'real-audio',
                           'http://www.bbc.co.uk/fivelive/live/surestream_sportsextra.ram',
                           '2009-05-21T07:55:00Z', '01:35:00' );

        // Storing it again should cause an exception. Set the expected
        // exception then attempt to store it.
        $this->setExpectedException( 'Zend_Db_Statement_Exception' );
        $locations->store( 'crid://bbc.co.uk/1178643909', 'real-audio',
                           'http://www.bbc.co.uk/fivelive/live/surestream_sportsextra.ram',
                           '2009-05-21T07:55:00Z', '01:35:00' );

    }

    /**
     * Tests that calling the RemoveAll function does indeed remove all of the
     * locations.
     */
    public function testRemoveAll( )
    {

        // Get an instance of the broadcasts model
        $locations = new Locations( );

        // Remove all details of the broadcasts
        $locations->removeAll( );

        // Load up data file with data that should be in the database
        $xml_dataset = $this->createXMLDataSet( dirname( __FILE__ )
                                              . DIRECTORY_SEPARATOR . 'datasets'
                                              . DIRECTORY_SEPARATOR . 'empty.xml' );

        // Check that it is in fact empty
        $this->assertTablesEqual( $xml_dataset->getTable( 'locations' ),
                                  $this->getConnection( )->createDataSet( )->getTable( 'locations' ) );

    }

}

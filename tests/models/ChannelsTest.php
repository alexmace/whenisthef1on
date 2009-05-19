<?php

require_once( 'PHPUnit/Extensions/Database/TestCase.php' );
require_once( 'Zend/Config/Ini.php' );
require_once( 'Zend/Db/Table.php' );
require_once( 'Zend/Db/Table/Abstract.php' );
require_once( 'models/Channels.php' );

/**
 * Set of tests for the Channels model
 *
 * @see Channels
 */
class ChannelsTest extends PHPUnit_Extensions_Database_TestCase
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
     * Tests that the store function accurately saves the channel information
     */
    public function testStore( )
    {

        // Get an instance of the broadcasts model
        $channels = new Channels( );

        // Attempt to store the information about the broadcast
        $channels->store( 'BBCTwo', 'BBC Two' );

        // Load up data file with data that should be in the database
        $xml_dataset = $this->createFlatXMLDataSet( dirname( __FILE__ )
                                                  . DIRECTORY_SEPARATOR . 'datasets'
                                                  . DIRECTORY_SEPARATOR . 'basic-after-channel-stored.xml' );

        // Test that the broadcast has been recorded correctly
        $this->assertTablesEqual( $xml_dataset->getTable( 'channels' ),
                                  $this->getConnection( )->createDataSet( )->getTable( 'channels' ) );


    }

    /**
     * Tests that when you try and store a duplicate entry it throws an
     * exception
     */
    public function testStoreDuplicate( )
    {

        // Get an instance of the channels model
        $channels = new Channels( );

        // Attempt to store the information about the broadcast
        $channels->store( 'BBCTwo', 'BBC Two' );

        // Storing it again should cause an exception. Set the expected
        // exception then attempt to store it.
        $this->setExpectedException( 'Zend_Db_Statement_Exception' );
        $channels->store( 'BBCTwo', 'BBC Two' );

    }

    /**
     * Tests that calling the RemoveAll function does indeed remove all of the
     * channels.
     */
    public function testRemoveAll( )
    {

        // Get an instance of the channels model
        $channels = new Channels( );

        // Remove all details of the channels
        $channels->removeAll( );

        // Load up data file with data that should be in the database
        $xml_dataset = $this->createXMLDataSet( dirname( __FILE__ )
                                              . DIRECTORY_SEPARATOR . 'datasets'
                                              . DIRECTORY_SEPARATOR . 'empty.xml' );

        // Check that it is in fact empty
        $this->assertTablesEqual( $xml_dataset->getTable( 'channels' ),
                                  $this->getConnection( )->createDataSet( )->getTable( 'channels' ) );

    }

}

<?php

define( 'APPLICATION_PATH', dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..'
                          . DIRECTORY_SEPARATOR );

/*
 * This script should be run as a cron job, refreshing the details of the
 * programmes in the database
 */
set_include_path( APPLICATION_PATH . 'application' . DIRECTORY_SEPARATOR
                . 'models' . PATH_SEPARATOR . get_include_path( ) );

require_once( 'Zend/Config/Ini.php' );
require_once( 'Zend/Db/Table.php' );
require_once( 'Zend/Rest/Client.php' );
require_once( 'Broadcasts.php' );
require_once( 'Locations.php' );
require_once( 'Programmes.php' );

$config = new Zend_Config_Ini( APPLICATION_PATH . 'config' . DIRECTORY_SEPARATOR
                             . 'config.ini', 'general' );
$db = Zend_Db::factory( $config->db->adapter, $config->db->toArray( ) );
$db->query( "SET NAMES 'utf8'" );
Zend_Db_Table::setDefaultAdapter( $db );

// Get instances of each of the models
$progsModel = new Programmes( );

// Set up the REST client to query the BBC
$client = new Zend_Rest_Client( 'http://www0.rdthdo.bbc.co.uk/cgi-perl/api/query.pl' );

// First, we need to get the list of groups.
$client->method( 'bbc.group.list' );
$groups = $client->get( );

// Iterate over the groups found looking for the ones with 'Formula 1' in their
// name
foreach( $groups as $group )
{

    // Get the attributes for this group
    $groupAttribs = $group->attributes( );

    // See if we can find 'Formula 1' in it's title
    if ( strpos( $groupAttribs->title, 'Formula 1' ) !== false )
    {

        // Next we need to find the programmes within this group, so query for
        // the members of the group.
        $client->method( 'bbc.group.getMembers' )
               ->group_id( (string)$groupAttribs->group_id );
        $programmes = $client->get( );

        // Iterate over the programmes that were found. The XML that is returned
        // encloses the programmes within a group tag, so iterate over the
        // contents of that.
        foreach( $programmes->group[0] as $programme )
        {

            // Get the attributes of the program.
            $progAttribs = $programme->attributes( );

            // Extract the programme id
            $programmeId = (string)$progAttribs->programme_id;

            // Now with the attributes we can query to get the information about
            // the programme and then the locations that it will be available
            $client->method( 'bbc.programme.getInfo' )
                   ->programme_id( $programmeId );
            $info = $client->get( );

            // Extract the title and synopsis of the programme
            $title = (string)$info->programme[0]->attributes( )->title;
            $synopsis = (string)$info->programme[0]->synopsis;

            // Save the details of the programme
            $progsModel->store( $programmeId, $title, $synopsis );

        }

    }

}
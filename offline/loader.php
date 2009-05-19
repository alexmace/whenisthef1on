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
require_once( 'Channels.php' );
require_once( 'Locations.php' );
require_once( 'Logos.php' );
require_once( 'Programmes.php' );

$config = new Zend_Config_Ini( APPLICATION_PATH . 'config' . DIRECTORY_SEPARATOR
                             . 'config.ini', 'general' );
$db = Zend_Db::factory( $config->db->adapter, $config->db->toArray( ) );
$db->query( "SET NAMES 'utf8'" );
Zend_Db_Table::setDefaultAdapter( $db );

// Get instances of each of the models
$broadModel = new Broadcasts( );
$chanModel = new Channels( );
$locModel = new Locations( );
$logoModel = new Logos( );
$progsModel = new Programmes( );

// Set up the REST client to query the BBC
$client = new Zend_Rest_Client( 'http://www0.rdthdo.bbc.co.uk/cgi-perl/api/query.pl' );

// First, we need to get the list of groups.
$client->method( 'bbc.group.list' );
$groups = $client->get( );

// Empty out the contents of the current database
$broadModel->removeAll( );
$chanModel->removeAll( );
$locModel->removeAll( );
$logoModel->removeAll( );
$progsModel->removeAll( );

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

            foreach( $info->programme[0]->event as $event )
            {

                // Save the broadcast dates
                $broadModel->store( $programmeId,
                                    (string)$event->attributes( )->channel_id,
                                    (string)$event->start[0],
                                    (string)$event->duration[0] );

            }

            // Now we need to load the locations up
            $client->method( 'bbc.programme.getLocations' )
                   ->programme_id( $programmeId );
            $locations = $client->get( );

            foreach( $locations->programme[0]->location as $location )
            {
                
                if ( (string)$location->type[0] != 'dvb' )
                {

                    $locModel->store( $programmeId, (string)$location->type[0],
                                      (string)$location->url[0],
                                      (string)$location->start[0],
                                      (string)$location->duration[0] );

                }

            }

        }

    }

}
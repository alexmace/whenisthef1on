<?php
/**
 * Broadcasts Class Definition
 *
 */

/**
 * This is the model that holds the logic involved with broadcasts of programmes
 *
 * @author Alex Mace <alex@hollytree.co.uk>
 * @package Models
 */
class Broadcasts extends Zend_Db_Table_Abstract
{

    /**
     * The name of the associated table
     *
     * @var string
     */
    protected $_name = 'broadcasts';

    /**
     * Saves the details of the broadcast for the given programme
     *
     * @param string $programmeId
     * @param string $channelId
     * @param string $start
     * @param string $duration
     */
    public function store( $programmeId, $channelId, $start, $duration )
    {

        // Set the data we're going to pass to the database.
        $data = array( 'programmeId' => $programmeId,
                       'channelId'   => $channelId,
                       'start'       => $start,
                       'duration'    => $duration );

        // Save it to the database
        $this->insert( $data );

    }

    /**
     * Removes all of the entries in the table
     */
    public function removeAll( )
    {

        $this->delete( '' );

    }

}
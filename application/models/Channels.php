<?php
/**
 * Channels Class Definition
 *
 */

/**
 * This is the model that holds the logic involved with channels
 *
 * @author Alex Mace <alex@hollytree.co.uk>
 * @package Models
 */
class Channels extends Zend_Db_Table_Abstract
{

    /**
     * The name of the associated table
     *
     * @var string
     */
    protected $_name = 'channels';

    /**
     * Saves the details of the channel
     *
     * @param string $channelId
     * @param string $name
     */
    public function store( $channelId, $name )
    {

        // Set the data we're going to pass to the database.
        $data = array( 'channelId' => $channelId,
                       'name'      => $name );

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
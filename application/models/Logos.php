<?php
/**
 * Logos Class Definition
 *
 */

/**
 * This is the model that holds the logic involved with logos of channels
 *
 * @author Alex Mace <alex@hollytree.co.uk>
 * @package Models
 */
class Logos extends Zend_Db_Table_Abstract
{

    /**
     * The name of the associated table
     *
     * @var string
     */
    protected $_name = 'logos';

    /**
     * Saves the details of the logo for a channel
     *
     * @param string $channelId
     * @param string $url
     */
    public function store( $channelId, $url )
    {

        // Set the data we're going to pass to the database.
        $data = array( 'channelId' => $channelId,
                       'url'       => $url );

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
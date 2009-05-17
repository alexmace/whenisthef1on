<?php
/**
 * Locations Class Definition
 *
 */

/**
 * This is the model that holds the logic involved with where to find a
 * programme online
 *
 * @author Alex Mace <alex@hollytree.co.uk>
 * @package Models
 */
class Locations extends Zend_Db_Table_Abstract
{

    /**
     * The name of the associated table
     *
     * @var string
     */
    protected $_name = 'locations';

    /**
     * Saves the details of the location for the given programme
     *
     * @param string $programmeId
     * @param string $type
     * @param string $url
     */
    public function store( $programmeId, $type, $url )
    {

        // Set the data we're going to pass to the database.
        $data = array( 'programmeId' => $programmeId,
                       'type'        => $type,
                       'url'         => $url );

        // Save it to the database
        $this->insert( $data );

    }

}
<?php
/**
 * IndexController Class Definition
 *
 */
require_once( 'Zend/Controller/Action.php' );

/**
 * The Index controller only has one page - the home page. The home page can
 * only be displayed once the user is logged in, otherwise it should redirect
 * to the login page in the Auth controller.
 *
 * @author Alex Mace <alex@hollytree.co.uk>
 * @package Controllers
 */
class IndexController extends Zend_Controller_Action
{

    /**
     * Shows the home page.
     */
    public function indexAction( )
    {

        // Stats used to be generated for display here, but I think they're now
        // taking too long to generate, so I've removed them for now.

    }

}

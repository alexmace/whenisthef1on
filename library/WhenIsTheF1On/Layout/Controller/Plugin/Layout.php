<?php

/**
 * Layout Controller Plugin that controls what layout is used on different
 * pages. The default layout is 'common.phtml'
 *
 */
class WhenIsTheF1On_Layout_Controller_Plugin_Layout extends Zend_Layout_Controller_Plugin_Layout {

    /**
     * Gets called before the Action Controller is dispatched and sets up the
     * layouts to use.
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch( Zend_Controller_Request_Abstract $request )
    {

    }

}
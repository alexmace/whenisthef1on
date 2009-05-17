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
        $client = new Zend_Rest_Client( 'http://www0.rdthdo.bbc.co.uk/cgi-perl/api/query.pl' );

        $client->method( 'bbc.group.list' );
        $groups = $client->get( );

        foreach( $groups as $group )
        {

            $attribs = $group->attributes( );

            if ( strpos( $attribs->title, 'Formula 1' ) !== false )
            {

                echo '<h1>' . $attribs->group_id . ": " . $attribs->title . "</h1>\n";
                echo '<ul>';

                $client->method( 'bbc.group.getMembers' )
                       ->group_id( (string)$attribs->group_id );
                $programmes = $client->get( );

                foreach( $programmes->group[0] as $programme )
                {

                    $progAttribs = $programme->attributes( );

                    echo '<li>' . $progAttribs->programme_id . ': ' . $progAttribs->title . "</li>\n";

                    $client->method( 'bbc.programme.getInfo' )
                           ->programme_id( (string)$progAttribs->programme_id );
                    $progInfo = $client->get( );

                    var_export( $progInfo );

                    $client->method( 'bbc.programme.getLocations' )
                           ->programme_id( (string)$progAttribs->programme_id );
                    $progLocations = $client->get( );

                    var_export( $progLocations );

                }

                echo '</ul>';

            }

/*            var_export( $group );
            echo "<br />\n";*/

        }
        //http://www0.rdthdo.bbc.co.uk/cgi-perl/api/query.pl?method=bbc.channel.getLocations&channel_id=BBCOne

    }

}

<?php
/**
 * Traction_Form Class Definition
 *
 */

/**
 * This sets up the standard format of forms within Traction. Sets up the 
 * directories to be used for any custom decorators and sets up the standard 
 * decorators to be used when rendering forms.
 * 
 * @author Alex Mace <alex@hollytree.co.uk>
 * @package Library
 * @subpackage Form
 */
class WhenIsTheF1On_Form extends Zend_Form {

    /**
     * Define how form elements will be decorated
     *
     * @var array
     */
    protected $_standardElementDecorator = array(
        'ViewHelper',
        array( 'Label' ),
        array( 'HtmlTag', array( 'tag' => 'p' ) )
    );

    /**
     * Special decorator for the file element because the ViewHelper does not
     * work for Zend_Form_Element_File
     *
     * @var array
     */
    protected $_fileElementDecorator = array(
        'File',
        array( 'Label' ),
        array( 'HtmlTag', array( 'tag' => 'p' ) )
    );

    /**
     * Define different decorator settings for buttons as we don't want to
     * prepend the button with a label
     *
     * @var array
     */
    protected $_buttonElementDecorator = array(
        'ViewHelper',
        array( 'HtmlTag', array( 'tag'   => 'p',
                                 'class' => 'buttons' ) )
    );
    

    /**
     * Define a "naked" decorator for hidden fields
     *
     * @var array
     */
    protected $_hiddenElementDecorator = array( 
    	'ViewHelper'
    );

    /**
     * Class constructor. Sets up the location of the Traction element
     * decorators. Makes sure the form is submitted in UTF-8 and sets up the
     * standard decorators to be used.
     *
     * @param array $options
     */
    public function __construct( $options = null ) {

        // Set up the path to the customer decorators
        $this->addElementPrefixPath( 'WhenIsTheF1On_Form_Decorator_',
                                     'WhenIsTheF1On/Form/Decorator/',
                                     'decorator' );

        // Pass the options array onto the super class
        parent::__construct( $options );

        // Make sure this form is submitted using UTF-8 and set up the standard
        // decorators for the form.
        $this->setAttrib( 'accept-charset', 'UTF-8' );
        $this->setDecorators( array(
            'FormElements',
            'Form'
        ) );

    }

}
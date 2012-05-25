<?php

/*
This is an authenticated photos action
*/

class Photos2Controller extends Zend_Controller_Action
{

    private $username;
    private $user_id_seq;
    private $authToken;

    public function init()
    {
        /* Initialize action controller here */

    }
     public function preDispatch(){

        // Authentication Piece
        $this->auth = Zend_Auth::getInstance();

        if(!$this->auth->hasIdentity()){
            $this->_redirect( '/login?f=' . $this->_request->getRequestUri() );
        } else {
            // User is valid and logged in
            $this->username = $this->auth->getIdentity();

            // Set user's user_id_seq
            Zend_Loader::loadClass('identity');
            $identity = new identity();
            $this->user_id_seq = $identity->getUserIDSeq( $this->username );

            // Set user's auth_token
            Zend_Loader::loadClass('AuthToken');
            $authTokenClass = new AuthToken();
            $this->authToken = $authTokenClass->getAuthToken( $this->user_id_seq );
        }
     }
     public function __call($method, $args)
     {
         if ('Action' == substr($method, -6)) {
            // If the action method was not found, render the error
            // template
            return $this->render('error');

	    // Forward to another page
            //return $this->_forward('index');
        }

        // all other methods throw an exception
        throw new Exception('Invalid method "'
                            . $method
                            . '" called',
                                500);

    }
    public function indexAction()
    {
	//print( $this->client_id_seq . ' - ' . $this->user_id_seq . '<br/>' );
    }
    public function uploadfileAction(){

        $this->view->authToken = $this->authToken;
    }
    public function listsAction(){

        $this->view->authToken = $this->authToken;
        $this->view->username = $this->username;
    }
    public function authtokenAction(){
        $this->view->authToken = $this->authToken;
    }
    public function mapAction(){
        $this->view->authToken = $this->authToken;
        $this->view->id_seq = $this->_request->getParam( 'id_seq' );
    }
    public function segmentdataAction(){
        $this->view->authToken = $this->authToken;
        $this->view->datasource_id_seq = $this->_request->getParam( 'datasource_id_seq' );
    }
    public function queryitemAction(){

        $this->view->authToken = $this->authToken;
        $this->view->datasource_id_seq = $this->_request->getParam( 'datasource_id_seq' );

        $this->view->submit = $this->_request->getParam( 'submit' );
        $this->view->item = $this->_request->getParam( 'item' );                                                                                                                             
        $this->view->type = $this->_request->getParam( 'type' );
        $this->view->customer_name = $this->_request->getParam( 'customer_name' );
    }
    public function getrecAction(){
        $this->view->authToken = $this->authToken;
        $this->view->datasource_id_seq = $this->_request->getParam( 'datasource_id_seq' );
   
        $this->view->field_mapped_value = $this->_request->getParam( 'field_mapped_value' );
        $this->view->algorithm = $this->_request->getParam( 'algorithm' );
        $this->view->type = $this->_request->getParam( 'type' );
        $this->view->customer_name = $this->_request->getParam( 'customer_name' );
        $this->view->part_name = $this->_request->getParam( 'part_name' );

        $this->view->neighborhoodSize = $this->_request->getParam( 'neighborhoodSize' );
    }
    public function getrecjsonAction(){
        $this->view->authToken = $this->authToken;
        $this->view->datasource_id_seq = $this->_request->getParam( 'datasource_id_seq' );
   
        $this->view->field_mapped_value = $this->_request->getParam( 'field_mapped_value' );
        $this->view->algorithm = $this->_request->getParam( 'algorithm' );
        $this->view->type = $this->_request->getParam( 'type' );
        $this->view->customer_name = $this->_request->getParam( 'customer_name' );
        $this->view->part_name = $this->_request->getParam( 'part_name' );

        $this->view->neighborhoodSize = $this->_request->getParam( 'neighborhoodSize' );
    }
    public function emailAction(){

        Zend_Loader::loadClass('Utilities');

        $utilities = new Utilities();

        $utilities->email( 'no-reply@imarketingb2b.com', 'y&=752QN', 'smtp.gmail.com', 'no-reply@imarketingb2b.com', 'No-Reply', 'garlandk@gmail.com', 'User', 'test subject', 'test test test' );

    }
    public function combinedataAction(){
        $this->view->authToken = $this->authToken;
        $this->view->datasource_id_seq = $this->_request->getParam( 'datasource_id_seq' );
        $this->view->addTo_datasource_id_seq = $this->_request->getParam( 'addTo_datasource_id_seq' );
    }
    public function recommendationsAction(){

        $this->view->authToken = $this->authToken;

        // After submit variables
        $this->view->submit = $this->_request->getParam( 'submit' );
        $this->view->datasource_id_seq = $this->_request->getParam( 'datasource_id_seq' );
        $this->view->category_datasource_id_seq = $this->_request->getParam( 'category_datasource_id_seq' );
        $this->view->application_datasource_id_seq = $this->_request->getParam( 'application_datasource_id_seq' );
        $this->view->item = strtoupper( $this->_request->getParam( 'item' ) );
    
        // Dynamically fill out this variable for the user based on the segment file name
        //$this->view->application_name = $this->_request->getParam( 'application_name' );
        if( $this->_request->getParam( 'submit' ) != '' ){

            $content = file_get_contents( "http://www.algorithms.io/data/index/class/DataSources/method/files/authToken/".$this->authToken );

            $file_list = json_decode( $content, true );

            foreach( $file_list as $aFile ){
                if( $aFile['id_seq'] == $this->view->datasource_id_seq )
                    $this->view->application_name = preg_replace( '/^Segment: /', '', $aFile['friendly_description'] );
            }
        }

    }
    public function recommendations2Action(){

        $this->view->authToken = $this->authToken;

        // After submit variables
        $this->view->submit = $this->_request->getParam( 'submit' );
        $this->view->datasource_id_seq = $this->_request->getParam( 'datasource_id_seq' );
        $this->view->category_datasource_id_seq = $this->_request->getParam( 'category_datasource_id_seq' );
        $this->view->application_datasource_id_seq = $this->_request->getParam( 'application_datasource_id_seq' );
        $this->view->item = strtoupper( $this->_request->getParam( 'item' ) );

        // Dynamically fill out this variable for the user based on the segment file name
        //$this->view->application_name = $this->_request->getParam( 'application_name' );
        if( $this->_request->getParam( 'submit' ) != '' ){

            $content = file_get_contents( "http://www.algorithms.io/data/index/class/DataSources/method/files/authToken/".$this->authToken );

            $file_list = json_decode( $content, true );

            foreach( $file_list as $aFile ){
                if( $aFile['id_seq'] == $this->view->datasource_id_seq )
                    $this->view->application_name = preg_replace( '/^Segment: /', '', $aFile['friendly_description'] );
            }
        }

    }
    public function recommendations3Action(){

        $this->view->authToken = $this->authToken;

        // After submit variables
        $this->view->submit = $this->_request->getParam( 'submit' );
        $this->view->datasource_id_seq = $this->_request->getParam( 'datasource_id_seq' );
        $this->view->category_datasource_id_seq = $this->_request->getParam( 'category_datasource_id_seq' );
        $this->view->application_datasource_id_seq = $this->_request->getParam( 'application_datasource_id_seq' );
        $this->view->item = strtoupper( $this->_request->getParam( 'item' ) );

        // Dynamically fill out this variable for the user based on the segment file name
        //$this->view->application_name = $this->_request->getParam( 'application_name' );
        if( $this->_request->getParam( 'submit' ) != '' ){

            $content = file_get_contents( "http://www.algorithms.io/data/index/class/DataSources/method/files/authToken/".$this->authToken );

            $file_list = json_decode( $content, true );

            foreach( $file_list as $aFile ){
                if( $aFile['id_seq'] == $this->view->datasource_id_seq )                                                
                    $this->view->application_name = preg_replace( '/^Segment: /', '', $aFile['friendly_description'] ); 
            }                                                                                                           
        }                                                                                                               
                                                                                                                        
    } 
    public function bulkprovisionAction(){

        $this->view->authToken = $this->authToken;
        
        // After submit variables
        $this->view->submit = $this->_request->getParam( 'submit' );
        $this->view->field_user_id = $this->_request->getParam( 'field_user_id' );
        $this->view->field_item_id = $this->_request->getParam( 'field_item_id' );
        $this->view->field_preference = $this->_request->getParam( 'field_preference' );
        $this->view->bulkProvision_datasource_id_seq = $this->_request->getParam( 'bulkProvision_datasource_id_seq' );
        $this->view->addTo_datasource_id_seq = $this->_request->getParam( 'addTo_datasource_id_seq' );

    }
    public function bulkdeleteAction(){

        $this->view->authToken = $this->authToken;
    
        // After submit variables
        $this->view->submit = $this->_request->getParam( 'submit' );
        $this->view->addTo_datasource_id_seq = $this->_request->getParam( 'addTo_datasource_id_seq' );
    }
    public function searchandreplaceAction(){

        $this->view->authToken = $this->authToken;
        $this->view->datasource_id_seq = $this->_request->getParam( 'datasource_id_seq' );
    }
    public function newarbAction(){

        $this->view->authToken = $this->authToken;
        $this->view->datasource_id_seq = $this->_request->getParam( 'datasource_id_seq' );
    }
}

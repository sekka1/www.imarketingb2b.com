<?php

/*
This is an unauthenticated photos action
*/

class SignupController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */

    }
     public function preDispatch(){
/*
        // Authentication Piece
        $this->auth = Zend_Auth::getInstance();

        if(!$this->auth->hasIdentity()){
                 $this->_redirect( '/login?f=' . $this->_request->getRequestUri() );
        } else {
                // User is valid and logged in
                $this->username = $this->auth->getIdentity();
        }
*/
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
    public function aaAction(){
        // Initial sign up form

        if( $this->getRequest()->isPost() ){
            // User is trying to submit a signup

            Zend_Loader::loadClass('Users');
            $users = new Users();

            $results = $users->initialSignUp( $this->_request ); 

            $this->view->hasSignedUp = 'true';
        }
    }
    public function verifyAction(){
        // Verify the user's sign up email address

        Zend_Loader::loadClass('Users');
        $users = new Users();

        $email = $this->_request->getParam( 'email' );
        $unique_id = $this->_request->getParam( 'id' );

        $this->view->verificationStatus = 'unknown';

        if( $email != '' && $unique_id != '' ){

            // Activate account
            $user_id_seq = $users->activateAccount( $email, $unique_id );

            if( $user_id_seq > 0 ){
                // Create account in Algorithms.io

                Zend_Loader::loadClass('AlgorithmsIOTrustedPartners');
                $algorithmsIOTrustedPartners = new AlgorithmsIOTrustedPartners();
                $status = $algorithmsIOTrustedPartners->createUserAndToken( $email );

                if( $status['outcome'] == 'Success' ){
                    // Created in Algorithms.io successfully, put this auth token into table auth_tokens
        
                    Zend_Loader::loadClass('AuthToken');
                    $authToken = new AuthToken();
                    $auth_token_id_seq = $authToken->saveAuthToken( $user_id_seq, $status['auth_token'], 'Algorithms.io' );
            
                    $this->view->verificationStatus = 'All Successful';
                } else {
                    $this->view->verificationStatus = 'Failed Partner User Creation';
                }
            } else {
                $this->view->verificationStatus = 'Failed';
            }
        }
    }
}

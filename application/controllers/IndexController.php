<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
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
//	header("Location: /events"); /* Redirect browser */
/*        // action body
	$this->view->title = "My Albums"; 
        $this->view->headTitle($this->view->title, 'PREPEND'); 
        $albums = new Model_DbTable_Albums(); 
        $this->view->albums = $albums->fetchAll();
*/
    }
    public function oneAction()
    {

    }
    public function twoAction()
    {

    }
    public function eventsAction()
    {

    }
    public function unauthAction(){

	// Sets which template you want for the output
        $this->view->templateType = 'none';

        $auth = Zend_Auth::getInstance();

        if(!$auth->hasIdentity()){
                 $this->_redirect('/customers');
        } else {
                echo $auth->getIdentity();
                //print_r ($auth);
        }
    }
    public function fbcheckinsAction(){
 
    }
    public function fblikesAction(){
    }
    public function fblikes2Action(){

        $user_id = $this->_request->getParam( 'user' );

        $this->view->user_id = $user_id;
    }
    public function fblikes3Action(){

        $user_id = $this->_request->getParam( 'user' );
        $fb_session = $this->_request->getParam( 'session' );

        $this->view->user_id = $user_id;
        $this->view->fb_session = $fb_session;
    }
    public function simplestoreAction(){

    }
    public function amzecsAction(){

   }
   public function amazonecsAction(){


   }
   public function amzecs2Action(){
   }
   public function amzecs3Action(){

 	$category = $this->_request->getParam( 'category' );
	$search = $this->_request->getParam( 'search' );

	$this->view->category = $category;
	$this->view->search = $search;

   }
   public function channelAction(){
        // This is a file for FB javascript plugin for cross domain browsing and social plugins

   }
    public function emailAction(){

        $email = $this->_request->getParam( 'email' );

        if( $email != '' ){
            Zend_Loader::loadClass('Utilities');

            $utilities = new Utilities();

            $utilities->email( 'no-reply@imarketingb2b.com', 'y&=752QN', 'smtp.gmail.com', 'no-reply@imarketingb2b.com', 'No-Reply', $email, $email, 'abdullah@imarketingb2b.com', 'A Sign up', 'iMarketingB2B Info Sign Up', 'Thank you for your interest in iMarketingB2B, we will contact you with more information at this email address: '.$email );
        }

        $this->_redirect( '/index/index' );
    }
    public function productsAction(){

    }
    public function apiAction(){

    }
    public function aboutAction(){

    }
    public function algopricingAction(){

    }
    public function jobsAction(){

    }
    public function loginAction(){

    }
}

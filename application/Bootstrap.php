<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoload() 
    { 
        $moduleLoader = new Zend_Application_Module_Autoloader(array( 
            'namespace' => '', 
            'basePath'  => APPLICATION_PATH)); 
        return $moduleLoader; 
    } 
    function _initViewHelpers() 
    { 
        $this->bootstrap('layout'); 
        $layout = $this->getResource('layout'); 
        $view = $layout->getView(); 

 
 
        $view->doctype('XHTML1_STRICT'); 
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8'); 
        $view->headTitle()->setSeparator(' - '); 
        //$view->headTitle('Zend Framework Tutorial'); 
    } 


}


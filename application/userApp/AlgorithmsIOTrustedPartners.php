<?php

class AlgorithmsIOTrustedPartners
{
    private $trustedPartnerAuthToken;

    public function __construct(){

        $this->trustedPartnerAuthToken = 'iMarketingB2B_29384jchdJ33940fjJdheuckeh';
    }
    public function createUserAndToken( $email ){
        // This funciton will create a new user and token at Algorithms.io

        $url = 'http://www.algorithms.io/data/index/class/Users/method/trustedPartnersUserCreation/authToken/'.$this->trustedPartnerAuthToken.'/email/'.$email;

        $results = json_decode( file_get_contents( $url ), true );

        return $results;
    }
}

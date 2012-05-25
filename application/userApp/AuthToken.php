<?php

class AuthToken
{
    private $generic_db;

    public function __construct(){

        Zend_Loader::loadClass('Generic');
        $this->generic_db = new Generic();
    }
    public function saveAuthToken( $user_id_seq, $token, $description ){
        // Saves an auth token to the db

        $result = '';

        if( $user_id_seq != '' && $token != '' && $description != '' ){

            $data['user_id_seq'] = $user_id_seq;
            $data['token'] = $token;
            $data['description'] = $description;
            $data['datetime_created'] = 'NOW()';
            $data['datetime_modified'] = 'NOW()';

            $result = $this->generic_db->save( 'auth_tokens', $data );
        }
        return $result;
    }
    public function getAuthToken( $user_id_seq ){
        // returns the auth token based on a user_id_seq

        $sql = 'SELECT token FROM auth_tokens WHERE user_id_seq = '.$user_id_seq;

        $results = $this->generic_db->customQuery( 'auth_tokens', $sql );

        return $results[0]['token'];
    }
}

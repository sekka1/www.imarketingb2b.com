<?php

class Utilities
{

public function __construct( ){


}
public function recordBelongsToUser( $user_id_seq, $table_name, $target_id_seq_column_name, $target_id_value ){
// This function checks if a id_seq belongs to the current user that is logged in.  Will return 
// true of fales

	$return_value = false;

	if( is_numeric( $target_id_value ) ){

		Zend_Loader::loadClass('Generic');

		$generic_db = new Generic();

		$results = $generic_db->customQuery( $table_name, 'SELECT * FROM '. $table_name . ' WHERE ' . $target_id_seq_column_name . ' = ' . $target_id_value . ' AND  user_id_seq = ' . $user_id_seq  );

		if( count( $results ) > 0 ){
			$return_value = true;
		}
	}

	return $return_value;
}
public function convertToCoordinates( $address ){
// Converts and address into Longitude and latitude coordinates by using the yahoo api

// Yahoo call should look like this:
// http://api.maps.yahoo.com/ajax/geocode?appid=onestep&qt=1&id=m&qs=1600+pennsylvania+ave+washington+dc

	$returnVal = '';

	$yahoo_api_url = 'http://api.maps.yahoo.com/ajax/geocode?appid=onestep&qt=1&id=m&qs=';

	// Massage user's address
	// Replace spaces with "+" signs
	$address = str_replace( ' ', '+', $address );

	// Replace commas with nothing
	//$address = str_replace( ',', '', $address );

	$handle = fopen( $yahoo_api_url.$address, "r");

	$output = '';

	while (!feof($handle)) {
		$output = fread( $handle, 8192 );
	}

	fclose($handle);

	// Return string looks like this get rid of the front yahoo and ending stuff
	// YGeoCode.getMap({"GeoID":"m","GeoAddress":"760 n 6th st san jose ca","GeoPoint":{"Lat":37.353005,"Lon":-121.895721},"GeoMID":false,"success":1},1);
	preg_match( '/"Lat":(-?\d+\.\d+),"Lon":(-?\d+\.\d+)\},/', $output, $returnVal );

	// Did not find the address.  Set it to both 0
	if( ! isset( $returnVal[1] ) ){
		$returnVal[1] = 0;
	}
	if( ! isset( $returnVal[2] ) ){
                $returnVal[2] = 0;
        }

//print_r( $returnVal );
	return $returnVal;
}
public function curlPost( $url, $post_params ){
    // Does a post and optional file upload to a given url
    // INTPUT:
    /*
        $post_params['file'] = ‘@’.'/tmp/testfile.txt’;
        $post_params['submit'] = urlencode(’submit’);;
    */
        $returnVal = '';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
        $result = curl_exec($ch);

        if( $result )
            $returnVal = $result;
        else
            $returnVal = curl_error($ch); 

        curl_close($ch);

        return $returnVal;
}
public function email( $auth_name, $auth_password, $mailserver, $fromEmail, $fromName, $toEmail, $toName, $bccEmail, $bccName, $subject, $body ){

    $config = array('auth' => 'login',
            'ssl' => 'tls',
            'port' => 587,
            'username' => $auth_name,
            'password' => $auth_password );

    $transport = new Zend_Mail_Transport_Smtp($mailserver, $config);

    $mail = new Zend_Mail();
    $mail->setBodyText($body);
    $mail->setFrom($fromEmail, $fromName);
    $mail->addTo($toEmail, $toName);
    $mail->addBcc($bccEmail, $bccName);
    $mail->setSubject($subject);
    $mail->send($transport);

}

}

?>

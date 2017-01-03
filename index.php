<?php

//SHOUTcast DNAS status for Android API
//By Ahmed Sazzad Hossain
// 03/01/2017


if (!isset($_GET['link'])) 
{
	$response['error'] = 'No get is found';
	die (json_encode($response));
} else {
	$link=trim($_GET['link']);
	// preg_match ( '#^http://(.*):(.*)/|;#' , $the_link,  $matches);
	// $ip=$matches[1];
	// $port=$matches[2];
}

ini_set("user_agent", "Mozilla/5.0 (Windows NT 6.1; rv:30.0) Gecko/20100101 Firefox/30.0");
//@ for no warning 
$html = @file_get_contents($link, true);

if ($html === false) 
{
    //There is an error opening the file
	$response['error'] = 'Server is down';
	echo json_encode($response);
}
else{

	if(preg_match('/Server is currently down/i', $html)) {

		$response['error'] = 'Server ok,but no streaming!';
		echo json_encode($response);
	}
		
	else{

		preg_match('/Stream is up at ([0-9]+) kbps with <B>([0-9]+)/', $html, $match1);
		preg_match('/Title: <\/font><\/td><td><font class=default><b>(.*?)<\/b>/', $html, $match2);
		preg_match('/Peak: <\/font><\/td><td><font class=default><b>(.*?)<\/b>/', $html, $match3);
		preg_match('/Genre: <\/font><\/td><td><font class=default><b>(.*?)<\/b>/', $html, $match4);
		preg_match('/Song: <\/font><\/td><td><font class=default><b>(.*?)<\/b>/', $html, $match5);

		$response['error'] 		= '';
		$response['encoder'] 	= $match1[1];
		$response['listeners']= $match1[2];
		$response['title'] 		= $match2[1];
		$response['peak'] 		= $match3[1];
		$response['genre'] 		= $match4[1];
		$response['playing'] 	= $match5[1];
		

		echo json_encode($response);
	}

}

?>

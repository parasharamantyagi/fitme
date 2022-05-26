<?php

namespace App\Helper;

class PlivoSms
{
    const API_KEY = "AAAABrYZ0vA:APA91bGIzetw4t3PHJ3cx3UA8oAcDf-IouC1G6UDlSsf5dN7OKrR0sMUr2T1sjxLKNh5I-tzHoQrjmUa6EbrrWEZ5CSgoGgm_veRMewa5BT3-gkGaaDAfJIXr3jWZNSGcwcXod-8kBlW";
    
	public static function push_notification($token,$body,$type) {
		$url = "https://fcm.googleapis.com/fcm/send";
		$serverKey = self::API_KEY;
		$title = "Fit me";
		$notification = array('title' =>$title, 'type'=>$type, 'body' => $body, 'sound' => 'default', 'badge' => '1');
		$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
		$json = json_encode($arrayToSend);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		//Send the request
		$response = curl_exec($ch);
		//Close request
		if ($response === FALSE) {
		die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
		return $response;
	}

}

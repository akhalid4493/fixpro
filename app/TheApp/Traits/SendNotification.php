<?php

namespace App\TheApp\Traits;

use App\Models\DeviceToken;

trait SendNotification
{
    public  function send($data ,$tokens = null)
    {
        if (is_array($tokens)) {
            $tokens = array_values(array_unique($tokens));
        } else {
            $tokens = array($tokens);
        }

        $ios = DeviceToken::
        whereIn('device_token', $tokens)
        ->select('device_token')
        ->where('platform', 'IOS')
        ->groupBy('device_token')
        ->pluck('device_token');

        $android = DeviceToken::
        whereIn('device_token', $tokens)
        ->where('platform', 'ANDROID')
        ->groupBy('device_token')
        ->pluck('device_token');


        if ($ios) {
            $regIdIOS = array_chunk(json_decode($ios),999);

            foreach ($regIdIOS as $tokens) {
              $msg[] = $this->PushIOS($data,$tokens);
            }
        }

        if ($android) {
            $regIdIOS = array_chunk(json_decode($ios),999);

            foreach ($regIdIOS as $tokens) {
              $this->PushANDROID($data,$tokens);
            }
        }
    }

    public function PushIOS($data,$tokens)
    {
        $notification = [
          'title'    => $data['title'],
          'body'     => $data['body'],
          'sound'    => 'default',
          'priority' => 'high',
          'badge' => '0',
        ];

        $data = [
          "type"     => $data['type'],
          "id"       => $data['id'],
        ];

        $fields_ios = [
            'registration_ids' => $tokens,
            'notification'     => $notification,
            'data'             => $data,
        ];

        return $this->Push($fields_ios);
    }

    public function PushANDROID($data,$tokens)
    {
        $notification = [
          'title'    => $data['title'],
          'body'     => $data['body'],
          'sound'    => 'default',
          'priority' => 'high',
          "type"     => $data['type'],
          "id"       => $data['id'],
        ];

        $fields_android = [
            'registration_ids' => $tokens,
            'data'             => $notification
        ];

        return $this->Push($fields_android);
    }

    public function Push($fields)
    {
        	$url = 'https://fcm.googleapis.com/fcm/send';

        	$server_key = 'AAAA5hkpT9c:APA91bHDgPd3YL2OQZJXvW1DUUKNNSwdCX93WSvqQB7NZSWOZUx_qt1a6-7zpZWxUqiOrB3Z5FT38-nIWCC2TJkVgqQ50GcH6lYZu1hDEZLbNPiFrsN3Oowj16sRqB0RCQA7rggKhHF6';

        	$headers = array(
        		'Content-Type:application/json',
        		'Authorization:key='.$server_key
        	);

        	$ch = curl_init();
        	curl_setopt($ch, CURLOPT_URL, $url);
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        	$result = curl_exec($ch);
        	if ($result === FALSE) {
        		die('FCM Send Error: ' . curl_error($ch));
        	}
        	curl_close($ch);
        	return $result;
    	}
}

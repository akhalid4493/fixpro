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

        $ios = DeviceToken::whereIn('device_token', $tokens)
        ->where('platform', 'IOS')
        ->groupBy('device_token')
        ->pluck('device_token');

        $android = DeviceToken::whereIn('device_token', $tokens)
        ->where('platform', 'Android')
        ->groupBy('device_token')
        ->pluck('device_token');

        $notification = [
          'title'    => $data['title'],
          'body'     => $data['body'],
          'sound'    => 'default',
          'priority' => 'high',
          "type"     => $data['type'],
          "id"       => $data['id'],
        ];

        $fields_ios = [
            'registration_ids' => $ios,
            'notification'     => $notification
        ];

        $fields_android = [
            'registration_ids' => $android,
            'data'             => $notification
        ];

        if (count($fields_ios) > 0) {
            $this->Push($fields_ios);
        }
        if (count($fields_android) > 0) {
            $this->Push($fields_android);
        }

    }

    public function Push($fields)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization:key=AAAA5hkpT9c:APA91bHDgPd3YL2OQZJXvW1DUUKNNSwdCX93WSvqQB7NZSWOZUx_qt1a6-7zpZWxUqiOrB3Z5FT38-nIWCC2TJkVgqQ50GcH6lYZu1hDEZLbNPiFrsN3Oowj16sRqB0RCQA7rggKhHF6',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // echo json_encode($fields);

        $result = curl_exec($ch);           
        echo curl_error($ch);
         
        if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        
        return $result;
    }
}
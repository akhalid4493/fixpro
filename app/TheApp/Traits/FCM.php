<?php
namespace App\TheApp\Traits;

trait SendNotification
{
    public  function send($data ,$devices_id = null)
    {

      // if (is_array($devices_id)) {
      //     $tokens = array_values(array_unique($devices_id));
      // } else {
      //     $tokens = array($devices_id);
      // }

      $notification = [
        'title'    => $data['title'],
        'body'     => $data['body'],
        'sound'    => 'default',
        'priority' => 'high',
      ];

      $data = [
          "type" => $data['type'],
          "id"   => $data['id'],
      ];

      $fields = [
        'registration_ids' => $tokens,
        'notification'     => $notification,
        'data'             => $data,
      ];

      return $this->Push($fields);
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

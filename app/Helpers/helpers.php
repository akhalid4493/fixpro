<?php
use Illuminate\Support\Str;
use Carbon\Carbon;

if (!function_exists('checkBoxDelete')) {
    /**
     * Access the OrderStatus helper.
     */
    function checkBoxDelete($id)
    {
      return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                  <input type="checkbox" class="group-checkable" name="ids" value="'.$id.'">
                  <span></span>
              </label>';
    }      
}

if (!function_exists('checkSubsribe')) {
    /**
     * Access the checkSubsribe helper.
     */
    function checkSubsribe($date)
    {
      if ($date < date('Y-m-d')) {
        return '<span class="label label-danger circle" style="font-size:13px">
                  '.$date.'
               </span>';
      }else{
        return '<span class="label label-primary circle" style="font-size:13px">
                  '.$date.'
               </span>';
      }
    }
}

if (!function_exists('PreviewStatus')) {
    /**
     * Access the PreviewStatus helper.
     */
    function PreviewStatus($preview)
    {
      if ($preview->previewStatus->status_code == 'pending'){
        return '<span class="label label-primary circle" style="font-size:13px">
                  '.$preview->previewStatus->name_ar.'
               </span>';
      }elseif($preview->previewStatus->status_code == 'accepted'){
        return '<span class="label label-info circle" style="font-size:13px">
                  '.$preview->previewStatus->name_ar.'
               </span>';
      }elseif($preview->previewStatus->status_code == 'reached'){
        return '<span class="label label-success circle" style="font-size:13px">
                  '.$preview->previewStatus->name_ar.'
               </span>';
      }elseif($preview->previewStatus->status_code == 'completed'){
        return '<span class="label label-success circle" style="font-size:13px">
                  '.$preview->previewStatus->name_ar.'
               </span>';
      }elseif($preview->previewStatus->status_code == 'on_way'){
        return '<span class="label label-warning circle" style="font-size:13px">
                  '.$preview->previewStatus->name_ar.'
               </span>';
      }elseif($preview->previewStatus->status_code == 'canceled'){
        return '<span class="label label-danger circle" style="font-size:13px">
                  '.$preview->previewStatus->name_ar.'
               </span>';
      }
      
    }
}

if (!function_exists('OrderStatus')) {
    /**
     * Access the OrderStatus helper.
     */
    function OrderStatus($order)
    {
      if ($order->orderStatus->status_code == 'pending'){
        return '<span class="label label-primary circle" style="font-size:13px">
                  '.$order->orderStatus->name_ar.'
               </span>';
        
      }elseif($order->orderStatus->status_code == 'accepted_user'){
        return '<span class="label label-info circle" style="font-size:13px">
                  '.$order->orderStatus->name_ar.'
               </span>';
      }elseif($order->orderStatus->status_code == 'cancelled_user'){
        return '<span class="label label-success circle" style="font-size:13px">
                  '.$order->orderStatus->name_ar.'
               </span>';
      }elseif($order->orderStatus->status_code == 'payment_succ'){
        return '<span class="label label-info circle" style="font-size:13px">
                  '.$order->orderStatus->name_ar.'
               </span>';
      }elseif($order->orderStatus->status_code == 'payment_failed'){
        return '<span class="label label-danger circle" style="font-size:13px">
                  '.$order->orderStatus->name_ar.'
               </span>';
      }
      
    }
}

if (!function_exists('SubscribeAds')) {
    /**
     * Access the SubscribeAds helper.
     */
    function SubscribeAds($ad)
    {
      if ($ad->hasSubscribe == null){
        return '<span class="label label-danger circle" style="font-size:13px">
                  غير مشترك
               </span>';
        
      }elseif($ad->hasSubscribe !=  null){

        if($ad->hasSubscribe->subscribe_end < date('Y-m-d')){
          return '<span class="label label-warning circle" style="font-size:13px">
                  '.$ad->hasSubscribe->subscribe_end.'
               </span>';
        }else{
          return '<span class="label label-success circle" style="font-size:13px">
                  '.$ad->hasSubscribe->subscribe_end.'
               </span>';
        }
        
      }
      
    }
}

if (!function_exists('subcriber')) {
    /**
     * Access the subcriber helper.
     */
    function subcriber($store)
    {
      if ($store->hasSubscribe == null){
        return '<span class="label label-danger circle" style="font-size:13px">
                  غير مشترك
               </span>';
        
      }elseif($store->hasSubscribe !=  null){

        if($store->hasSubscribe->subscribe_end < date('Y-m-d')){
          return '<span class="label label-warning circle" style="font-size:13px">
                  الاشتراك منتهي
               </span>';
        }else{
          return '<span class="label label-success circle" style="font-size:13px">
                  مشترك
               </span>';
        }
        
      }
      
    }
}

if (!function_exists('Price')) {
    /**
     * Access the Price helper.
     */
    function Price($price)
    {
      return number_format($price,3,'.','');
    }
}

if (!function_exists('Label')) {
    /**
     * Access the Price helper.
     */
    function Label($data,$color)
    {
      return 
            '<span class="label label-lg '.$color.' circle" style="font-size:13px">
                  '.$data.'
             </span>';
    }
}

if (!function_exists('ScreenShots')) {

    function ScreenShots($type=null)
    {
      if ($type == 'one') {
        return Screenshot::first();
      }

      return Screenshot::all();
    }
}


if (!function_exists('Status')) {
    /**
     * Access the Status helper.
     */
    function Status($status)
    {
      if ($status == 0)
      {
        return '<span class="label label-danger circle" style="font-size:13px">
                  غير مفعل
               </span>';
        
      }elseif($status == 1)
      {
        return '<span class="label label-success circle" style="font-size:13px">
                  مفعل
               </span>';
      }
      
    }
}


function btn($type,$permission,$route, $count=null){

  $button = '';

  // Return Show Row Input
    if($type == 'show'){
      if (Auth::user()->can($permission)) {
          $button = "&emsp;<a class='btn btn-sm btn-warning' href=".$route.">
                              <i class='fa fa-eye'></i>
                            </a>";
      }
    }

  // Return Edit Row Input
    if ($type == 'edit') {
      if (Auth::user()->can($permission)) {
          $button = "&emsp;<a class='btn btn-sm blue' href=".$route.">
                              <i class='fa fa-edit'></i>
                            </a>";
      }
    }

    // Return DELETE Row Input
    if($type == 'delete'){
      if (Auth::user()->can($permission)) {
          $button='&emsp;<a class="btn btn-sm red" onclick="deleteRow(\''.$route.'\')">
                            <i class="fa fa-trash-o"></i>
                          </a>'.'
                          '.csrf_field();
      }
    }

    if($type == 'gallery'){
      if (Auth::user()->can($permission)) {
          $button ="&emsp;<a class='btn btn-sm yellow' href=".$route.">
                            ".count($count)." <i class='fa fa-photo'></i>
                          </a>";
      }
    }

   return $button;
}


function dateFormat($date){

  $newFormat = date('d-m-Y , h:i a',strtotime($date));
  return $newFormat;

}



function ar_slug($string, $separator = '-')
{
  $string = trim($string);
  $string = mb_strtolower($string, 'UTF-8');

 $string = preg_replace("/[^a-z_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى١٢٣٤٥٦٧٨٩٠1234567890#]/u", '', $string);

  $string = preg_replace("/[\s-_]+/", ' ', $string);

  $string = preg_replace("/[\s_]/", $separator, $string);

  return $string;
}


function transText($data , $column , $lang = null)
{
  if ($lang == null)
    $lang = app()->getLocale();

  $textTrans = $column.'_'.$lang;

  return $data->$textTrans;
}

function makeTrans($column)
{
  $lang = app()->getLocale();

  $textTrans = $column.'_'.$lang;

  return $textTrans;
}


function addToJson($ar , $en)
{
  $text = [
            'en' => $en,
            'ar' => $ar,
        ];

  $json = json_encode($text , JSON_UNESCAPED_UNICODE);

  return $json;
}


function shortDescrip($descrip , $numb)
{
  $desc = Str::words(strip_tags($descrip) , $numb ,' ....');
  return $desc;
}

function activeMenu($url)
{
  if ($url == Request::url()) {
    return true;
  }

  return false;
  
  // return strstr(request()->path(), $uri);
}



if (!function_exists('settings')) {
    /**
     * Access the settings helper.
     */
    function settings($name)
    {
        return $settings = Settings::getValue($name);
    }
}



if (!function_exists('transDate')) {
    /**
     * Access the transDate helper.
     */
    function transDate($date)
    {
      if (app()->getLocale() == "ar") {
        return ArabicDate($date);
      }

      return $date;
    }
}

if (!function_exists('ArabicDate')) {
    /**
     * Access the transDate helper.
     */
    function ArabicDate($date) {

      header('Content-Type: text/html; charset=utf-8');

      $months = array("Jan" => "يناير", 
              "Feb" => "فبراير", 
              "Mar" => "مارس", 
              "Apr" => "أبريل", 
              "May" => "مايو", 
              "Jun" => "يونيو", 
              "Jul" => "يوليو", 
              "Aug" => "أغسطس", 
              "Sep" => "سبتمبر", 
              "Oct" => "أكتوبر", 
              "Nov" => 
              "نوفمبر", 
              "Dec" => 
              "ديسمبر");

      $standard = array("0","1","2","3","4","5","6","7","8","9");
      $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");

      $theDate = $date; // The Current Date

      $en_day   = date("d", strtotime($theDate));
      $en_month = date("M", strtotime($theDate));
      $en_year  = date("Y", strtotime($theDate));

      foreach ($months as $en => $ar) {
          if ($en == $en_month) 
             $ar_month = $ar;
      }

      $current_date = $en_day .'/' .$ar_month. '/' .$en_year;

      $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);

      return $arabic_date;
  }
}



 if (!function_exists('timeStampeConverter')) {
    /**
     * Access the timeStampeConverter helper.
     */
    function timeStampeConverter($date)
    {
        $datetime = $date;
        $string   =str_replace("-"," ",$datetime);
        $datetime =  preg_replace('/( \(.*)$/','',$string);

        $date = new DateTime($datetime);
        $zone = $date->getTimezone();

        return $date->format('Y-m-d H:i:s');

    }
}
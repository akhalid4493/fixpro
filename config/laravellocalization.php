<?php

return [


    'supportedLocales' => [
        'ar'=>['name'=>'Arabic','script' => 'Arab', 'native' => 'العربية', 'regional' => 'ar_AE'],
        'en'=>['name'=>'English','script' => 'Latn', 'native'=> 'English', 'regional' => 'en_GB'],
        
    ],

    'useAcceptLanguageHeader' => false,
    'hideDefaultLocaleInURL' => false,

    // If you want to display the locales in particular order in the language selector you should write the order here. 
    //CAUTION: Please consider using the appropriate locale code otherwise it will not work
    //Example: 'localesOrder' => ['es','en'],
    'localesOrder' => [],

];

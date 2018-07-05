<?php
/*************************************************************************************************************************
* Author: Riccardo Castagna MBA, PHP developer - Palermo (ITALY) https://api.whatsapp.com/send?phone=393315954155         *
* This php package solves the problem to charge an external font resource                                                 *
* with the "controlling font performance" using font-display options.                                                     *
* This option is useful, to fast load the external font and in general to have the control over browser behavioral        *
* and, in particular, over how the different browsers have to load the external font.                                     *
* This option is useful to make all text remains visible during web font loads,                                           *
* leveraging the font-display CSS feature to ensure text is user-visible while web fonts are loading.                     *
* At the moment is no possible to add at any external font resource the font-display options,                             *
* when you call the query, for example, through google font API:                                                          *
* "https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500"                                             *
* and you wish to add the descriptor param: "&font-display=fallback"                                                      *
* making something like this query:                                                                                       *
* "https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500&font-display=fallback".                      *
* As far as I know, Google has not yet solved this issue and, to work,                                                    *
* the "font-display" descriptor option must be inserted as param inside the css function @font-face{}.                    *
* A possible way is, to use the php cURL extension to manipulate this external resourse and add                           *
* the font-display option param inside the css function.                                                                  *
* And also, very important thing, if the external resource is charged through server side,                                *
* the client side gain. Working on localhost, obviously, the thing is imperceptible because on localhost server and       * 
* client are the same device.                                                                                             *
* With this tecnique is also possible to manipulate, more or less, everything; others external resource and API like:     *
* google-map, file css, file js, jquery, what do you want, with the aim to lighten the client's operations and also       *
* to hide any API keys.                                                                                                   *                                                            
* How you can see, I have used the curl_multi_init() istead of curl_init(), this because, probably, in the future         *
* I will add some other external resource to be loaded simultaneously, changing something in the main class.              *
* CLASS USAGE:                                                                                                            *
* $ref= new Fontperformance;                                                                                              *
* $ref->fontdisplay("https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500","fallback");              *
* Where param 1 is a string, is the link to external font resource, in this example by google font.                       *
* param 2 is a string, is the performance controlling option. Possible values are:                                        *
* auto | block | swap | fallback | optional                                                                               *
* For a complete reference guide and option usage please consult:                                                         *
* https://developers.google.com/web/updates/2016/02/font-display                                                          *
**************************************************************************************************************************/

class Fontperformance{

private function set_option($x, $y){
curl_setopt($x, CURLOPT_URL,  $y);
curl_setopt($x, CURLOPT_HEADER, 0);
curl_setopt($x, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($x, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($x, CURLOPT_ENCODING, "gzip,deflate");
}

private function sslresolve(){
if (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
$http = "https://";    
} else {$http = "http://";} 
return $http;
}

private function linkresolve($fontlink){
$arr_1 = array("https://","http://");
$arr_2 = array("","");
$link = str_replace($arr_1,$arr_2,$fontlink);
return $link; 
}


private function optionresolve($option){
switch ($option) {
    case "auto":
        $op = $option; 
        break;
    case "block":
        $op = $option; 
        break;
    case "swap":
        $op = $option; 
        break;
    case "fallback":
         $op = $option; 
        break;
    case "optional":
        $op = $option; 
        break;        
    default:
        $op = "auto";
    echo "<p>You have set up a no correct value for font-display. Correct possible values are: auto | block | swap | fallback | optional  
          </p>
          <p>For a complete reference guide please consult: 
              <a href='https://developers.google.com/web/updates/2016/02/font-display'>Controlling Font Performance with font-display
              </a>              
          </p>";
    break; 
}
return $op;  
}


public function fontdisplay($fontlink,$option){
$fontoption=$this->optionresolve($option); 
$ssl = $this->sslresolve();
$externalfont = $this->linkresolve($fontlink); 
$ch1 = curl_init();  
$this->set_option($ch1, $ssl.$externalfont);
$mh = curl_multi_init();
curl_multi_add_handle($mh, $ch1); 
$running = null;
do {
curl_multi_exec($mh, $running);
} while ($running);
curl_multi_remove_handle($mh, $ch1);
curl_multi_close($mh);
$font = curl_multi_getcontent($ch1);
$fontdisplayoption = str_replace("@font-face {","@font-face {\n font-display: ".$fontoption.";" , $font );
return $fontdisplayoption;                
}

}



?>
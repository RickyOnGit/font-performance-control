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
* Also with the alternative method using @import url(//fonts.googleapis.com/css?family=Open+Sans); inside css you are     *
* not able to set up the values for font-display. And not even, I think I'm not wrong (I gave only a quick                *
* look at this library), with the JavaScript library:                                                                     *
* Web Font Loader: https://developers.google.com/fonts/docs/webfont_loader                                                *
* At the moment the only way is the manual set up for each                                                                *
* css element: p {font-family: 'MyWebFont', fallback, sans-serif;}                                                        *
* As far as I know, google or someone else has not yet solved this issue and, to work,                                    *
* the "font-display" descriptor option must be inserted as value inside the css function @font-face{...}.                 *
*                                                                                                                         *
* A possible way is, to use the PHP to manipulate this external resourse and add                                          *
* the font-display option param inside the css function, moreover, in this way, the API keys, when these are necessary,   *
* will be hidden.                                                                                                         *                                                            
* With this php class there is also the possibility (VIEW:ADVANCED CLASS USAGE EXAMPLE N°2 FILE: INDEX_2.PHP)             *
* to load the external fonts (TEN MAXIMUM, PLEASE) all together simultaneously, it is faster but it must be used          *
* with extreme  caution and with common sense, example file: index_2.php.                                                 *
* Ten fonts simultaneously is enough AND, PLEASE, NOT FROM ONLY ONE SERVER if we                                          *
* want to avoid to commute this demo into a cyber attack to google servers, and if we want to prevent                     *
* google killing me and you; I joke, obviously, I joke ... ;)                                                             *
* But, obviously, no one load ten fonts simultaneously in only one page. For testing, in the example N°2, fl. index_2.php *
* by forcing the test, I have loaded seven different font simultaneously from only one server,                            *
* seven are too much, but I did it only for testing to show                                                               *
* that also in this case, with seven different fonts loaded simultaneously, all text remains visible with                 *
* the set up of the font-display during web fonts load.                                                                   *
*                                                                                                                         *
* To avoid the critical request chain  https://developers.google.com/web/tools/lighthouse/audits/critical-request-chains  *
* I have set up to defer (load asynchronously) the style with a small escamotage:                                         *
* <style media="none" onload="if(media!='all')media='all'" >                                                              *
* The ligthhouse report of this demo with seven fonts loaded simultaneously is:                                           *
* https://googlechrome.github.io/lighthouse/viewer/?gist=798a57975a8555b6417a09446ce50b09                                 *                                                                                      *
*                                                                                                                         *
* SIMPLE CLASS USAGE EXAMPLE N°1 FILE: INDEX.PHP (NO SIMULTANEOUSLY)                                                      *
* $ref= new Fontperformance;                                                                                              *
* $font_1 = $ref->fontdisplay("link_to_font_api","fallback");                                                             *
* $font_2 = $ref->fontdisplay("link_to_font_api","auto");                                                                 *
* Where param 1 is a string, is the link to external font resource, in this example through google font api.              *
* param 2 is a string, is the performance controlling option. Possible values are:                                        *
* auto | block | swap | fallback | optional                                                                               *
*                                                                                                                         *
* ADVANCED CLASS USAGE EXAMPLE N°2 FILE: INDEX_2.PHP (SIMULTANEOUSLY)                                                     *
* $ref= new Fontperformance;                                                                                              *
* $apilink = array("link_to_font_api_1","link_to_font_api_n", ....);                                                      *
* $ref->multi_simul_fontdisplay($apilink,"fallback" );                                                                    *
* where the params1 is an array with all links to the font api                                                            *
* and where the param 2 is a string, is the performance controlling option. Possible values are:                          *
* auto | block | swap | fallback | optional , this will return an array with all fonts.                                   *                                             *
* PLEASE DO NOT FOLLOW MY BAD EXAMPLE, DON'T LOAD MORE THAN TWO MAXIMUM DIFFERENT FONTS SIMULTANEOUSLY                    *
*                                                                                                                         *
* For a complete reference guide about font-display descriptor values please consult:                                     *
* https://developers.google.com/web/updates/2016/02/font-display                                                          *
**************************************************************************************************************************/

class Fontperformance{

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

private function fontfaceresolve($opt,$source){
$str = str_replace("@font-face {","@font-face {\n font-display: ".$opt.";" , $source );
return $str;
}

private function set_option($x, $y){
curl_setopt($x, CURLOPT_URL,  $y);
curl_setopt($x, CURLOPT_HEADER, 0);
curl_setopt($x, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($x, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($x, CURLOPT_ENCODING, "gzip,deflate");
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
$fontdisplayoption = $this->fontfaceresolve($fontoption,$font);
return $fontdisplayoption;                
}


public function multi_simul_fontdisplay($paramfont,$paramoption){
if ((is_array($paramfont))&&(isset($paramoption))) {
$ssl = $this->sslresolve();
$n = count($paramfont);
$q = count($paramoption);
if(($n>0)&&($q==1)){
$running = null;
$ch = array();
$font = array();
$fontoption = array();
$multifont = array();

$fontoption[0]=$this->optionresolve($paramoption);
$externalfont[0] = $this->linkresolve($paramfont[0]);
$ch[0] = curl_init();
$this->set_option($ch[0], $ssl.$externalfont[0]);
$mh = curl_multi_init();
curl_multi_add_handle($mh, $ch[0]);
 
$m=1;
foreach ($paramfont as $k => $fontvalue){
if($k!=0){          
$fontoption[$m]=$this->optionresolve($paramoption);
$externalfont[$m] = $this->linkresolve($fontvalue);
$ch[$m] = curl_init();  
$this->set_option($ch[$m], $ssl.$externalfont[$m]); 
curl_multi_add_handle($mh, $ch[$m]); 
$m++;
}
}

do { 
curl_multi_exec($mh, $running); 
} while ($running);

$x = 0;
foreach ($ch as $chvalue){
$font[$x] = curl_multi_getcontent($chvalue);
curl_multi_remove_handle($mh, $chvalue);
$x++;
}

$y = 0;
foreach($fontoption as $fontoptionval ){
foreach($font as $fontvalor ){
$multifont[$y] = $this->fontfaceresolve($fontoptionval,$fontvalor);
$y++; 
}
} 
curl_multi_close($mh);
}
}
return $multifont; 
}

}
?>
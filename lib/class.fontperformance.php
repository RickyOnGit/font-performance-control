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
* A possible way is, to use the php cURL extension to manipulate this external resourse and add                           *
* the font-display option param inside the css function.                                                                  *
* And also, very important thing, if the external resource is charged through server side,                                *
* the client side gain.                                                                                                   *
* With this tecnique is also possible to manipulate, more or less, everything with the aim to lighten                     *
* the client's operations and also with the possibility to hide any API keys when these are necessary.                    *                                                            
* How you can see, I have used the curl_multi_init(), this because, with this class there is also the possibility         *
* to load the external fonts (ten maximum) all together simultaneously, it is faster but it must be used with extreme     *
* caution and with common sense, example file: index_2.php.                                                               *
* I have set up a maximum of ten fonts simultaneously, ten is enough AND, PLEASE, NOT FROM ONLY ONE SERVER if we          *
* want to avoid to commute this demo into a cyber attack to google servers, and if we want to prevent                     *
* google killing me and you; I joke, obviously, I joke ... ;)                                                             *
* But, obviously, no one load ten fonts simultaneously in only one page. For testing, in the example N°2, fl. index_2.php *
* by forcing, I have loaded seven different font simultaneously from only one server,                                     *
* seven are too much, but I did it only for testing to show                                                               *
* that also in this case, with seven different fonts loaded simultaneously, all text remains visible with                 *
* the set up of the font-display during web fonts load.                                                                   *
* To avoid the critical request chain  https://developers.google.com/web/tools/lighthouse/audits/critical-request-chains  *
* I have set up to defer (load asynchronously) the style with a small escamotage:                                         *
* <style media="none" onload="if(media!='all')media='all'" >                                                              *
* The ligthhouse report of this demo with seven fonts loaded simultaneously is:                                           *
* https://googlechrome.github.io/lighthouse/viewer/?gist=798a57975a8555b6417a09446ce50b09                                 *                                                                                      *
*                                                                                                                         *
* SIMPLE CLASS USAGE EXAMPLE N°1 FILE: INDEX.PHP (NO SIMULTANEOUSLY)                                                      *
* $ref= new Fontperformance;                                                                                              *
* $ref->fontdisplay("https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500","fallback");              *
* Where param 1 is a string, is the link to external font resource, in this example through google font api.              *
* param 2 is a string, is the performance controlling option. Possible values are:                                        *
* auto | block | swap | fallback | optional                                                                               *
*                                                                                                                         *
* ADVANCED CLASS USAGE EXAMPLE N°2 FILE: INDEX_2.PHP (SIMULTANEOUSLY)                                                     *
* $ref= new Fontperformance;                                                                                              *
* $ref->multi_simul_fontdisplay("link_1","option_1","link_2","option_2","link_n","option_n", ... );                       *
* where the params: link_1, link_2, link_n ... are "strings", are the links to external font resources                    *
* and where the paramas: option_1, option_2, option_n ... are the related options                                         *
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

public function multi_simul_fontdisplay($fontlink_1,$option_1,$fontlink_2='',$option_2='',$fontlink_3='',$option_3='',$fontlink_4='',$option_4='',
$fontlink_5='',$option_5='', $fontlink_6='',$option_6='', $fontlink_7='', $option_7='',$fontlink_8='',$option_8='',
$fontlink_9='',$option_9='',$fontlink_10='',$option_10=''){

$fontoption_1=$this->optionresolve($option_1);
$ssl = $this->sslresolve();
$externalfont_1 = $this->linkresolve($fontlink_1);
$ch1 = curl_init();  
$this->set_option($ch1, $ssl.$externalfont_1);
$mh = curl_multi_init();
curl_multi_add_handle($mh, $ch1);  

if (($option_2!='')&&($fontlink_2!='')){
$fontoption_2=$this->optionresolve($option_2);
$externalfont_2 = $this->linkresolve($fontlink_2);
$ch2 = curl_init();  
$this->set_option($ch2, $ssl.$externalfont_2);
curl_multi_add_handle($mh, $ch2);  
}

if (($option_3!='')&&($fontlink_3!='')){
$fontoption_3=$this->optionresolve($option_3);
$externalfont_3 = $this->linkresolve($fontlink_3);
$ch3 = curl_init();  
$this->set_option($ch3, $ssl.$externalfont_3);
curl_multi_add_handle($mh, $ch3);  
}

if (($option_4!='')&&($fontlink_4!='')){
$fontoption_4=$this->optionresolve($option_4);
$externalfont_4 = $this->linkresolve($fontlink_4);
$ch4 = curl_init();  
$this->set_option($ch4, $ssl.$externalfont_4);
curl_multi_add_handle($mh, $ch4);  
}

if (($option_5!='')&&($fontlink_5!='')){
$fontoption_5=$this->optionresolve($option_5);
$externalfont_5 = $this->linkresolve($fontlink_5);
$ch5 = curl_init();  
$this->set_option($ch5, $ssl.$externalfont_5);
curl_multi_add_handle($mh, $ch5);  
}

if (($option_6!='')&&($fontlink_6!='')){
$fontoption_6=$this->optionresolve($option_6);
$externalfont_6 = $this->linkresolve($fontlink_6);
$ch6 = curl_init();  
$this->set_option($ch6, $ssl.$externalfont_6);
curl_multi_add_handle($mh, $ch6);  
}

if (($option_7!='')&&($fontlink_7!='')){
$fontoption_7=$this->optionresolve($option_7);
$externalfont_7 = $this->linkresolve($fontlink_7);
$ch7 = curl_init();  
$this->set_option($ch7, $ssl.$externalfont_7);
curl_multi_add_handle($mh, $ch7);  
}

if (($option_8!='')&&($fontlink_8!='')){
$fontoption_8=$this->optionresolve($option_8);
$externalfont_8 = $this->linkresolve($fontlink_8);
$ch8 = curl_init();  
$this->set_option($ch8, $ssl.$externalfont_8);
curl_multi_add_handle($mh, $ch8);  
}

if (($option_9!='')&&($fontlink_9!='')){
$fontoption_9=$this->optionresolve($option_9);
$externalfont_9 = $this->linkresolve($fontlink_9);
$ch9 = curl_init();  
$this->set_option($ch9, $ssl.$externalfont_9);
curl_multi_add_handle($mh, $ch9);  
}

if (($option_10!='')&&($fontlink_10!='')){
$fontoption_10=$this->optionresolve($option_10);
$externalfont_10 = $this->linkresolve($fontlink_10);
$ch10 = curl_init();  
$this->set_option($ch10, $ssl.$externalfont_10);
curl_multi_add_handle($mh, $ch10);  
}
$running = null;
do {
curl_multi_exec($mh, $running);
} while ($running);

curl_multi_remove_handle($mh, $ch1);

if (isset($ch2)){
curl_multi_remove_handle($mh, $ch2);
}
if (isset($ch3)){
curl_multi_remove_handle($mh, $ch3);
}
if (isset($ch4)){
curl_multi_remove_handle($mh, $ch4);
}
if (isset($ch5)){
curl_multi_remove_handle($mh, $ch5);
}
if (isset($ch6)){
curl_multi_remove_handle($mh, $ch6);
}
if (isset($ch7)){
curl_multi_remove_handle($mh, $ch7);
}
if (isset($ch8)){
curl_multi_remove_handle($mh, $ch8);
}
if (isset($ch9)){
curl_multi_remove_handle($mh, $ch9);
}
if (isset($ch10)){
curl_multi_remove_handle($mh, $ch10);
}

curl_multi_close($mh);

$font_1 = curl_multi_getcontent($ch1);
$fontdisplayoption_1 = $this->fontfaceresolve($fontoption_1,$font_1);   

if (isset($ch2)){
$font_2 = curl_multi_getcontent($ch2);
$fontdisplayoption_2 = $this->fontfaceresolve($fontoption_2,$font_2); 
} else {$fontdisplayoption_2 ='';}

if (isset($ch3)){
$font_3 = curl_multi_getcontent($ch3);
$fontdisplayoption_3 = $this->fontfaceresolve($fontoption_3,$font_3); 
} else {$fontdisplayoption_3 ='';}

if (isset($ch4)){
$font_4 = curl_multi_getcontent($ch4);
$fontdisplayoption_4 = $this->fontfaceresolve($fontoption_4,$font_4); 
} else {$fontdisplayoption_4 ='';}

if (isset($ch5)){
$font_5 = curl_multi_getcontent($ch5);
$fontdisplayoption_5 = $this->fontfaceresolve($fontoption_5,$font_5); 
} else {$fontdisplayoption_5 ='';}

if (isset($ch6)){
$font_6 = curl_multi_getcontent($ch6);
$fontdisplayoption_6 = $this->fontfaceresolve($fontoption_6,$font_6); 
} else {$fontdisplayoption_6 ='';}

if (isset($ch7)){
$font_7 = curl_multi_getcontent($ch7);
$fontdisplayoption_7 = $this->fontfaceresolve($fontoption_7,$font_7); 
} else {$fontdisplayoption_7 ='';}

if (isset($ch8)){
$font_8 = curl_multi_getcontent($ch8);
$fontdisplayoption_8 = $this->fontfaceresolve($fontoption_8,$font_8); 
} else {$fontdisplayoption_8 ='';}

if (isset($ch9)){
$font_9 = curl_multi_getcontent($ch9);
$fontdisplayoption_9 = $this->fontfaceresolve($fontoption_9,$font_9); 
} else {$fontdisplayoption_9 ='';}

if (isset($ch10)){
$font_10 = curl_multi_getcontent($ch10);
$fontdisplayoption_10 = $this->fontfaceresolve($fontoption_10,$font_10); 
} else {$fontdisplayoption_10 ='';}

$multifont = array($fontdisplayoption_1,$fontdisplayoption_2,$fontdisplayoption_3,$fontdisplayoption_4,$fontdisplayoption_5,$fontdisplayoption_6,
$fontdisplayoption_7,$fontdisplayoption_8,$fontdisplayoption_9,$fontdisplayoption_10);
return $multifont; 
}

}



?>
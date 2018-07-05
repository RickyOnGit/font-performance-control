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
include_once("./lib/class.fontperformance.php"); 
$ref= new Fontperformance;
$font_display = $ref->fontdisplay("https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500","fallback");
$font_display_2 = $ref->fontdisplay("https://fonts.googleapis.com/css?family=Rancho","fallback");
?>
<!DOCTYPE html>
<html lang='it'>
  <head>
    <title>Controlling Font Performance with font-display</title>
    <meta charset='utf-8'>
    <meta name='description' content='Controlling Font Performance with font-display'>
    <meta name='keywords' content='Font Performance font-display'>
    <meta name='author' content='Riccardo Castagna'>
    <meta name='robots' content='all'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta http-equiv='X-UA-Compatible' content='IE=edge'> -->
    <link href='./php-icon.png' rel='shortcut icon' type='image/png'>
<style>
<?php echo $font_display, $font_display_2;  ?>
body { 
margin: 0px;
padding: 0px;
}
h1 {font-family:"Rancho";} 
p {font-family:"Montserrat Alternates";}
h1{
font-size: 35px;
text-align: center;
}
p {
font-size: 16px;
font-weight: 300;  
}
.title{
width:100%;
}
</style>
</head>
  <body>
   <div class="title">
     <h1>Controlling Font Performance with font-display</h1>
   </div>
    <p>This php package solves the problem to charge an external font resource 
        with the <strong>"controlling font performance"</strong> using <strong>font-display</strong> options.<br>
        This option is useful, to fast load the external font and in general to have the control over browser behavioral
        and, in particular,<br> over how the different browsers have to load the external font.<br>                                
        This option is useful to make all text remains visible during web font loads,<br>                                           
        leveraging the font-display CSS feature to ensure text is user-visible while web fonts are loading.<br><br>  
        At the moment is no possible to add at any external font resource the font-display options,<br> 
        when you call the query, for example, through google font API:<br>
        "https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500" <br>
        and you wish to add the descriptor param: "&font-display=fallback" <br>
        making something like this query:<br>"https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500&font-display=fallback"<br><br> 
        As far as I know, Google has not yet solved this issue and, to work,<br> 
        the "font-display" descriptor option must be inserted as param inside the css function @font-face{}.<br>   
        A possible way is, to use the php cURL extension to manipulate this external resourse and add 
        the font-display option param inside the css function.<br> And also, very important thing, if the external resource is charged through server side, 
        the client side gain.<br> Working on localhost, obviously, the thing is imperceptible because on localhost, server and client are the same device.<br><br>
        With this tecnique is also possible to manipulate, more or less, everything; others external resource and API like:<br> google-map, file css, 
        file js, jquery, what do you want, with the aim to lighten the client's operations and also to hide any API keys.<br><br> 
        How you can see, I have used the curl_multi_init() istead of curl_init(),<br> this because, probably, in the future I will add some 
        other external resource to be loaded simultaneously, changing something in the main class.<br><br>
        <strong>CLASS USAGE:</strong><br> 
        <strong>$ref= new Fontperformance;</strong><br>
        <strong>$ref->fontdisplay("https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500","fallback");</strong><br><br>
        Where param 1 is a string, is the link to external font resource, in this example through google font api.<br>
        param 2 is a string, is the performance controlling option. Possible values are:<br>
        <strong>auto | block | swap | fallback | optional</strong><br><br> 
        For a complete reference guide about font-display descriptors please consult:<br> 
        <a href="https://developers.google.com/web/updates/2016/02/font-display">Controlling Font Performance with font-display
        </a><br>
        <a href="https://www.w3.org/TR/css-fonts-4/#font-display-font-feature-values">W3C font display</a><br><br>
        <a href="https://api.whatsapp.com/send?phone=393315954155">info & contacts</a>  
    </p> 
  </body>
</html>
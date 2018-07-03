<h1>Author: Riccardo Castagna MBA, PHP developer - Palermo (ITALY) <a href=https://api.whatsapp.com/send?phone=393315954155>contact</a></h1>
<p>This php class solves the problem to charge an external font resource 
with the <strong>"controlling font performance"</strong> using <strong>font-display</strong> options.<br>
This option is useful, to fast load the external font and in general to have the control over browser behavioral and, in particular, over how the
browser has to load the external font.<br><br>  
At the moment is no possible to add at any external font resource the font-display options,<br> 
when you call the query, for example, of google font:<br>
"https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500" <br>
and you wish to add the param: "&font-display=fallback" <br>
like this: "https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500&font-display=fallback" <br> 
As far as I know, Google has not yet solved this issue and, to work, 
the "font-display" option must be inserted as param within the css function @font-face{}.<br>   
A possible way is, to use the php cURL extension to manipulate this external resourse and add 
the font-display option param inside the css function. And also, very important thing, if the external resource is charged by server side, 
the client side gain. Working on localhost, obviously, the thing is imperceptible because on localhost, server and client are the same device.<br><br>
With this tecnique is also possible to manipulate, more or less, everything; others external resource like: 
google-map, file css, file js, jquery, what do you want ...<br><br> 
How you can see, I have used the curl_multi_init() istead of curl_init(), this to make you free to change, if you wish, the php class and 
to add more than one font resource.<br><br>
CLASS USAGE:<br> 
$ref= new Fontperformance;<br>
$ref->fontdisplay("https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500","fallback");<br>
Where param 1 is a string, is the link to external font resource, in this example by google font.<br>
param 2 is a string, is the performance controlling option. Possible values are:<br>
 auto | block | swap | fallback | optional<br> 
For a complete reference guide and option usage please consult:<br> 
<a href="https://developers.google.com/web/updates/2016/02/font-display">Controlling Font Performance with font-display</a>  
</p> 

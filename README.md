<h1>Author: Riccardo Castagna MBA, PHP developer - Palermo (ITALY) </h1>
<p>This php class solves the problem to charge an external font resource 
with the <strong>"controlling font performance"</strong> using <strong>font-display</strong> options.<br>
This option is useful, to fast load the external font and in general to have the control over browser behavioral
and, in particular,<br> over how the different browsers have to load the external font.<br>                                
This option is useful to make all text remains visible during web font loads,<br>                                           
leveraging the font-display CSS feature to ensure text is user-visible while web fonts are loading.<br><br>  
At the moment is no possible to add at any external font resource the font-display options,<br> 
when you call the query, for example, through google font API:<br>
"https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500" <br>
and you wish to add the descriptor param: "&font-display=fallback" <br>
making something like this: "https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500&font-display=fallback".<br> 
As far as I know, Google has not yet solved this issue and, to work, 
the "font-display" descriptor option must be inserted as param inside the css function @font-face{}.<br>   
A possible way is, to use the php cURL extension to manipulate this external resourse and add 
the font-display option param inside the css function. And also, very important thing, if the external resource is charged through server side, the client side gain. 
Working on localhost, obviously, the thing is imperceptible because on localhost, server and client are the same device.<br><br>
With this tecnique is also possible to manipulate, more or less, everything; others external resource and API like:     
google-map, file css, file js, jquery, what do you want, with the aim to lighten the client's operations and also       
to hide any API keys.                                       
How you can see, I have used the curl_multi_init() istead of curl_init(), this because, probably, in the future         
I will add some other external resource to be loaded simultaneously..<br><br>
<strong>CLASS USAGE:</strong><br> 
$ref= new Fontperformance;<br>
$ref->fontdisplay("https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500","fallback");<br>
Where param 1 is a string, is the link to external font resource, in this example by google font.<br>
param 2 is a string, is the performance controlling option. Possible values are:<br>
 auto | block | swap | fallback | optional<br> 
For a complete reference guide about font-display descriptor please consult:<br> 
<a href="https://developers.google.com/web/updates/2016/02/font-display">Controlling Font Performance with font-display</a><br>
<a href="https://www.w3.org/TR/css-fonts-4/#font-display-font-feature-values">W3C font display</a><br><br>
<a href="https://api.whatsapp.com/send?phone=393315954155">Info & Contacts</a> 
</p> 

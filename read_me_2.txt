This php package solves the problem to charge an external font resource
with the "controlling font performance" using font-display options.

This option is useful, to fast load the external font and in general to have the control over browser behavioral
and, in particular,
over how the different browsers have to load the external font.
This option is useful to make all text remains visible during web font loads,
leveraging the font-display CSS feature to ensure text is user-visible while web fonts are loading.



At the moment is no possible to add at any external font resource the font-display options,
when you call the query, for example, through google font API:
"https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500"
and you wish to add the descriptor param: "&font-display=fallback"
making something like this query:
"https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500&font-display=fallback".
Also with the alternative method using @import url(//fonts.googleapis.com/css?family=Open+Sans); inside css you are
not able to set up the values for font-display.
And not even, I think I'm not wrong (I gave only a quick
look at this library), with the JavaScript library:
Web Font Loader: 
https://developers.google.com/fonts/docs/webfont_loader 
At the moment the only way is the manual set up for each
css element: p {font-family: 'MyWebFont', fallback, sans-serif;}



As far as I know, google or someone else has not yet solved this issue and, to work,
the "font-display" descriptor option must be inserted as value inside the css function @font-face{...}.

In short, as reported by the W3C:
https://www.w3.org/TR/css-fonts-4/#font-display-font-feature-values 
, when a font is served by a third-party font foundry,
the developer does not control the @font-face rules[..],
the importance to set a default policy for an entire font-family
is also useful to avoid the ransom note effect (i.e. mismatched font faces).

A possible way is, to use the PHP to manipulate this external resourse and add
the font-display option param inside the css function, moreover, in this way, the API keys, when these are necessary,
will be hidden.

With this php class there is also the possibility (VIEW:ADVANCED CLASS USAGE EXAMPLE N°2 FILE: INDEX_2.PHP)
to load the external fonts all together simultaneously, index_2.php.
I have entered the possibility,
for the external font files, to be stored locally setting a param option: true for locally stored and false for not.
Since, usually, we don't change fonts every day, why a client device have to connect each time, in all parts of the world, 
to load this external resources ? Is it necessary .... ? Is it a fast method ... ?

My thought is no, and also the speed test gave me reason, it is not necessary, instead, it need to set the .htaccess file with
a long time cache for the font files.
In the EXAMPLE TWO I have loaded seven different font simultaneously from only one server,
seven are too much, but I did it only for testing to show
that also in this case, with seven different fonts, all text remains visible with
the set up of the font-display during web fonts load.
Simultaneously, when the param option is set to true,
became only the check of the server to the external font resource, and the resources are downloaded only
if locally don't exists.

To avoid the critical request chain
I have set up to defer (load asynchronously) the style with a small escamotage:
style media="none" onload="if(media!='all')media='all'"

Here you can see the ligthhouse reports, about performances, of these three demos,
example N°1 with two fonts not loaded simultaneously,
example N°2 with seven different fonts loaded and stored locally and
example N°3 with seven different fonts loaded simultaneously but not stored locally.
These tests are only indicative and to make a correct comparison
the quantities should be homogeneous, ie load the same number of fonts.
In any case, from the various others tests carried out, the fastest, obviously, is, in any case, the example N°2.

example N°1 Emulated Nexus 5X, Throttled Fast 3G network,
Network throttling: 562,5 ms HTTP RTT, 1.474,6 Kbps down, 675 Kbps up (DevTools)
CPU throttling: 4x slowdown (DevTools):
https://googlechrome.github.io/lighthouse/viewer/?gist=b316fc892210f82dfcf56f5285c75ee6
example N°1 Emulated Nexus 5X, Throttled Fast 3G network,
Network throttling: 150 ms TCP RTT, 1.638,4 Kbps throughput (Simulated)
CPU throttling: 4x slowdown (Simulated):
https://googlechrome.github.io/lighthouse/viewer/?gist=e79ffd09199fecaa5ecd35f84f3d32e8

example N°2 Emulated Nexus 5X, Throttled Fast 3G network,
Network throttling: 562,5 ms HTTP RTT, 1.474,6 Kbps down, 675 Kbps up (DevTools)
CPU throttling: 4x slowdown (DevTools):
https://googlechrome.github.io/lighthouse/viewer/?gist=23b8f92d04eb3f32f6cfd7e317535510
example N°2 Emulated Nexus 5X, Throttled Fast 3G network,
Network throttling: 150 ms TCP RTT, 1.638,4 Kbps throughput (Simulated)
CPU throttling: 4x slowdown (Simulated):
https://googlechrome.github.io/lighthouse/viewer/?gist=b01c2975e469b0a2d36ea2224a78a84f

example N°3 Emulated Nexus 5X, Throttled Fast 3G network,
Network throttling: 562,5 ms HTTP RTT, 1.474,6 Kbps down, 675 Kbps up (DevTools)
CPU throttling: 4x slowdown (DevTools):
https://googlechrome.github.io/lighthouse/viewer/?gist=44ee33c578e928a59d04f13a60f18675
example N°3 Emulated Nexus 5X, Throttled Fast 3G network,
Network throttling: 150 ms TCP RTT, 1.638,4 Kbps throughput (Simulated)
CPU throttling: 4x slowdown (Simulated):
https://googlechrome.github.io/lighthouse/viewer/?gist=7d88e7348587aa49bc582e0e78375520



SIMPLE CLASS USAGE EXAMPLE N°1 FILE:INDEX.PHP (FONT-DISPLAY YES, NO SIMULTANEOUSLY CHECK,
NO FONT FILES ARE STORED LOCALLY, .HTACCESS CACHE YES);
$ref= new Fontperformance;
$font_1 = $ref->fontdisplay("link_to_font_api","fallback");
$font_2 = $ref->fontdisplay("link_to_font_api","auto");
Where param 1 is a string, is the link to external font resource, in this example through google font api.
param 2 is a string, is the performance controlling option. Possible values are:
auto | block | swap | fallback | optional

ADVANCED CLASS USAGE EXAMPLE N°2 FILE:INDEX_2.PHP (FONT-DISPLAY YES, SIMULTANEOUSLY CHECK YES,
ALL FONT FILES ARE STORED LOCALLY IF LOCALLY DO NOT EXIST, .HTACCESS CACHE YES);
$ref= new Fontperformance;
$apilink = array("link_to_font_api_1","link_to_font_api_n", ....);
$ref->multi_simul_fontdisplay($apilink,"fallback", true );
where the params1 is an array with all links to the font api, it's good, also, for only one font,
and where the param 2 is a string, is the performance controlling option. Possible values are:
auto | block | swap | fallback | optional, 
param 3: true o false, true for storing locally the exernal fonts, false for not storing, (default value is false),
this will return an array with all fonts.

For a complete reference guide about font-display descriptor please consult:
Controlling Font Performance with font-display:
https://developers.google.com/web/updates/2016/02/font-display
W3C font display: 
https://www.w3.org/TR/css-fonts-4/#font-display-font-feature-values

Author Riccardo Castagna 
Ph: +39 3315954155

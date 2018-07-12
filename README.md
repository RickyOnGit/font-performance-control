<h1>Author: Riccardo Castagna MBA, PHP developer - Palermo (ITALY) </h1>
 <p>This php package solves the problem to charge an external font resource<br>                                                 
 with the <strong>"controlling font performance"</strong> using font-display options.<br><br>                                                 
 This option is useful, to fast load the external font and in general to have the control over browser behavioral<br>        
 and, in particular,<br> over how the different browsers have to load the external font.<br>                                     
 This option is useful to make all text remains visible during web font loads,<br>                                           
 leveraging the font-display CSS feature to ensure text is user-visible while web fonts are loading.</p><br><br>                     
 <p>At the moment is no possible to add at any external font resource the font-display options,<br>                             
 when you call the query, for example, through google font API:<br>                                                          
 "https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500"<br>                                             
 and you wish to add the descriptor param: "&font-display=fallback"<br>                                                      
 making something like this query:<br>                                                                                       
 "https://fonts.googleapis.com/css?family=Montserrat+Alternates%3A300%2C500&font-display=fallback".<br>                      
 Also with the alternative method using @import url(//fonts.googleapis.com/css?family=Open+Sans); inside css you are<br>     
 not able to set up the values for font-display.<br> And not even, I think I'm not wrong (I gave only a quick<br>                
 look at this library), with the JavaScript library:<br>                                                                     
 <a href="https://developers.google.com/fonts/docs/webfont_loader">Web Font Loader </a><br>                                                
 At the moment the only way is the manual set up for each<br>                                                                
 css element: p {font-family: 'MyWebFont', fallback, sans-serif;}</p><br><br>                                                        
 <p>As far as I know, google or someone else has not yet solved this issue and, to work,<br>                                    
 the "font-display" descriptor option must be inserted as value inside the css function @font-face{...}.<br><br>
 <strong> A possible way is, to use the PHP to manipulate this external resourse and add<br>                                          
 the font-display option param inside the css function, moreover, in this way, the API keys, when these are necessary,<br>   
 will be hidden.</strong><br><br>                                                                                                        With this php class there is also the possibility (VIEW:ADVANCED CLASS USAGE EXAMPLE N&deg;2 FILE: INDEX_2.PHP)<br>             
 to load the external fonts all together simultaneously,  index_2.php.<br>                                                   
 To avoid changing this demo into a cyber attack to google servers, and if we want to prevent<br>                          
 google killing me and you; I joke, obviously, I joke ... ;), in the example N&deg;2,the font files are stored locally and<br>   
 since, usually, we don't change fonts every day, why we have to connect each time to this external resources ?<br>          
 is it necessary .... ? My thought is no, it is not necessary, instead, it need to set the .htaccess file with<br>           
 a long time cache for the font files.<br>                                                                                   
 In the EXAMPLE TWO I have loaded seven different font simultaneously from only one server,<br>                              
 seven are too much, but I did it only for testing to show<br>                                                               
 that also in this case, with seven different fonts loaded simultaneously, all text remains visible with<br>                 
 the set up of the font-display during web fonts load.<br>                                                                   
 Simultaneously is only the check of the server to the exeternal font resource because the resources are downloaded only<br>              if locally don't exists.</p><br><br>
<p>To avoid the <a href="https://developers.google.com/web/tools/lighthouse/audits/critical-request-chains">critical request chain</a><br>  I have set up to defer (load asynchronously) the style with a small escamotage:<br>                                         
 style media="none" onload="if(media!='all')media='all'"<br><br>                                                              
 Here you can see the ligthhouse reports, about performances, of these two demo,<br>example N&deg;1 with two fonts not loaded simultaneously and<br>
 example N&deg;2 with seven fonts loaded simultaneously;<br><br>  
 example N&deg;1 Emulated Nexus 5X, Throttled Fast 3G network,<br> Network throttling: 562,5 ms HTTP RTT, 1.474,6 Kbps down, 675 Kbps up (DevTools)<br>
 CPU throttling: 4x slowdown (DevTools):<br> 
 <a href="https://googlechrome.github.io/lighthouse/viewer/?gist=b316fc892210f82dfcf56f5285c75ee6">lighthouse performance report N 1</a><br>
 example N&deg;1 Emulated Nexus 5X, Throttled Fast 3G network,<br> Network throttling: 150 ms TCP RTT, 1.638,4 Kbps throughput (Simulated)<br>
 CPU throttling: 4x slowdown (Simulated):<br>
 <a href="https://googlechrome.github.io/lighthouse/viewer/?gist=e79ffd09199fecaa5ecd35f84f3d32e8">lighthouse performance report N 1</a><br><br>                                          
 example N&deg;2 Emulated Nexus 5X, Throttled Fast 3G network,<br> Network throttling: 562,5 ms HTTP RTT, 1.474,6 Kbps down, 675 Kbps up (DevTools)<br>
 CPU throttling: 4x slowdown (DevTools):<br>
 <a href="https://googlechrome.github.io/lighthouse/viewer/?gist=23b8f92d04eb3f32f6cfd7e317535510">lighthouse performance report N 2</a><br>
 example N&deg;2 Emulated Nexus 5X, Throttled Fast 3G network,<br> Network throttling: 150 ms TCP RTT, 1.638,4 Kbps throughput (Simulated)<br>
 CPU throttling: 4x slowdown (Simulated):<br>
 <a href="https://googlechrome.github.io/lighthouse/viewer/?gist=b01c2975e469b0a2d36ea2224a78a84f">lighthouse performance report N 2</a></p><br><br>                                                                                                                       
                                                                                                                         
<p><strong>SIMPLE CLASS USAGE EXAMPLE N&deg;1 FILE:INDEX.PHP (FONT-DISPLAY YES, NO SIMULTANEOUSLY CHECK,<br> 
 NO FONT FILES ARE STORED LOCALLY, .HTACCESS CACHE YES);</strong><br>                                                      
 $ref= new Fontperformance;<br>                                                                                              
 $font_1 = $ref->fontdisplay("link_to_font_api","fallback");<br>                                                             
 $font_2 = $ref->fontdisplay("link_to_font_api","auto");<br>               
 Where param 1 is a string, is the link to external font resource, in this example through google font api.<br>              
 param 2 is a string, is the performance controlling option. Possible values are:<br>                                        
 auto | block | swap | fallback | optional<br><br>                                                                               
                                                                                                                         
<strong>ADVANCED CLASS USAGE EXAMPLE N&deg;2 FILE:INDEX_2.PHP (FONT-DISPLAY YES, SIMULTANEOUSLY CHECK YES,<br>                          
ALL FONT FILES ARE STORED LOCALLY IF LOCALLY DO NOT EXIST, .HTACCESS CACHE YES);</strong>          
 $ref= new Fontperformance;                                                                                              
 $apilink = array("link_to_font_api_1","link_to_font_api_n", ....);                                                      
 $ref->multi_simul_fontdisplay($apilink,"fallback" );                                                                    
 where the params1 is an array with all links to the font api, it's good, also, for only one font,                    
 and where the param 2 is a string, is the performance controlling option. Possible values are:  
 auto | block | swap | fallback | optional , this will return an array with all fonts.<br>                                
<strong> PLEASE DO NOT FOLLOW MY BAD EXAMPLE, DON'T LOAD MORE THAN TWO MAXIMUM DIFFERENT FONTS SIMULTANEOUSLY</strong><br><br> 
For a complete reference guide about font-display descriptor please consult:<br> 
<a href="https://developers.google.com/web/updates/2016/02/font-display">Controlling Font Performance with font-display</a><br>
<a href="https://www.w3.org/TR/css-fonts-4/#font-display-font-feature-values">W3C font display</a><br><br>
<a href="https://api.whatsapp.com/send?phone=393315954155">Info & Contacts</a> 
</p> 

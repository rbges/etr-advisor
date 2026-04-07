<?php
    /**
     * PoS and Parsing 2.0 example for PHP.
     *
     * In order to run this example, the license key must be included in the key variable.
     * If you don't know your key, check your account at MeaningCloud (https://www.meaningcloud.com/developer/account/licenses)
     *
     * You can find more information at http://www.meaningcloud.com/developer/lemmatization-pos-parsing/doc/2.0
     *
     * @author     MeaningCloud (support@meaningcloud.com)
     * @copyright  Copyright (c) 2015, MeaningCloud LLC. All rights reserved.
     */
   
   if(!isset($_SESSION)){ session_start(); } 
   
    function getAnalysis ($sentence) {
        $result = array();
        $morphoArray = array();
        $syntaxArray = array();
        
        // We define the variables needed to call the API
        $api = 'http://api.meaningcloud.com/parser-2.0';
        $key = 'ccf5d5a18e16be45133f14e79e0f237a';
        $txt = $sentence;
        $lang = 'es';  // es/en/fr/it/pt/ca
        
        // We make the request and parse the response to an array
        $response = sendPost($api, $key, $lang, $txt);
        $json = json_decode($response, true);
        $morpho = array();
       
        //We traverse the syntactical tree saving the leaves we find
        if(isset($json['token_list'])){
          foreach($json['token_list'] as $sentence){
            traverseTree($sentence, $morpho);
          }
        }
      
        // Show the morphological analyses
        foreach($morpho as $m){
          if(isset($m['analysis_list'])) {
            foreach($m['analysis_list'] as $k=>$a)
             $morphoArray[$m['analysis_list'][0]['original_form']] = $a['tag_info'];
          }
        }
        
        // We search in the tag syntactic_tree_relation_list
        foreach($json['token_list'][0]['token_list'][0]['token_list'][1]['syntactic_tree_relation_list'] as $item){
            array_push($syntaxArray, $item[type]); 
        }
        array_push($result, $morphoArray);
        array_push($result, $syntaxArray);
        return $result;
    }
    
 
    // Auxiliary function to make a post request
    function sendPost($api, $key, $lang, $txt) {
        $data = http_build_query(array('key'=>$key,
                                       'lang'=>$lang,
                                       'txt'=>$txt,
                                       'verbose' => 'y',
                                       'src'=>'sdk-php-ma-2.0')); // management internal parameter
        $context = stream_context_create(array('http'=>array(
              'method'=>'POST',
              'header'=>
                'Content-type: application/x-www-form-urlencoded'."\r\n".
                'Content-Length: '.strlen($data)."\r\n",
              'content'=>$data)));
        $fd = fopen($api, 'r', false, $context);
        $response = stream_get_contents($fd);
        fclose($fd);
        return $response;
    }
    
    
   // This function traverses the tree with the analysis of the input (token). Every time it reaches a leaf, it adds it to the morphological array.
    function traverseTree(&$token, &$morpho) {
        if(isset($token['token_list'])){
          foreach($token['token_list'] as $t){
            if(isset($t['token_list'])){ //if it has token children, it's not a leaf
              traverseTree($t, $morpho);
            }else{ // it's a leaf!
              $morpho[]=$t;
            }
          }
        }
    }
?>
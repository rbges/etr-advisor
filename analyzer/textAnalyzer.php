<?php
	
if(!isset($_SESSION)){ session_start(); } 

function textAnalyzer(){
    
    include_once ("./analyzer/textConverter.php");
    include_once ("./analyzer/morphosyntacticAnalyzer.php");
    $file_uploaded = $_SESSION['file_uploaded'];
    $file_uploaded = './input' . $file_uploaded . '.html';
    
    //HTML DOM structure
    $doc = new DOMDocument();
    //$doc->loadHTMLFile("../input/tmp/phpHV46rO.html");
    $doc->loadHTMLFile($file_uploaded);
    $doc->saveHTML();
    $xpath = new DOMXpath($doc);

    $textAnalyzerArray = array();
 
    //Function allText, located at textConverter.php file
    $paragraphs = getParagraphs();

    //Vars
    $parameters = 'parameters.txt';
    $all_parameters = file($parameters);

    $maxChar = array();
    $maxChar['maxC'] = rtrim($all_parameters[109]);
    $maxNum = array();
    $maxNum['maxN'] = rtrim($all_parameters[113]);
    $specialCharacters = array();
    $specialCharacters['sp1'] = rtrim($all_parameters[117]);
    $specialCharacters['sp2'] = rtrim($all_parameters[118]);
    $specialCharacters['sp3'] = rtrim($all_parameters[119]);
    $specialCharacters['sp4'] = rtrim($all_parameters[120]);
    $specialCharacters['sp5'] = rtrim($all_parameters[121]);
    $specialCharacters['sp6'] = rtrim($all_parameters[122]);
    $specialCharacters['sp7'] = rtrim($all_parameters[123]);
    $specialCharacters['sp8'] = rtrim($all_parameters[124]);
    $specialCharacters['sp9'] = rtrim($all_parameters[125]);
    $specialCharacters['sp10'] = rtrim($all_parameters[126]);
    $specialCharacters['sp11'] = rtrim($all_parameters[127]);
    $specialCharacters['sp12'] = rtrim($all_parameters[128]);
    $specialCharacters['sp13'] = rtrim($all_parameters[129]);
    $specialCharacters['sp14'] = rtrim($all_parameters[130]);
    $specialCharacters['sp15'] = rtrim($all_parameters[131]);
    $orderCharacters = array();
    $orderCharacters['ord1'] = rtrim($all_parameters[135]);
    $orderCharacters['ord2'] = rtrim($all_parameters[136]);
    $maxWords = array();
    $maxWords['maxW'] = rtrim($all_parameters[140]);
    $maxProns = array();
    $maxProns['maxP'] = rtrim($all_parameters[144]);

/* 1) El tamaño de las líneas es correcto. */

    $i=0;
    foreach ($paragraphs as $words) {
        //This array is filled with index of the end of the sentence
        $arrayEnd = array();
        
        //We must split into words (Taking into account UTF-8 encoding)
        $characters = preg_split("//u", $paragraphs[$i], null, PREG_SPLIT_NO_EMPTY);

        //Removing blank spaces
        for($j=0; $j<count($characters); $j++){ 
          if ($characters[$j] == ' '){ 
             unset($characters[$j]);
          }
        }
        $characters = array_values($characters);
        
        //Loop through each character
        for($j=0; $j<count($characters); $j++){ 
            
            //Only split sentences when these cases aren't false
            if ($characters[$j] == '.'){   
               //Case (...)
                if(!($characters[$j+1]=='.' || $characters[$j-1]=='.'|| $characters[$j+1]==',')){
                   array_push($arrayEnd, $j);
                }
            }        
            
            //Case (¿/¡..?/! Sentence2)
            if ($characters[$j] == '?' || $characters[$j] =='!'){
                if (ctype_upper($characters[$j+1])){
                   array_push($arrayEnd, $j);
                }
            }
        }
        //Substraction between indexs of arrayEnd determines the number of characters in the sentence.
        for($k=0; $k<strlen($arrayEnd[$k]); $k++){
            $subtraction=0;
            if($k==0){
                $subtraction=(int)$arrayEnd[$k];
            }else{
                $subtraction=(int)$arrayEnd[$k] - (int)$arrayEnd[$k-1];
            }
            
            //Sentences can't contain more than 60 characters
            if ((int)$subtraction>(int)$maxChar['maxC']){ 
                $textAnalyzerArray['P1'] = 'Las siguientes líneas:<br><br>'.$paragraphs[$i]. '<br><br>contienen frases de más de '.$maxChar['maxC'].' caracteres. Concretamente tienen '.$subtraction.' caracteres.';
            }
        }
        $i++;
    }
    

    
/* 2) Los números grandes se expresan de forma correcta. */

    $P2_errors = array();
    //Iteration over the <p> returned by "getParagraphs" function
    $i=0;
    foreach ($paragraphs as $words) {
        //We must split into words
        $words = explode(" ", trim($paragraphs[$i]));
        $words = str_replace('(', '', $words);
        $words = str_replace(')', '', $words);
        $words = str_replace(',', '', $words);
        $words = str_replace('.', '', $words);
        
        //Loop through each word. If we find a number, check if it's greater than 100.000  
        foreach($words as $word){
            if (is_numeric($word) && (int)$word>(int)$maxNum['maxN']){
                array_push($P2_errors, $word);
               //echo 'ERROR: El número' . $word. 'es muy grande';
            } 
        }
        $i++;
    }
    if (!empty($P2_errors)){
        $numberError = implode(", ", array_unique($P2_errors));
        $textAnalyzerArray['P2'] = 'Se recomienda sustituir los numeros:<br><br>'.$numberError.'<br><br>por las palabras "pocos, algunos o muchos" por ejemplo.';
    }
    unset($P2_errors);


/* 3) El texto no tiene paréntesis, corchetes, porcentajes y otros signos ortográficos difíciles de entender. */

    $P3_errors = array();
    $i=0;
    foreach ($paragraphs as $words) {
        //We must split into characters
        $characters = preg_split("//u", $paragraphs[$i], null, PREG_SPLIT_NO_EMPTY);
        
        //Loop through each character. If we find a special character, we got an error  
        foreach($characters as $key => $value){
            $character = explode("-", $value);
            $character = trim($character[0]);
            if (in_array($character, $specialCharacters)) {
                array_push($P3_errors, $character);
            }
        }
        $i++;
    }
    if (!empty($P3_errors)){
        $P3_errors = array_unique($P3_errors);
        $specialError = implode(", ", $P3_errors);
        $textAnalyzerArray['P3'] = 'Usted esta utilizando los siguientes caracteres especiales desaconsejados:<br><br>'.$specialError;
    }
    unset($P3_errors);
    
    
/* 4) Evitar el uso de caracteres de orden. */

    $P4_errors = array();
    $i=0;
    foreach ($paragraphs as $words) {
        //We must split into characters
        $characters = preg_split("//u", $paragraphs[$i], null, PREG_SPLIT_NO_EMPTY);
        
        //Loop through each character. If we find an order character, we got an error  
        foreach($characters as $key => $value){
            $character = explode("-", $value);
            $character = trim($character[0]);
            
            if (in_array($character, $orderCharacters)) {
                array_push($P4_errors, $character);
            }
        }
        $i++;
    }
    if (!empty($P4_errors)){
        $P4_errors = array_unique($P4_errors);
        $orderError = implode(", ", $P4_errors);
        $textAnalyzerArray['P4'] = 'Usted esta utilizando los siguientes caracteres de orden desaconsejados:<br><br>'.$orderError;
    }
    unset($P4_errors);


/* 5) El texto se compone de frases cortas. */
/* 7) El uso de pronombres es correcto. */
/* 10) El texto va dirigido a la persona que lo lee. */
/* 11) No utilizar la forma pasiva. */
/* 12) Las oraciones han de tener sujeto. */
/* 13) El texto se compone de frases simples: sujeto + verbo + complementos. */
    
    $P5_errors=array(); $P7_errors=array(); $P9_errors=array(); $P10_errors=array(); $P11_errors=array(); $P12_errors=array(); 
    
    $firstPersonCounter=0;
    $thirdPersonCounter=0;
    //First of all. Iterating the paragraphs
    for($i=0; $i<count($paragraphs); $i++) {
        
        //This array is filled with index of the end of the sentence
        $arrayEnd = array();
        
        //Iterating each paragraph, splitting into words(Taking into account UTF-8 encoding)
        for($j=0; $j<strlen($paragraphs[$i]); $j++){
            $characters = preg_split("//u", $paragraphs[$i], null, PREG_SPLIT_NO_EMPTY);
        }
        
        //Loop through each character. Searching cutting patterns
        for($l=0; $l<count($characters); $l++){ 
            //Only split sentences when these cases aren't false
            if ($characters[$l] == '.'){
                //Cases (etc.,) / (...)
                if(!($characters[$l+1]=='.' || $characters[$l-1]=='.' || $characters[$l+1]==',')){
                    array_push($arrayEnd, $l+1);
                }
            }
            //Case (¿/¡Words?/!+Sentence)
            if ($characters[$l] == '?' || $characters[$l] =='!'){
                if (ctype_upper($characters[$l+1]) || ctype_upper($characters[$l+2])){
                   array_push($arrayEnd, $l+1);
                }
            }
        }

        //Iteration according to obtained indexes 
        for($k=0; $k<strlen($arrayEnd[$k]); $k++){ 
            if($k!=0){
               (int)$arrayEnd[$k] = (int)$arrayEnd[$k] - (int)$arrayEnd[$k-1];
            }    
            //Splitting the paragraph into senteces (in position k)
            $newArray = str_split_unicode($paragraphs[$i], $arrayEnd[$k]);
        
            /* [REGLA 5] */
            //Counting words per sentence obtained
            preg_match_all('/\pL+/u', $newArray[0], $nWords);
            $wordsSentence = array();
            if(count($nWords[0]) > (int)$maxWords['maxW']){
                array_push($wordsSentence, $nWords[0]);
                //echo 'ERROR: Existen frases con más de 15 palabras en la frase: '. $newArray[0] . '<br>';
            }
            
            //MORPHOLOGIC
            $pronCounter = 0; //Only pronositions per sentence must be taken into account.
            $passiveCounter = 0;
            $passiveAux = array(); //For special treatments in passive voice
            $prons = array();
            $passives = array();
            $syntax = array();

            
            //Function getMorphological, located at morphosyntacticAnalyzer.php file
            $arrayAnalysis = array();
            sleep(1); //Sleep 1 seconds cause of the API. (2 requests per second)
            $arrayAnalysis = getAnalysis($newArray[0]);
            
            //Loop through each word  
            foreach($arrayAnalysis[0] as $key => $value){
                //Morphological analysis is given in the format: [word]->description1, description2, ...
                $value = str_replace(',', '', $value);
                
                //Searching strings according to the rules
                /* [REGLA 7] */
                if(strstr($value, 'relativo') || strstr($value, 'cuantificador') || strstr($value, 'posesivo') || strstr($value, 'demostrativo') ||
                     strstr($value, 'interrogativo') || strstr($value, 'personal') //|| strstr($value, 'indefinido')
                   ){ 
                   if (!(strstr($value, 'determinante') || strstr($value, 'adverbio')) ) {
                        array_push($prons, $key);
                        $pronCounter++;
                   }

                }
                /* [REGLA 9] */
                if(strstr($value, '1') || strstr($value, '3')){
                    $firstPersonCounter++;
                    $thirdPersonCounter++;
                }
                /* [REGLA 10] */
                if(strstr($value, 'pasiva')){
                    array_push($passives, $key);
                    $passiveCounter++;
                }
                /* [REGLA 11] */
                if(strstr($value, 'sujeto')){
                    array_push($syntax, 'sujeto');
                }
                /* Special treatments (se + verb) */
                if(strstr($value, 'nombre')){
                    array_push($passiveAux, 'nombre');
                }
                if(strstr($key, 'se')){
                    array_push($passiveAux, $key);
                }
                if(strstr($value, 'verbo') && in_array('se', $passiveAux) && !in_array('nombre', $passiveAux)){
                    $passiveCounter++;
                    unset($passiveAux);
                }
            }
            /* [REGLA 5] */
            if(!empty($wordsSentence)){
                array_push($P5_errors, '- '.$newArray[0].'<br>');
            }
            /* [REGLA 7] */
            if((int)$pronCounter > (int)$maxProns['maxP']){
                $pronsFound=implode(", ", $prons);
                array_push($P7_errors, '- '.$newArray[0].' tiene los siguientes pronombres: ('.$pronsFound .').<br><br>');
            }
            /* [REGLA 9] */
        	if((int)$firstPersonCounter!=0 || (int)$thirdPersonCounter!=0){
        	    array_push($P9_errors, '- '.$newArray[0].'<br>');
        	}            
            /* [REGLA 10] */
            if((int)$passiveCounter > 0){
                $passivesFound=implode(", ", $passives);
                array_push($P10_errors, '- '.$newArray[0].'<br>');
            }
            
            // SYNTACTIC
            /* [REGLA 11] */
            if(!($arrayAnalysis[1][0]=='iof_isSubject')){
                array_push($P11_errors, '- '.$newArray[0].'<br>');
            }
            /* [REGLA 12] */
            //Subject + verb + complements
            if(!($arrayAnalysis[1][0]=='iof_isSubject') && (!in_array('iof_isDirectObject', $arrayAnalysis) || !in_array('iof_isComplement', $arrayAnalysis))){
                array_push($P12_errors, '- '.$newArray[0].'<br>');
            }
                
            //Removing processed sentence
            $paragraphs[$i] = iconv_substr($paragraphs[$i], (int)$arrayEnd[$k], (int)strlen($paragraphs[$i]));
        }
    }
    
    if(!empty($P5_errors)){
        $textAnalyzerArray['P5'] = 'Las siguientes oraciones contienen más de '.$maxWords['maxW'].' palabras: <br><br>'. implode("<br>", $P5_errors);
    }
    if(!empty($P7_errors)){
        $textAnalyzerArray['P7'] = 'Las siguientes oraciones contienen más de '.$maxProns['maxP'].' pronombres: <br><br>' . implode("<br>", $P7_errors);
    }
    if(!empty($P9_errors)){
        $textAnalyzerArray['P9'] = 'Las siguientes oraciones no contienen expresiones en segunda persona: <br><br>' . implode("<br>", $P9_errors);
    }
    if(!empty($P10_errors)){
        $textAnalyzerArray['P10'] = 'Las siguientes oraciones contienen la voz pasiva: <br><br>'. implode("<br>", $P10_errors);      
    }
    if(!empty($P11_errors)){
        $textAnalyzerArray['P11'] = 'Las siguientes oraciones no tienen sujeto: <br><br>'.implode("<br>", $P11_errors);
    }
    if(!empty($P12_errors)){
        $textAnalyzerArray['P12'] = 'Las siguientes oraciones no tienen la estructura: "sujeto + verbo + complementos": <br><br>'.implode("<br>", $P12_errors);
    }


/* 6) Las fechas se escriben de forma completa. */
    
    //Iteration over the <p> returned by "getParagraphs" function
    $paragraphs = getParagraphs(); 
    for($i=0; $i<count($paragraphs); $i++) {
        
        //Looking for a date format
        if( preg_match_all("/([0-9]{2})\-([0-9]{2})\-([0-9]{4})/i", $paragraphs[$i], $dates) ||
            preg_match_all("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/i", $paragraphs[$i], $dates) ||
            preg_match_all("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/i", $paragraphs[$i], $dates) ||
            preg_match_all("/([0-9]{4})\/([0-9]{2})\/([0-9]{2})/i", $paragraphs[$i], $dates)
        ){
            //Converting array of dates to string
            $datesFound=implode(", ", $dates[0]);
            $textAnalyzerArray['P6'] = 'Las siguientes fechas deberían tener un formato del estilo de "28 de marzo del 2018":<br><br>('.$datesFound.').';
        }
    }

    
/* 8) No utilizar números romanos. */

    //Iteration over the <p> returned by "getParagraphs" function
    $paragraphs = getParagraphs(); 
    for($i=0; $i<count($paragraphs); $i++) {

        //Looking for a Roman numerals
        if(preg_match_all("/\b(?:X?L?(?:X{0,3}(?:IX|IV|V|V?I{1,3})|IX|X{1,3})|XL|L)\b/", $paragraphs[$i], $roman)){
            //Converting array of Roman numerals to string
            $numeralsFound=implode(", ", $roman[0]);
            $textAnalyzerArray['P8'] = 'No se deben utilizar los siguientes números romanos encontrados:<br><br>'.$numeralsFound.'.';
        }
    }
    return $textAnalyzerArray;
}

    /**
     *This function is similar to str_split, but can process unicode characters.
     **/
    function str_split_unicode($str, $l = 0) {
        if ($l > 0) {
            $ret = array();
            $len = mb_strlen($str, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, "UTF-8");
            }
                return $ret;
            }
            return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }
?>
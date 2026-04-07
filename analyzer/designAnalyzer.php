<?php

if(!isset($_SESSION)){ session_start(); } 

function designAnalyzer(){
   
    include_once ("./analyzer/textConverter.php");
    $file_uploaded = $_SESSION['file_uploaded'];
    $file_uploaded = './input' . $file_uploaded . '.html';
    
    //HTML DOM structure
    $doc = new DOMDocument();
    $doc->loadHTMLFile($file_uploaded);
    $doc->saveHTML();
    $xpath = new DOMXpath($doc);

    $designAnalyzerArray = array();
    
    //Function allText, located at textConverter.php file
    $slideTags = allText();

    //Vars
    $parameters = 'parameters.txt';
    $all_parameters = file($parameters);
    
    $accepted_fonts = array();
    $accepted_fonts['fuente1'] = rtrim($all_parameters[72]);
    $accepted_fonts['fuente2'] = rtrim($all_parameters[73]);
    $accepted_fonts['fuente3'] = rtrim($all_parameters[74]);
    $accepted_fonts['fuente4'] = rtrim($all_parameters[75]);
    $accepted_fonts['fuente5'] = rtrim($all_parameters[76]);
    $accepted_fonts['fuente6'] = rtrim($all_parameters[77]);
    $accepted_fonts['fuente7'] = rtrim($all_parameters[78]);
    $accepted_fonts['fuente8'] = rtrim($all_parameters[79]);
    $accepted_fonts['fuente9'] = rtrim($all_parameters[80]);
    $accepted_fonts['fuente10'] = rtrim($all_parameters[81]);
    $accepted_fonts['fuente11'] = rtrim($all_parameters[82]);
    $maxminLength = array();
    $maxminLength['minL'] = rtrim($all_parameters[86]);
    $maxminLength['maxL'] = rtrim($all_parameters[87]);
    $maxBold = array();
    $maxBold['maxB'] = rtrim($all_parameters[91]);
    $maxSubred = array();
    $maxSubred['maxS'] = rtrim($all_parameters[95]);
    $maxUpper = array();
    $maxUpper['maxU'] = rtrim($all_parameters[99]);
    $maxWords = array();
    $maxWords['maxW'] = rtrim($all_parameters[103]);
    
/* 1) El tipo de letra facilita la lectura del texto. */

    $P1_errors = array();
    //Definition of tags wich can include font-family
    $textTags = $xpath->query('//body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $textTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $textTags->item($i);
        
        //Get the substring of style="" if we have a font-family
        $pos = strpos($element->getAttribute('style'), 'font-family');

        if(gettype($pos)=='integer'){
            $subString = substr($element->getAttribute('style'), (int)$pos);

            //Split style elements in order to search font-family
            list($fontSize, $value) = preg_split('/[:;]/', $subString);
            $value = trim($value);
            $fontName = preg_split("/[\s,]+/", $value); 

            if (!in_array($fontName[0], $accepted_fonts)) { //First value of the name
                array_push($P1_errors, $value);
            }
        }
    }
    if (!empty($P1_errors)){
        $fontsError = implode(", ",  array_unique($P1_errors));
        $designAnalyzerArray['P1'] = 'Tu diapositiva contiene fuentes no aceptadas: '. $fontsError;
    }
    unset($P1_errors);
    
/* 2) El tamaño de letra debe ser visiblemente bueno y cómodo para la lectura.	*/
$P2_errors = array();

//Definition of tags wich can include font-size
$textTags = $xpath->query('//body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
$length = $textTags->length;

//Loop through the set of HTML elements
for ($i = 0; $i < $length; $i++) {
    $element = $textTags->item($i);
    
    //Get the substring of style="" if we have a font-size
    $pos = strpos($element->getAttribute('style'), 'font-size');
    if(gettype($pos)=='integer'){
        $subString = substr($element->getAttribute('style'), (int)$pos);
        
        //Split style elements in order to search font-size
        list($fontFamily, $value) = preg_split('/[:;]/', $subString);
        
        if (!((int)$value >= (int)$maxminLength['minL']) && ((int)$value <= (int)$maxminLength['maxL'])){
            array_push($P2_errors, trim($value));
        }
    }
}

if (!empty($P2_errors)){
    $sizeError = implode(", ", $P2_errors);
    $designAnalyzerArray['P2'] = 'Existen fuentes con tamaño ('.$sizeError.'). Recuerda que el tamaño permitido está entre '.$maxminLength['minL'].' y '.$maxminLength['maxL'].'';
}
unset($P2_errors);   

/* 3) No utilizar texto en cursiva. */

    $P3_errors = 0;
    //Definition of tags wich can include italic font. (<em>/<i>/or <... style="font-style: italic")
    $italicTags = $xpath->query('//em | //i  | //body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $italicTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $italicTags->item($i);
        
        //If <em> or <i> appears in html, we got an error
        if ($element->tagName == ('em') || $element->tagName == ('i')) {
            $P3_errors++;
        }else{        
            //Get the substring of style="" if we have a font-style
            $pos = strpos($element->getAttribute('style'), 'font-style');
    
            if(gettype($pos)=='integer'){
                $subString = substr($element->getAttribute('style'), (int)$pos);
                
                //Split style elements in order to search font-style
                list($fontStyle, $value) = preg_split('/[:;]/', $subString);
                $value = trim($value);

                if (strcmp($value,'italic')==0){
                    $P3_errors++;
                }
            }
        }
    }
    if ($P3_errors != 0){
        $designAnalyzerArray['P3'] = 'No debe existir texto en cursiva. Es decir, evita el uso de las etiquetas em o i, así como del estilo de fuente "italic"';
    }

/* 4) El texto incluye palabras en negrita de forma poco usada. */

    //Definition of tags wich can include bold font. (<b> or <strong> or <... style="font-style: bold")
    $boldTags = $xpath->query('//b | //strong | //body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $boldTags->length;
    
    $countBold=0;
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $boldTags->item($i);
        
        //If <b> or <strong> appears in html more than 5 times, we got an error
        if ($element->tagName == ('b') || $element->tagName == ('strong')) {
            $countBold++;
        }else{        
            //Get the substring of style="" if we have a font-style
            $pos = strpos($element->getAttribute('style'), 'font-style');
    
            if (gettype($pos)=='integer'){
                $subString = substr($element->getAttribute('style'), (int)$pos);
                
                //Split style elements in order to search font-style
                list($fontStyle, $value) = preg_split('/[:;]/', $subString);
                $value = trim($value);

                if (strcmp($value,'bold')==0){
                    $countBold++;
                }
            }
        }
    }
    if ((int)$countBold >= (int)$maxBold['maxB']){
        $designAnalyzerArray['P4'] = 'En tu diapositiva hay demasiadas palabras en negrita('.$countBold .'). Intenta tener un número inferior a '.$maxBold['maxB'].'.';
    }
    
/* 5) El texto tiene pocas palabras subrayadas. */
   
    //Definition of tags wich can include underline font. (<u>  or <... style="text-decoration: underline")
    $underlineTags = $xpath->query('//u | //body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $underlineTags->length;
    
    $countUnderline=0;
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $underlineTags->item($i);
        
        //If <b> or <strong> appears in html more than 5 times, we got an error
        if ($element->tagName == ('u')) {
            $countUnderline++;
        }else{        
            //Get the substring of style="" if we have "text-decoration: underline"
            $pos = strpos($element->getAttribute('style'), 'text-decoration');
    
            if (gettype($pos)=='integer'){
                $subString = substr($element->getAttribute('style'), (int)$pos);
                
                //Split style elements in order to search font-style
                list($fontStyle, $value) = preg_split('/[:;]/', $subString);
                $value = trim($value);

                if (strcmp($value,'underline')==0){
                    $countUnderline++;
                }
            }
        }
    }
    if ((int)$countUnderline > (int)$maxSubred['maxS']){
        $designAnalyzerArray['P5'] = 'En tu diapositiva hay demasiadas palabras subrayadas('.$countUnderline.'). Intenta tener un número inferior a '.$maxSubred['maxS'].'.';
    }
    
/* 6) El texto no tiene adornos, colores ni sombras. */

    $P6_errors = 0;
    //Definition of tags wich can include "style="text-shadow"
    $shadowTags = $xpath->query('//body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $shadowTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $shadowTags->item($i);
        
        //Get the substring of style="" if we have text-shadow in the text
        $pos = strpos($element->getAttribute('style'), 'text-shadow');

        if(gettype($pos)=='integer'){
            $P6_errors++;
        }
    }
    if ($P6_errors != 0){
        $designAnalyzerArray['P6'] = 'No puede existir texto sombreado. Por tanto, evita el uso del estilo "text-shadow".';
    }

/* 7) El texto utiliza las mayúsculas según las reglas ortográficas. */

    //Iteration over the tags returned by "allText" function
    $nWordsCapital=0;
    foreach ($slideTags as $tag) {
        //We must split into words
        $nWordsTag = explode(" ", trim($tag));
        
        //Loop through each word. If we find a capital letter, counter is increased.  
        foreach($nWordsTag as $arr){
            if (ctype_upper($arr)){
               $nWordsCapital++;
            } 
        }
    }
    if ((int)$nWordsCapital >= (int)$maxUpper['maxU']){
        $designAnalyzerArray['P7'] = 'Has superado el límite establecido ('.$maxUpper['maxU'].') de palabras completamente en mayúsculas.';
    }

/* 8) El color del texto debe ser negro. */	

    $P8_errors = array();
    //Definition of tags which can include "style="color"
    $colorTags = $xpath->query('//body | //span | //p | //div | //a | //li | //ol | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
    $length = $colorTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $colorTags->item($i);
        
        //Get the substring of style="" if we have a color
        $pos = strpos($element->getAttribute('style'), 'color');

        if(gettype($pos)=='integer'){
            $subString = substr($element->getAttribute('style'), (int)$pos);
            
            //Split style elements in order to search color
            list($fontColor, $value) = preg_split('/[:;]/', $subString);
            $value = trim($value);
            
            if (!(strcmp($value,'#000000')==0 ||  strcmp($value,'black')==0 || strcmp($value,'#Hex_RGB')==0)){
                array_push($P8_errors, trim($value));
            }
        }
    }

    if (!empty($P8_errors)){
        $fontColorError = implode(", ", $P8_errors);
        $designAnalyzerArray['P8'] = 'Hay colores de fuente inadecuados, como ('.$fontColorError.'). El color de la fuente debe ser negro, el cual puede indicar mediante los valores de color #000000, black o #Hex_RGB.';
    }
    unset($P8_errors);

/* 9) El color del fondo debe ser blanco sólido. */

    $P9_errors = array();
    //Definition of tags wich can include "style="background-color o background"
    $backgroundTags = $xpath->query('//body | //span | //div');
    $length = $backgroundTags->length;
    
    //Loop through the set of HTML elements
    for ($i = 0; $i < $length; $i++) {
        $element = $backgroundTags->item($i);
        
        //Get the substring of style="" if we have background or background-color
        $pos = strpos($element->getAttribute('style'), 'background');
       
        if(gettype($pos)=='integer'){
            $subString = substr($element->getAttribute('style'), (int)$pos);
            
            //Split style elements in order to search background-color
            list($fontBackgroundColor, $value) = preg_split('/[:;]/', $subString);
            $value = trim($value);
            
            if (!(strcmp($value,'#FFFFFF')==0 ||  strcmp($value,'white')==0)){
                array_push($P9_errors, trim($value));
            }
        }
    }

    if (!empty($P9_errors)){
        $backgroundError = implode(", ", $P9_errors);
        $designAnalyzerArray['P9'] = 'Se ha detectado un color de fondo .'.$backgroundError.' El color de fondo debe ser blanco, indicado mediante los valores de background o background-color #FFFFFF o white.';
    }
    unset($P9_errors);
   
/* 10) La cantidad de palabras en la diapositiva es correcta (máx 50 palabras). */

    //Iteration over the tags returned by "allText" function
    $nWordsSlide=0;
    foreach ($slideTags as $tag) {
        //We must split into words
        $nWordsTag = count(explode(" ", trim($tag)));
        $nWordsSlide = $nWordsSlide + $nWordsTag;
        $nbucle++;
    }
    if ((int)$nWordsSlide >= (int)$maxWords['maxW']){
        $designAnalyzerArray['P10'] = 'La diapositiva contiene '.$nWordsSlide.' palabras, y el límite está establecido en '.$maxWords['maxW'].'.';
    }
    return $designAnalyzerArray;
}
?>
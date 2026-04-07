<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST")  { 
        extract($_POST);

        $OPTIONPAUTA = $_POST['inlineRadioOptions']; 

        //Condition 1
        $archivo = $_POST['file_name']; 
        $trozos = explode(".", $archivo); 
        $extension = end($trozos); 
        
        //Condition 2
        $target_dir = "./tmp/";
        $target_file = $target_dir . basename($_FILES["file_uploaded"]["tmp_name"] . ".html");
        $file = $_FILES['file_uploaded']['tmp_name'];
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $finfo = new finfo(FILEINFO_MIME);
        
        if (strpos($finfo->file($_FILES['file_uploaded']['tmp_name']),'text/html') === 0 || $extension=="html") {
            //Added html doctype and utf-8 encoding to prevent
          if (move_uploaded_file($file, $target_file)) {
            //Adding utf-8 encoding and html meta to prevent 
            $htmlLine = '<meta http-equiv="CONTENT-TYPE" content="text/html; charset=utf-8">'."\n";
            prepend($htmlLine, $target_file);

            //Session started and redirection to results page
            $_SESSION['file_uploaded'] = $_FILES['file_uploaded']['tmp_name'];
            header('Location:../result.php?option='.$OPTIONPAUTA.'&file=' . $_FILES['file_uploaded']['name']);
          } 
          else {
            $alerta = "** Ha habido un problema. Inténtelo de nuevo **";
            echo "<script>"; 
                echo "if(alert('$alerta'));";  
                    echo "window.location = '../index.php';"; 
            echo "</script>"; 
          }
        }
        else{
            $alerta = "** Debe subir un archivo de tipo html **";
            echo "<script>"; 
                echo "if(alert('$alerta'));";  
                    echo "window.location = '../index.php';"; 
            echo "</script>"; 
        }
    }
    else{
        header("HTTP/1.0 405 Method Not Allowed"); 
    }
    
    function prepend($string, $orig_filename) {
          $context = stream_context_create();
          $orig_file = fopen($orig_filename, 'r', 1, $context);
        
          $temp_filename = tempnam(sys_get_temp_dir(), 'php_prepend_');
          file_put_contents($temp_filename, $string);
          file_put_contents($temp_filename, $orig_file, FILE_APPEND);
        
          fclose($orig_file);
          unlink($orig_filename);
          rename($temp_filename, $orig_filename);
    }
?>
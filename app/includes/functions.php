<?php

    /*error_reporting(E_ALL);
    ini_set('display_errors', true);
    ini_set('html_errors', true);
    ini_set('log_errors', 'On');
    ini_set('error_log', $ROOT .'/app/web/error.log');
    
    function makeMessageError($message, $e=null){
        global $SQL_ERROR;
        $hr = '<hr style="margin: 5px; 0;">';
        if(is_null($e)) $_SESSION['showMessageBox'] = $message;
        else {
            $ex = $e->getMessage();
            $code = $e->getCode();
            $error = isset($SQL_ERROR[$code]) ? "<br><span class='text-danger'>{$SQL_ERROR[$code]}</span>" : "";
            $_SESSION['showMessageBox'] = "$message$error$hr<div style='font-weight: normal;'><u>Message d'erreur <b>pour l'administrateur</b></u> : $ex</div>";
        }
        return $_SESSION['showMessageBox'];
    }

    function myErrorHandler($errno, $errstr, $errfile, $errline) {
        $ROOT = $_SESSION['ROOT'];
        $file = $ROOT . "/app/web/logs.log";
        $f = @fopen($file, "a+");
        $str = "[" . date("d/m/Y H:i:s") . "]";
        $str .= "\n$errstr\nFichier $errfile : Ligne $errline (Erreur n° $errno)\n\n";
        @fwrite($f, $str);
        @fclose($f);
    }*/
    
   function date_english_to_french($date){
       $d = substr($date,0,10);
       $annee = substr($d,0,4);
       $mois = substr($d,5,2);
       $jour = substr($d,8,2);
       return "$jour/$mois/$annee";
   }
   
   function date_english_with_hour_to_french($date){
       $d = substr($date, 0, 10);
       $heure = substr($date, 11, strlen($date));
       $annee = substr($d,0,4);
       $mois = substr($d,5,2);
       $jour = substr($d,8,2);
       return "$jour/$mois/$annee $heure";
   }

   function date_french_to_english($date){
       $d = substr($date,0,10);
       $annee = substr($d,7,4);
       $mois = substr($d,4,2);
       $jour = substr($d,0,2);
       return "$annee-$mois-$jour";
   }

   function date_french_with_hour_to_english($date){
       $d = substr($date, 0, 10);
       $heure = substr($date, 11, strlen($date));
       $annee = substr($d,7,4);
       $mois = substr($d,4,2);
       $jour = substr($d,0,2);
       return "$$annee-$mois-$jour $heure";
   }
   
   function format_date_english_with_hour($date){
       $d = substr($date, 0, 10);
       $heure = substr($date, 11, strlen($date));
       $annee = substr($d,0,4);
       $mois = substr($d,5,2);
       $jour = substr($d,8,2);
       return "$annee/$mois/$jour $heure";
   }
   
   function format_date_english($date){
       $d = substr($date, 0, 10);
       $annee = substr($d,0,4);
       $mois = substr($d,5,2);
       $jour = substr($d,8,2);
       return "$annee/$mois/$jour";
   }
  


<?php
/*
 * Include this file for automatically showing error messages in the browser.
 */



//set to true to show location of the error - a bit insecure.
$SEB_SHOW_LOCATION      = TRUE;

//set to true to show error message - insecure
$SEB_SHOW_MESSAGE       = TRUE;

//set to true to show code excerpt. highly useful for debugging and totally
//insecure for production systems.
$SEB_SHOW_EXCERPT       = TRUE;

$SEB_BGCOLOR_MAIN       = "#b0c4de";
$SEB_BGCOLOR_CODE       = "#fff5cf";
$SEB_BGCOLOR_CODE_ERROR = "red";
$SEB_BGCOLOR_LINENUM    = "#dcdcdc";
$SEB_EXTRA_CODELINES    = 2; //lines to show before and after the faulty line

//specifies how to format tabs
$SEB_TAB_WIDTH          = 4;

//true if, and only if, errors of level E_NOTICE should be ignored
$SEB_IGNORE_E_NOTICE      = TRUE;


//error_reporting(E_ERROR | E_WARNING | E_NOTICE);
set_error_handler('SEB_errorHandler');


if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    echo "<html><head><title>\n";
    echo "Sample Error Output (".basename(__FILE__).")\n";
    echo "</title></head><body>\n";


    //the following line generates a "Division by zero" error.
	$x = 1 / 0;

    //that you can see this line means that the $SEB_EXTRA_CODELINES variable is set to at least 2

    echo "</body></html>\n";
}


/*
 * This function is invoked when an error occurs. It prints error information
 * in HTML format to standard output.
 */
function SEB_errorHandler($level, $message, $scriptFileName, $lineNumber) {
    global
     $SEB_SHOW_LOCATION,
     $SEB_SHOW_MESSAGE,
     $SEB_SHOW_EXCERPT,
     $SEB_BGCOLOR_MAIN,
     $SEB_BGCOLOR_CODE,
     $SEB_BGCOLOR_CODE_ERROR,
     $SEB_BGCOLOR_LINENUM,
     $SEB_EXTRA_CODELINES,
     $SEB_TAB_WIDTH,
     $SEB_IGNORE_E_NOTICE
    ;

    if ($level == E_NOTICE && $SEB_IGNORE_E_NOTICE)
        return;

    //caption
    switch ($level) {
        case E_ERROR          : $caption = "E_ERROR";           break;
        case E_WARNING        : $caption = "E_WARNING";         break;
        case E_PARSE          : $caption = "E_PARSE";           break;
        case E_NOTICE         : $caption = "E_NOTICE";          break;
        case E_CORE_ERROR     : $caption = "E_CORE_ERROR";      break;
        case E_CORE_WARNING   : $caption = "E_CORE_WARNING";    break;
        case E_COMPILE_ERROR  : $caption = "E_COMPILE_ERROR";   break;
        case E_COMPILE_WARNING: $caption = "E_COMPILE_WARNING"; break;
        case E_USER_ERROR     : $caption = "E_USER_ERROR";      break;
        case E_USER_WARNING   : $caption = "E_USER_WARNING";    break;
        case E_USER_NOTICE    : $caption = "E_USER_NOTICE";     break;
        case E_ALL            : $caption = "E_ALL";             break;

        //since PHP 5.0.0:
        //case E_STRICT: $caption = "E_STRICT"; break;  

        //since PHP 5.1.0:
        //case __COMPILER_HALT_OFFSET__: $caption = "__COMPILER_HALT_OFFSET__"; break;

        default: $caption = "unknown error level: $level"; break;
    }
    $caption = "<b>$caption</b><br />\n";

    //message
    $message .= "<br />\n";

    //location
    $scriptBaseFileName = basename($scriptFileName);
    $scriptPathLen      = strlen($scriptFileName) - strlen($scriptBaseFileName);
    $scriptPath         = substr($scriptFileName, 0, $scriptPathLen);
    $location = "location: ".
     "$scriptPath<b>$scriptBaseFileName:$lineNumber</b><br />\n";

    if ($lineList = @file($scriptFileName)) {
        $charSearch  = array(     " ",                                 "\t");
        $charReplace = array("&nbsp;", str_repeat("&nbsp;", $SEB_TAB_WIDTH));

        $excerpt =
         "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"".
         " style=\"margin: 6px;".
         " font-family: courier new, courier; font-size: 13px;".
         " background: $SEB_BGCOLOR_CODE;\">\n"
        ;

        $iStart = $lineNumber - $SEB_EXTRA_CODELINES - 1;
        $iEnd   = $lineNumber + $SEB_EXTRA_CODELINES;
        if ($iStart <                0) $iStart = 0;
        if ($iEnd   > count($lineList)) $iEnd   = count($lineList);
        for ($i = $iStart; $i < $iEnd; $i++) {
            if ($i == $lineNumber - 1)
                $codeStyle = "background: $SEB_BGCOLOR_CODE_ERROR;";
            else
                $codeStyle = "";

            $lineBegin =
             "<tr><td style=\"background: $SEB_BGCOLOR_LINENUM; color: black;".
             " font-family: courier new, courier; font-size: 13px;\"><b>".
             ($i + 1).":&nbsp;</b></td><td width=\"100%\"".
             " style=\"$codeStyle color: black; font-family: courier new, courier;".
             " font-size: 13px;\" nowrap><b>";
            $lineEnd   =
             "</b></td></tr>\n";

            $lineMiddle = htmlentities($lineList[$i]);
            $lineMiddle = str_replace($charSearch, $charReplace, $lineMiddle);
            $excerpt .= $lineBegin.$lineMiddle.$lineEnd;
        }

        $excerpt .= "</table>\n";
    } else
        $excerpt = "(no excerpt available)<br />\n";

    if (! $SEB_SHOW_LOCATION) $location = '';
    if (! $SEB_SHOW_MESSAGE ) $message  = '';
    if (! $SEB_SHOW_EXCERPT ) $excerpt  = '';

    echo
     "<p>\n".
     "<div style=\"".
     " padding: 2px;".
     " font-family: arial,helvetica,verdana,sans-serif;".
     " font-size: 13px;".
     " text-align: left;".
     " color: black;".
     " background: $SEB_BGCOLOR_MAIN;".
     "\">\n".
     $caption.
     $message.
     $location.
     $excerpt.
     "PHP ".PHP_VERSION." (".PHP_OS.")<br />\n".
     "</div>\n".
     "</p>\n"
    ;
}

?>

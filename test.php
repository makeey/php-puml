<?php
$source = file_get_contents(__DIR__ .'/tests/data/Test1.php');
$tokens = token_get_all($source);

foreach ($tokens as $token) {
    if (is_string($token)) {
        // simple 1-character token
        echo $token;
    } else {
        // token array
        list($id, $text) = $token;
        var_dump($token);
        switch ($id) {
            case T_COMMENT:
            case T_VARIABLE:
                echo $text;
            case T_DOC_COMMENT:
                // no action on comments
                break;

            default:
                break;
        }
    }
}
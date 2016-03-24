<?php

/* utils.php, added to composer.json. Useful to have functions in Blade views. */

/**
 * Gets the formatted text, replacing entries such as [text] by a link to the definition
 * URL for text.
 * @return string $text
 */
function get_definition_formatted_text($text)
{
    $url = URL::to("/");
    $formatted = nl2br(urldecode($text));
    $pattern = "/\[([^]]*)\]/i";
    $replace = "<a href=\"{$url}/expression/define?e=$1\">$1</a>";
    $formatted = preg_replace($pattern, $replace, $formatted);
    return $formatted;
}

<?php

/* utils.php, added to composer.json. Useful to have functions in Blade views. */

/**
 * Get the formatted text, replacing entries such as [text] by a link to the definition
 * URL for text.
 * @param string $text
 * @return string $text
 */
function get_definition_formatted_text($text, $language)
{
    $url = URL::to($language['slug'] . "/");
    $formatted = nl2br(urldecode($text));
    $pattern = "/\[([^]]*)\]/i";
    $replace = "<a href=\"{$url}/expression/define?e=$1\">$1</a>";
    $formatted = preg_replace($pattern, $replace, $formatted);
    return $formatted;
}

/**
 * Get a YouTube video data. The data array returned contains the video ID, and further time information.
 * So if the video is for video ID 3, and starts at 10 seconds, the array will contain both data.
 * @param array $media
 * @return array
 */
function get_video_data($media)
{
    $data = array();
    $url = $media['url'];
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
        $data['video_id'] = $match[1];
    }
    if (preg_match('%(?:t=)([0-9]+)%i', $url, $match)) {
        $data['t'] = $match[1];
    }
    return $data;
}

<?php

namespace Lethe\Json;

class Util
{

    public static function stripJsonComments($json)
    {
        $chars = str_split($json);
        $last = count($chars) - 1;
        $insideString = false;
        $insideComment = false;
        $stripped = '';

        for ($i = 0; $i <= $last; $i++) {
            $currentChar = $chars[$i];
            $nextChar = ($i == $last) ? '' : $chars[$i + 1];

            if (!$insideComment
                && (($i == 0) ? '' : $chars[$i - 1]) != '\\'
                && $currentChar == '"') {
                $insideString = !$insideString;
            }

            if ($insideString) {
                $stripped .= $currentChar;
                continue;
            }

            if (!$insideComment && $currentChar . $nextChar == '//') {
                $insideComment = 'single';
                $i++;
            } elseif ($insideComment == 'single' && $currentChar . $nextChar == "\r\n") {
                $insideComment = false;
                $i++;
            } elseif ($insideComment == 'single' && $currentChar == "\n") {
                $insideComment = false;
            } elseif (!$insideComment && $currentChar . $nextChar == '/*') {
                $insideComment = 'multi';
                $i++;
                continue;
            } elseif ($insideComment == 'multi' && $currentChar . $nextChar == '*/') {
                $insideComment = false;
                $i++;
                continue;
            }

            if ($insideComment) {
                continue;
            }

            $stripped .= $currentChar;
        }

        return $stripped;
    }

}

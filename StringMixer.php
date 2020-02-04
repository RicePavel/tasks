<?php
namespace Tasks;

/**
 * https://habr.com/ru/post/87754/
 */

class StringMixer {
    
    public static function handleString($str) {
        $newStr = "";
        $startSegment = 0;
        $i = 0;
        while ($i < strlen($str)) {
            if ($str[$i] === "{") {
                $newStr .= substr($str, $startSegment, $i - $startSegment);
                $endReplacementsegment = self::getEndReplacementSegment($str, $i);
                $replacementSegment = self::getReplacementSegment($str, $i, $endReplacementsegment);
                $newStr .= $replacementSegment;
                $i = $endReplacementsegment + 1;
                $startSegment = $i;
            } else {
                $i++;
            }
        }
        $newStr .= substr($str, $startSegment, $i - $startSegment);
        return $newStr;
    }

    private static function getReplacementSegment($str, $start, $end) {
        $i = $start + 1;
        $startSegment = $i;
        while ($i < $end) {
            if ($str[$i] === "{") {
                $newStr .= substr($str, $startSegment, $i - $startSegment);
                $endReplacementsegment = self::getEndReplacementSegment($str, $i);
                $replacementSegment = self::getReplacementSegment($str, $i, $endReplacementsegment);
                $newStr .= $replacementSegment;
                $i = $endReplacementsegment + 1;
                $startSegment = $i;
            } else {
                $i++;
            }
        }
        $newStr .= substr($str, $startSegment, $i - $startSegment);
        $arr = explode("|", $newStr);
        if (count($arr) > 0) {
            return $arr[rand(0, count($arr) - 1)];
        } else {
            return $newStr;
        }
    }

    private static function getEndReplacementSegment($str, $start) {
        $count = 0;
        for ($n = $start + 1; $n < strlen($str); $n++) {
            if ($str[$n] === "{") {
                $count++;
            }
            if ($str[$n] === "}") {
                if ($count > 0) {
                    $count--;
                } else {
                    return $n;
                }
            }
        }
        return $start;
    }
    
}





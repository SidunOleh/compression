<?php

class RLE
{
    public static function encode(string $str): string
    {
        $encoded = '';
        $count = 0;
        for ($i=0; $i < strlen($str); $i++) { 
            $count++;

            if (
                $str[$i] !== ($str[$i+1] ?? null) or 
                $count == 255
            ) {
                $encoded .= pack('C', $count) . $str[$i];
                $count = 0;
            }
        }

        return $encoded;
    }

    public static function decode(string $str): string
    {
        $decoded = '';
        for ($i=0; $i < strlen($str); $i=$i+2) { 
            $decoded .= str_repeat($str[$i+1], unpack('C', $str[$i])[1]);
        }

        return $decoded;
    }
}
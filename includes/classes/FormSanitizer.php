<?php

class FormSanitizer
{
    public static function sanitizeFormString(string $inputText): string
    {
        $inputText = strip_tags($inputText);
        $inputText = trim($inputText);
        $inputText = strtolower($inputText);
        return ucfirst($inputText);
    }

    public static function sanitizeFormUserName(string $inputText): string
    {
        $inputText = strip_tags($inputText);
        return trim($inputText);
    }

    public static function sanitizeFormEmail(string $inputText): string
    {
        $inputText = strip_tags($inputText);
        return trim($inputText);
    }

    public static function sanitizeFormPassword(string $inputText): string
    {
        return strip_tags($inputText);
    }
}
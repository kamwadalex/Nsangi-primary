<?php

namespace App\Support;

class PlainTextContent
{
    public static function toPlain(?string $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        $value = preg_replace('/<br\s*\/?>/i', "\n", $value);
        $value = preg_replace('/<\/p>\s*/i', "\n\n", $value);
        $value = preg_replace('/<\/li>\s*/i', "\n", $value);
        $value = strip_tags($value);
        $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace("/\r\n|\r/", "\n", preg_replace("/\n{3,}/", "\n\n", $value)));
    }

    public static function sanitize(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $plain = self::toPlain($value);

        return $plain === '' ? null : $plain;
    }

    public static function toHtml(?string $value): string
    {
        $plain = self::toPlain($value);

        return $plain === '' ? '' : nl2br(e($plain));
    }
}

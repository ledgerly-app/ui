<?php

namespace Ledgerly\UI\Support;

use Illuminate\Support\Str;

final class MetadataPresenter
{
    /**
     * @return array<int, array{key:string,label:string,value:string}>
     */
    public static function present(?array $metadata): array
    {
        if (! $metadata || ! is_array($metadata)) {
            return [];
        }

        $hidden = config('ledgerly-ui.hidden_metadata_keys', []);

        $rows = [];

        foreach ($metadata as $key => $value) {
            if (in_array($key, $hidden, true)) {
                continue;
            }

            $rows[] = [
                'key' => $key,
                'label' => self::humanizeKey($key),
                'value' => self::stringify($value),
            ];
        }

        return $rows;
    }

    private static function humanizeKey(string $key): string
    {
        return Str::headline(str_replace('_', ' ', $key));
    }

    private static function stringify(mixed $value): string
    {
        if (is_null($value)) {
            return 'null';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return (string) $value;
    }
}

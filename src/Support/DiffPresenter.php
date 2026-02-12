<?php

namespace Ledgerly\UI\Support;

use Illuminate\Support\Str;

final class DiffPresenter
{
    /**
     * Normalize a diff payload into a UI-Friendly structure.
     *
     * @param  array<string, mixed>|null  $diff
     * @return array<int, array{key:string, field:string, before:mixed, after:mixed}>
     */
    public static function present(?array $diff): array
    {
        if (! $diff || ! is_array($diff)) {
            return [];
        }

        $rows = [];

        foreach ($diff as $key => $value) {
            // Must be [before, after]
            if (! is_array($value) || count($value) < 2) {
                continue;
            }

            [$before, $after] = $value;

            $rows[] = [
                'key' => $key,
                'field' => self::humanizeField($key),
                'before' => self::stringify($before),
                'after' => self::stringify($after),
            ];
        }

        return $rows;
    }

    private static function humanizeField(string $key): string
    {
        return Str::headline(str_replace('_', ' ', $key));
    }

    private static function stringify(mixed $value): string|bool
    {
        if (is_null($value)) {
            return 'null';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_array($value)) {
            return json_encode($value);
        }

        if (is_object($value)) {
            return method_exists($value, '__toString')
                ? (string) $value
                : json_encode($value);
        }

        /** @var string $value */
        return $value;
    }
}

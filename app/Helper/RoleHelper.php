<?php

namespace App\Helpers;

class RoleHelper
{
    public static function encodeRole(string $role): string
    {
        $secret = env('ROLE_SECRET_KEY');
        return base64_encode($role . '|' . $secret);
    }

    public static function decodeRole(string $encoded): ?string
    {
        $secret = env('ROLE_SECRET_KEY');
        $decoded = base64_decode($encoded);

        if (!$decoded || !str_contains($decoded, '|')) {
            return null;
        }

        [$role, $decodedSecret] = explode('|', $decoded);

        return $decodedSecret === $secret ? $role : null;
    }
}

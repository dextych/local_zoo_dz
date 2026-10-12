<?php
declare(strict_types=1);

namespace App;

use RuntimeException;

final class Config
{
    private static function key(): string
    {
        $key = getenv('APP_KEY');

        if (!$key || !preg_match('/^[a-f0-9]{64}$/i', $key)) {
            throw new RuntimeException('Invalid APP_KEY');
        }

        return hex2bin($key);
    }

    public static function encrypt(string $value): string
    {
        $iv = random_bytes(12);
        $tag = '';

        $encrypted = openssl_encrypt(
            $value,
            'aes-256-gcm',
            self::key(),
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($encrypted === false) {
            throw new RuntimeException('Encryption failed');
        }

        return 'enc:' . base64_encode($iv . $tag . $encrypted);
    }

    public static function get(string $name, mixed $default = null): mixed
    {
        $config = require __DIR__ . '/../config/app.php';
        $value = $config[$name] ?? $default;

        if (!is_string($value) || !str_starts_with($value, 'enc:')) {
            return $value;
        }

        $data = base64_decode(substr($value, 4), true);

        if ($data === false || strlen($data) < 28) {
            throw new RuntimeException('Invalid encrypted value');
        }

        $result = openssl_decrypt(
            substr($data, 28),
            'aes-256-gcm',
            self::key(),
            OPENSSL_RAW_DATA,
            substr($data, 0, 12),
            substr($data, 12, 16)
        );

        if ($result === false) {
            throw new RuntimeException('Decryption failed');
        }

        return $result;
    }
}

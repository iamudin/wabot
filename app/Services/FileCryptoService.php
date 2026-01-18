<?php

namespace App\Services;

class FileCryptoService
{
    protected string $publicKey;
    protected string $privateKey;

    public function __construct()
    {
        $this->publicKey = file_get_contents(storage_path('public.pem'));
        $this->privateKey = file_get_contents(storage_path('private.pem'));
    }
    public function decryptStream(array $payload, callable $callback): void
    {
        // Decrypt AES key
        openssl_private_decrypt(
            base64_decode($payload['key']),
            $aesKey,
            $this->privateKey
        );

        $iv = base64_decode($payload['iv']);

        $encryptedData = base64_decode($payload['data']);

        // Decrypt (AES)
        $decrypted = openssl_decrypt(
            $encryptedData,
            'AES-256-CBC',
            $aesKey,
            OPENSSL_RAW_DATA,
            $iv
        );

        // Stream output
        $callback($decrypted);
    }

    /**
     * Encrypt file (AES + RSA)
     */
    public function encrypt(string $fileContent): array
    {
        // AES key
        $aesKey = random_bytes(32); // 256 bit
        $iv = random_bytes(16);

        // Encrypt file with AES
        $encryptedData = openssl_encrypt(
            $fileContent,
            'AES-256-CBC',
            $aesKey,
            OPENSSL_RAW_DATA,
            $iv
        );

        // Encrypt AES key with RSA public key
        openssl_public_encrypt($aesKey, $encryptedKey, $this->publicKey);

        return [
            'data' => base64_encode($encryptedData),
            'key' => base64_encode($encryptedKey),
            'iv' => base64_encode($iv),
        ];
    }

    /**
     * Decrypt file
     */
    public function decrypt(string $encryptedData, string $encryptedKey, string $iv): string
    {
        // Decrypt AES key with RSA private key
        openssl_private_decrypt(
            base64_decode($encryptedKey),
            $aesKey,
            $this->privateKey
        );

        // Decrypt file
        return openssl_decrypt(
            base64_decode($encryptedData),
            'AES-256-CBC',
            $aesKey,
            OPENSSL_RAW_DATA,
            base64_decode($iv)
        );
    }
}

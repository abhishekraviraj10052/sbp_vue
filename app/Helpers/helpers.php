<?php
if (!function_exists('aes_encrypt')) {

    function aes_encrypt($plainText)
    {
        $saltSecret = env('ENCRYPTIONSALT');
        if ($saltSecret === '') {
            throw new InvalidArgumentException('saltSecret cannot be empty');
        }

        $VERSION = 'v1';
        $CIPHER  = 'aes-256-gcm';
        $IV_LEN  = 12;
        $TAG_LEN = 16;

        $b64urlEncode = function (string $data): string {
            return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
        };


        $key = hash('sha256', $saltSecret, true);

        $iv  = random_bytes($IV_LEN);
        $tag = '';

        $ciphertext = openssl_encrypt(
            $plainText,
            $CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            '',
            $TAG_LEN
        );

        if ($ciphertext === false) {
            throw new RuntimeException('Encryption failed');
        }

        return $VERSION . '.' .
            $b64urlEncode($iv) . '.' .
            $b64urlEncode($ciphertext) . '.' .
            $b64urlEncode($tag);
    }
}


if (!function_exists('aes_decrypt')) {

    function aes_decrypt($encryptedText)
    {
        $saltSecret = env('ENCRYPTIONSALT');
        try {
            if ($saltSecret === '') {
                return false;
            }

            $VERSION = 'v1';
            $CIPHER  = 'aes-256-gcm';

            $b64urlDecode = function (string $data): string {
                $b64 = strtr($data, '-_', '+/');
                $pad = strlen($b64) % 4;
                if ($pad) {
                    $b64 .= str_repeat('=', 4 - $pad);
                }

                $out = base64_decode($b64, true);
                if ($out === false) {
                    throw new RuntimeException('Invalid base64');
                }
                return $out;
            };

            $parts = explode('.', $encryptedText);
            if (count($parts) !== 4 || $parts[0] !== $VERSION) {
                return false;
            }

            $iv         = $b64urlDecode($parts[1]);
            $ciphertext = $b64urlDecode($parts[2]);
            $tag        = $b64urlDecode($parts[3]);

            $key = hash('sha256', $saltSecret, true);

            $plaintext = openssl_decrypt(
                $ciphertext,
                $CIPHER,
                $key,
                OPENSSL_RAW_DATA,
                $iv,
                $tag
            );

            if ($plaintext === false) {
                return false;
            }

            return $plaintext;
        } catch (\Throwable $e) {
            return false;
        }
    }
}

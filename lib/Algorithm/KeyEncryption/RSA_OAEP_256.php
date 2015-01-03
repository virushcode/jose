<?php

namespace SpomkyLabs\JOSE\Algorithm\KeyEncryption;

use Jose\JWKInterface;
use SpomkyLabs\JOSE\Util\RSAConverter;

class RSA_OAEP_256 extends RSA
{
    /**
     * @inheritdoc
     */
    public function encryptKey(JWKInterface $key, $cek)
    {
        $this->checkKey($key);
        $values = array_intersect_key($key->getValues(), array_flip(array('n', 'e')));
        $rsa = RSAConverter::fromArrayToRSA_Crypt($values);
        $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
        $rsa->setHash("sha256");
        $rsa->setMGFHash("sha256");

        return $rsa->encrypt($cek);
    }

    /**
     * @inheritdoc
     */
    public function decryptKey(JWKInterface $key, $encrypted_key)
    {
        $this->checkKey($key);
        $values = array_intersect_key($key->getValues(), array_flip(array('n', 'e', 'p', 'd', 'q', 'dp', 'dq', 'qi')));
        $rsa = RSAConverter::fromArrayToRSA_Crypt($values);
        $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
        $rsa->setHash("sha256");
        $rsa->setMGFHash("sha256");

        return $rsa->decrypt($encrypted_key);
    }
}

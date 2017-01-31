<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HashMask
{
    /**
     * Logic from Encryption.
     * The key is encrypted in Base64 then, divided in half, inverted and encrypted again.
     *
     * @param string $data
     *
     * @return string
     */
    public function disguise($data)
    {
        $encryptedData = base64_encode((string) $data);
        return base64_encode(strrev(substr($encryptedData, (strlen($encryptedData)/2)-strlen($encryptedData)
                ,strlen($encryptedData)).substr($encryptedData, 0, (strlen($encryptedData)/2)-strlen($encryptedData))));
    }
    /**
     * Logic from Decryption
     * Reverse process of 'disguise()' to recover the original value.
     *
     * @param string $encryptedData
     *
     * @return string
     */
    public function retrieve($encryptedData)
    {
        $encryptedData = base64_decode((string) $encryptedData);
        $encryptedData = strrev(
            substr($encryptedData, (strlen($encryptedData)/2)-strlen($encryptedData),strlen($encryptedData))
            .substr($encryptedData, 0, (strlen($encryptedData)/2)-strlen($encryptedData)));
        return base64_decode($encryptedData);
    }

}

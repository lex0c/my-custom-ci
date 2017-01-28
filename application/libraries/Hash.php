<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hash Generator
 * @link https://github.com/lleocastro/cosmosphp/
 * @license https://github.com/lleocastro/cosmosphp/blob/master/LICENSE
 * @author Léo Castro <leonardo_carvalho@outlook.com>
 * @package \Cosmos\Security\Encryption
 */
class Hash
{
    /**
     * Encryption prefix
     * @see http://www.php.net/security/crypt_blowfish.php
     * @var string
     */
    protected $prefix = '2a';
    /**
     * Salt [MTc2MzMxNDQ4NTdmZDg4Yz]
     * @see http://www.php.net/security/crypt_blowfish.php
     * @var string
     */
    protected $salt = '';
    /**
     * Cost default '8' [4 <> 31]
     * @see http://www.php.net/security/crypt_blowfish.php
     * @var int
     */
    protected $cost = 8;

    /**
     * Encrypter Factory
     *
     * @param string $prefix
     * @param string $salt
     * @param int    $cost
     */
    public function __construct(string $prefix = '', string $salt = '', int $cost = 8)
    {
        $prefix = trim($prefix); $salt = trim($salt);
        $this->prefix = ($prefix == '') ? $this->prefix = '2a' : $this->prefix = $prefix;
        $this->salt = ($salt   == '') ? $this->salt = $this->generate_hash() : $this->salt = $salt;
        $this->cost = ($cost < 4 || $cost > 31) ? $this->cost = '8' : $this->cost = $cost;
    }
    /**
     * Encrypt Generator.
     *
     * @param string $value
     *
     * @return string
     */
    public function generate(string $value):string
    {
        return str_replace('=', '', strrev(
            $this->inverse(crypt(strrev($value), $this->generate_hash()))));
    }
    /**
     * Compare hashes.
     *
     * @param string $value
     * @param string $hash
     *
     * @return bool
     */
    public function is_equals(string $value, string $hash):bool
    {
        $v = strrev($value);
        $h = $this->reverse(strrev($hash));
        if (crypt($v, $h) === $h) {
            return true;
        }
        return false;
    }
    /**
     * Generate a random salt.
     *
     * @return string
     */
    protected function generate_salt():string
    {
        return substr(base64_encode(uniqid(mt_rand(), true)), 0, 22);
    }
    /**
     * Build a hash string for crypt.
     *
     * @return string
     */
    protected function generate_hash():string
    {
        return sprintf('$%s$%02d$%s$', $this->prefix, $this->cost, $this->generate_salt());
    }

    /**
     * Hard hash encrypting.
     *
     * @param string $encryptedData
     *
     * @return string
     */
    protected function inverse(string $encryptedData):string
    {
        return base64_encode(strrev(
                substr($encryptedData, (strlen($encryptedData)/2)-strlen($encryptedData), strlen($encryptedData)).
                substr($encryptedData, 0, (strlen($encryptedData)/2)-strlen($encryptedData)))
        );
    }
    /**
     * Decrypting.
     *
     * @param string $encryptedData
     *
     * @return string
     */
    protected function reverse(string $encryptedData):string
    {
        $encryptedData = base64_decode($encryptedData);
        return strrev(
            substr($encryptedData, (strlen($encryptedData)/2)-strlen($encryptedData),strlen($encryptedData)).
            substr($encryptedData, 0, (strlen($encryptedData)/2)-strlen($encryptedData))
        );
    }

    /**
     * Returns the encrypt prefix.
     *
     * @return string
     */
    public function get_prefix()
    {
        return $this->prefix;
    }
    /**
     * Set the encrypt prefix.
     *
     * @param string $prefix
     *
     * @return Hash
     */
    public function set_prefix(string $prefix):Hash
    {
        $this->prefix = trim($prefix);
        return $this;
    }
    /**
     * Returns the encrypt salt.
     *
     * @return string
     */
    public function get_salt()
    {
        return $this->salt;
    }
    /**
     * Set the encrypt salt.
     *
     * @param string $salt
     *
     * @return Hash
     */
    public function set_salt(string $salt):Hash
    {
        $salt = trim($salt);
        if (strlen($salt) == 22) {
            $this->salt = $salt;
        } else {
            $this->salt = $this->generate_hash();
        }
        return $this;
    }
    /**
     * Returns the encrypt cost.
     *
     * @return string
     */
    public function get_cost()
    {
        return $this->cost;
    }
    /**
     * Set the encrypt cost.
     *
     * @param int $cost
     *
     * @return Hash
     */
    public function set_cost(int $cost):Hash
    {
        if (($cost > 3) && ($cost < 32)) {
            $this->cost = $cost;
        } else {
            $this->cost = 8;
        }
        return $this;
    }

}

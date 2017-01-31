<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hash
{
    /**
     * Encryption prefix
     * @var string
     */
    protected $prefix = '2a';

    /**
     * Salt [MTc2MzMxNDQ4NTdmZDg4Yz]
     * @var string
     */
    protected $salt = '';

    /**
     * Cost default '8' [4 <> 31]
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
    public function __construct($prefix = '', $salt = '', $cost = 8)
    {
        $prefix = trim((string) $prefix); $salt = trim((string) $salt); $cost = (int) $cost;
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
    public function generate($value)
    {
        return str_replace('=', '', strrev(
            $this->inverse(crypt(strrev((string) $value), $this->generate_hash()))));
    }

    /**
     * Compare hashes.
     *
     * @param string $value
     * @param string $hash
     *
     * @return bool
     */
    public function is_equals($value, $hash)
    {
        $v = strrev((string) $value);
        $h = $this->reverse(strrev((string) $hash));
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
    protected function generate_salt()
    {
        return substr(base64_encode(uniqid(mt_rand(), true)), 0, 22);
    }

    /**
     * Build a hash string for crypt.
     *
     * @return string
     */
    protected function generate_hash()
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
    protected function inverse($encryptedData)
    {
        $encryptedData = (string) $encryptedData;
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
    protected function reverse($encryptedData)
    {
        $encryptedData = base64_decode((string) $encryptedData);
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
    public function set_prefix($prefix)
    {
        $this->prefix = trim((string) $prefix);
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
    public function set_salt($salt)
    {
        $salt = trim((string) $salt);
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
    public function set_cost($cost)
    {
        $cost = (int) $cost;
        if (($cost > 3) && ($cost < 32)) {
            $this->cost = $cost;
        } else {
            $this->cost = 8;
        }
        return $this;
    }

}

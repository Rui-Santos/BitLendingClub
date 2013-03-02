<?php

abstract class Service_Bitcoind_Abstract extends Zend_Service_Abstract
{

    /**
     * 
     * @param type $pubkey
     * @return type
     */
    public static function pubKeyToAddress($pubkey)
    {
        return self::hash160ToAddress($this->hash160($pubkey));
    }

    /**
     * 
     * @param type $hash160
     * @param type $addressversion
     * @return type
     */
    public static function hash160ToAddress($hash160, $addressversion = BITCOIN_ADDRESS_VERSION)
    {
        $hash160 = $addressversion . $hash160;
        $check = pack("H*", $hash160);
        $check = hash("sha256", hash("sha256", $check, true));
        $check = substr($check, 0, 8);
        $hash160 = strtoupper($hash160 . $check);
        return self::encodeBase58($hash160);
    }

    /**
     * 
     * @param type $hex
     * @return string
     */
    private function encodeBase58($hex)
    {
        if (strlen($hex) % 2 != 0) {
            die("encodeBase58: uneven number of hex characters");
        }
        $orighex = $hex;

        $hex = self::decodeHex($hex);
        $return = "";
        while (bccomp($hex, 0) == 1) {
            $dv = (string) bcdiv($hex, "58", 0);
            $rem = (integer) bcmod($hex, "58");
            $hex = $dv;
            $return = $return . self::$base58chars[$rem];
        }
        $return = strrev($return);

        //leading zeros
        for ($i = 0; $i < strlen($orighex) && substr($orighex, $i, 2) == "00"; $i += 2) {
            $return = "1" . $return;
        }

        return $return;
    }

    /**
     * 
     * @param type $hex
     * @return type
     */
    private function decodeHex($hex)
    {
        $hex = strtoupper($hex);
        $return = "0";
        for ($i = 0; $i < strlen($hex); $i++) {
            $current = (string) strpos(self::$hexchars, $hex[$i]);
            $return = (string) bcmul($return, "16", 0);
            $return = (string) bcadd($return, $current, 0);
        }
        return $return;
    }

    public static function addressToHash160($addr)
    {
        $addr = self::decodeBase58($addr);
        $addr = substr($addr, 2, strlen($addr) - 10);
        return $addr;
    }

    /**
     * 
     * @param type $base58
     * @return string
     */
    private function decodeBase58($base58)
    {
        $origbase58 = $base58;

        $return = "0";
        for ($i = 0; $i < strlen($base58); $i++) {
            $current = (string) strpos(Bitcoin::$base58chars, $base58[$i]);
            $return = (string) bcmul($return, "58", 0);
            $return = (string) bcadd($return, $current, 0);
        }

        $return = self::encodeHex($return);

        //leading zeros
        for ($i = 0; $i < strlen($origbase58) && $origbase58[$i] == "1"; $i++) {
            $return = "00" . $return;
        }

        if (strlen($return) % 2 != 0) {
            $return = "0" . $return;
        }

        return $return;
    }

    /**
     * 
     * @param type $addr
     * @param type $addressversion
     * @return boolean
     */
    public static function checkAddress($addr, $addressversion = BITCOIN_ADDRESS_VERSION)
    {
        $addr = self::decodeBase58($addr);
        if (strlen($addr) != 50) {
            return false;
        }
        $version = substr($addr, 0, 2);
        if (hexdec($version) > hexdec($addressversion)) {
            return false;
        }
        $check = substr($addr, 0, strlen($addr) - 8);
        $check = pack("H*", $check);
        $check = strtoupper(hash("sha256", hash("sha256", $check, true)));
        $check = substr($check, 0, 8);
        return $check == substr($addr, strlen($addr) - 8);
    }

    /**
     * 
     * @param type $dec
     * @return type
     */
    private function encodeHex($dec)
    {
        $return = "";
        while (bccomp($dec, 0) == 1) {
            $dv = (string) bcdiv($dec, "16", 0);
            $rem = (integer) bcmod($dec, "16");
            $dec = $dv;
            $return = $return . self::$hexchars[$rem];
        }
        return strrev($return);
    }

}
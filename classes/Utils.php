<?php
/**
 * Utilities
 * php version 7.2
 *
 * @category ImageManipulation\Utilities
 * @package  KokyIMage
 * @author   Martin Kokeš <info@martinkokes.cz>
 * @author   Jan Pilař <pilarjan4111@gmail.com>
 * @license  GPL https://choosealicense.com/licenses/gpl-3.0/
 * @link     imgmod.martinkokes.cz
 */

/**
 * Utilities class
 * php version 7.2
 *
 * @category ImageManipulation\Utilities\Utils
 * @package  KokyIMage
 * @author   Martin Kokeš <info@martinkokes.cz>
 * @author   Jan Pilař <pilarjan4111@gmail.com>
 * @license  GPL https://choosealicense.com/licenses/gpl-3.0/
 * @link     imgmod.martinkokes.cz
 */
class Utils
{
    /**
     * Generate a random string, using a cryptographically secure
     * pseudorandom number generator (random_int)
     *
     * For PHP 7, random_int is a PHP core function
     * For PHP 5.x, depends on https://github.com/paragonie/random_compat
     *
     * @param int    $length   How many characters do we want?
     * @param string $keyspace A string of all possible characters to select from
     * 
     * @return string
     */
    public static function randomStr(int $length, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
}

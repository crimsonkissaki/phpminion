<?php
/**
 * PHPMinion
 *
 * A suite of tools to facilitate development and debugging.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 9, 2015
 * @version     0.1
 */

namespace PHPMinion\Utilities\ClassAnalyzer\Workers;

use PHPMinion\Utilities\ClassAnalyzer\Exceptions\ClassAnalyzerException;

/**
 * TokenWorker
 *
 * Uses PHP tokens to get information about files.
 *
 * @created        October 26, 2015
 * @version        0.1
 */
class TokenWorker
{

    // token values change between versions, this will hopefully keep it constant
    // and putting them here helps with IDE hinting
    const USE_T = T_USE;
    const WHITESPACE_T = T_WHITESPACE;
    const STRING_T = T_STRING;
    const NS_SEPARATOR_T = T_NS_SEPARATOR;

    /**
     * Attempts to grab file text using PHP token indicators
     * http://php.net/manual/en/tokens.php
     *
     * @param string $file        File to parse
     * @param mixed  $start       Starting token
     * @param mixed  $end         Final token/symbol (;)
     * @param bool   $includeEnds Include the start/end args in the result strings
     * @return array
     * @throws ClassAnalyzerException
     */
    public function getTextByTokens($file, $start, $end = ';', $includeEnds = true)
    {
        if (!is_file($file)) {
            throw new ClassAnalyzerException("TokenWorker cannot tokenize invalid file '{$file}'");
        }

        $fileTokens = token_get_all(file_get_contents($file));
        // array of stdClass holding start/end keys for parsing
        $useTokens = [];
        $useTokenKey = 0;
        $foundStartToken = false;
        foreach ($fileTokens as $key => $token) {
            if (!$foundStartToken && $this->doesTokenMatch($start, $token)) {
                $foundStartToken = true;
                $useTokens[$useTokenKey] = new \stdClass;
                $useTokens[$useTokenKey]->startKey = $key;
            }
            if ($foundStartToken && $this->doesTokenMatch($end, $token)) {
                $foundStartToken = false;
                $useTokens[$useTokenKey]->endKey = $key;
                $useTokenKey += 1;
            }
        }

        if (!$includeEnds) {
            foreach ($useTokens as $k => $obj) {
                $obj->startKey += 1;
                $obj->endKey -= 1;
            }
        }

        $results = $this->compileTokenIdsIntoString($useTokens, $fileTokens);

        return $results;
    }

    /**
     * Checks a token for a start/end value
     *
     * Tokens can be arrays or a string if ;
     *
     * @param mixed $needle
     * @param mixed $token
     * @return bool
     */
    private function doesTokenMatch($needle, $token)
    {
        $haystack = (is_array($token)) ? $token[0] : $token;

        return ($needle === $haystack);
    }

    /**
     * Slices specified series of tokens from a full file token list
     *
     * @param   array $tokens     Start/Stop token keys
     * @param   array $fileTokens File token array
     * @return  array
     */
    private function compileTokenIdsIntoString($tokens, $fileTokens)
    {
        $strings = [];
        foreach ($tokens as $token) {
            $offset = $token->startKey;
            $length = ($token->endKey - $token->startKey) + 1;
            $tokensToCompile = array_slice($fileTokens, $offset, $length);
            $strings[] = $this->compileString($tokensToCompile);
        }

        return $strings;
    }

    /**
     * Compiles slice of PHP tokens into a string
     *
     * @param   array $tokens Tokens to combine into single string
     * @return  string
     */
    private function compileString($tokens)
    {
        $string = '';
        foreach ($tokens as $token) {
            $string .= (is_array($token) ? $token[1] : $token);
        }

        return $string;
    }
}

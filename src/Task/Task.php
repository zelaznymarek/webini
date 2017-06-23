<?php

namespace Task;

class Task
{
    private const BLACK = '000000';
    private const WHITE = 'ffffff';

    /**
     * Task no 1.
     * Returns unique id based on user info from $_SERVER.
     * Id is always not longer than 32 chars.
     */
    public function userUniqId(): string
    {
        $userInfo = array_filter($_SERVER, function ($x) {
            return in_array($x, [
                'REMOTE_ADDR',
                'REMOTE_HOST',
                'REMOTE_PORT',
                'REMOTE_USER',
                'REDIRECT_REMOTE_USER',
                'PHP_AUTH_USER',
                'PHP_AUTH_PW'
            ],
                false
            );
        });

        $userInfoString = implode('', $userInfo);

        $userInfoLenght = strlen($userInfoString);

        $leap = intdiv($userInfoLenght, 32) + 1;

        $id = '';

        $i = 0;

        while ($i < $userInfoLenght) {
            $id .= $userInfoString[$i];
            $i += $leap;
        }

        return $id;
    }

    /**
     * Task no 2.
     * Returns occurance of 3 same letters in a row.
     */
    public function sameThreeLettersCount(string $text): int
    {
        $counter = 0;
        for ($i = 0, $iMax = strlen($text) - 2; $i < $iMax; $i++) {
            if ($text[$i] === $text[$i + 1]
                && $text[$i + 1] === $text[$i + 2]
            ) {
                ++$counter;
            }
        }
        return $counter;
    }

    /**
     * Task no 3.
     * Prints text colored with grayscale.
     */
    public function colorString(string $text): void
    {
        $charSet = [];
        $colorSet = [];
        $leap = 9.8; //Color range 255 divided by number of letters in alphabeth (26).
        $currentColor = 0;

        for ($i = 97; $i < 123; $i++) {
            $charSet[] = chr($i);
        }

        foreach ($charSet as $key => $value) {
            $colorSet[$value] = dechex($currentColor) . dechex($currentColor) . dechex($currentColor);
            $currentColor += $leap;
        }
        $colorSet['z'] = self::WHITE;

        for ($i = 0, $iMax = strlen($text); $i < $iMax; $i++) {
            $char = $text[$i];

            $color = $colorSet[mb_strtolower($char)] ?? self::BLACK;
            echo "<span style=\"color:$color\">$char</span>";
        }
    }
}

<?php


namespace Task;


class TextManipulator
{
    private const AVG_WORDS_PER_SEC = 4;

    /** @var string */
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Returns number of alphanumeric signs in given text.
     * Whitespaces, special signsa dn newline signs are not counted.
     */
    public function countAlphanums(): int
    {

        $pattern = '/[\p{L}\d]/';
        return preg_match_all($pattern, $this->text);
    }

    /**
     * Returns number of words in given text.
     * One letter conjunctions are also counted.
     */
    public function countWords(): int
    {

        $pattern = '/[a-zżółćęśąźń]+/iu';
        return preg_match_all($pattern, $this->text);
    }

    /**
     * Replaces all occurences of 'search' with 'replace' string.
     */
    public function replace(string $search, string $replace): void
    {
        $this->text = str_replace($search, $replace, $this->text);
    }

    /**
     * Returns sorted array of aggregate counted words in given text.
     */
    public function aggregateWords(): array
    {
        $cleanText = $this->sanitize($this->text);
        $words = $this->split($cleanText);
        $aggregatedWords = $this->aggregate($words);

        arsort($aggregatedWords);

        return $aggregatedWords;
    }

    /**
     * Returns given text without special chars.
     */
    private function sanitize(string $text): string
    {
        $sanitizePattern = '/[^\s\p{L}\d]/';
        return preg_replace($sanitizePattern, '', $text);
    }

    /**
     * Returns array with words.
     */
    private function split(string $text): array
    {
        $splitPattern = '/[\t|\r|\n|\s]+/';
        return preg_split($splitPattern, mb_strtolower($text));
    }

    /**
     * Aggregate count words.
     */
    private function aggregate(array $words): array
    {
        $aggregatedWords = [];

        foreach ($words as $word) {
            if (array_key_exists($word, $aggregatedWords)) {
                ++$aggregatedWords[$word];
                continue;
            }
            $aggregatedWords[$word] = 1;
        }
        return $aggregatedWords;
    }

    /**
     * Returns estimates time in seconds needed to read article.
     */
    public function estimateTime(): int
    {

        return intdiv($this->countWords(), self::AVG_WORDS_PER_SEC);
    }

    /**
     * Returns article with shuffled sentences.
     */
    public function shuffleArticle(): string
    {
        $articleArray = explode('.', $this->text);

        $sentencesWithDots = array_map([$this, "addDots"], $articleArray);

        shuffle($sentencesWithDots);

        return implode(' ', $sentencesWithDots);
    }

    /**
     * Adds dots at the end of sentence.
     */
    private function addDots(string $sentence): ?string
    {
        if ('' === $sentence) {
            return null;
        }
        return trim($sentence) . '.';
    }

    /**
     * Prints text in grayscale.
     */
    public function colorText(Task $task): void
    {
        $task->colorString($this->text);
    }
}

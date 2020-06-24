<?php

namespace DivineOmega\PHPSummary;

class SummaryTool
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    private function getParagraphs(string $content): array
    {
        return explode(PHP_EOL.PHP_EOL, $content);
    }

    private function getSentences(string $content): array
    {
        $sentenceTokenizer = new SentenceTokenizer();
        $sentenceTokenizer->setContent($content);

        return $sentenceTokenizer->getSentences();
    }

    /**
     * @return bool|int
     */
    private function sentencesIntersection(string $sent1, string $sent2)
    {
        $s1 = explode(' ', $sent1);
        $s2 = explode(' ', $sent2);

        if (count($s1) + count($s2) === 0) {
            return true;
        }

        $intersect = array_intersect($s1, $s2);
        $splicePoint = ((count($s1) + count($s2)) / 2);

        $splicedIntersect = array_splice($intersect, 0, $splicePoint);

        return count($splicedIntersect);
    }

    private function getSentencesRanks(string $content): array
    {
        $sentences = $this->getSentences($content);
        $n = count($sentences);

        $values = [];

        // Assign each score to each sentence
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $intersection = $this->sentencesIntersection($sentences[$i], $sentences[$j]);
                $values[$i][$j] = $intersection;
            }
        }

        // Build sentences object array
        $sentenceRankings = [];

        for ($i = 0; $i < $n; $i++) {
            $score = 0;
            for ($j = 0; $j < $n; $j++) {
                if ($i == $j) {
                    continue;
                }

                $score += $values[$i][$j];
            }

            $sentenceRanking = new \stdClass();
            $sentenceRanking->sentence = $sentences[$i];
            $sentenceRanking->score = $score;

            $sentenceRankings[] = $sentenceRanking;
        }

        return $sentenceRankings;
    }

    private function getBestSentence(string $paragraph, array $sentenceRankings): ?string
    {
        $sentences = $this->getSentences($paragraph);

        if (count($sentences) < 2) {
            return null;
        }

        $highestScore = 0;
        $bestSentence = null;

        foreach ($sentences as $sentence) {
            foreach ($sentenceRankings as $sentenceRanking) {
                if ($sentenceRanking->sentence == $sentence && $sentenceRanking->score > $highestScore) {
                    $highestScore = $sentenceRanking->score;
                    $bestSentence = $sentenceRanking->sentence;
                }
            }
        }

        return $bestSentence;
    }

    public function getSummarySentences(): array
    {
        $sentenceRankings = $this->getSentencesRanks($this->content);

        $paragraphs = $this->getParagraphs($this->content);

        $sentences = [];

        foreach ($paragraphs as $paragraph) {
            $bestSentence = $this->getBestSentence($paragraph, $sentenceRankings);

            if ($bestSentence) {
                $sentences[] = $bestSentence;
            }
        }

        return $sentences;
    }

    public function getSummary(): string
    {
        $sentences = $this->getSummarySentences();

        $summary = '';

        foreach ($sentences as $sentence) {
            $summary .= $sentence;
            $summary .= ' ';
        }

        return trim($summary);
    }
}

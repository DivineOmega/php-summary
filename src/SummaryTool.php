<?php
namespace DivineOmega\PHPSummary;

use DivineOmega\PHPSummary\SentenceTokenizer;

class SummaryTool
{
  private $title = null;
  private $content = null;

  public function __construct($title, $content) {
    $this->title = $title;
    $this->content = $content;
  }

  private function getParagraphs($content) {
    return explode("\n\n", $content);
  }

  private function getSentences($content) {
    $sentenceTokenizer = new SentenceTokenizer();
    $sentenceTokenizer->setContent($content);
    return $sentenceTokenizer->getSentences();
  }

  private function sentencesIntersection($sent1, $sent2) {
  	$s1 = explode(' ', $sent1);
  	$s2 = explode(' ', $sent2);

  	if(count($s1) + count($s2) === 0) {
  		return true;
  	}

  	$intersect  = array_intersect($s1, $s2);
  	$splicePoint = ((count($s1) + count($s2)) / 2);

    $splicedIntersect = array_splice($intersect, 0, $splicePoint);

    return count($splicedIntersect);
  }

  private function getSentencesRanks($content) {
  	$sentences = $this->getSentences($content);
    $n = count($sentences);

		$values = [];

		// Assign each score to each sentence
    for ($i=0; $i < $n; $i++) {
      for ($j=0; $j < $n; $j++) {
				$intersection = $this->sentencesIntersection($sentences[$i], $sentences[$j]);
				$values[$i][$j] = $intersection;
			}
		}

		// Build sentences object array
		$sentenceRankings = [];

    for ($i=0; $i < $n; $i++) {
      $score = 0;
      for ($j=0; $j < $n; $j++) {
        if ($i==$j) {
          continue;
        }

        $score += $values[$i][$j];
      }

      $sentenceRanking = new \stdClass;
      $sentenceRanking->sentence = $sentences[$i];
      $sentenceRanking->score = $score;

      $sentenceRankings[] = $sentenceRanking;
    }

		return $sentenceRankings;
	}

  private function getBestSentence($paragraph, $sentenceRankings) {

    $sentences = $this->getSentences($paragraph);

    if (count($sentences)<2) {
      return;
    }

    $highestScore = 0;
    $bestSentence = null;

    foreach($sentences as $sentence) {
      foreach($sentenceRankings as $sentenceRanking)
      {
        if ($sentenceRanking->sentence == $sentence && $sentenceRanking->score > $highestScore)
        {
          $highestScore = $sentenceRanking->score;
          $bestSentence = $sentenceRanking->sentence;
        }
      }
    }

    return $bestSentence;
  }

  public function getSummarySentences()
  {
    $sentenceRankings = $this->getSentencesRanks($this->content);

    $paragraphs = $this->getParagraphs($this->content);

    $sentences = [];

    foreach($paragraphs as $paragraph) {
      $bestSentence = $this->getBestSentence($paragraph, $sentenceRankings);

      if ($bestSentence) {
        $sentences[] = $bestSentence;
      }
    }

    return $sentences;
  }

  public function getSummaryWithoutTitle()
  {
    $sentences = $this->getSummarySentences();

    $summary = "";

    foreach($sentences as $sentence) {
        $summary .= $sentence;
        $summary .= " ";
    }

    $summary = trim($summary);

    return $summary;
  }

  public function getSummary() {

    $summary = $this->title;
    $summary .= "\n\n";

    $summary .= $this->getSummaryWithoutTitle();

    $summary .= "\n\n";

    return $summary;
  }

}

?>

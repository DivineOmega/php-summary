<?php
namespace DivineOmega\PHPSummary;

use DivineOmega\PHPSummary\SentenceTokenizer;

class Summary
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

  private function intersectSafe($a, $b) {
    $ai = 0;
    $bi = 0;
    $result = [];

  	while($ai < count($a) && $bi < count($b)) {
  		if      ($a[$ai] < $b[$bi] ){ $ai++; }
  		else if ($a[$ai] > $b[$bi] ){ $bi++; }
  		else /* they're equal */
  		{
  			$result[] = $a[$ai];
  			$ai++;
  			$bi++;
  		}
  	}

  	return $result;
  }

  private function sentencesIntersection($sent1, $sent2) {
  	$s1 = explode(' ', $sent1);
  	$s2 = explode(' ', $sent2);

  	if(count($s1) + count($s2) === 0) {
  		return true;
  	}

  	$intersect  = $this->intersectSafe($s1, $s2);
  	$splicePoint = ((count($s1) + count($s2)) / 2);

    $splicedIntersect = array_splice($intersect, 0, $splicePoint);

    return count($splicedIntersect);
  }

  private function getSentencesRanks($content) {
  	$sentences = $this->getSentences($content);
    $n = count($sentences);
  	$zeroNRange = range(0, $n);
  	$nRange = range(0, $n);

		$values = [];

		// Assign each score to each sentence
    for ($i=0; $i < $n; $i++) {
      for ($j=0; $j < $n; $j++) {
				$intersection = $this->sentencesIntersection($sentences[$i], $sentences[$j]);
				$values[$i][$j] = $intersection;
			}
		}

		// Build sentences object array
		$sentenceObjs = [];

    for ($i=0; $i < $n; $i++) {
      $score = 0;
      for ($j=0; $j < $n; $j++) {
        if ($i==$j) {
          continue;
        }

        $score += $values[$i][$j];
      }

      $sentenceObj = new \stdClass;
      $sentenceObj->sentence = $sentences[$i];
      $sentenceObj->score = $score;

      $sentenceObjs[] = $sentenceObj;
    }

		return $sentenceObjs;
	}

  private function getBestSentence($paragraph, $sentenceObjs) {

    $sentences = $this->getSentences($paragraph);

    if (count($sentences)<2) {
      return;
    }

    $highestScore = 0;
    $bestSentence = 0;

    foreach($sentences as $sentence) {
      foreach($sentenceObjs as $sentenceObj)
      {
        if ($sentenceObj->sentence == $sentence && $sentenceObj->score > $highestScore)
        {
          $highestScore = $sentenceObj->score;
          $bestSentence = $sentenceObj->sentence;
        }
      }
    }

    return $bestSentence;
  }

  public function getSummary() {

    $sentenceObjs = $this->getSentencesRanks($this->content);

    $paragraphs = $this->getParagraphs($this->content);

    $summary = $this->title;
    $summary .= "\n\n";

    foreach($paragraphs as $paragraph) {
      $bestSentence = $this->getBestSentence($paragraph, $sentenceObjs);

      if ($bestSentence) {
        $summary .= $bestSentence;
        $summary .= " ";
      }
    }

    $summary .= "\n\n";

    return $summary;
  }

}

?>

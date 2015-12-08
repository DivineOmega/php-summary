<?php
namespace DivineOmega\PHPSummary;

class SentenceTokenizer
{
  private $content = null;

  public function setContent($content) {
    $this->content = $content;
  }

  public function getSentences() {

    if (!trim($this->content)) {
      return [];
    }

    $contentParts = preg_split("/([\.\!\?])+/", $this->content, -1, PREG_SPLIT_DELIM_CAPTURE);

    $sentences = [];

    for ($i=0; $i < count($contentParts); $i+=2) {

      if (!isset($contentParts[$i+1])) {
        break;
      }

      $sentence = $contentParts[$i] . $contentParts[$i+1];
      $sentence = trim($sentence);
      $sentences[] = $sentence;
    }

    return $sentences;

  }

}

?>

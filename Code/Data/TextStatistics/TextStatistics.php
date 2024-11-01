<?php class TextStatistics{ protected $strEncoding = ''; public $normalise = true; public $dps = 1; private static $strText = false; public function __construct($strEncoding = '') { if ($strEncoding != '') { $this->strEncoding = $strEncoding; } } public function setText($strText) { if ($strText !== false) { self::$strText = Text::cleanText($strText); } return self::$strText; } public function setEncoding($strEncoding) { $this->strEncoding = $strEncoding; return true; } public function fleschKincaidReadingEase($strText = false) { $strText = $this->setText($strText); $score = Maths::bcCalc( Maths::bcCalc( 206.835, '-', Maths::bcCalc( 1.015, '*', Text::averageWordsPerSentence($strText, $this->strEncoding) ) ), '-', Maths::bcCalc( 84.6, '*', Syllables::averageSyllablesPerWord($strText, $this->strEncoding) ) ); if ($this->normalise) { return Maths::normaliseScore($score, 0, 100, $this->dps); } else { return Maths::bcCalc($score, '+', 0, true, $this->dps); } } public function fleschKincaidGradeLevel($strText = false) { $strText = $this->setText($strText); $score = Maths::bcCalc( Maths::bcCalc( 0.39, '*', Text::averageWordsPerSentence($strText, $this->strEncoding) ), '+', Maths::bcCalc( Maths::bcCalc( 11.8, '*', Syllables::averageSyllablesPerWord($strText, $this->strEncoding) ), '-', 15.59 ) ); if ($this->normalise) { return Maths::normaliseScore($score, 0, 12, $this->dps); } else { return Maths::bcCalc($score, '+', 0, true, $this->dps); } } public function gunningFogScore($strText = false) { $strText = $this->setText($strText); $score = Maths::bcCalc( Maths::bcCalc( Text::averageWordsPerSentence($strText, $this->strEncoding), '+', Syllables::percentageWordsWithThreeSyllables($strText, false, $this->strEncoding) ), '*', '0.4' ); if ($this->normalise) { return Maths::normaliseScore($score, 0, 19, $this->dps); } else { return Maths::bcCalc($score, '+', 0, true, $this->dps); } } public function colemanLiauIndex($strText = false) { $strText = $this->setText($strText); $score = Maths::bcCalc( Maths::bcCalc( Maths::bcCalc( 5.89, '*', Maths::bcCalc( Text::letterCount($strText, $this->strEncoding), '/', Text::wordCount($strText, $this->strEncoding) ) ), '-', Maths::bcCalc( 0.3, '*', Maths::bcCalc( Text::sentenceCount($strText, $this->strEncoding), '/', Text::wordCount($strText, $this->strEncoding) ) ) ), '-', 15.8 ); if ($this->normalise) { return Maths::normaliseScore($score, 0, 12, $this->dps); } else { return Maths::bcCalc($score, '+', 0, true, $this->dps); } } public function smogIndex($strText = false) { $strText = $this->setText($strText); $score = Maths::bcCalc( 1.043, '*', Maths::bcCalc( Maths::bcCalc( Maths::bcCalc( Syllables::wordsWithThreeSyllables($strText, true, $this->strEncoding), '*', Maths::bcCalc( 30, '/', Text::sentenceCount($strText, $this->strEncoding) ) ), 'sqrt', 0 ), '+', 3.1291 ) ); if ($this->normalise) { return Maths::normaliseScore($score, 0, 12, $this->dps); } else { return Maths::bcCalc($score, '+', 0, true, $this->dps); } } public function automatedReadabilityIndex($strText = false) { $strText = $this->setText($strText); $score = Maths::bcCalc( Maths::bcCalc( 4.71, '*', Maths::bcCalc( Text::letterCount($strText, $this->strEncoding), '/', Text::wordCount($strText, $this->strEncoding) ) ), '+', Maths::bcCalc( Maths::bcCalc( 0.5, '*', Maths::bcCalc( Text::wordCount($strText, $this->strEncoding), '/', Text::sentenceCount($strText, $this->strEncoding) ) ), '-', 21.43 ) ); if ($this->normalise) { return Maths::normaliseScore($score, 0, 12, $this->dps); } else { return Maths::bcCalc($score, '+', 0, true, $this->dps); } } public function daleChallReadabilityScore($strText = false) { $strText = $this->setText($strText); $score = Maths::bcCalc( Maths::bcCalc( 0.1579, '*', Maths::bcCalc( 100, '*', Maths::bcCalc( $this->daleChallDifficultWordCount($strText), '/', Text::wordCount($strText, $this->strEncoding) ) ) ), '+', Maths::bcCalc( 0.0496, '*', Maths::bcCalc( Text::wordCount($strText, $this->strEncoding), '/', Text::sentenceCount($strText, $this->strEncoding) ) ) ); if ($this->normalise) { return Maths::normaliseScore($score, 0, 10, $this->dps); } else { return Maths::bcCalc($score, '+', 0, true, $this->dps); } } public function spacheReadabilityScore($strText = false) { $strText = $this->setText($strText); $score = Maths::bcCalc( Maths::bcCalc( Maths::bcCalc( 0.121, '*', Maths::bcCalc( Text::wordCount($strText, $this->strEncoding), '/', Text::sentenceCount($strText, $this->strEncoding) ) ), '+', Maths::bcCalc( 0.082, '*', $this->spacheDifficultWordCount($strText) ) ), '+', 0.659 ); if ($this->normalise) { return Maths::normaliseScore($score, 0, 5, $this->dps); } else { return Maths::bcCalc($score, '+', 0, true, $this->dps); } } public function daleChallDifficultWordCount($strText = false) { $strText = $this->setText($strText); $intDifficultWords = 0; $arrWords = explode(' ', Text::lowerCase(preg_replace('`[^A-za-z\' ]`', '', $strText), $this->strEncoding)); $arrDaleChall = Resource::fetchDaleChallWordList(); for ($i = 0, $intWordCount = count($arrWords); $i < $intWordCount; $i++) { if (strlen(trim($arrWords[$i])) < 2) { continue; } if ((!in_array(Pluralise::getPlural($arrWords[$i]), $arrDaleChall)) && (!in_array(Pluralise::getSingular($arrWords[$i]), $arrDaleChall))) { $intDifficultWords++; } } return $intDifficultWords; } public function spacheDifficultWordCount($strText = false) { $strText = $this->setText($strText); $intDifficultWords = 0; $arrWords = explode(' ', strtolower(preg_replace('`[^A-za-z\' ]`', '', $strText))); $wordsCounted = array(); $arrSpache = Resource::fetchSpacheWordList(); for ($i = 0, $intWordCount = count($arrWords); $i < $intWordCount; $i++) { if (strlen(trim($arrWords[$i])) < 2) { continue; } $singularWord = Pluralise::getSingular($arrWords[$i]); if ((!in_array(Pluralise::getPlural($arrWords[$i]), $arrSpache)) && (!in_array($singularWord, $arrSpache))) { if (!in_array($singularWord, $wordsCounted)) { $intDifficultWords++; $wordsCounted[] = $singularWord; } } } return $intDifficultWords; } public function letterCount($strText = false) { $strText = $this->setText($strText); return Text::letterCount($strText, $this->strEncoding); } public function sentenceCount($strText = false) { $strText = $this->setText($strText); return Text::sentenceCount($strText, $this->strEncoding); } public function wordCount($strText = false) { $strText = $this->setText($strText); return Text::wordCount($strText, $this->strEncoding); } public function averageWordsPerSentence($strText = false) { $strText = $this->setText($strText); return Text::averageWordsPerSentence($strText, $this->strEncoding); } public function syllableCount($strText = false) { $strText = $this->setText($strText); return Syllables::syllableCount($strText, $this->strEncoding); } public function totalSyllables($strText = false) { $strText = $this->setText($strText); return Syllables::totalSyllables($strText, $this->strEncoding); } public function averageSyllablesPerWord($strText = false) { $strText = $this->setText($strText); return Syllables::averageSyllablesPerWord($strText, $this->strEncoding); } public function wordsWithThreeSyllables($strText = false, $blnCountProperNouns = true) { $strText = $this->setText($strText); return Syllables::wordsWithThreeSyllables($strText, $blnCountProperNouns, $this->strEncoding); } public function percentageWordsWithThreeSyllables($strText = false, $blnCountProperNouns = true) { $strText = $this->setText($strText); return Syllables::percentageWordsWithThreeSyllables($strText, $blnCountProperNouns, $this->strEncoding); } public function flesch_kincaid_reading_ease($strText = false) { return $this->fleschKincaidReadingEase($strText); } public function flesch_kincaid_grade_level($strText = false) { return $this->fleschKincaidGradeLevel($strText); } public function gunning_fog_score($strText = false) { return $this->gunningFogScore($strText); } public function coleman_liau_index($strText = false) { return $this->colemanLiauIndex($strText); } public function smog_index($strText = false) { return $this->smogIndex($strText); } public function automated_readability_index($strText = false) { return $this->automatedReadabilityIndex($strText); } public function dale_chall_readability_score($strText = false) { return $this->daleChallReadabilityScore($strText); } public function spache_readability_score($strText = false) { return $this->spacheReadabilityScore($strText); } } 
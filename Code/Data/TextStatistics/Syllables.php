<?php class Syllables{ static public $arrProblemWords = array( 'abalone' => 4 ,'abare' => 3 ,'abed' => 2 ,'abruzzese' => 4 ,'abbruzzese' => 4 ,'aborigine' => 5 ,'acreage' => 3 ,'adame' => 3 ,'adieu' => 2 ,'adobe' => 3 ,'anemone' => 4 ,'apache' => 3 ,'aphrodite' => 4 ,'apostrophe' => 4 ,'ariadne' => 4 ,'cafe' => 2 ,'calliope' => 4 ,'catastrophe' => 4 ,'chile' => 2 ,'chloe' => 2 ,'circe' => 2 ,'coyote' => 3 ,'epitome' => 4 ,'forever' => 3 ,'gethsemane' => 4 ,'guacamole' => 4 ,'hyperbole' => 4 ,'jesse' => 2 ,'jukebox' => 2 ,'karate' => 3 ,'machete' => 3 ,'maybe' => 2 ,'people' => 2 ,'recipe' => 3 ,'sesame' => 3 ,'shoreline' => 2 ,'simile' => 3 ,'syncope' => 3 ,'tamale' => 3 ,'yosemite' => 4 ,'daphne' => 2 ,'eurydice' => 4 ,'euterpe' => 3 ,'hermione' => 4 ,'penelope' => 4 ,'persephone' => 4 ,'phoebe' => 2 ,'zoe' => 2 ); static public $arrSubSyllables = array( 'cia(l|$)' ,'tia' ,'cius' ,'cious' ,'[^aeiou]giu' ,'[aeiouy][^aeiouy]ion' ,'iou' ,'sia$' ,'eous$' ,'[oa]gue$' ,'.[^aeiuoycgltdb]{2,}ed$' ,'.ely$' ,'^jua' ,'uai' ,'eau' ,'[aeiouy](b|c|ch|d|dg|f|g|gh|gn|k|l|ll|lv|m|mm|n|nc|ng|nn|p|r|rc|rn|rs|rv|s|sc|sk|sl|squ|ss|st|t|th|v|y|z)e$' ,'[aeiouy](b|c|ch|dg|f|g|gh|gn|k|l|lch|ll|lv|m|mm|n|nc|ng|nch|nn|p|r|rc|rn|rs|rv|s|sc|sk|sl|squ|ss|th|v|y|z)ed$' ,'[aeiouy](b|ch|d|f|gh|gn|k|l|lch|ll|lv|m|mm|n|nch|nn|p|r|rn|rs|rv|s|sc|sk|sl|squ|ss|st|t|th|v|y)es$' ,'^busi$' ); static public $arrAddSyllables = array( '([^s]|^)ia' ,'riet' ,'dien' ,'iu' ,'io' ,'eo($|[b-df-hj-np-tv-z])' ,'ii' ,'[ou]a$' ,'[aeiouym]bl$' ,'[aeiou]{3}' ,'[aeiou]y[aeiou]' ,'^mc' ,'ism$' ,'asm$' ,'thm$' ,'([^aeiouy])\1l$' ,'[^l]lien' ,'^coa[dglx].' ,'[^gq]ua[^auieo]' ,'dnt$' ,'uity$' ,'[^aeiouy]ie(r|st|t)$' ,'eings?$' ,'[aeiouy]sh?e[rsd]$' ,'iell' ,'dea$' ,'real' ,'[^aeiou]y[ae]' ,'gean$' ,'uen' ); static public $arrAffix = array( '`^un`' ,'`^fore`' ,'`^ware`' ,'`^none?`' ,'`^out`' ,'`^post`' ,'`^sub`' ,'`^pre`' ,'`^pro`' ,'`^dis`' ,'`^side`' ,'`ly$`' ,'`less$`' ,'`some$`' ,'`ful$`' ,'`ers?$`' ,'`ness$`' ,'`cians?$`' ,'`ments?$`' ,'`ettes?$`' ,'`villes?$`' ,'`ships?$`' ,'`sides?$`' ,'`ports?$`' ,'`shires?$`' ,'`tion(ed)?$`' ); static public $arrDoubleAffix = array( '`^above`' ,'`^ant[ie]`' ,'`^counter`' ,'`^hyper`' ,'`^afore`' ,'`^agri`' ,'`^in[ft]ra`' ,'`^inter`' ,'`^over`' ,'`^semi`' ,'`^ultra`' ,'`^under`' ,'`^extra`' ,'`^dia`' ,'`^micro`' ,'`^mega`' ,'`^kilo`' ,'`^pico`' ,'`^nano`' ,'`^macro`' ,'`berry$`' ,'`woman$`' ,'`women$`' ); static public $arrTripleAffix = array( '`ology$`' ,'`ologist$`' ,'`onomy$`' ,'`onomist$`' ); public static function syllableCount($strWord, $strEncoding = '') { $strWord = trim($strWord); if (Text::letterCount(trim($strWord), $strEncoding) == 0) { return 0; } $debug = array(); $debug['Counting syllables for'] = $strWord; $strWord = preg_replace('`[^A-Za-z]`', '', $strWord); $strWord = Text::lowerCase($strWord, $strEncoding); if (isset(self::$arrProblemWords[$strWord])) { return self::$arrProblemWords[$strWord]; } $singularWord = Pluralise::getSingular($strWord); if ($singularWord != $strWord) { if (isset(self::$arrProblemWords[$singularWord])) { return self::$arrProblemWords[$singularWord]; } } $debug['After cleaning, lcase'] = $strWord; $strWord = preg_replace(self::$arrAffix, '', $strWord, -1, $intAffixCount); $strWord = preg_replace(self::$arrDoubleAffix, '', $strWord, -1, $intDoubleAffixCount); $strWord = preg_replace(self::$arrTripleAffix, '', $strWord, -1, $intTripleAffixCount); if (($intAffixCount + $intDoubleAffixCount + $intTripleAffixCount) > 0) { $debug['After Prefix and Suffix Removal'] = $strWord; $debug['Prefix and suffix counts'] = $intAffixCount . ' * 1 syllable, ' . $intDoubleAffixCount . ' * 2 syllables, ' . $intTripleAffixCount . ' * 3 syllables'; } $arrWordParts = preg_split('`[^aeiouy]+`', $strWord); $intWordPartCount = 0; foreach ($arrWordParts as $strWordPart) { if ($strWordPart <> '') { $debug['Counting (' . $intWordPartCount . ')'] = $strWordPart; $intWordPartCount++; } } $intSyllableCount = $intWordPartCount + $intAffixCount + (2 * $intDoubleAffixCount) + (3 * $intTripleAffixCount); $debug['Syllables by Vowel Count'] = $intSyllableCount; foreach (self::$arrSubSyllables as $strSyllable) { $_intSyllableCount = $intSyllableCount; $intSyllableCount -= preg_match('`' . $strSyllable . '`', $strWord); if ($_intSyllableCount != $intSyllableCount) { $debug['Subtracting (' . $strSyllable . ')'] = $strSyllable; } } foreach (self::$arrAddSyllables as $strSyllable) { $_intSyllableCount = $intSyllableCount; $intSyllableCount += preg_match('`' . $strSyllable . '`', $strWord); if ($_intSyllableCount != $intSyllableCount) { $debug['Adding (' . $strSyllable . ')'] = $strSyllable; } } $intSyllableCount = ($intSyllableCount == 0) ? 1 : $intSyllableCount; $debug['Result'] = $intSyllableCount; return $intSyllableCount; } public static function totalSyllables($strText, $strEncoding = '') { $intSyllableCount = 0; $arrWords = explode(' ', $strText); $intWordCount = count($arrWords); for ($i = 0; $i < $intWordCount; $i++) { $intSyllableCount += self::syllableCount($arrWords[$i], $strEncoding); } return $intSyllableCount; } public static function averageSyllablesPerWord($strText, $strEncoding = '') { $intSyllableCount = 0; $intWordCount = Text::wordCount($strText, $strEncoding); $arrWords = explode(' ', $strText); for ($i = 0; $i < $intWordCount; $i++) { $intSyllableCount += self::syllableCount($arrWords[$i], $strEncoding); } $averageSyllables = (Maths::bcCalc($intSyllableCount, '/', $intWordCount)); return $averageSyllables; } public static function wordsWithThreeSyllables($strText, $blnCountProperNouns = true, $strEncoding = '') { $intLongWordCount = 0; $intWordCount = Text::wordCount($strText, $strEncoding); $arrWords = explode(' ', $strText); for ($i = 0; $i < $intWordCount; $i++) { if (Syllables::syllableCount($arrWords[$i], $strEncoding) > 2) { if ($blnCountProperNouns) { $intLongWordCount++; } else { $strFirstLetter = Text::substring($arrWords[$i], 0, 1, $strEncoding); if ($strFirstLetter !== Text::upperCase($strFirstLetter, $strEncoding)) { $intLongWordCount++; } } } } return $intLongWordCount; } public static function percentageWordsWithThreeSyllables($strText, $blnCountProperNouns = true, $strEncoding = '') { $intWordCount = Text::wordCount($strText, $strEncoding); $intLongWordCount = self::wordsWithThreeSyllables($strText, $blnCountProperNouns, $strEncoding); $intPercentage = Maths::bcCalc(Maths::bcCalc($intLongWordCount, '/', $intWordCount), '*', 100); return $intPercentage; } } 
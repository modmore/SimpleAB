<?php
$snips = array(
    'sabConversion' => 'Stand-alone snippet to register a conversion to SimpleAB.',
    'sabConversionHook' => 'Hook for use with FormIt to register a conversion to SimpleAB.',
    'SimpleAB' => 'SimpleAB snippet to run Chunk A/B tests. Specify the &test property.',
);

$snippets = array();
$idx = 0;

foreach ($snips as $name => $description) {
    $idx++;
    $snippets[$idx] = $modx->newObject('modSnippet');
    $snippets[$idx]->fromArray(array(
       'id' => $idx,
       'name' => $name,
       'description' => $description . ' (Part of SimpleAB)',
       'snippet' => getSnippetContent($sources['snippets'] . strtolower($name) . '.snippet.php')
    ));
}

return $snippets;

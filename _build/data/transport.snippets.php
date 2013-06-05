<?php
$snips = array(
    'sabConversion' => 'Stand-alone snippet to register a conversion to SimpleAB.',
    'sabConversionHook' => 'Hook for use with FormIt to register a conversion to SimpleAB.',
    'sabConversionUrl' => 'Snippet that properly generates the URL to load via AJAX to register a conversion.',
    'SimpleAB' => 'SimpleAB snippet to run Chunk A/B tests. Specify the &test property.',
);

$snippets = array();
$idx = 0;

foreach ($snips as $name => $description) {
    $idx++;
    $snippets[$idx] = $modx->newObject('modSnippet');
    $snippets[$idx]->fromArray(array(
       'name' => $name,
       'description' => $description . ' (Part of SimpleAB)',
       'snippet' => getSnippetContent($sources['snippets'] . strtolower($name) . '.snippet.php')
    ));
}

return $snippets;

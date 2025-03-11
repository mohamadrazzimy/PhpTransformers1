<?php
require "./vendor/autoload.php";

// Enable garbage collection
gc_enable();

use Codewithkyrian\Transformers\Transformers;
use function Codewithkyrian\Transformers\Pipelines\pipeline;

Transformers::setup()->setCacheDir("./models")->apply();

// Use a smaller model for translation
$translationPipeline = pipeline("translation", 'Xenova/nllb-200-distilled-600M');

$inputs = [
    "The quality of tools in the PHP ecosystem has greatly improved in recent years",
    "Some developers don't like PHP as a programming language",
    "I appreciate Laravel as a development tool",
    "Laravel is a framework that improves my productivity",
    "Using an outdated version of Laravel is not a good practice",
    "I love Laravel",
];


foreach ($inputs as $input) {
    $output = $translationPipeline(
        $input,
        maxNewTokens: 256,
        tgtLang: 'ita_Latn'
    );
    echo "🇬🇧 " . $input . PHP_EOL;
    echo "🇮🇹 " . trim($output[0]["translation_text"]) . PHP_EOL;
    echo PHP_EOL;

    // Clean up memory
    gc_collect_cycles();
}


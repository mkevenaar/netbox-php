<?php

if ($argc < 3) {
    fwrite(STDERR, "Usage: php tests/check-coverage.php <clover.xml> <minimum-percent>\n");
    exit(2);
}

$coverageFile = $argv[1];
$minimumCoverage = (float) $argv[2];

if (!is_file($coverageFile)) {
    fwrite(STDERR, sprintf("Coverage file not found: %s\n", $coverageFile));
    exit(2);
}

$document = new DOMDocument();
if (!$document->load($coverageFile)) {
    fwrite(STDERR, sprintf("Unable to read coverage file: %s\n", $coverageFile));
    exit(2);
}

$metrics = $document->getElementsByTagName('project')->item(0);
if ($metrics === null) {
    fwrite(STDERR, "Coverage file does not contain project metrics.\n");
    exit(2);
}

$projectMetrics = null;
foreach ($metrics->childNodes as $childNode) {
    if ($childNode instanceof DOMElement && $childNode->tagName === 'metrics') {
        $projectMetrics = $childNode;
        break;
    }
}

if ($projectMetrics === null) {
    fwrite(STDERR, "Coverage file does not contain statement metrics.\n");
    exit(2);
}

$statements = (int) $projectMetrics->getAttribute('statements');
$coveredStatements = (int) $projectMetrics->getAttribute('coveredstatements');
$coverage = $statements === 0 ? 0.0 : ($coveredStatements / $statements) * 100;

printf("Statement coverage: %.2f%% (%d/%d)\n", $coverage, $coveredStatements, $statements);

if ($coverage < $minimumCoverage) {
    fwrite(
        STDERR,
        sprintf("Coverage %.2f%% is below required minimum %.2f%%.\n", $coverage, $minimumCoverage)
    );
    exit(1);
}

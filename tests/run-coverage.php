<?php

$minimumCoverage = $argc > 1 ? (float) $argv[1] : null;
$coverageFile = $argv[2] ?? 'build/logs/clover.xml';

$phpunit = findPhpUnit();
if ($phpunit === null) {
    fwrite(STDERR, "Unable to find PHPUnit. Run composer install first.\n");
    exit(2);
}

$coverageDirectory = dirname($coverageFile);
if (!is_dir($coverageDirectory) && !mkdir($coverageDirectory, 0777, true) && !is_dir($coverageDirectory)) {
    fwrite(STDERR, sprintf("Unable to create coverage directory: %s\n", $coverageDirectory));
    exit(2);
}

$runner = coverageRunner($phpunit, $coverageFile);
if ($runner === null) {
    fwrite(
        STDERR,
        "No coverage driver found. Install/enable PCOV or Xdebug, or make phpdbg available in PATH.\n"
    );
    exit(2);
}

printf("Running coverage with %s\n", $runner['label']);
$exitCode = runCommand($runner['command']);
if ($exitCode !== 0) {
    exit($exitCode);
}

if ($minimumCoverage === null) {
    exit(0);
}

$checkCommand = implode(' ', [
    escapeshellarg(PHP_BINARY),
    escapeshellarg(__DIR__ . '/check-coverage.php'),
    escapeshellarg($coverageFile),
    escapeshellarg((string) $minimumCoverage),
]);

exit(runCommand($checkCommand));

function findPhpUnit(): ?string
{
    $basePath = dirname(__DIR__) . '/vendor/bin/phpunit';
    foreach ([$basePath, $basePath . '.bat'] as $candidate) {
        if (is_file($candidate)) {
            return $candidate;
        }
    }

    return null;
}

/**
 * @return array{label: string, command: string}|null
 */
function coverageRunner(string $phpunit, string $coverageFile): ?array
{
    $arguments = [
        escapeshellarg($phpunit),
        '--coverage-text',
        '--coverage-clover',
        escapeshellarg($coverageFile),
    ];

    if (PHP_SAPI === 'phpdbg' || extension_loaded('pcov') || extension_loaded('xdebug')) {
        if (extension_loaded('xdebug')) {
            putenv('XDEBUG_MODE=coverage');
        }

        return [
            'label' => PHP_SAPI === 'phpdbg' ? 'phpdbg' : PHP_BINARY,
            'command' => escapeshellarg(PHP_BINARY) . ' ' . implode(' ', $arguments),
        ];
    }

    $phpdbg = findExecutable('phpdbg');
    if ($phpdbg === null) {
        return null;
    }

    return [
        'label' => $phpdbg,
        'command' => escapeshellarg($phpdbg) . ' -qrr ' . implode(' ', $arguments),
    ];
}

function findExecutable(string $name): ?string
{
    $candidates = [
        dirname(PHP_BINARY) . DIRECTORY_SEPARATOR . $name,
        dirname(PHP_BINARY) . DIRECTORY_SEPARATOR . $name . '.exe',
    ];

    $path = getenv('PATH');
    $pathExtensions = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
        ? array_filter(explode(';', getenv('PATHEXT') ?: '.EXE;.BAT;.CMD'))
        : [''];

    if ($path !== false) {
        foreach (explode(PATH_SEPARATOR, $path) as $directory) {
            foreach ($pathExtensions as $extension) {
                $candidates[] = $directory . DIRECTORY_SEPARATOR . $name . $extension;
            }
        }
    }

    foreach ($candidates as $candidate) {
        if (is_file($candidate)) {
            return $candidate;
        }
    }

    return null;
}

function runCommand(string $command): int
{
    passthru($command, $exitCode);

    return $exitCode;
}

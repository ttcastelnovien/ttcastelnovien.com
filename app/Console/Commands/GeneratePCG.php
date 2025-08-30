<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class GeneratePCG extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-pcg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build the full PCG hierarchy in JSON from a TXT file';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $input = database_path('seeder_data/pcg.txt');
        $output = database_path('seeder_data/pcg.json');

        if (! file_exists($input)) {
            fwrite(STDERR, "Input file not found: $input\n");

            return CommandAlias::FAILURE;
        }

        $raw = file_get_contents($input);
        if ($raw === false) {
            fwrite(STDERR, "Could not read input file: $input\n");

            return CommandAlias::FAILURE;
        }

        $raw = str_replace(["\r\n", "\r"], "\n", $raw);
        $lines = array_values(array_filter(explode("\n", $raw), fn ($l) => trim($l) !== ''));

        $joined = [];
        $prevCode = null;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            // Normalize dash characters and spacing
            $line = preg_replace('/\s*[–—-]\s*/u', ' - ', $line);

            // If the line doesn't begin with a code, treat it as a continuation of the previous name
            if (! preg_match('/^\d+/', $line)) {
                if ($prevCode !== null) {
                    $joined[count($joined) - 1]['name'] .= ' '.trim($line);
                }

                continue;
            }

            if (preg_match('/^(\d+)\s*-\s*(.+)$/u', $line, $m)) {
                $code = $m[1];
                $name = trim($m[2]);
            } else {
                // Unrecognized line format; skip
                continue;
            }

            $joined[] = ['code' => $code, 'name' => $name];
            $prevCode = $code;
        }

        if (empty($joined)) {
            fwrite(STDERR, "Parsed 0 rows from input file. Aborting.\n");

            return CommandAlias::FAILURE;
        }

        // Deduplicate by code (last occurrence wins) and sort by natural code order
        $byCode = [];
        foreach ($joined as $row) {
            $byCode[$row['code']] = ['code' => $row['code'], 'name' => $row['name']];
        }
        uksort($byCode, static function ($a, $b) {
            // natural order by string compare of codes
            return strcmp($a, $b);
        });

        // Build nodes map
        $nodes = [];
        foreach ($byCode as $code => $row) {
            $nodes[$code] = [
                'name' => $row['name'],
                'code' => $row['code'],
            ];
        }

        // Assign each node to its parent using the longest prefix that exists
        foreach (array_keys($nodes) as $code) {
            $parent = null;
            for ($i = strlen($code) - 1; $i >= 1; $i--) {
                $prefix = substr($code, 0, $i);
                if (isset($nodes[$prefix])) {
                    $parent = $prefix;
                    break;
                }
            }
            if ($parent !== null) {
                if (! array_key_exists('items', $nodes[$parent])) {
                    $nodes[$parent]['items'] = [];
                }

                $nodes[$parent]['items'][] = &$nodes[$code];
            }
        }

        // Sort children recursively by code
        $sortItems = function (&$node) use (&$sortItems) {
            if (! empty($node['items'])) {
                usort($node['items'], static fn ($a, $b) => strcmp($a['code'], $b['code']));
                foreach ($node['items'] as &$child) {
                    $sortItems($child);
                }
            }
        };

        // Collect top-level classes (codes with length 1)
        $top = [];
        foreach ($nodes as $code => &$node) {
            if (strlen($code) === 1) {
                $sortItems($node);
                $top[] = $node;
            }
        }

        usort($top, static fn ($a, $b) => strcmp($a['code'], $b['code']));

        // Write JSON
        $ok = file_put_contents($output, json_encode($top, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        if ($ok === false) {
            fwrite(STDERR, "Failed to write JSON to $output\n");

            return CommandAlias::FAILURE;
        }

        $this->info("Wrote full PCG JSON to $output");

        return CommandAlias::SUCCESS;
    }
}

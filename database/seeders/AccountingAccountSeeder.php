<?php

namespace Database\Seeders;

use App\Models\Accounting\Account;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AccountingAccountSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeder_data/pcg.json');

        try {
            $data = json_decode(File::get($path), associative: true);

            foreach ($data as $item) {
                $code = $this->normalizeCode($item['code']);

                /** @var Account $account */
                $account = Account::firstOrCreate(
                    ['code' => $code],
                    [
                        'name' => $item['name'],
                        'code' => $code,
                    ]
                );

                $this->importChildren($item['items'], $account);
            }
        } catch (FileNotFoundException) {
            return;
        }
    }

    /**
     * @param  array<int, array{name: string, code: string, items: array}>  $children
     */
    private function importChildren(array $children, Account $parent): void
    {
        foreach ($children as $key => $child) {
            $code = $this->normalizeCode($child['code']);

            /** @var Account $account */
            $account = Account::firstOrCreate(
                ['code' => $code],
                [
                    'name' => $child['name'],
                    'code' => $code,
                    'parent_id' => $parent->id,
                ]
            );

            if (array_key_exists('items', $child) && ! empty($child['items'])) {
                $this->importChildren($child['items'], $account);
            }
        }
    }

    private function normalizeCode(string $code): string
    {
        return str_pad($code, 7, '0');
    }
}

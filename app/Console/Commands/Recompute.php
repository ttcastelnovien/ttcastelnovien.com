<?php

namespace App\Console\Commands;

use App\Enums\LicenceCategory;
use App\Models\Licence\Licence;
use App\Models\Licence\LicenceFee;
use App\Models\Meta\Season;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class Recompute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recompute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recompute data based on latest code changes';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->recomputeLicences();

        return CommandAlias::SUCCESS;
    }

    private function recomputeLicences(): void
    {
        $season = Season::current()->first();
        $licences = Licence::query()->whereSeasonId($season->id)->get();

        foreach ($licences as $licence) {
            $licenceFee = LicenceFee::query()
                ->whereJsonContains('licence_types', $licence->licence_type)
                ->whereJsonContains('licence_categories', $licence->category)
                ->where('season_id', $season->id)
                ->firstOrFail();

            $licence->category = LicenceCategory::fromBirthDate($licence->person->birth_date, $licence->season);
            $licence->is_minor = LicenceCategory::isMinorCategory($licence->category);
            $licence->licence_fee_id = $licenceFee->id;
            $licence->save();
        }
    }
}

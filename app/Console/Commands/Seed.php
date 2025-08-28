<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\Accounting\Account;
use App\Models\Clubs\Club;
use App\Models\HumanResource\Person;
use App\Models\Meta\Season;
use App\Models\Security\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Command\Command as CommandAlias;

class Seed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the database with defaults data.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Importing default seasons...');
        $this->importSeasons();

        $this->info('Importing default user...');
        $this->importSuperUser();

        $this->info('Importing default clubs and halls...');
        $this->importClubs();

        $this->info('Importing default pcg...');
        $this->importPCG();

        return CommandAlias::SUCCESS;
    }

    private function importSeasons(): void
    {
        collect([
            [
                'name' => '2025/2026',
                'starts_at' => Carbon::create(year: 2025, month: 7),
                'ends_at' => Carbon::create(year: 2026, month: 6, day: 30),
            ],
            [
                'name' => '2026/2027',
                'starts_at' => Carbon::create(year: 2026, month: 7),
                'ends_at' => Carbon::create(year: 2027, month: 6, day: 30),
            ],
            [
                'name' => '2027/2028',
                'starts_at' => Carbon::create(year: 2027, month: 7),
                'ends_at' => Carbon::create(year: 2028, month: 6, day: 30),
            ],
            [
                'name' => '2028/2029',
                'starts_at' => Carbon::create(year: 2028, month: 7),
                'ends_at' => Carbon::create(year: 2029, month: 6, day: 30),
            ],
            [
                'name' => '2029/2030',
                'starts_at' => Carbon::create(year: 2029, month: 7),
                'ends_at' => Carbon::create(year: 2030, month: 6, day: 30),
            ],
            [
                'name' => '2030/2031',
                'starts_at' => Carbon::create(year: 2030, month: 7),
                'ends_at' => Carbon::create(year: 2031, month: 6, day: 30),
            ],
        ])
            ->each(fn ($item) => Season::query()->createOrFirst(
                attributes: ['name' => $item['name']],
                values: $item,
            ));
    }

    private function importSuperUser(): void
    {
        $person = Person::query()->createOrFirst(
            attributes: ['licence_number' => config('app.superuser.licence')],
            values: [
                'first_name' => config('app.superuser.firstname'),
                'last_name' => config('app.superuser.lastname'),
                'licence_number' => config('app.superuser.licence'),
                'birth_date' => config('app.superuser.birth_date'),
                'address_line_1' => config('app.superuser.address'),
                'postal_code' => config('app.superuser.zip_code'),
                'city' => config('app.superuser.city'),
            ]
        );

        User::query()->createOrFirst(
            attributes: ['username' => config('app.superuser.username')],
            values: [
                'username' => config('app.superuser.username'),
                'password' => Hash::make(config('app.superuser.password')),
                'roles' => [UserRole::ADMIN, UserRole::HISTORY],
                'person_id' => $person->id,
            ]
        );
    }

    private function importClubs(): void
    {
        collect([
            [
                'halls' => [
                    [
                        'name' => 'Aigre CP',
                        'address_line_1' => 'Gymnase',
                        'address_line_2' => '10 rue du Renclos',
                        'postal_code' => '16140',
                        'city' => 'Aigre',
                        'latitude' => '45.88959',
                        'longitude' => '0.00751',
                    ],
                ],
                'club' => [
                    'name' => 'Aigre CP',
                    'short_name' => 'Aigre',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Angoulême TTGF',
                        'address_line_1' => 'Salle JP Gatien',
                        'address_line_2' => '74 rue de la Trésorière',
                        'postal_code' => '16000',
                        'city' => 'Angoulême',
                        'latitude' => '45.63449',
                        'longitude' => '0.14902',
                    ],
                ],
                'club' => [
                    'name' => 'Angoulême TTGF',
                    'short_name' => 'TTGF',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'T.T.C. Baignes Barbezieux',
                        'address_line_1' => 'Salle polyvalente',
                        'address_line_2' => '1 rue Baptiste Roussy',
                        'postal_code' => '16360',
                        'city' => 'Baignes-Sainte-Radegonde',
                        'latitude' => '45.38285',
                        'longitude' => '-0.23734',
                    ],
                ],
                'club' => [
                    'name' => 'T.T.C. Baignes Barbezieux',
                    'short_name' => 'TTC2B',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Brie-Champniers STT',
                        'address_line_1' => 'Centre Sportif des Montagnes',
                        'address_line_2' => '776 Rue de la Génoise',
                        'postal_code' => '16430',
                        'city' => 'Champniers',
                        'latitude' => '45.6908',
                        'longitude' => '0.18801',
                    ],
                ],
                'club' => [
                    'name' => 'Brie-Champniers STT',
                    'short_name' => 'Brie-Champniers',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Chabanais TT',
                        'address_line_1' => 'Gymnase',
                        'address_line_2' => '6178 Rue des Écoles',
                        'postal_code' => '16150',
                        'city' => 'Chabanais',
                        'latitude' => '45.87732',
                        'longitude' => '0.71438',
                    ],
                ],
                'club' => [
                    'name' => 'Chabanais TT',
                    'short_name' => 'Chabanais',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Salle de Montmoreau',
                        'address_line_1' => 'Gymase du collège',
                        'address_line_2' => '5 Rue Henri Dunant',
                        'postal_code' => '16190',
                        'city' => 'Montmoreau',
                        'latitude' => '45.39738',
                        'longitude' => '0.12984',
                    ],
                    [
                        'name' => 'Salle de Chalais',
                        'address_line_1' => 'Gymase du collège',
                        'address_line_2' => '34 Rue d’Angoulême',
                        'postal_code' => '16210',
                        'city' => 'Chalais',
                        'latitude' => '45.27626',
                        'longitude' => '0.04048',
                    ],
                ],
                'club' => [
                    'name' => 'Chalais Montmoreau TT',
                    'short_name' => 'Chalais Montmoreau',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Chasseneuil TTC',
                        'address_line_1' => 'Gymnase intercommunal',
                        'address_line_2' => '30 Rue Bir’Hacheim',
                        'postal_code' => '16260',
                        'city' => 'Chasseneuil-sur-Bonnieure',
                        'latitude' => '45.82232',
                        'longitude' => '0.45489',
                    ],
                ],
                'club' => [
                    'name' => 'Chasseneuil TTC',
                    'short_name' => 'Chasseneuil',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Chazelles CP',
                        'address_line_1' => 'Route de Marthon',
                        'address_line_2' => null,
                        'postal_code' => '16380',
                        'city' => 'Chazelles',
                        'latitude' => '45.64081',
                        'longitude' => '0.37281',
                    ],
                ],
                'club' => [
                    'name' => 'Chazelles CP',
                    'short_name' => 'Chazelles',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Châteaubernard SLTT',
                        'address_line_1' => 'Salle Jean Monnet',
                        'address_line_2' => 'Rue Jean Monnet',
                        'postal_code' => '16100',
                        'city' => 'Châteaubernard',
                        'latitude' => '45.67464',
                        'longitude' => '-0.3193',
                    ],
                ],
                'club' => [
                    'name' => 'Châteaubernard SLTT',
                    'short_name' => 'Châteaubernard',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Châteauneuf TT Castelnovien',
                        'address_line_1' => 'Salle Omnisports François Gabart',
                        'address_line_2' => '3 Impasse du Chemin Piquet',
                        'postal_code' => '16120',
                        'city' => 'Châteauneuf sur Charente',
                        'latitude' => '45.59336',
                        'longitude' => '-0.05421',
                    ],
                ],
                'club' => [
                    'name' => 'Châteauneuf TT Castelnovien',
                    'short_name' => 'TTCastelnovien',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Cognac UATT',
                        'address_line_1' => 'Salle Jean Monnet',
                        'address_line_2' => 'Rue Jean Monnet',
                        'postal_code' => '16100',
                        'city' => 'Châteaubernard',
                        'latitude' => '45.67464',
                        'longitude' => '-0.3193',
                    ],
                ],
                'club' => [
                    'name' => 'Cognac UATT',
                    'short_name' => 'Cognac',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Confolens TT',
                        'address_line_1' => 'Gymnase de la Gare',
                        'address_line_2' => '17 Avenue Gambetta',
                        'postal_code' => '16500',
                        'city' => 'Confolens',
                        'latitude' => '46.02033',
                        'longitude' => '0.66866',
                    ],
                ],
                'club' => [
                    'name' => 'Confolens TT',
                    'short_name' => 'Confolens',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Fléac MJC',
                        'address_line_1' => 'Salle des sports',
                        'address_line_2' => '1 avenue des Sports',
                        'postal_code' => '16730',
                        'city' => 'Fléac',
                        'latitude' => '45.6619',
                        'longitude' => '0.08976',
                    ],
                ],
                'club' => [
                    'name' => 'Fléac MJC',
                    'short_name' => 'Fléac',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Gond Pontouvre TTGP',
                        'address_line_1' => 'Salle spécifique',
                        'address_line_2' => '50 rue du Treuil',
                        'postal_code' => '16160',
                        'city' => 'Gond-Pontouvre',
                        'latitude' => '45.68216',
                        'longitude' => '0.16369',
                    ],
                ],
                'club' => [
                    'name' => 'Gond Pontouvre TTGP',
                    'short_name' => 'TTGP',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Isle d’Espagnac 3STT',
                        'address_line_1' => 'Salle omnisports',
                        'address_line_2' => 'L’isle ô sports',
                        'address_line_3' => '22 avenue Jean Jaurès',
                        'postal_code' => '16340',
                        'city' => 'Isle d’Espagnac',
                        'latitude' => '45.66258',
                        'longitude' => '0.1989',
                    ],
                ],
                'club' => [
                    'name' => 'Isle d’Espagnac 3STT',
                    'short_name' => 'Isle d’Espagnac',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'La Couronne COC',
                        'address_line_1' => 'Salle du Four Banal',
                        'address_line_2' => 'Place des Volontaires de l’An II',
                        'postal_code' => '16400',
                        'city' => 'La Couronne',
                        'latitude' => '45.60927',
                        'longitude' => '0.09998',
                    ],
                ],
                'club' => [
                    'name' => 'La Couronne COC',
                    'short_name' => 'La Couronne',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'La Rochefoucauld UATT',
                        'address_line_1' => 'Salle Léon Jarton',
                        'address_line_2' => 'Impasse des Fossés',
                        'postal_code' => '16110',
                        'city' => 'La Rochefoucauld',
                        'latitude' => '45.74293',
                        'longitude' => '0.38561',
                    ],
                ],
                'club' => [
                    'name' => 'La Rochefoucauld UATT',
                    'short_name' => 'La Rochefoucauld',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Luchac-Chassors TT',
                        'address_line_1' => 'Salle de la Pointe',
                        'address_line_2' => '10 Zone Artisanale',
                        'address_line_3' => 'Route de Jarnac',
                        'postal_code' => '16200',
                        'city' => 'Chassors',
                        'latitude' => '45.7155',
                        'longitude' => '-0.20327',
                    ],
                ],
                'club' => [
                    'name' => 'Luchac-Chassors TT',
                    'short_name' => 'Luchac-Chassors',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Magnac sur Touvre TTP',
                        'address_line_1' => 'Complexe sportif',
                        'address_line_2' => 'Rue Pierre de Coubertin',
                        'postal_code' => '16600',
                        'city' => 'Magnac sur Touvre',
                        'latitude' => '45.67249',
                        'longitude' => '0.23583',
                    ],
                ],
                'club' => [
                    'name' => 'Magnac sur Touvre TTP',
                    'short_name' => 'Magnac',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Mansle CR',
                        'address_line_1' => 'Salle omnisports',
                        'address_line_2' => 'Rue de la Doue',
                        'postal_code' => '16230',
                        'city' => 'Mansle',
                        'latitude' => '45.87172',
                        'longitude' => '0.17255',
                    ],
                ],
                'club' => [
                    'name' => 'Mansle CR',
                    'short_name' => 'Mansle',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Merpins US',
                        'address_line_1' => 'Salle des fêtes',
                        'address_line_2' => '239 Rue de la Distillerie',
                        'postal_code' => '16100',
                        'city' => 'Merpins',
                        'latitude' => '45.6733',
                        'longitude' => '-0.3586',
                    ],
                ],
                'club' => [
                    'name' => 'Merpins US',
                    'short_name' => 'Merpins',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Montbron CP',
                        'address_line_1' => 'Gymnase Albert Livert',
                        'address_line_2' => 'Avenue du Groupe Scolaire',
                        'postal_code' => '16220',
                        'city' => 'Montbron',
                        'latitude' => '45.66697',
                        'longitude' => '0.50327',
                    ],
                ],
                'club' => [
                    'name' => 'Montbron CP',
                    'short_name' => 'Montbron',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Mornac TT',
                        'address_line_1' => 'Salle omnisports',
                        'address_line_2' => 'Rue du Champ de Penot',
                        'postal_code' => '16600',
                        'city' => 'Mornac',
                        'latitude' => '45.67742',
                        'longitude' => '0.27032',
                    ],
                ],
                'club' => [
                    'name' => 'Mornac TT',
                    'short_name' => 'Mornac',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Puymoyen TT',
                        'address_line_1' => 'Salle des sports',
                        'address_line_2' => '1 rue du Peusec',
                        'postal_code' => '16400',
                        'city' => 'Puymoyen',
                        'latitude' => '45.61645',
                        'longitude' => '0.18104',
                    ],
                ],
                'club' => [
                    'name' => 'Puymoyen TT',
                    'short_name' => 'Puymoyen',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Ruffec CTT',
                        'address_line_1' => 'Salle Louis Petit',
                        'address_line_2' => '4 Avenue du professeur Girard',
                        'postal_code' => '16700',
                        'city' => 'Ruffec',
                        'latitude' => '46.03186',
                        'longitude' => '0.205',
                    ],
                ],
                'club' => [
                    'name' => 'Ruffec CTT',
                    'short_name' => 'Ruffec',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Saint-Séverin AP',
                        'address_line_1' => 'Salle des fêtes',
                        'address_line_2' => '8 Rue du Périgord',
                        'postal_code' => '16390',
                        'city' => 'Saint Séverin',
                        'latitude' => '45.31264',
                        'longitude' => '0.25064',
                    ],
                ],
                'club' => [
                    'name' => 'Saint-Séverin AP',
                    'short_name' => 'Saint-Séverin',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'SG Rouillac TTC',
                        'address_line_1' => 'Gymnase',
                        'address_line_2' => 'Rue des Fins Bois',
                        'postal_code' => '16170',
                        'city' => 'Rouillac',
                        'latitude' => '45.7803',
                        'longitude' => '-0.06538',
                    ],
                ],
                'club' => [
                    'name' => 'SG Rouillac TTC',
                    'short_name' => 'Rouillac',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Torsac CP',
                        'address_line_1' => 'Salle Communale',
                        'address_line_2' => '10 rue de Charmant',
                        'postal_code' => '16410',
                        'city' => 'Fouquebrune',
                        'latitude' => '45.52725',
                        'longitude' => '0.20907',
                    ],
                ],
                'club' => [
                    'name' => 'Torsac CP',
                    'short_name' => 'Torsac',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Tourriers Jauldes EP',
                        'address_line_1' => 'Salles des fêtes',
                        'address_line_2' => '41 Grand Rue',
                        'address_line_3' => 'Le Bourg',
                        'postal_code' => '16560',
                        'city' => 'Jauldes',
                        'latitude' => '45.78509',
                        'longitude' => '0.25742',
                    ],
                ],
                'club' => [
                    'name' => 'Tourriers Jauldes EP',
                    'short_name' => 'Tourriers Jauldes',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Vars EP',
                        'address_line_1' => 'Salle des sports',
                        'address_line_2' => '12 bis route de la Gare',
                        'postal_code' => '16330',
                        'city' => 'Vars',
                        'latitude' => '45.76323',
                        'longitude' => '0.12802',
                    ],
                ],
                'club' => [
                    'name' => 'Vars EP',
                    'short_name' => 'Vars',
                ],
            ],
            [
                'halls' => [
                    [
                        'name' => 'Villefagnan AL',
                        'address_line_1' => 'Salle des fêtes',
                        'address_line_2' => '18 Rue du Champ de Foire',
                        'postal_code' => '16240',
                        'city' => 'Villefagnan',
                        'latitude' => '46.01488',
                        'longitude' => '-0.07919',
                    ],
                ],
                'club' => [
                    'name' => 'Villefagnan AL',
                    'short_name' => 'Villefagnan',
                ],
            ],
        ])
            ->each(function ($item) {
                $club = Club::query()->createOrFirst(
                    attributes: ['name' => $item['club']['name']],
                    values: $item['club'],
                );

                foreach ($item['halls'] as $hall) {
                    $club->halls()->createOrFirst(
                        attributes: ['name' => $hall['name']],
                        values: $hall,
                    );
                }
            });
    }

    private function importPCG(): void
    {
        $path = database_path('seeder_data/pcg.json');

        try {
            $data = json_decode(File::get($path), associative: true);

            foreach ($data as $item) {
                $code = $this->normalizePCGCode($item['code']);

                /** @var Account $account */
                $account = Account::query()->firstOrCreate(
                    ['code' => $code],
                    [
                        'name' => $item['name'],
                        'code' => $code,
                    ]
                );

                $this->importPCGChildren($item['items'], $account);
            }
        } catch (FileNotFoundException) {
            return;
        }
    }

    /**
     * @param  array<int, array{name: string, code: string, items: array}>  $children
     */
    private function importPCGChildren(array $children, Account $parent): void
    {
        foreach ($children as $child) {
            $code = $this->normalizePCGCode($child['code']);

            /** @var Account $account */
            $account = Account::query()->firstOrCreate(
                ['code' => $code],
                [
                    'name' => $child['name'],
                    'code' => $code,
                    'parent_id' => $parent->id,
                ]
            );

            if (array_key_exists('items', $child) && ! empty($child['items'])) {
                $this->importPCGChildren($child['items'], $account);
            }
        }
    }

    private function normalizePCGCode(string $code): string
    {
        return str_pad($code, 7, '0');
    }
}

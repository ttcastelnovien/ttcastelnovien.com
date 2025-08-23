<?php

namespace App\Models\Communication;

use App\Models\HumanResource\Person;
use App\Models\Meta\Season;
use App\Models\Traits\Blamable;
use Database\Factories\Communication\EventFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class Event extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Traits modifiers
    |--------------------------------------------------------------------------
    */

    /** @use HasFactory<EventFactory> */
    use Blamable, HasFactory, HasUlids;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'title',
        'description',
        'at_home',
        'address',
        'latitude',
        'longitude',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'opponent',
        'check_in_time',
        'departure_time',
        'attachments',
        'season_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'at_home' => 'boolean',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'start_date' => 'date',
            'end_date' => 'date',
            'attachments' => 'array',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return BelongsToMany<Person> */
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }

    /** @return BelongsToMany<Group> */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    /** @return BelongsTo<Season> */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsAllDayAttribute(): bool
    {
        return is_null($this->start_time) && is_null($this->end_time);
    }

    public function getDateAttribute(): string
    {
        if (is_null($this->end_date)) {
            return $this->formatted_start;
        }

        return sprintf(
            '%s - %s',
            $this->formatted_start,
            $this->formatted_end,
        );
    }

    public function getStartAttribute(): Carbon
    {
        if (is_null($this->start_time)) {
            return $this->start_date->shiftTimezone('Europe/Paris');
        }

        return $this->start_date->shiftTimezone('Europe/Paris')->setTimeFromTimeString($this->start_time);
    }

    public function getFormattedStartAttribute(): string
    {
        if (is_null($this->start_time)) {
            return $this->start->isoFormat('ddd DD MMM Y');
        }

        return $this->start->isoFormat('ddd DD MMM Y à HH:mm');
    }

    public function getEndAttribute(): ?Carbon
    {
        if (is_null($this->end_date) && is_null($this->end_time)) {
            return null;
        }

        if (is_null($this->end_date)) {
            return $this->start_date->shiftTimezone('Europe/Paris')->setTimeFromTimeString($this->end_time);
        }

        if (is_null($this->end_time)) {
            return $this->end_date->shiftTimezone('Europe/Paris');
        }

        return $this->end_date->shiftTimezone('Europe/Paris')->setTimeFromTimeString($this->end_time);
    }

    public function getFormattedEndAttribute(): ?string
    {
        if (is_null($this->end)) {
            return null;
        }

        if (is_null($this->end_time)) {
            $this->end->isoFormat('ddd DD MMM Y');
        }

        return $this->end->isoFormat('ddd DD MMM Y à HH:mm');
    }
}

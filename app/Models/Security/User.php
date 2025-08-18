<?php

namespace App\Models\Security;

use App\Enums\UserRole;
use App\Models\Communication\Event;
use App\Models\Communication\Group;
use App\Models\HumanResource\Person;
use Database\Factories\Security\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser, HasName
{
    /*
    |--------------------------------------------------------------------------
    | Traits modifiers
    |--------------------------------------------------------------------------
    */

    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUlids, Notifiable;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'username',
        'password',
        'roles',
        'is_active',
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'roles' => AsEnumCollection::of(UserRole::class),
            'is_active' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return BelongsTo<Person> */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /** @return BelongsToMany<Event> */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    /** @return BelongsToMany<Group> */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /** @return list<UserRole> */
    public function getUserRolesAttribute(): array
    {
        /** @var Collection<int, UserRole> $roles */
        $roles = $this->roles;

        $rolesArray = $roles->toArray();
        $rolesArray[] = UserRole::USER;

        return array_unique($rolesArray, SORT_REGULAR);
    }

    public function hasRole(UserRole $role): bool
    {
        return in_array($role, $this->user_roles, strict: true);
    }

    /*
    |--------------------------------------------------------------------------
    | Implementations
    |--------------------------------------------------------------------------
    */

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->person()?->full_name ?? $this->username;
    }
}

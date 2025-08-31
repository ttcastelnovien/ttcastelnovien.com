<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Models\Meta\Season;
use App\Services\Google\GoogleDrive;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Utilities\Get;
use Google\Service\Drive\DriveFile;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class DriveFileUpload extends FileUpload
{
    private ?\Closure $drivePathCallback = null;

    private ?Season $season = null;

    private ?\Closure $fileNameCallback = null;

    protected function setUp(): void
    {
        $this->storeFiles(false)
            ->dehydrateStateUsing(fn ($state, Get $get) => $this->uploadToDrive($state, $get));
    }

    public function setDrivePath(\Closure $callback): static
    {
        $this->drivePathCallback = $callback;

        return $this;
    }

    public function setSeason(Season $season): static
    {
        $this->season = $season;

        return $this;
    }

    public function setFileName(\Closure $callback): static
    {
        $this->fileNameCallback = $callback;

        return $this;
    }

    private function uploadToDrive(?TemporaryUploadedFile $state, Get $get): ?string
    {
        if ($state === null) {
            return null;
        }

        $filename = ($this->fileNameCallback)($get).'.'.$state->getClientOriginalExtension();

        $metadata = new DriveFile;
        $metadata->setName($filename);

        $season = $this->season ?: Season::current()->first();

        return GoogleDrive::uploadFile(
            metadata: $metadata,
            file: $state,
            folders: ($this->drivePathCallback)($get),
            rootFolderId: $season->drive_id,
        )->getId();
    }
}

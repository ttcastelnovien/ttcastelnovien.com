<?php

declare(strict_types=1);

namespace App\Services\Google;

use Google\Service\Drive;
use Google\Service\Drive\Channel;
use Google\Service\Drive\Drive as RootDrive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\FileList;
use Google\Service\Drive\GeneratedIds;
use Google\Service\Drive\LabelList;
use Google\Service\Drive\ModifyLabelsRequest;
use Google\Service\Drive\ModifyLabelsResponse;
use Google\Service\Drive\Operation;
use Google\Service\Exception;

final class GoogleDrive
{
    use GoogleSDK;

    private static ?Drive $drive = null;

    private static ?RootDrive $rootDrive = null;

    private static function drive(): Drive
    {
        if (self::$drive instanceof Drive) {
            return self::$drive;
        }

        /*
        |--------------------------------------------------------------------------
        | Initialize Google Drive
        |--------------------------------------------------------------------------
        */

        self::$drive = new Drive(self::client());
        self::$rootDrive = self::drive()->drives->get(config('app.google.shared_drive_id'));

        return self::$drive;
    }

    /**
     * @throws Exception
     */
    public static function copyFile($fileId, DriveFile $postBody, array $options = []): DriveFile
    {
        return self::drive()->files->copy($fileId, $postBody, [
            ...$options,
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function createFile(DriveFile $postBody, $options = []): DriveFile
    {
        return self::drive()->files->create($postBody, [
            ...$options,
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function deleteFile(string $fileId): void
    {
        self::drive()->files->delete($fileId, [
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function downloadFile(string $fileId, $options = []): Operation
    {
        return self::drive()->files->download($fileId, $options);
    }

    /**
     * @throws Exception
     */
    public static function emptyTrash(): void
    {
        self::drive()->files->emptyTrash([
            'driveId' => self::$rootDrive->id,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function export(string $fileId, string $mimeType)
    {
        return self::drive()->files->export($fileId, $mimeType);
    }

    /**
     * @throws Exception
     */
    public static function generateIds(int $count): GeneratedIds
    {
        return self::drive()->files->generateIds([
            'count' => $count,
            'space' => 'drive',
            'type' => 'files',
        ]);
    }

    /**
     * @throws Exception
     */
    public static function get(string $fileId, array $options = []): DriveFile
    {
        return self::drive()->files->get($fileId, [
            ...$options,
            'alt' => 'media',
            'acknowledgeAbuse' => true,
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function listFiles(array $options = []): FileList
    {
        return self::drive()->files->listFiles([
            ...$options,
            'corpora' => 'drive',
            'driveId' => self::$rootDrive->id,
            'includeItemsFromAllDrives' => true,
            'spaces' => 'drive',
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function listLabels(string $fileId, array $options = []): LabelList
    {
        return self::drive()->files->listLabels($fileId, $options);
    }

    /**
     * @throws Exception
     */
    public static function modifyLabels(string $fileId, ModifyLabelsRequest $postBody, array $options = []): ModifyLabelsResponse
    {
        return self::drive()->files->modifyLabels($fileId, $postBody, $options);
    }

    /**
     * @throws Exception
     */
    public static function update(string $fileId, DriveFile $postBody, array $options = []): DriveFile
    {
        return self::drive()->files->update($fileId, $postBody, [
            ...$options,
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function watch(string $fileId, Channel $postBody, array $options = []): Channel
    {
        return self::drive()->files->watch($fileId, $postBody, [
            ...$options,
            'acknowledgeAbuse' => true,
            'supportsAllDrives' => true,
        ]);
    }
}

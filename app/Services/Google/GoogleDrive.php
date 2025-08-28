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
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\UploadedFile;

final class GoogleDrive
{
    use GoogleSDK;

    private static ?Drive $drive = null;

    private static ?RootDrive $rootDrive = null;

    private static function init(): void
    {
        if (self::$drive instanceof Drive) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Initialize Google Drive
        |--------------------------------------------------------------------------
        */

        self::$drive = new Drive(self::client());
        self::$rootDrive = self::$drive->drives->get(config('app.google.shared_drive_id'));
    }

    /**
     * @throws Exception
     */
    public static function copyFile($fileId, DriveFile $postBody, array $options = []): DriveFile
    {
        self::init();

        return self::$drive->files->copy($fileId, $postBody, [
            ...$options,
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @param  array<string>  $folders
     *
     * @throws Exception
     */
    public static function createFile(
        DriveFile $metadata,
        UploadedFile $file,
        array $folders,
        ?string $rootFolderId = null,
        $options = []
    ): DriveFile {
        self::init();

        $lastParentId = self::recursivelyCreateFolders($folders, $rootFolderId ?? self::$rootDrive->id);
        $metadata->setParents([$lastParentId]);

        return self::$drive->files->create($metadata, [
            ...$options,
            'data' => $file->getContent(),
            'mimeType' => $file->getClientMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id',
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function createFolder(
        string $name,
        string $parentId,
        $options = []
    ): DriveFile {
        self::init();

        $metadata = new DriveFile;
        $metadata->setName($name);
        $metadata->setMimeType('application/vnd.google-apps.folder');
        $metadata->setParents([$parentId]);

        return self::$drive->files->create($metadata, [
            ...$options,
            'fields' => 'id',
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function deleteFile(string $fileId): void
    {
        self::init();

        self::$drive->files->delete($fileId, [
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function downloadFile(string $fileId, $options = []): Operation
    {
        self::init();

        return self::$drive->files->download($fileId, $options);
    }

    /**
     * @throws Exception
     */
    public static function emptyTrash(): void
    {
        self::init();

        self::$drive->files->emptyTrash([
            'driveId' => self::$rootDrive->id,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function export(string $fileId, string $mimeType)
    {
        self::init();

        return self::$drive->files->export($fileId, $mimeType);
    }

    /**
     * @throws Exception
     */
    public static function generateIds(int $count): GeneratedIds
    {
        self::init();

        return self::$drive->files->generateIds([
            'count' => $count,
            'space' => 'drive',
            'type' => 'files',
        ]);
    }

    /**
     * @throws Exception
     */
    public static function getFileContent(string $fileId, array $options = []): Response
    {
        self::init();

        /** @var Response */
        return self::$drive->files->get($fileId, [
            ...$options,
            'alt' => 'media',
            'acknowledgeAbuse' => true,
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function getFileMetadata(string $fileId, array $options = []): DriveFile
    {
        self::init();

        return self::$drive->files->get($fileId, [
            ...$options,
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function listFiles(array $options = []): FileList
    {
        self::init();

        return self::$drive->files->listFiles([
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
        self::init();

        return self::$drive->files->listLabels($fileId, $options);
    }

    /**
     * @throws Exception
     */
    public static function modifyLabels(string $fileId, ModifyLabelsRequest $postBody, array $options = []): ModifyLabelsResponse
    {
        self::init();

        return self::$drive->files->modifyLabels($fileId, $postBody, $options);
    }

    /**
     * @throws Exception
     */
    public static function update(string $fileId, DriveFile $postBody, array $options = []): DriveFile
    {
        self::init();

        return self::$drive->files->update($fileId, $postBody, [
            ...$options,
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function watch(string $fileId, Channel $postBody, array $options = []): Channel
    {
        self::init();

        return self::$drive->files->watch($fileId, $postBody, [
            ...$options,
            'acknowledgeAbuse' => true,
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * @throws Exception
     */
    private static function recursivelyCreateFolders(array $folders, string $parentId): string
    {
        $folder = array_shift($folders);

        if ($folder === null) {
            return $parentId;
        }

        $q = sprintf("name='%s' and mimeType='application/vnd.google-apps.folder' and '%s' in parents and trashed=false", $folder, $parentId);
        $existingFolders = self::listFiles(['q' => $q]);

        if (count($existingFolders->getFiles()) > 0) {
            $currentFolderId = $existingFolders->getFiles()[0]->getId();
        } else {
            $currentFolderId = self::createFolder($folder, $parentId)->getId();
        }

        return self::recursivelyCreateFolders($folders, $currentFolderId);
    }
}

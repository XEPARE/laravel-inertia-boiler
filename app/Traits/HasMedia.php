<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

trait HasMedia
{
    /**
     * Update the user's media file.
     *
     * @param \Illuminate\Http\UploadedFile $media
     * @param string $pathColumn
     * @param string $path
     * @return void
     */
    public function updateMedia(UploadedFile $media, string $pathColumn = 'profile_photo_path', string $path = 'profile-photos'): void
    {
        tap($this->{$pathColumn}, function ($previous) use ($media, $path) {
            $this->forceFill([
                $path => $media->storePublicly(
                    $path, ['disk' => $this->mediaDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->mediaDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's media file.
     *
     * @param string|null $path
     * @return void
     */
    public function deleteMedia(string|null $path): void
    {
        if (is_null($this->{$path})) {
            return;
        }

        Storage::disk($this->mediaDisk())->delete($this->{$path});

        $this->forceFill([
            $path => null,
        ])->save();
    }

    /**
     * Get the URL to the user's media file.
     *
     * @param string $path
     * @param string $defaultUrl
     * @return string
     */
    public function getMediaUrl(string|null $path, string $defaultUrl): string
    {
        return $this->{$path}
                    ? Storage::disk($this->mediaDisk())->url($this->{$path})
                    : $defaultUrl;
    }

    /**
     * @param string $sourceUrl
     * @param string $pathColumn
     * @param string $path
     * @return void
     */
    public function updateMediaByUrl(string $sourceUrl, string $pathColumn = 'profile_photo_path', string $path = 'profile-photos'): void
    {
        tap($this->{$pathColumn}, function ($previous) use ($sourceUrl, $pathColumn, $path) {
            Storage::disk($this->mediaDisk())->put($name = sprintf('%s/%s', $path, Uuid::uuid4()), file_get_contents($sourceUrl), [
                'visibility' => 'public'
            ]);
            $this->forceFill([
                $pathColumn => $name,
            ])->save();

            if ($previous) {
                Storage::disk($this->mediaDisk())->delete($previous);
            }
        });
    }

    /**
     * Get the disk that media files should be stored on.
     *
     * @return string
     */
    protected function mediaDisk(): string
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('filesystems.default');
    }
}

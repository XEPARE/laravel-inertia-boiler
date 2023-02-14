<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasMedia
{
    /**
     * Update the user's media file.
     *
     * @param  \Illuminate\Http\UploadedFile  $media
     * @param  string  $path
     * @return void
     */
    public function updateMedia(UploadedFile $media, $pathColumn = 'profile_photo_path', $path = 'profile-photos')
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
     * @param  string  $path
     * @return void
     */
    public function deleteMedia($path)
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
     * @param  string  $path
     * @param  string  $defaultUrl
     * @return string
     */
    public function getMediaUrl($path, $defaultUrl)
    {
        return $this->{$path}
                    ? Storage::disk($this->mediaDisk())->url($this->{$path})
                    : $defaultUrl;
    }

    /**
     * Get the disk that media files should be stored on.
     *
     * @return string
     */
    protected function mediaDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('filesystems.default');
    }
}
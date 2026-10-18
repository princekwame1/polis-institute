<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesImageUploads
{
    /**
     * Store a newly uploaded image, or remove the current one when asked.
     *
     * Returns the path to keep on the model: the new upload, the existing
     * path when nothing changed, or null when the image was removed.
     */
    protected function syncImage(Request $request, string $field, string $directory, ?string $currentPath = null): ?string
    {
        if ($request->hasFile($field)) {
            $this->deleteImage($currentPath);

            return $request->file($field)->store($directory, 'public');
        }

        if ($request->boolean("remove_{$field}")) {
            $this->deleteImage($currentPath);

            return null;
        }

        return $currentPath;
    }

    protected function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}

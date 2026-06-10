<?php

if (!function_exists('photo_url')) {
    /**
     * Resolve the full URL for a stored photo.
     * Checks both root (assets/img/) and subdirectory (assets/img/images/)
     * to handle legacy and new uploads transparently.
     *
     * @param  string|null  $photo        The stored filename from the database
     * @param  string       $placeholder  Fallback image filename (inside assets/img/)
     * @return string
     */
    function photo_url(?string $photo, string $placeholder = 'placeholder.png'): string
    {
        if (empty($photo)) {
            return asset('assets/img/' . $placeholder);
        }

        // If the stored value already contains a directory separator, use it directly
        if (str_contains($photo, '/')) {
            return asset('assets/img/' . $photo);
        }

        // Check images/ subfolder first (where most repositories save via ImageHelper)
        if (file_exists(public_path('assets/img/images/' . $photo))) {
            return asset('assets/img/images/' . $photo);
        }

        // Fall back to root assets/img/ (legacy records, super admin, items, etc.)
        if (file_exists(public_path('assets/img/' . $photo))) {
            return asset('assets/img/' . $photo);
        }

        // File not found anywhere – return placeholder
        return asset('assets/img/' . $placeholder);
    }
}

if (!function_exists('noimage_url')) {
    /**
     * Return the no-image fallback URL.
     *
     * @return string
     */
    function noimage_url(): string
    {
        return asset('assets/img/noimage.png');
    }
}

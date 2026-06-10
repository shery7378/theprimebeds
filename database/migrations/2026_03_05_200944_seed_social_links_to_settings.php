<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * Seeds the four main social platforms into the settings.social_link field.
     * Only updates if the field is currently empty / has no filled-in links,
     * so existing data is never overwritten.
     */
    public function up(): void
    {
        $setting = DB::table("settings")->first();

        if (!$setting) {
            return;
        }

        $existing = $setting->social_link
            ? json_decode($setting->social_link, true)
            : null;

        // Determine whether any URLs are already saved
        $hasExistingLinks =
            !empty($existing["links"]) &&
            count(array_filter($existing["links"] ?? [])) > 0;

        if ($hasExistingLinks) {
            // Respect whatever the admin has already configured
            return;
        }

        // Seed the four platforms with placeholder "#" URLs.
        // The admin should fill in the real URLs via:
        //   Admin Panel → Settings → Footer & Contact Page → Social Link
        DB::table("settings")->update([
            "social_link" => json_encode([
                "icons" => [
                    "fab fa-facebook-f", // Facebook
                    "fab fa-instagram", // Instagram
                    "fab fa-linkedin-in", // LinkedIn
                    "fab fa-tiktok", // TikTok  (rendered as SVG — FA 5.8.0 does not ship this glyph)
                ],
                "links" => [
                    "#", // Replace with your Facebook page URL
                    "#", // Replace with your Instagram profile URL
                    "#", // Replace with your LinkedIn page URL
                    "#", // Replace with your TikTok profile URL
                ],
            ]),
        ]);
    }

    /**
     * Reverse the migrations.
     * Clears the social_link field back to an empty structure.
     * Only runs if the links still contain the placeholder "#" values
     * set by the up() method, to avoid accidentally wiping real data.
     */
    public function down(): void
    {
        $setting = DB::table("settings")->first();

        if (!$setting) {
            return;
        }

        $existing = $setting->social_link
            ? json_decode($setting->social_link, true)
            : null;

        if (empty($existing["links"])) {
            return;
        }

        // Only roll back if every link is still the placeholder "#"
        $allPlaceholders =
            count(
                array_filter($existing["links"], fn($url) => $url !== "#"),
            ) === 0;

        if ($allPlaceholders) {
            DB::table("settings")->update([
                "social_link" => json_encode([
                    "icons" => [],
                    "links" => [],
                ]),
            ]);
        }
    }
};

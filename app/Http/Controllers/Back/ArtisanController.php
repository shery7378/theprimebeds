<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ArtisanController extends Controller
{
    /**
     * Constructor Method.
     * Enforce admin authentication for all actions.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('adminlocalize');
    }

    /**
     * Show the Artisan Tools page.
     */
    public function index()
    {
        // Get all migration files from the migrations directory
        $migrationFiles = $this->getMigrationFiles();

        // Get migrations that have already been run from DB
        $ranMigrations = $this->getRanMigrations();

        // Get all seeder class names from the seeders directory
        $seeders = $this->getAvailableSeeders();

        return view('back.artisan.index', compact('migrationFiles', 'ranMigrations', 'seeders'));
    }

    /**
     * Run migrate command.
     */
    public function migrate(Request $request)
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();
            return back()->with('success', 'Migration ran successfully!' . ($output ? '<br><pre>' . htmlspecialchars($output) . '</pre>' : ''));
        } catch (\Exception $e) {
            return back()->with('error', 'Migration failed: ' . $e->getMessage());
        }
    }

    /**
     * Run migrate:fresh command (drops all tables and re-runs migrations).
     */
    public function migrateFresh(Request $request)
    {
        try {
            Artisan::call('migrate:fresh', ['--force' => true]);
            $output = Artisan::output();
            return back()->with('success', 'Fresh migration completed!' . ($output ? '<br><pre>' . htmlspecialchars($output) . '</pre>' : ''));
        } catch (\Exception $e) {
            return back()->with('error', 'Fresh migration failed: ' . $e->getMessage());
        }
    }

    /**
     * Run migrate:rollback command.
     */
    public function migrateRollback(Request $request)
    {
        try {
            Artisan::call('migrate:rollback', ['--force' => true]);
            $output = Artisan::output();
            return back()->with('success', 'Rollback completed!' . ($output ? '<br><pre>' . htmlspecialchars($output) . '</pre>' : ''));
        } catch (\Exception $e) {
            return back()->with('error', 'Rollback failed: ' . $e->getMessage());
        }
    }

    /**
     * Run a specific seeder class.
     */
    public function runSeeder(Request $request)
    {
        $request->validate([
            'seeder' => 'required|string',
        ]);

        $seeder = $request->input('seeder');

        // Security: only allow seeder classes from App\Database\Seeders namespace
        $allowedSeeders = $this->getAvailableSeeders();
        if (!in_array($seeder, $allowedSeeders)) {
            return back()->with('error', 'Invalid seeder class selected.');
        }

        try {
            Artisan::call('db:seed', [
                '--class' => $seeder,
                '--force' => true,
            ]);
            $output = Artisan::output();
            return back()->with('success', "Seeder <strong>{$seeder}</strong> ran successfully!" . ($output ? '<br><pre>' . htmlspecialchars($output) . '</pre>' : ''));
        } catch (\Exception $e) {
            return back()->with('error', "Seeder failed: " . $e->getMessage());
        }
    }

    /**
     * Run all seeders via DatabaseSeeder.
     */
    public function runAllSeeders()
    {
        try {
            Artisan::call('db:seed', ['--force' => true]);
            $output = Artisan::output();
            return back()->with('success', 'All seeders ran successfully!' . ($output ? '<br><pre>' . htmlspecialchars($output) . '</pre>' : ''));
        } catch (\Exception $e) {
            return back()->with('error', 'Seeder failed: ' . $e->getMessage());
        }
    }

    /**
     * Get all migration file names (without .php) from the migrations directory.
     */
    private function getMigrationFiles(): array
    {
        $path = database_path('migrations');
        $files = File::glob($path . '/*.php');
        $result = [];
        foreach ($files as $file) {
            $result[] = pathinfo($file, PATHINFO_FILENAME);
        }
        sort($result);
        return $result;
    }

    /**
     * Get migrations that have already been run from the migrations table.
     */
    private function getRanMigrations(): array
    {
        try {
            return DB::table('migrations')->pluck('migration')->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get all seeder class names from the seeders directory.
     */
    private function getAvailableSeeders(): array
    {
        $path = database_path('seeders');
        $files = File::glob($path . '/*.php');
        $seeders = [];
        foreach ($files as $file) {
            $className = pathinfo($file, PATHINFO_FILENAME);
            $seeders[] = $className;
        }
        sort($seeders);
        return $seeders;
    }
}

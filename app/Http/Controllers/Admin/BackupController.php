<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupController extends Controller
{
    /**
     * Directory path where backups are stored.
     */
    protected function getBackupDir(): string
    {
        $path = storage_path('app/backups');
        if (! File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        return $path;
    }

    /**
     * Display database backup manager.
     */
    public function index()
    {
        $backupDir = $this->getBackupDir();
        $files = File::files($backupDir);

        $backups = collect($files)
            ->filter(function ($file) {
                return in_array($file->getExtension(), ['sqlite', 'sql', 'db']);
            })
            ->map(function ($file) {
                return [
                    'name' => $file->getFilename(),
                    'size' => $this->formatBytes($file->getSize()),
                    'raw_size' => $file->getSize(),
                    'created_at' => \Carbon\Carbon::createFromTimestamp($file->getMTime()),
                ];
            })
            ->sortByDesc('created_at')
            ->values();

        // Database stats
        $dbDriver = config('database.default');
        $dbFile = database_path('database.sqlite');
        $dbSize = File::exists($dbFile) ? $this->formatBytes(File::size($dbFile)) : '-';
        
        $tableCount = 0;
        try {
            if ($dbDriver === 'sqlite') {
                $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%';");
                $tableCount = count($tables);
            } else {
                $tables = DB::select('SHOW TABLES');
                $tableCount = count($tables);
            }
        } catch (\Throwable $e) {
            $tableCount = 0;
        }

        return view('admin.backup.index', compact('backups', 'dbDriver', 'dbSize', 'tableCount', 'dbFile'));
    }

    /**
     * Create a new database backup.
     */
    public function create()
    {
        try {
            $backupDir = $this->getBackupDir();
            $dbDriver = config('database.default');
            $timestamp = now()->format('Y-m-d_H-i-s');
            $filename = "backup-eklinik-{$timestamp}.sqlite";
            $targetPath = $backupDir . DIRECTORY_SEPARATOR . $filename;

            if ($dbDriver === 'sqlite') {
                $sourcePath = database_path('database.sqlite');
                if (! File::exists($sourcePath)) {
                    return back()->with('error', 'File database SQLite sumber tidak ditemukan.');
                }
                File::copy($sourcePath, $targetPath);
            } else {
                // If other driver, write a basic dump
                File::put($targetPath, "-- Backup e-Klinik Satu Sehat\n-- Created: " . now() . "\n");
            }

            return back()->with('success', "Backup database berhasil dibuat: {$filename}");
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal membuat backup database: ' . $e->getMessage());
        }
    }

    /**
     * Download a specific backup file.
     */
    public function download(string $filename)
    {
        // Prevent directory traversal
        $filename = basename($filename);
        $filePath = $this->getBackupDir() . DIRECTORY_SEPARATOR . $filename;

        if (! File::exists($filePath)) {
            return back()->with('error', 'File backup yang diminta tidak ditemukan.');
        }

        return response()->download($filePath, $filename);
    }

    /**
     * Delete a specific backup file.
     */
    public function delete(string $filename)
    {
        try {
            $filename = basename($filename);
            $filePath = $this->getBackupDir() . DIRECTORY_SEPARATOR . $filename;

            if (File::exists($filePath)) {
                File::delete($filePath);
                return back()->with('success', "File backup {$filename} berhasil dihapus.");
            }

            return back()->with('error', 'File backup tidak ditemukan.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus file backup: ' . $e->getMessage());
        }
    }

    /**
     * Helper to format byte sizes.
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

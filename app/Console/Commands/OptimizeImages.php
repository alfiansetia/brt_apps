<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class OptimizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $folders = [
        '/app/public/img/part',
        '/app/public/img/service',
        '/app/public/img/pool',
    ];

    // 🔧 Pengaturan
    protected $maxWidth = 800;
    protected $quality = 80;

    /**
     * Execute the console command.
     */
    public function handle()
    {

        ini_set('memory_limit', '4098M');
        foreach ($this->folders as $folder) {
            if (file_exists(storage_path($folder))) {
                $path = storage_path($folder);

                if (!File::exists($path)) {
                    $this->warn("⚠️ Folder not found: $folder");
                    continue;
                }

                $files = File::allFiles($path);
                $this->info("📁 Optimizing folder: $folder (" . count($files) . " file(s))");

                foreach ($files as $key => $file) {
                    $filePath = $file->getRealPath();
                    $this->info("Process: " . $filePath);
                    try {
                        $image = Image::read($filePath);
                        $width = $image->width();
                        if ($width > $this->maxWidth) {
                            $image->scaleDown(width: $this->maxWidth);
                            $image->save($filePath, quality: $this->quality);
                            $this->info("✅ Optimized: " . $file->getFilename());
                        } else {
                            $this->error("↩️ Skipped (already small): " . $file->getFilename());
                        }
                    } catch (\Throwable $e) {
                        $this->error("❌ Failed: {$file->getFilename()} - " . $e->getMessage());
                    }
                }
                $this->newLine();
            }
        }
        $this->info("🎉 Optimization complete!");
        return 0;
    }
}

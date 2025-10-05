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

        $this->info("🧩 Starting image optimization...\n");

        $source = storage_path('app/public/img/part');
        $destination = storage_path('app/public/img/part/tmp');

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $files = File::allFiles($source);

        foreach ($files as $key => $file) {
            try {
                $this->info("🎉 File: " . $file->getFilename());

                $image = Image::read($file->getRealPath());

                $image->scaleDown(800);

                $savePath = $destination . '/' . $file->getFilename();
                $image->save($savePath);

                $this->line("✅ Saved to: " . $savePath);
            } catch (\Throwable $e) {
                $this->error("❌ Error on " . $file->getFilename() . " → " . $e->getMessage());
            }
        }

        // $this->info("🧩 Starting image optimization...\n");
        // $files = File::allFiles(storage_path('/app/public/img/part'));
        // foreach ($files as $key => $file) {
        //     $this->info("🎉 File :" . $file->getFilename());
        //     $image = Image::read($file);
        //     $image->orient();
        //     $image->scaleDown(800);
        //     $image->save(storage_path('/app/public/img/part/tmp') . $file->getFilename());
        // }

        // foreach ($this->folders as $folder) {
        //     if (file_exists(storage_path($folder))) {
        //         $path = storage_path($folder);

        //         if (!File::exists($path)) {
        //             $this->warn("⚠️ Folder not found: $folder");
        //             continue;
        //         }

        //         $files = File::allFiles($path);
        //         $this->info("📁 Optimizing folder: $folder (" . count($files) . " file(s))");

        //         foreach ($files as $key => $file) {
        //             $filePath = $file->getRealPath();

        //             // 🧠 Cek MIME type
        //             // $mime = @mime_content_type($filePath);
        //             // if (!str_starts_with($mime, 'image/')) {
        //             //     $this->info("🚫 Skipped (not image): " . $file->getFilename());
        //             //     continue;
        //             // }
        //             $this->info("Process: " . $filePath);

        //             // try {
        //             $image = scaleDown($filePath);
        //             $image->save($filePath);

        //             // $image = Image::read($filePath);
        //             // $width = $image->width();
        //             // if ($width > $this->maxWidth) {
        //             //     $image->scaleDown(width: $this->maxWidth);
        //             //     $image->save($filePath, quality: $this->quality);
        //             //     $this->info("✅ Optimized: " . $file->getFilename());
        //             // } else {
        //             //     $this->error("↩️ Skipped (already small): " . $file->getFilename());
        //             // }
        //             // } catch (\Throwable $e) {
        //             //     $this->error("❌ Failed: {$file->getFilename()} - " . $e->getMessage());
        //             // }
        //         }
        //         $this->newLine();
        //     }
        // }
        // $this->info("🎉 Optimization complete!");
        return 0;
    }
}

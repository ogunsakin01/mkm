<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportCSVJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $importLimit = 10000;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly string $fileName, public readonly int $start = 1, private int|null $end = null)
    {
        $this->end = $this->end ?: $this->importLimit;
        Log::info("Start = " . number_format($this->start) . " End=" . number_format($this->end));
    }

    /**
     * Execute the job.
     */
    public function handle(): bool
    {
        $csvPath = public_path('/' . $this->fileName);
        $csvFile = file($csvPath);
        $csvLength = count($csvFile);

        $headers = str_getcsv($csvFile[0]);

        if ($this->end > $csvLength) {
            $this->end = $csvLength - 1;
        }

        if ($this->start < $csvLength) {
            $recordsToPersistToDb = [];
            for ($i = $this->start; $i <= $this->end; $i++) {
                $line = str_getcsv($csvFile[$i]);
                $line = array_combine($headers, $line);
                $recordsToPersistToDb[] = $line;
            }

            Product::query()->upsert($recordsToPersistToDb, ['sku'], ['name', 'brand', 'description']);

            $nextStart = $this->end + 1;
            $nextEnd = $nextStart + $this->importLimit;

            dispatch(new ImportCSVJob($this->fileName, $nextStart, $nextEnd));
        } else {
            Log::info('Import successful');
        }
        return true;
    }
}

<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExportCSVJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $csvHeaders;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly string $fileName, private readonly int $page = 1)
    {
        $this->csvHeaders = ['sku', 'name', 'brand', 'description'];
    }

    /**
     * Execute the job.
     */
    public function handle(): bool
    {
        $csvPath = public_path('/' . $this->fileName);
        $csvFile = fopen($csvPath, 'a+');

        // Write header if export is new
        if ($this->page === 1) {
            fputcsv($csvFile, $this->csvHeaders);
        }

        $products = Product::query()->simplePaginate(5000, $this->csvHeaders, 'page', $this->page);
        foreach ($products as $product) {
            $product = array_values($product->toArray());
            fputcsv($csvFile, $product);
        }

        fclose($csvFile);

        if ($products->hasMorePages()) {
            $nextPage = $this->page + 1;
            dispatch(new ExportCSVJob($this->fileName, $nextPage));
        }else{
            Log::info('Export successful');
        }
        return true;
    }
}

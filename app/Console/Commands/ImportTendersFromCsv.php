<?php

namespace App\Console\Commands;

use App\Models\Tender;
use Illuminate\Console\Command;
use League\Csv\Exception;
use League\Csv\Reader;
use Carbon\Carbon;
use League\Csv\UnavailableStream;

class ImportTendersFromCsv extends Command
{
    protected $signature = 'import:tenders {file}';
    protected $description = 'Импорт тендеров из файла CSV';

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function handle(): int
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("Файл не найден: {$filePath}");
            return 1;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $count = 0;
        $skipped = 0;
        $batchSize = 1000;
        $batch = [];

        $recordGenerator = function () use ($csv) {
            foreach ($csv as $record) {
                yield $record;
            }
        };

        foreach ($recordGenerator() as $record) {
            try {
                if (Tender::where('external_code', $record['Внешний код'])->exists()) {
                    $this->warn("Тендер с external_code {$record['Внешний код']} уже существует, пропускаем");
                    $skipped++;
                    continue;
                }

                $batch[] = [
                    'external_code' => $record['Внешний код'],
                    'number' => $record['Номер'],
                    'status' => $record['Статус'],
                    'name' => $record['Название'],
                    'change_date' => Carbon::createFromFormat('d.m.Y H:i:s', $record['Дата изм.']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($batch) >= $batchSize) {
                    Tender::insert($batch);
                    $count += count($batch);
                    $batch = [];
                    $this->info("Обработано {$count} записей...");
                }
            } catch (\Exception $e) {
                $this->error("Ошибка при обработке записи: {$e->getMessage()}");
                $skipped++;
            }
        }

        if (!empty($batch)) {
            Tender::insert($batch);
            $count += count($batch);
        }

        $this->info("Импорт завершен. Импортировано {$count} тендеров, пропущено {$skipped}.");
        return 0;
    }
}

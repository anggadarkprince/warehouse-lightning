<?php

namespace App\Exports;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CollectionExporter
{
    /**
     * Export collection.
     *
     * @param Collection $data
     * @param string[] $options
     * @return string|void
     */
    public function simpleExportToExcel(Collection $data, $options = [])
    {
        $title = key_exists('title', $options) ? $options['title'] : 'Document';
        $excludes = key_exists('excludes', $options) ? $options['excludes'] : [];
        $stream = key_exists('stream', $options) ? $options['stream'] : false;
        $disk = key_exists('disk', $options) ? $options['disk'] : 'local';
        $storeTo = key_exists('storeTo', $options) ? $options['storeTo'] : 'exports/temp/' . $title . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator(config('app.name'))
            ->setLastModifiedBy(config('app.name'))
            ->setTitle($title)
            ->setSubject('Data export: ' . $title)
            ->setDescription('Data export generated by: ' . config('app.name'));

        $excelWriter = new Xlsx($spreadsheet);

        try {
            $spreadsheet->setActiveSheetIndex(0);
            $activeSheet = $spreadsheet->getActiveSheet();

            $activeSheet->setCellValue('A1', $title)
                ->getStyle('A1')
                ->getFont()
                ->setBold(true);

            if ($data->isNotEmpty()) {
                $header = collect($data->first())->filter(function ($itemData) {
                    return !is_array($itemData);
                });
                $header = $header->keys();
                $header = $header->map(function ($title) {
                    return strtoupper(str_replace(['_', '-'], ' ', $title));
                });

                $dataCells = $data->map(function ($item) use ($excludes) {
                    $itemCell = [];
                    foreach (collect($item)->toArray() as $key => $val) {
                        if (!in_array($key, $excludes) && !is_array($val)) {
                            $itemCell[$key] = $val;
                        }
                    }

                    return collect($itemCell);
                });

                $activeSheet->fromArray($header->toArray(), null, 'A1');
                $activeSheet->fromArray($dataCells->toArray(), null, 'A2');

                $this->setHeaderFilterAndStyles($spreadsheet, $header);
            }

            if ($stream) {
                $excelWriter->save('php://output');
            } else {
                return $this->persistToDisk($excelWriter, $storeTo, $disk);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Export lazy collection.
     *
     * @param LazyCollection $data
     * @param string[] $options
     * @return string|void
     */
    public function lazyExportToExcel(LazyCollection $data, $options = [])
    {
        $title = key_exists('title', $options) ? $options['title'] : 'Document';
        $excludes = key_exists('excludes', $options) ? $options['excludes'] : [];
        $stream = key_exists('stream', $options) ? $options['stream'] : false;
        $disk = key_exists('disk', $options) ? $options['disk'] : 'local';
        $storeTo = key_exists('storeTo', $options) ? $options['storeTo'] : 'exports/temp/' . $title . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator(config('app.name'))
            ->setLastModifiedBy(config('app.name'))
            ->setTitle($title)
            ->setSubject('Data export: ' . $title)
            ->setDescription('Data export generated by: ' . config('app.name'));

        $excelWriter = new Xlsx($spreadsheet);

        try {
            $spreadsheet->setActiveSheetIndex(0);
            $activeSheet = $spreadsheet->getActiveSheet();

            $activeSheet->setCellValue('A1', $title)
                ->getStyle('A1')
                ->getFont()
                ->setBold(true);

            if ($data->isNotEmpty()) {
                $header = collect($data->first())->filter(function ($itemData, $key) use ($excludes) {
                    return !is_array($itemData) && !in_array($key, $excludes);
                });
                $header = $header->keys()->map(function ($title) {
                    return strtoupper(str_replace(['_', '-'], ' ', $title));
                });

                // add header into sheet
                $startRow = 1;
                $activeSheet->fromArray($header->toArray(), null, 'A' . $startRow);

                // add data into sheet
                $startRow = 2;
                $data->each(function ($row, $index) use ($activeSheet, $startRow, $excludes) {
                    $itemCell = [];
                    foreach (collect($row)->toArray() as $key => $val) {
                        if (!is_array($val) && !in_array($key, $excludes)) {
                            $itemCell[$key] = $val;
                        }
                    }

                    $activeSheet->fromArray($itemCell, null, 'A' . ($startRow + $index));
                });

                $this->setHeaderFilterAndStyles($spreadsheet, $header);
            }

            if ($stream) {
                $excelWriter->save('php://output');
            } else {
                return $this->persistToDisk($excelWriter, $storeTo, $disk);
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Set header filter and style.
     *
     * @param Spreadsheet $spreadsheet
     * @param $header
     */
    protected function setHeaderFilterAndStyles(Spreadsheet $spreadsheet, $header)
    {
        $columnIterator = $spreadsheet->getActiveSheet()->getColumnIterator();
        foreach ($columnIterator as $column) {
            $spreadsheet->getActiveSheet()
                ->getColumnDimension($column->getColumnIndex())
                ->setAutoSize(true);

            $spreadsheet->getActiveSheet()
                ->getStyle($column->getColumnIndex() . '1')
                ->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['rgb' => '000000']
                        ],
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb' => 'FFFFFF']
                        ]
                    ]
                );
        }

        $spreadsheet->getActiveSheet()->setAutoFilterByColumnAndRow(1, 1, $header->count(), 1);
    }

    /**
     * Persist exported data to disk.
     *
     * @param $excelWriter
     * @param $storeTo
     * @param $disk
     * @return false
     */
    protected function persistToDisk($excelWriter, $storeTo, $disk)
    {
        ob_start();
        $excelWriter->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        if (Storage::disk($disk)->put($storeTo, $content)) {
            return $storeTo;
        }

        return false;
    }

    /**
     * Simplify stream download for data export.
     *
     * @param $data
     * @param $options
     * @return StreamedResponse
     */
    public function streamDownload($data, $options)
    {
        $options['stream'] = true;
        $headers = key_exists('headers', $options) ? $options['headers'] : [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
        $fileName = data_get($options, 'fileName', Str::slug(data_get($options, 'title', 'File')) . '.xlsx');

        return response()->streamDownload(function () use ($data, $fileName, $options) {
            $this->lazyExportToExcel($data, $options);
        }, $fileName, $headers);
    }
}

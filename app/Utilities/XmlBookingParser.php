<?php

namespace App\Utilities;

use App\Models\Container;
use App\Models\Goods;

class XmlBookingParser
{
    /**
     * Parse and check imported file data.
     *
     * @param $path
     * @return mixed
     */
    public function parse($path)
    {
        $xml = simplexml_load_file($path);

        $parsedData = json_decode(json_encode($xml), true);

        if (key_exists('header', $parsedData)) {
            $data = $parsedData['header'];

            if (!key_exists('0', $data['kontainer']) || !is_array($data['kontainer'][0])) {
                $data['kontainer'] = [$data['kontainer']];
            }
            if (!key_exists('0', $data['barang']) || !is_array($data['barang'][0])) {
                $data['barang'] = [$data['barang']];
            }
            return collect([
                'reference_number' => $data['nomorAju'],
                'supplier_name' => $data['namaPemasok'],
                'owner_name' => $data['namaPemilik'],
                'shipper_name' => $data['namaPengirim'],
                'carrier_name' => $data['namaPengangkut'],
                'voy_flight' => $data['nomorVoyFlight'],
                'arrival_date' => $data['tanggalTiba'],
                'tps' => $data['kodeTps'],
                'total_cif' => $data['cif'],
                'total_gross_weight' => $data['bruto'],
                'total_weight' => $data['netto'],
                'description' => '',
                'containers' => collect($data['kontainer'])->map(function ($container) {
                    $existingContainer = Container::where('container_number', $container['nomorKontainer'])->first();
                    return collect([
                        'container_id' => $existingContainer ? $existingContainer->id : '',
                        'container_number' => $existingContainer ? $existingContainer->container_number : $container['nomorKontainer'],
                        'container_type' => $existingContainer ? $existingContainer->container_type : $container['kodeTipeKontainer'],
                        'container_size' => $existingContainer ? $existingContainer->container_size : $container['kodeUkuranKontainer'],
                        'shipping_line' => $existingContainer ? $existingContainer->shipping_line : '',
                        'seal' => '',
                        'description' => '',
                    ]);
                }),
                'goods' => collect($data['barang'])->map(function ($goods) use ($data) {
                    $itemNumber = $data['nomorAju'] . '-' . $goods['kodeBarang'];
                    $existingGoods = Goods::where('item_number', $itemNumber)->first();
                    return collect([
                        'goods_id' => $existingGoods ? $existingGoods->id : '',
                        'item_name' => $goods['uraian'],
                        'item_number' => $itemNumber,
                        'unit_quantity' => $goods['jumlahSatuan'],
                        'package_quantity' => $goods['jumlahKemasan'],
                        'unit_name' => $goods['kodeSatuan'],
                        'package_name' => $goods['kodeKemasan'],
                        'weight' => $goods['netto'],
                        'gross_weight' => $goods['netto'],
                        'description' => '',
                    ]);
                })
            ]);
        }

        return null;
    }

}

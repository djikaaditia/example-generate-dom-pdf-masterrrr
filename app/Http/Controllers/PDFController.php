<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $image1 = file_get_contents('images/logo.png');
        $encoded_image1 = base64_encode($image1);
        $image2 = file_get_contents('images/garis.png');
        $encoded_image2 = base64_encode($image2);
        $image3 = file_get_contents('images/bulat.png');
        $encoded_image3 = base64_encode($image3);
        $users = User::get();

        
        $data = [
            'encoded_images' => [
            'logo' => $encoded_image1,
            'garis' => $encoded_image2,
            'bulat' => $encoded_image3,
        ],
            'title' => 'Example Generate PDF',
            'date' => date('m/d/Y'),
            'users' => $users,
            'rincian_gaji' => [
                'details'  => [
                    'jumlah_pasien'  => '30 Pasien',
                    'total_transaksi'  => 'Rp 24.340.000',
                    'total_discount'  => '-Rp 300.000',
                    'total_biaya_sarana_lab'  => '-Rp 300.000',
                    'total_nett_transaksi'  => 'Rp 16.850.000',
                ],
                'sharing' => [
                    'total_sharing_gross' => 'Rp 5.264.000',
                    'total_sharing_o/s' => '-Rp 2.086.000',
                    'total_sharing' => 'Rp 3.178.000',
                ],
                'potongan' => [
                    'total_potongan' => '-Rp 32.250',
                    'keterangan' => 'PPH21',
                ],
                'tambahan' => [
                    'total_tambahan' => 'Rp 100.000',
                    'keterangan' => 'Bonus bulanan',
                ],
            ],
        ];
        // $details = [
        //     ['name' => 'Jumlah Pasien', 'value' => '30 Pasien'],
        //     ['name' => 'Total Transaksi', 'value' => 'Rp 22.340.000'],
        //     ['name' => 'Total Discount', 'value' => '-Rp 300.000'],
        //     ['name' => 'Total Biaya Sarana/Lab', 'value' => '-Rp 300.000'],
        //     ['name' => 'Total Nett. Transaksi', 'value' => 'Rp 16.850.000'],
        // ];
        
        
        // $pdf = Pdf::loadView('pdf', $details);
        $pdf = Pdf::loadView('pdf', $data);

        return $pdf->stream('slip_gaji.pdf');
    }
}

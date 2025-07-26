<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Tagihan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 20px;
        }

        .struk {
            max-width: 350px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .info,
        .summary {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table td,
        table th {
            padding: 4px;
            border-bottom: 1px dotted #000;
            text-align: left;
        }

        table:last-of-type td {
            border-bottom: 1px solid #000;
            padding: 6px 4px;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #000 !important;
        }

        .text-right {
            text-align: right;
        }

        .thank {
            text-align: center;
            margin-top: 10px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="struk">
        <h2>VOLTIX</h2>
        <p style="text-align: center; font-size: 11px; margin: -5px 0 15px 0;">
            Sistem Pembayaran Listrik Pascabayar<br>
            ====================================
        </p>

        <div class="info">
            <p>No Tagihan: {{ $tagihan->id_tagihan }}</p>
            <p>Invoice: {{ $tagihan->no_invoice ?? '#' . str_pad($tagihan->id_tagihan, 8, '0', STR_PAD_LEFT) }}</p>
            <p>Nama Pelanggan: {{ $tagihan->pelanggan->nama_pelanggan }}</p>
            <p>Periode: {{ bulanIndo($tagihan->bulan) }} {{ $tagihan->tahun }}</p>
            @if (isset($pembayaran) && $pembayaran && $pembayaran->metodePembayaran)
                <p>Metode Pembayaran: {{ $pembayaran->metodePembayaran->nama }}</p>
            @endif
            <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
            <hr style="border: 1px dotted #000; margin: 10px 0;">
        </div>

        <table>
            <tbody>
                <tr>
                    <td>No. KWH</td>
                    <td class="text-right">{{ $tagihan->pelanggan->nomor_kwh }}</td>
                </tr>
                <tr>
                    <td>Daya Terpasang</td>
                    <td class="text-right">{{ $tagihan->pelanggan->tarif->daya ?? 'N/A' }} VA</td>
                </tr>
                <tr>
                    <td>Penggunaan Listrik</td>
                    <td class="text-right">{{ $tagihan->jumlah_meter }} kWh</td>
                </tr>
                <tr>
                    <td>Tarif per kWh</td>
                    <td class="text-right">Rp
                        {{ number_format($tagihan->pelanggan->tarif->tarifperkwh ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td class="text-right">{{ $tagihan->status }}</td>
                </tr>
            </tbody>
        </table>

        <table>
            <tbody>
                <tr>
                    <td>Biaya Pemakaian</td>
                    <td class="text-right">Rp
                        {{ number_format($tagihan->jumlah_meter * ($tagihan->pelanggan->tarif->tarifperkwh ?? 0), 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td>Biaya Admin</td>
                    <td class="text-right">Rp
                        @if (isset($pembayaran) && $pembayaran->biaya_admin)
                            {{ number_format($pembayaran->biaya_admin, 0, ',', '.') }}
                        @else
                            {{ number_format(2500, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="total">TOTAL TAGIHAN</td>
                    <td class="text-right total">Rp
                        @if (isset($pembayaran) && $pembayaran->total_bayar)
                            {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}
                        @else
                            {{ number_format($tagihan->jumlah_meter * ($tagihan->pelanggan->tarif->tarifperkwh ?? 0) + 2500, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="thank">
            <p>Terima kasih!</p>
            <p style="font-size: 11px; margin-top: 15px;">
                Pembayaran dapat dilakukan melalui sistem online.<br>
                Simpan struk ini sebagai bukti.
            </p>
        </div>
    </div>
</body>

</html>

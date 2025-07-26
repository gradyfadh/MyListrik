<?php

function bubbleSort(&$arr, $n) {
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
        }
    }
}

function binarySearch($arr, $n, $cari) {
    $low = 0;
    $high = $n - 1;
    while ($low <= $high) {
        $mid = floor(($low + $high) / 2);
        if ($arr[$mid] == $cari) {
            return true;
        }
        if ($cari < $arr[$mid]) {
            $high = $mid - 1;
        } else {
            $low = $mid + 1;
        }
    }
    return false;
}

// MAIN PROGRAM
$angka = [];
$n = 0;

while (true) {
    echo "\n========== MENU ==========\n";
    echo "1. Input Angka\n";
    echo "2. Sorting\n";
    echo "3. Searching\n";
    echo "4. Keluar\n";
    echo "Pilih menu (1-4): ";
    $pilihan = trim(fgets(STDIN));

    if ($pilihan == 1) {
        echo "Masukkan jumlah angka: ";
        $n = (int) trim(fgets(STDIN));
        for ($i = 0; $i < $n; $i++) {
            echo "Angka ke-" . ($i + 1) . ": ";
            $angka[$i] = (int) trim(fgets(STDIN));
        }
        echo "Angka berhasil diinput!\n";
    } elseif ($pilihan == 2) {
        if ($n === 0) {
            echo "Data belum diinput.\n";
            continue;
        }
        echo "Data sebelum sorting:\n";
        foreach ($angka as $a) {
            echo "$a ";
        }
        echo "\n";

        bubbleSort($angka, $n);

        echo "Hasil setelah sorting (Ascending):\n";
        foreach ($angka as $a) {
            echo "$a ";
        }
        echo "\n";
    } elseif ($pilihan == 3) {
        if ($n === 0) {
            echo "Data belum diinput.\n";
            continue;
        }
        echo "Masukkan angka yang dicari: ";
        $cari = (int) trim(fgets(STDIN));
        $hasil = binarySearch($angka, $n, $cari);
        if ($hasil) {
            echo "Angka $cari ditemukan.\n";
        } else {
            echo "Angka $cari tidak ditemukan.\n";
        }
    } elseif ($pilihan == 4) {
        echo "Keluar dari program...\n";
        break;
    } else {
        echo "Menu tidak valid!\n";
    }
}

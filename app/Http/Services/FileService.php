<?php

namespace App\Http\Services;

class FileService
{
    // proses upload
    public function upload($file, $path)
    {
        $uploaded = $file;
        $fileName = $uploaded->hashName();

        return $uploaded->storeAs($path, $fileName, 'public');
    }

    // cara 1
    // proses delete
    // public function delete($file)
    // {
    //     $fullPath = storage_path('app/public/' . $file); // Menggabungkan path

    //     // Cek apakah file ada sebelum mencoba menghapusnya
    //     if (file_exists($fullPath)) {
    //         $deleted = unlink($fullPath); // Menghapus file
    //         return $deleted; // Mengembalikan hasil penghapusan
    //     }

    //     // Jika file tidak ada, bisa mengembalikan false atau menangani sesuai kebutuhan
    //     return false;
    // }

    // cara 2
    public function delete($file)
    {
        $filePath = storage_path('app/public/' . $file);

        // Cek apakah file ada sebelum menghapusnya
        if (file_exists($filePath)) {
            return unlink($filePath);
        }

        // Kembalikan false jika file tidak ditemukan
        return false;
    }
}

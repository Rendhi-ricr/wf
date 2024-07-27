<?php

function create_slug($string) {
    // Ubah ke huruf kecil
    $string = strtolower($string);
    
    // Hapus karakter yang tidak perlu
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    
    // Ganti spasi dengan tanda hubung (-)
    $string = preg_replace('/[\s-]+/', '-', $string);
    
    // Hapus tanda hubung dari awal dan akhir
    $string = trim($string, '-');
    
    return $string;
}
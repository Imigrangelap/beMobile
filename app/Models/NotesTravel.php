<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotesTravel extends Model
{
    /** @use HasFactory<\Database\Factories\NotesTravelFactory> */
    use HasFactory;
    protected $fillable = [
        'id_users',
        'deskripsi_travel',
        'nama_wisata',
        'foto_thumbnail	',
        'tanggal_kunjungan',
        'rating_travel',
        'biaya_travel'
    ];
}

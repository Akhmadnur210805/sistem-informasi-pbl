<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Pengumpulan extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'mata_kuliah_id', 'nama_file', 'path_file'];
}
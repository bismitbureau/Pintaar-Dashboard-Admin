<?php

namespace Models\App;

use Illuminate\Database\Eloquent\Model;

class PertanyaanTopik extends Model
{
    protected $table = 'pertanyaan_topiks';

	// public $timestamps = false;

    protected $fillable = ['id_topik', 'pertanyaan', 'judul_pertanyaan', 'gambar',
                            'jawaban', 'opsi_1', 'opsi_2', 'opsi_3', 'opsi_4'];



}

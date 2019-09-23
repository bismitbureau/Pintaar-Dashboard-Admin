<?php
namespace Models\App;
use Illuminate\Database\Eloquent\Model;
class FileTopik extends Model
{
protected $table = 'file_topik';
protected $fillable = ['id_topik', 'file_name', 'url', 'is_active'];
public function topiks()
{
  return $this->belongsTo("App\Topik", "id_topik");
}
}

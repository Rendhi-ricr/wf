<?php

namespace App\Models;

use CodeIgniter\Model;

class KsModel extends Model
{
    protected $table            = 't_kerjasama';
    protected $primaryKey       = 'id_ks';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title_ks', 'photo_cover', 'date_posting', 'time_posting', 'id_user'
    ];

    protected bool $allowEmptyInserts = false;

    public function markAsTrash($ids)
    {
        return $this->whereIn('id_ks', $ids)->set(['trash' => '2'])->update();
    }

    public function trash($ids)
    {
        return $this->where('id_ks', $ids)->set(['trash' => '2'])->update();
    }

    public function restore($ids)
    {
        return $this->where('id_ks', $ids)->set(['trash' => '1'])->update();
    }
}

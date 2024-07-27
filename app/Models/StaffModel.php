<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{
    protected $table            = 't_staff';
    protected $primaryKey       = 'id_staff';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_staff', 'photo_cover', 'jabatan', 'id_user',
    ];

    protected bool $allowEmptyInserts = false;

    public function markAsTrash($ids)
    {
        return $this->whereIn('id_staff', $ids)->set(['trash' => '2'])->update();
    }

    public function trash($ids)
    {
        return $this->where('id_staff', $ids)->set(['trash' => '2'])->update();
    }

    public function restore($ids)
    {
        return $this->where('id_staff', $ids)->set(['trash' => '1'])->update();
    }
}

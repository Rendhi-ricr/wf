<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $table            = 't_agenda';
    protected $primaryKey       = 'id_agenda';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title_agenda', 'starttime_agenda', 'endtime_agenda', 'date_agenda', 'location', 'desc_agenda',
        'status', 'trash', 'photo_cover', 'photo_desc', 'date_posting', 'time_posting', 'slug_agenda', 'id_user'
    ];

    protected bool $allowEmptyInserts = false;

    public function markAsTrash($ids)
    {
        return $this->whereIn('id_agenda', $ids)->set(['trash' => '2'])->update();
    }

    public function trash($ids)
    {
        return $this->where('id_agenda', $ids)->set(['trash' => '2'])->update();
    }

    public function restore($ids)
    {
        return $this->where('id_agenda', $ids)->set(['trash' => '1'])->update();
    }
}

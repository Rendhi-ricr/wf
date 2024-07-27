<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table            = 't_faq';
    protected $primaryKey       = 'id_faq';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title_faq', 'desc_faq', 'date_posting', 'time_posting', 'id_user'
    ];

    protected bool $allowEmptyInserts = false;

    public function markAsTrash($ids)
    {
        return $this->whereIn('id_faq', $ids)->set(['trash' => '2'])->update();
    }

    public function trash($ids)
    {
        return $this->where('id_faq', $ids)->set(['trash' => '2'])->update();
    }

    public function restore($ids)
    {
        return $this->where('id_faq', $ids)->set(['trash' => '1'])->update();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table            = 't_news';
    protected $primaryKey       = 'id_news';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title_news', 'status', 'trash', 'photo_cover', 'photo_desc', 'desc_news', 'date_posting', 'time_posting', 'slug_news', 'id_user'
    ];

    protected bool $allowEmptyInserts = false;

    public function markAsTrash($ids)
    {
        return $this->whereIn('id_news', $ids)->set(['trash' => '2'])->update();
    }

    public function trash($ids)
    {
        return $this->where('id_news', $ids)->set(['trash' => '2'])->update();
    }

    public function restore($ids)
    {
        return $this->where('id_news', $ids)->set(['trash' => '1'])->update();
    }
}

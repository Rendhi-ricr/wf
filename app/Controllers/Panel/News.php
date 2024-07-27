<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\NewsModel;

class News extends BaseController
{
    public function index()
    {
        return view('bo_layouts/news/index');
    }

    public function fetchNewsPublish()
    {
        $request = service('request');
        $NewsModel = new NewsModel();

        $searchValue = $request->getPost('search')['value'] ?? '';
        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;

        $totalRecords = $NewsModel->countAllResults();

        $q = $NewsModel->select('t_news.id_news, t_news.title_news, t_news.status, t_news.trash, t_news.date_posting, t_news.time_posting, u.fullname')
            ->join('t_user as u', 't_news.id_user=u.id_user', 'inner')
            ->groupStart() // Mulai grup kondisi LIKE
            ->like('t_news.title_news', $searchValue)
            // ->orLike('rc.nm_category', $searchValue)
            ->groupEnd() // Akhir grup kondisi LIKE
            ->where([
                't_news.status' => 'publish',
                't_news.trash' => '1'
            ]);

        $totalRecordsWithFilter = $q->countAllResults(false);

        $newss = $q->orderBy('t_news.id_news', 'DESC')
            ->findAll($length, $start);

        $data = [];
        foreach ($newss as $news) {
            $data[] = [
                '<input type="checkbox" class="row-select">',
                $news['id_news'],
                $news['title_news'],
                '<span class="badge text-bg-success">' . $news['status'] . '</span>',
                $news['date_posting'] . ' ' . $news['time_posting'],
                $news['fullname'],
                '<div class="d-flex align-items-center">
                <a href="' . site_url("panel/news/" . $news['id_news'] . "/edit") . '" class="btn btn-light me-2" title="Edit"><i class="ti ti-edit ti-sm"></i></a>
                <button 
                    data-bs-toggle="modal" 
                    data-bs-target="#konfirmasiHapusData" 
                    data-title="' . $news['title_news'] . '" 
                    data-href="' . site_url("panel/news/" . $news['id_news'] . "/trash") . '" 
                    class="btn btn-danger" title="Trash"><i class="ti ti-trash ti-sm"></i></button>
                </div>',
            ];
        }

        $response = [
            "draw" => intval($request->getPost('draw')),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordsWithFilter,
            "data" => $data
        ];

        return $this->response->setJSON($response);
    }

    public function fetchNewsDraft()
    {
        $request = service('request');
        $NewsModel = new NewsModel();

        $searchValue = $request->getPost('search')['value'] ?? '';
        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;

        $totalRecords = $NewsModel->countAllResults();

        $q = $NewsModel->select('t_news.id_news, t_news.title_news, t_news.status, t_news.trash, t_news.date_posting, t_news.time_posting, u.fullname')
            ->join('t_user as u', 't_news.id_user=u.id_user', 'inner')
            ->groupStart() // Mulai grup kondisi LIKE
            ->like('t_news.title_news', $searchValue)
            // ->orLike('rc.nm_category', $searchValue)
            ->groupEnd() // Akhir grup kondisi LIKE
            ->where([
                't_news.status' => 'draft',
                't_news.trash' => '1'
            ]);

        $totalRecordsWithFilter = $q->countAllResults(false);

        $newss = $q->orderBy('t_news.id_news', 'DESC')
            ->findAll($length, $start);

        $data = [];
        foreach ($newss as $news) {
            $data[] = [
                '<input type="checkbox" class="row-select">',
                $news['id_news'],
                $news['title_news'],
                '<span class="badge text-bg-warning">' . $news['status'] . '</span>',
                $news['date_posting'] . ' ' . $news['time_posting'],
                $news['fullname'],
                '<div class="d-flex align-items-center">
                <a href="' . site_url("panel/news/" . $news['id_news'] . "/edit") . '" class="btn btn-light me-2" title="Edit"><i class="ti ti-edit ti-sm"></i></a>
                <button 
                    data-bs-toggle="modal" 
                    data-bs-target="#konfirmasiHapusData" 
                    data-title="' . $news['title_news'] . '" 
                    data-href="' . site_url("panel/news/" . $news['id_news'] . "/trash") . '" 
                    class="btn btn-danger" title="Trash"><i class="ti ti-trash ti-sm"></i></button>
                </div>',
            ];
        }

        $response = [
            "draw" => intval($request->getPost('draw')),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordsWithFilter,
            "data" => $data
        ];

        return $this->response->setJSON($response);
    }

    public function fetchNewsTrash()
    {
        $request = service('request');
        $NewsModel = new NewsModel();

        $searchValue = $request->getPost('search')['value'] ?? '';
        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;

        $totalRecords = $NewsModel->countAllResults();

        $q = $NewsModel->select('t_news.id_news, t_news.title_news, t_news.status, t_news.trash, t_news.date_posting, t_news.time_posting, u.fullname')
            ->join('t_user as u', 't_news.id_user=u.id_user', 'inner')
            ->groupStart() // Mulai grup kondisi LIKE
            ->like('t_news.title_news', $searchValue)
            ->groupEnd() // Akhir grup kondisi LIKE
            ->where('t_news.trash', '2');

        $totalRecordsWithFilter = $q->countAllResults(false);

        $newss = $q->orderBy('t_news.id_news', 'DESC')
            ->findAll($length, $start);

        $data = [];
        foreach ($newss as $news) {
            $data[] = [
                $news['id_news'],
                $news['title_news'],
                '<span class="badge text-bg-danger">trash</span>',
                $news['date_posting'] . ' ' . $news['time_posting'],
                $news['fullname'],
                '<div class="d-flex align-items-center">
                <a href="' . site_url("panel/news/" . $news['id_news'] . "/restore") . '" class="btn btn-warning me-2" title="Restore"><i class="ti ti-restore ti-sm"></i></a>
                <button 
                    data-bs-toggle="modal" 
                    data-bs-target="#konfirmasiHapusData" 
                    data-title="' . $news['title_news'] . '" 
                    data-href="' . site_url("panel/news/" . $news['id_news'] . "/remove") . '" 
                    class="btn btn-danger" title="Delete Permanen"><i class="ti ti-trash ti-sm"></i></button>
                </div>',
            ];
        }

        $response = [
            "draw" => intval($request->getPost('draw')),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordsWithFilter,
            "data" => $data
        ];

        return $this->response->setJSON($response);
    }

    public function tambah()
    {
        $data = [];
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'title_news' => 'required',
                'desc_news' => 'required',
                'status' => 'required',
                'photo_cover' => 'if_exist'
                    . '|is_image[photo_cover]'
                    . '|mime_in[photo_cover,image/jpg,image/jpeg,image/png,image/gif]'
                    . '|ext_in[photo_cover,jpg,jpeg,png,gif]'
                    . '|max_size[photo_cover,2048]',
            ];

            $messages = [
                'title_news' => [
                    'required' => 'News harus di isi.',
                ],

                'desc_news' => [
                    'required' => 'Description harus di isi.',
                ],
                'status' => [
                    'required' => 'Status harus di isi.',
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                // Jika validasi gagal, kirim error ke view
                $data['validation'] = $this->validator;
            } else {
                $newsModel = new NewsModel();
                $storeData = [
                    'title_news'   => $this->request->getPost('title_news'),
                    'status'   => $this->request->getPost('status'),
                    'trash'   => '1',
                    'desc_news'   => $this->request->getPost('desc_news'),
                    'date_posting' => date('Y-m-d'),
                    'time_posting' => date('H:i'),
                    'slug_news' => create_slug($this->request->getPost('title_news')),
                    'id_user' => 3,
                ];

                if ($this->request->getPost('photo_desc')) {
                    $storeData['photo_desc'] = $this->request->getPost('photo_desc');
                }

                $file = $this->request->getFile('photo_cover');

                if ($file && $file->isValid() && !$file->hasMoved()) {
                    // Baca konten file
                    $fileContent = file_get_contents($file->getTempName());

                    // Periksa apakah ada tag PHP atau kode jahat dalam konten file
                    if (preg_match('/<\?php|<script|<\?=/i', $fileContent)) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung kode berbahaya dan tidak dapat diunggah.';
                        return view('bo_layouts/news/tambah', $data); // Jangan lanjutkan proses
                    }

                    // Mengecek metadata gambar untuk informasi yang mencurigakan
                    $exifData = @exif_read_data($file->getTempName());
                    if ($exifData && isset($exifData['Comment']) && preg_match('/<\?php|<script|<\?=/i', $exifData['Comment'])) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung metadata berbahaya dan tidak dapat diunggah.';
                        return view('bo_layouts/news/tambah', $data); // Jangan lanjutkan proses
                    }

                    $newFileName = 'news_' . time() . '.' . $file->getClientExtension();

                    // Pindahkan file ke direktori tujuan dengan nama baru
                    $file->move(WRITEPATH . 'uploads/news', $newFileName);

                    $storeData['photo_cover'] = $newFileName;
                }

                $newsModel->insert($storeData);

                //flash message
                session()->setFlashdata('message', 'News berhasil disimpan');
                return redirect()->to('/panel/news');
            }
        }

        return view('bo_layouts/news/tambah', $data);
    }

    public function edit($id)
    {
        $newsModel = new NewsModel();
        $da = $newsModel->where('id_news', $id)->first();

        $data = [];
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'title_news' => 'required',
                'desc_news' => 'required',
                'status' => 'required',
                'photo_cover' => 'if_exist'
                    . '|is_image[photo_cover]'
                    . '|mime_in[photo_cover,image/jpg,image/jpeg,image/png,image/gif]'
                    . '|ext_in[photo_cover,jpg,jpeg,png,gif]'
                    . '|max_size[photo_cover,2048]',
            ];

            $messages = [
                'title_news' => [
                    'required' => 'News harus di isi.',
                ],
                'desc_news' => [
                    'required' => 'Description harus di isi.',
                ],
                'status' => [
                    'required' => 'Status harus di isi.',
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                // Jika validasi gagal, kirim error ke view
                $data['validation'] = $this->validator;
            } else {
                $storeData = [
                    'title_news'   => $this->request->getPost('title_news'),
                    'slug_news' => create_slug($this->request->getPost('title_news')),
                    'desc_news'   => $this->request->getPost('desc_news'),
                    'status'   => $this->request->getPost('status'),
                    'trash'   => '1',
                    'date_posting' => date('Y-m-d'),
                    'time_posting' => date('H:i'),
                    'id_user' => 3,
                ];

                if ($this->request->getPost('photo_desc')) {
                    $storeData['photo_desc'] = $this->request->getPost('photo_desc');
                }

                $file = $this->request->getFile('photo_cover');

                if ($file && $file->isValid() && !$file->hasMoved()) {
                    // Baca konten file
                    $fileContent = file_get_contents($file->getTempName());

                    // Periksa apakah ada tag PHP atau kode jahat dalam konten file
                    if (preg_match('/<\?php|<script|<\?=/i', $fileContent)) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung kode berbahaya dan tidak dapat diunggah.';
                        $data['dataNews'] = $da;
                        return view('bo_layouts/news/edit', $data); // Jangan lanjutkan proses
                    }

                    // Mengecek metadata gambar untuk informasi yang mencurigakan
                    $exifData = @exif_read_data($file->getTempName());
                    if ($exifData && isset($exifData['Comment']) && preg_match('/<\?php|<script|<\?=/i', $exifData['Comment'])) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung metadata berbahaya dan tidak dapat diunggah.';
                        $data['dataNews'] = $da;
                        return view('bo_layouts/news/edit', $data); // Jangan lanjutkan proses
                    }

                    // Pindahkan file ke direktori tujuan dengan nama baru
                    $newFileName = 'news_ ' . time() . '.' . $file->getClientExtension();
                    $file->move(WRITEPATH . 'uploads/news ', $newFileName);

                    $existingFile = $da['photo_cover'];
                    if ($existingFile) {
                        if (file_exists(WRITEPATH . 'uploads/news/' . $existingFile)) {
                            unlink(WRITEPATH . 'uploads/news/' . $existingFile);
                        }
                    }

                    $storeData['photo_cover'] = $newFileName;
                }

                $newsModel->update($id, $storeData);

                //flash message
                session()->setFlashdata('message', 'News berhasil disimpan');
                return redirect()->to('/panel/news');
            }
        }

        $data['dataNews'] = $da;
        return view('bo_layouts/news/edit', $data);
    }

    public function trashSelected()
    {
        $newsModel = new NewsModel();
        $ids = $this->request->getPost('ids');
        if ($ids) {
            $newsModel->markAsTrash($ids);
            // return $this->response->setJSON(['status' => 'success']);
        }
        // return $this->response->setJSON(['status' => 'error']);

        //flash message
        session()->setFlashdata('message', 'News berhasil dihapus');
        return redirect()->to('/panel/news');
    }

    public function trash($id)
    {
        $newsModel = new NewsModel();
        $newsModel->trash($id);

        //flash message
        session()->setFlashdata('message', 'News berhasil dihapus');
        return redirect()->to('/panel/news');
    }

    public function restore($id)
    {
        $newsModel = new NewsModel();
        $newsModel->restore($id);

        //flash message
        session()->setFlashdata('message', 'News berhasil direstore');
        return redirect()->to('/panel/news');
    }

    public function remove($id)
    {
        $newsModel = new NewsModel();
        $da = $newsModel->where('id_news ', $id)->first();
        $existingFile = $da['photo_cover'];
        if ($existingFile) {
            if (file_exists(WRITEPATH . 'uploads/news/' . $existingFile)) {
                unlink(WRITEPATH . 'uploads/news/' . $existingFile);
            }
        }

        $newsModel->delete($id);
        //flash message
        session()->setFlashdata('message', 'News berhasil dihapus');
        return redirect()->to('/panel/news');
    }
}

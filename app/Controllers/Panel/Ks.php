<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\KsModel;

class Ks extends BaseController
{
    public function index()
    {
        return view('bo_layouts/kerjasama/index');
    }

    public function fetchKerjasama()
    {
        $request = service('request');
        $ksModel = new KsModel();

        $searchValue = $request->getPost('search')['value'] ?? '';
        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;

        $totalRecords = $ksModel->countAllResults();

        $q = $ksModel->select('t_kerjasama.id_ks, t_kerjasama.photo_cover,t_kerjasama.title_ks, t_kerjasama.date_posting, t_kerjasama.time_posting, u.fullname')
            ->join('t_user as u', 't_kerjasama.id_user=u.id_user', 'inner')
            ->groupStart() // Mulai grup kondisi LIKE
            ->like('t_kerjasama.title_ks', $searchValue)
            // ->orLike('rc.nm_category', $searchValue)
            ->groupEnd(); // Akhir grup kondisi LIKE


        $totalRecordsWithFilter = $q->countAllResults(false);

        $kss = $q->orderBy('t_kerjasama.id_ks', 'DESC')
            ->findAll($length, $start);

        $data = [];
        foreach ($kss as $ks) {
            $data[] = [
                '<input type="checkbox" class="row-select">',
                $ks['id_ks'],
                $ks['title_ks'],
                '<img src="' . base_url('uploads/kerjasama/' . $ks['photo_cover']) . '" width="200px" class="d-block mx-auto">',
                $ks['date_posting'] . ' ' . $ks['time_posting'],
                $ks['fullname'],
                '<div class="d-flex align-items-center">
                <a href="' . site_url("panel/ks/" . $ks['id_ks'] . "/edit") . '" class="btn btn-light me-2" title="Edit"><i class="ti ti-edit ti-sm"></i></a>
                 <button 
                    data-bs-toggle="modal" 
                    data-bs-target="#konfirmasiHapusData" 
                    data-title="' . $ks['title_ks'] . '" 
                    data-href="' . site_url("panel/ks/" . $ks['id_ks'] . "/remove") . '" 
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
                'title_ks' => 'required',
                'photo_cover' => 'if_exist'
                    . '|is_image[photo_cover]'
                    . '|mime_in[photo_cover,image/jpg,image/jpeg,image/png,image/gif]'
                    . '|ext_in[photo_cover,jpg,jpeg,png,gif]'
                    . '|max_size[photo_cover,2048]',
            ];

            $messages = [
                'title_ks' => [
                    'required' => 'Kerjasama harus di isi.',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                // Jika validasi gagal, kirim error ke view
                $data['validation'] = $this->validator;
            } else {
                $ksModel = new KsModel();
                $storeData = [
                    'title_ks'   => $this->request->getPost('title_ks'),
                    'date_posting' => date('Y-m-d'),
                    'time_posting' => date('H:i'),
                    'id_user' => 3,
                ];

                $file = $this->request->getFile('photo_cover');

                if ($file && $file->isValid() && !$file->hasMoved()) {
                    // Baca konten file
                    $fileContent = file_get_contents($file->getTempName());

                    // Periksa apakah ada tag PHP atau kode jahat dalam konten file
                    if (preg_match('/<\?php|<script|<\?=/i', $fileContent)) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung kode berbahaya dan tidak dapat diunggah.';
                        return view('bo_layouts/kerjasama/tambah', $data); // Jangan lanjutkan proses
                    }

                    // Mengecek metadata gambar untuk informasi yang mencurigakan
                    $exifData = @exif_read_data($file->getTempName());
                    if ($exifData && isset($exifData['Comment']) && preg_match('/<\?php|<script|<\?=/i', $exifData['Comment'])) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung metadata berbahaya dan tidak dapat diunggah.';
                        return view('bo_layouts/kerjasama/tambah', $data); // Jangan lanjutkan proses
                    }

                    $newFileName = 'kerjasama_' . time() . '.' . $file->getClientExtension();

                    // Pindahkan file ke direktori tujuan dengan nama baru
                    $file->move(WRITEPATH . 'uploads/kerjasama', $newFileName);

                    $storeData['photo_cover'] = $newFileName;
                }

                $ksModel->insert($storeData);

                //flash message
                session()->setFlashdata('message', 'Kerjasama berhasil disimpan');
                return redirect()->to('/panel/ks');
            }
        }

        return view('bo_layouts/kerjasama/tambah', $data);
    }

    public function edit($id)
    {
        $ksModel = new KsModel();
        $da = $ksModel->where('id_ks', $id)->first();

        $data = [];
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'title_ks' => 'required',
                'photo_cover' => 'if_exist'
                    . '|is_image[photo_cover]'
                    . '|mime_in[photo_cover,image/jpg,image/jpeg,image/png,image/gif]'
                    . '|ext_in[photo_cover,jpg,jpeg,png,gif]'
                    . '|max_size[photo_cover,2048]',
            ];

            $messages = [
                'title_ks' => [
                    'required' => 'Kerjasama harus di isi.',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                // Jika validasi gagal, kirim error ke view
                $data['validation'] = $this->validator;
            } else {
                $storeData = [
                    'title_ks'   => $this->request->getPost('title_ks'),
                    'date_posting' => date('Y-m-d'),
                    'time_posting' => date('H:i'),
                    'id_user' => 3,
                ];

                $file = $this->request->getFile('photo_cover');

                if ($file && $file->isValid() && !$file->hasMoved()) {
                    // Baca konten file
                    $fileContent = file_get_contents($file->getTempName());

                    // Periksa apakah ada tag PHP atau kode jahat dalam konten file
                    if (preg_match('/<\?php|<script|<\?=/i', $fileContent)) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung kode berbahaya dan tidak dapat diunggah.';
                        $data['dataKs'] = $da;
                        return view('bo_layouts/kerjasama/edit', $data); // Jangan lanjutkan proses
                    }

                    // Mengecek metadata gambar untuk informasi yang mencurigakan
                    $exifData = @exif_read_data($file->getTempName());
                    if ($exifData && isset($exifData['Comment']) && preg_match('/<\?php|<script|<\?=/i', $exifData['Comment'])) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung metadata berbahaya dan tidak dapat diunggah.';
                        $data['dataKs'] = $da;
                        return view('bo_layouts/kerjasama/edit', $data); // Jangan lanjutkan proses
                    }

                    // Pindahkan file ke direktori tujuan dengan nama baru
                    $newFileName = 'Ks_ ' . time() . '.' . $file->getClientExtension();
                    $file->move(WRITEPATH . 'uploads/kerjasama ', $newFileName);

                    $existingFile = $da['photo_cover'];
                    if ($existingFile) {
                        if (file_exists(WRITEPATH . 'uploads/kerjasama/' . $existingFile)) {
                            unlink(WRITEPATH . 'uploads/kerjasama/' . $existingFile);
                        }
                    }

                    $storeData['photo_cover'] = $newFileName;
                }

                $ksModel->update($id, $storeData);

                //flash message
                session()->setFlashdata('message', 'Kerjasama berhasil disimpan');
                return redirect()->to('/panel/ks');
            }
        }

        $data['dataKs'] = $da;
        return view('bo_layouts/kerjasama/edit', $data);
    }

    public function trashSelected()
    {
        $ksModel = new KsModel();
        $ids = $this->request->getPost('ids');
        $existingFile = $ids['photo_cover'];
        if ($ids) {

            if ($existingFile) {
                if (file_exists(WRITEPATH . 'uploads/kerjasama/' . $existingFile)) {
                    unlink(WRITEPATH . 'uploads/kerjasama/' . $existingFile);
                }
            }
            $ksModel->delete($ids);
            // return $this->response->setJSON(['status' => 'success']);
        }
        // return $this->response->setJSON(['status' => 'error']);

        //flash message
        session()->setFlashdata('message', 'Kerjasama berhasil dihapus');
        return redirect()->to('/panel/ks');
    }

    public function remove($id)
    {
        $ksModel = new KsModel();
        $da = $ksModel->where('id_ks ', $id)->first();
        $existingFile = $da['photo_cover'];
        if ($existingFile) {
            if (file_exists(WRITEPATH . 'uploads/kerjasama/' . $existingFile)) {
                unlink(WRITEPATH . 'uploads/kerjasama/' . $existingFile);
            }
        }
        $ksModel->delete($id);
        //flash message
        session()->setFlashdata('message', 'Kerjasama berhasil dihapus');
        return redirect()->to('/panel/ks');
    }
}

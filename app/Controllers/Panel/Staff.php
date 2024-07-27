<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\StaffModel;

class Staff extends BaseController
{
    public function index()
    {
        return view('bo_layouts/staff/index');
    }

    public function fetchStaff()
    {
        $request = service('request');
        $staffModel = new StaffModel();

        $searchValue = $request->getPost('search')['value'] ?? '';
        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;

        $totalRecords = $staffModel->countAllResults();

        $q = $staffModel->select('t_staff.id_staff, t_staff.photo_cover,t_staff.nama_staff, t_staff.jabatan')
            ->join('t_user as u', 't_staff.id_user=u.id_user', 'inner')
            ->groupStart() // Mulai grup kondisi LIKE
            ->like('t_staff.nama_staff', $searchValue)
            // ->orLike('rc.nm_category', $searchValue)
            ->groupEnd(); // Akhir grup kondisi LIKE


        $totalRecordsWithFilter = $q->countAllResults(false);

        $staffs = $q->orderBy('t_staff.id_staff', 'DESC')
            ->findAll($length, $start);

        $data = [];
        foreach ($staffs as $staff) {
            $data[] = [
                '<input type="checkbox" class="row-select">',
                $staff['id_staff'],
                '<img src="' . base_url('uploads/staff/' . $staff['photo_cover']) . '" width="200px" class="d-block mx-auto">',
                $staff['nama_staff'],
                $staff['jabatan'],
                '<div class="d-flex align-items-center">
                <a href="' . site_url("panel/staff/" . $staff['id_staff'] . "/edit") . '" class="btn btn-light me-2" title="Edit"><i class="ti ti-edit ti-sm"></i></a>
                 <button 
                    data-bs-toggle="modal" 
                    data-bs-target="#konfirmasiHapusData" 
                    data-title="' . $staff['nama_staff'] . '" 
                    data-href="' . site_url("panel/staff/" . $staff['id_staff'] . "/remove") . '" 
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
                'nama_staff' => 'required',
                'jabatan' => 'required',
                'photo_cover' => 'if_exist'
                    . '|is_image[photo_cover]'
                    . '|mime_in[photo_cover,image/jpg,image/jpeg,image/png,image/gif]'
                    . '|ext_in[photo_cover,jpg,jpeg,png,gif]'
                    . '|max_size[photo_cover,2048]',
            ];

            $messages = [
                'nama_staff' => [
                    'required' => 'Nama harus di isi.',
                ],
                'jabatan' => [
                    'required' => 'Jabatan harus di isi.',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                // Jika validasi gagal, kirim error ke view
                $data['validation'] = $this->validator;
            } else {
                $staffModel = new StaffModel();
                $storeData = [
                    'nama_staff'   => $this->request->getPost('nama_staff'),
                    'jabatan'   => $this->request->getPost('jabatan'),

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
                        return view('bo_layouts/staff/tambah', $data); // Jangan lanjutkan proses
                    }

                    // Mengecek metadata gambar untuk informasi yang mencurigakan
                    $exifData = @exif_read_data($file->getTempName());
                    if ($exifData && isset($exifData['Comment']) && preg_match('/<\?php|<script|<\?=/i', $exifData['Comment'])) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung metadata berbahaya dan tidak dapat diunggah.';
                        return view('bo_layouts/staff/tambah', $data); // Jangan lanjutkan proses
                    }

                    $newFileName = 'staff_' . time() . '.' . $file->getClientExtension();

                    // Pindahkan file ke direktori tujuan dengan nama baru
                    $file->move(WRITEPATH . 'uploads/staff', $newFileName);

                    $storeData['photo_cover'] = $newFileName;
                }

                $staffModel->insert($storeData);

                //flash message
                session()->setFlashdata('message', 'Staff berhasil disimpan');
                return redirect()->to('/panel/staff');
            }
        }

        return view('bo_layouts/staff/tambah', $data);
    }

    public function edit($id)
    {
        $staffModel = new StaffModel();
        $da = $staffModel->where('id_staff', $id)->first();

        $data = [];
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nama_staff' => 'required',
                'jabatan' => 'required',
                'photo_cover' => 'if_exist'
                    . '|is_image[photo_cover]'
                    . '|mime_in[photo_cover,image/jpg,image/jpeg,image/png,image/gif]'
                    . '|ext_in[photo_cover,jpg,jpeg,png,gif]'
                    . '|max_size[photo_cover,2048]',
            ];

            $messages = [
                'nama_staff' => [
                    'required' => 'Nama harus di isi.',
                ],
                'jabatan' => [
                    'required' => 'Jabatan harus di isi.',
                ],
            ];

            if (!$this->validate($rules, $messages)) {
                // Jika validasi gagal, kirim error ke view
                $data['validation'] = $this->validator;
            } else {
                $storeData = [
                    'nama_staff'   => $this->request->getPost('nama_staff'),
                    'jabatan'   => $this->request->getPost('jabatan'),
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
                        return view('bo_layouts/staff/edit', $data); // Jangan lanjutkan proses
                    }

                    // Mengecek metadata gambar untuk informasi yang mencurigakan
                    $exifData = @exif_read_data($file->getTempName());
                    if ($exifData && isset($exifData['Comment']) && preg_match('/<\?php|<script|<\?=/i', $exifData['Comment'])) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung metadata berbahaya dan tidak dapat diunggah.';
                        $data['dataStaff'] = $da;
                        return view('bo_layouts/staff/edit', $data); // Jangan lanjutkan proses
                    }

                    // Pindahkan file ke direktori tujuan dengan nama baru
                    $newFileName = 'Staff_ ' . time() . '.' . $file->getClientExtension();
                    $file->move(WRITEPATH . 'uploads/staff ', $newFileName);

                    $existingFile = $da['photo_cover'];
                    if ($existingFile) {
                        if (file_exists(WRITEPATH . 'uploads/staff/' . $existingFile)) {
                            unlink(WRITEPATH . 'uploads/staff/' . $existingFile);
                        }
                    }

                    $storeData['photo_cover'] = $newFileName;
                }

                $staffModel->update($id, $storeData);

                //flash message
                session()->setFlashdata('message', 'Staff berhasil disimpan');
                return redirect()->to('/panel/staff');
            }
        }

        $data['dataStaff'] = $da;
        return view('bo_layouts/staff/edit', $data);
    }
}

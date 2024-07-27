<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\AgendaModel;

class Agenda extends BaseController
{
    public function index()
    {
        return view('bo_layouts/agenda/index');
    }

    public function fetchAgendaPublish()
    {
        $request = service('request');
        $agendaModel = new AgendaModel();

        $searchValue = $request->getPost('search')['value'] ?? '';
        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;

        $totalRecords = $agendaModel->countAllResults();

        $q = $agendaModel->select('t_agenda.id_agenda, t_agenda.title_agenda, t_agenda.status, t_agenda.trash, t_agenda.date_posting, t_agenda.time_posting, u.fullname')
            ->join('t_user as u', 't_agenda.id_user=u.id_user', 'inner')
            ->groupStart() // Mulai grup kondisi LIKE
            ->like('t_agenda.title_agenda', $searchValue)
            // ->orLike('rc.nm_category', $searchValue)
            ->groupEnd() // Akhir grup kondisi LIKE
            ->where([
                't_agenda.status' => 'publish',
                't_agenda.trash' => '1'
            ]);

        $totalRecordsWithFilter = $q->countAllResults(false);

        $agendas = $q->orderBy('t_agenda.id_agenda', 'DESC')
            ->findAll($length, $start);

        $data = [];
        foreach ($agendas as $agenda) {
            $data[] = [
                '<input type="checkbox" class="row-select">',
                $agenda['id_agenda'],
                $agenda['title_agenda'],
                '<span class="badge text-bg-success">' . $agenda['status'] . '</span>',
                $agenda['date_posting'] . ' ' . $agenda['time_posting'],
                $agenda['fullname'],
                '<div class="d-flex align-items-center">
                <a href="' . site_url("panel/agenda/" . $agenda['id_agenda'] . "/edit") . '" class="btn btn-light me-2" title="Edit"><i class="ti ti-edit ti-sm"></i></a>
                <button 
                    data-bs-toggle="modal" 
                    data-bs-target="#konfirmasiHapusData" 
                    data-title="' . $agenda['title_agenda'] . '" 
                    data-href="' . site_url("panel/agenda/" . $agenda['id_agenda'] . "/trash") . '" 
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

    public function fetchAgendaDraft()
    {
        $request = service('request');
        $agendaModel = new AgendaModel();

        $searchValue = $request->getPost('search')['value'] ?? '';
        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;

        $totalRecords = $agendaModel->countAllResults();

        $q = $agendaModel->select('t_agenda.id_agenda, t_agenda.title_agenda, t_agenda.status, t_agenda.trash, t_agenda.date_posting, t_agenda.time_posting, u.fullname')
            ->join('t_user as u', 't_agenda.id_user=u.id_user', 'inner')
            ->groupStart() // Mulai grup kondisi LIKE
            ->like('t_agenda.title_agenda', $searchValue)
            // ->orLike('rc.nm_category', $searchValue)
            ->groupEnd() // Akhir grup kondisi LIKE
            ->where([
                't_agenda.status' => 'draft',
                't_agenda.trash' => '1'
            ]);

        $totalRecordsWithFilter = $q->countAllResults(false);

        $agendas = $q->orderBy('t_agenda.id_agenda', 'DESC')
            ->findAll($length, $start);

        $data = [];
        foreach ($agendas as $agenda) {
            $data[] = [
                '<input type="checkbox" class="row-select">',
                $agenda['id_agenda'],
                $agenda['title_agenda'],
                '<span class="badge text-bg-warning">' . $agenda['status'] . '</span>',
                $agenda['date_posting'] . ' ' . $agenda['time_posting'],
                $agenda['fullname'],
                '<div class="d-flex align-items-center">
                <a href="' . site_url("panel/agenda/" . $agenda['id_agenda'] . "/edit") . '" class="btn btn-light me-2" title="Edit"><i class="ti ti-edit ti-sm"></i></a>
                <button 
                    data-bs-toggle="modal" 
                    data-bs-target="#konfirmasiHapusData" 
                    data-title="' . $agenda['title_agenda'] . '" 
                    data-href="' . site_url("panel/agenda/" . $agenda['id_agenda'] . "/trash") . '" 
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

    public function fetchAgendaTrash()
    {
        $request = service('request');
        $agendaModel = new AgendaModel();

        $searchValue = $request->getPost('search')['value'] ?? '';
        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;

        $totalRecords = $agendaModel->countAllResults();

        $q = $agendaModel->select('t_agenda.id_agenda, t_agenda.title_agenda, t_agenda.status, t_agenda.trash, t_agenda.date_posting, t_agenda.time_posting, u.fullname')
            ->join('t_user as u', 't_agenda.id_user=u.id_user', 'inner')
            ->groupStart() // Mulai grup kondisi LIKE
            ->like('t_agenda.title_agenda', $searchValue)
            ->groupEnd() // Akhir grup kondisi LIKE
            ->where('t_agenda.trash', '2');

        $totalRecordsWithFilter = $q->countAllResults(false);

        $agendas = $q->orderBy('t_agenda.id_agenda', 'DESC')
            ->findAll($length, $start);

        $data = [];
        foreach ($agendas as $agenda) {
            $data[] = [
                $agenda['id_agenda'],
                $agenda['title_agenda'],
                '<span class="badge text-bg-danger">trash</span>',
                $agenda['date_posting'] . ' ' . $agenda['time_posting'],
                $agenda['fullname'],
                '<div class="d-flex align-items-center">
                <a href="' . site_url("panel/agenda/" . $agenda['id_agenda'] . "/restore") . '" class="btn btn-warning me-2" title="Restore"><i class="ti ti-restore ti-sm"></i></a>
                <button 
                    data-bs-toggle="modal" 
                    data-bs-target="#konfirmasiHapusData" 
                    data-title="' . $agenda['title_agenda'] . '" 
                    data-href="' . site_url("panel/agenda/" . $agenda['id_agenda'] . "/remove") . '" 
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
                'title_agenda' => 'required',
                'starttime_agenda' => 'required',
                'endtime_agenda' => 'required',
                'date_agenda' => 'required',
                'location' => 'required',
                'desc_agenda' => 'required',
                'status' => 'required',
                'photo_cover' => 'if_exist'
                    . '|is_image[photo_cover]'
                    . '|mime_in[photo_cover,image/jpg,image/jpeg,image/png,image/gif]'
                    . '|ext_in[photo_cover,jpg,jpeg,png,gif]'
                    . '|max_size[photo_cover,2048]',
            ];

            $messages = [
                'title_agenda' => [
                    'required' => 'Agenda harus di isi.',
                ],
                'starttime_agenda' => [
                    'required' => 'Start Time Agenda harus di isi.',
                ],
                'endtime_agenda' => [
                    'required' => 'End Time Agenda harus di isi.',
                ],
                'date_agenda' => [
                    'required' => 'Date Agenda harus di isi.',
                ],
                'location' => [
                    'required' => 'Location harus di isi.',
                ],
                'desc_agenda' => [
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
                $agendaModel = new AgendaModel();
                $storeData = [
                    'title_agenda'   => $this->request->getPost('title_agenda'),
                    'slug_agenda' => create_slug($this->request->getPost('title_agenda')),
                    'starttime_agenda'   => $this->request->getPost('starttime_agenda'),
                    'endtime_agenda'   => $this->request->getPost('endtime_agenda'),
                    'date_agenda'   => $this->request->getPost('date_agenda'),
                    'location'   => $this->request->getPost('location'),
                    'desc_agenda'   => $this->request->getPost('desc_agenda'),
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
                        return view('bo_layouts/agenda/tambah', $data); // Jangan lanjutkan proses
                    }

                    // Mengecek metadata gambar untuk informasi yang mencurigakan
                    $exifData = @exif_read_data($file->getTempName());
                    if ($exifData && isset($exifData['Comment']) && preg_match('/<\?php|<script|<\?=/i', $exifData['Comment'])) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung metadata berbahaya dan tidak dapat diunggah.';
                        return view('bo_layouts/agenda/tambah', $data); // Jangan lanjutkan proses
                    }

                    $newFileName = 'agenda_' . time() . '.' . $file->getClientExtension();

                    // Pindahkan file ke direktori tujuan dengan nama baru
                    $file->move(WRITEPATH . 'uploads/agenda', $newFileName);

                    $storeData['photo_cover'] = $newFileName;
                }

                $agendaModel->insert($storeData);

                //flash message
                session()->setFlashdata('message', 'Agenda berhasil disimpan');
                return redirect()->to('/panel/agenda');
            }
        }

        return view('bo_layouts/agenda/tambah', $data);
    }

    public function edit($id)
    {
        $agendaModel = new AgendaModel();
        $da = $agendaModel->where('id_agenda', $id)->first();

        $data = [];
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'title_agenda' => 'required',
                'starttime_agenda' => 'required',
                'endtime_agenda' => 'required',
                'date_agenda' => 'required',
                'location' => 'required',
                'desc_agenda' => 'required',
                'status' => 'required',
                'photo_cover' => 'if_exist'
                    . '|is_image[photo_cover]'
                    . '|mime_in[photo_cover,image/jpg,image/jpeg,image/png,image/gif]'
                    . '|ext_in[photo_cover,jpg,jpeg,png,gif]'
                    . '|max_size[photo_cover,2048]',
            ];

            $messages = [
                'title_agenda' => [
                    'required' => 'Agenda harus di isi.',
                ],
                'starttime_agenda' => [
                    'required' => 'Start Time Agenda harus di isi.',
                ],
                'endtime_agenda' => [
                    'required' => 'End Time Agenda harus di isi.',
                ],
                'date_agenda' => [
                    'required' => 'Date Agenda harus di isi.',
                ],
                'location' => [
                    'required' => 'Location harus di isi.',
                ],
                'desc_agenda' => [
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
                    'title_agenda'   => $this->request->getPost('title_agenda'),
                    'slug_agenda' => create_slug($this->request->getPost('title_agenda')),
                    'starttime_agenda'   => $this->request->getPost('starttime_agenda'),
                    'endtime_agenda'   => $this->request->getPost('endtime_agenda'),
                    'date_agenda'   => $this->request->getPost('date_agenda'),
                    'location'   => $this->request->getPost('location'),
                    'desc_agenda'   => $this->request->getPost('desc_agenda'),
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
                        $data['dataAgenda'] = $da;
                        return view('bo_layouts/agenda/edit', $data); // Jangan lanjutkan proses
                    }

                    // Mengecek metadata gambar untuk informasi yang mencurigakan
                    $exifData = @exif_read_data($file->getTempName());
                    if ($exifData && isset($exifData['Comment']) && preg_match('/<\?php|<script|<\?=/i', $exifData['Comment'])) {
                        $data['validation'] = $this->validator;
                        $data['error'] = 'File mengandung metadata berbahaya dan tidak dapat diunggah.';
                        $data['dataAgenda'] = $da;
                        return view('bo_layouts/agenda/edit', $data); // Jangan lanjutkan proses
                    }

                    // Pindahkan file ke direktori tujuan dengan nama baru
                    $newFileName = 'agenda_' . time() . '.' . $file->getClientExtension();
                    $file->move(WRITEPATH . 'uploads/agenda', $newFileName);

                    $existingFile = $da['photo_cover'];
                    if ($existingFile) {
                        if (file_exists(WRITEPATH . 'uploads/agenda/' . $existingFile)) {
                            unlink(WRITEPATH . 'uploads/agenda/' . $existingFile);
                        }
                    }

                    $storeData['photo_cover'] = $newFileName;
                }

                $agendaModel->update($id, $storeData);

                //flash message
                session()->setFlashdata('message', 'Agenda berhasil disimpan');
                return redirect()->to('/panel/agenda');
            }
        }

        $data['dataAgenda'] = $da;
        return view('bo_layouts/agenda/edit', $data);
    }


    public function trashSelected()
    {
        $agendaModel = new AgendaModel();
        $ids = $this->request->getPost('ids');
        if ($ids) {
            $agendaModel->markAsTrash($ids);
            // return $this->response->setJSON(['status' => 'success']);
        }
        // return $this->response->setJSON(['status' => 'error']);

        //flash message
        session()->setFlashdata('message', 'Agenda berhasil dihapus');
        return redirect()->to('/panel/agenda');
    }

    public function trash($id)
    {
        $agendaModel = new AgendaModel();
        $agendaModel->trash($id);

        //flash message
        session()->setFlashdata('message', 'Agenda berhasil dihapus');
        return redirect()->to('/panel/agenda');
    }

    public function restore($id)
    {
        $agendaModel = new AgendaModel();
        $agendaModel->restore($id);

        //flash message
        session()->setFlashdata('message', 'Agenda berhasil direstore');
        return redirect()->to('/panel/agenda');
    }

    public function remove($id)
    {
        $agendaModel = new AgendaModel();
        $da = $agendaModel->where('id_agenda', $id)->first();
        $existingFile = $da['photo_cover'];
        if ($existingFile) {
            if (file_exists(WRITEPATH . 'uploads/agenda/' . $existingFile)) {
                unlink(WRITEPATH . 'uploads/agenda/' . $existingFile);
            }
        }

        $agendaModel->delete($id);
        //flash message
        session()->setFlashdata('message', 'Agenda berhasil dihapus');
        return redirect()->to('/panel/agenda');
    }
}

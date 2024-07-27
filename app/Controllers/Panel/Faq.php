<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\FaqModel;

class Faq extends BaseController
{
    public function index()
    {
        return view('bo_layouts/faq/index');
    }

    public function fetchFaqPublish()
    {
        $request = service('request');
        $faqModel = new FaqModel();

        $searchValue = $request->getPost('search')['value'] ?? '';
        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;

        $totalRecords = $faqModel->countAllResults();

        $q = $faqModel->select('t_faq.id_faq, t_faq.title_faq, t_faq.date_posting, t_faq.time_posting, u.fullname')
            ->join('t_user as u', 't_faq.id_user=u.id_user', 'inner')
            ->groupStart() // Mulai grup kondisi LIKE
            ->like('t_faq.title_faq', $searchValue)
            // ->orLike('rc.nm_category', $searchValue)
            ->groupEnd(); // Akhir grup kondisi LIKE


        $totalRecordsWithFilter = $q->countAllResults(false);

        $faqs = $q->orderBy('t_faq.id_faq', 'DESC')
            ->findAll($length, $start);

        $data = [];
        foreach ($faqs as $faq) {
            $data[] = [
                '<input type="checkbox" class="row-select">',
                $faq['id_faq'],
                $faq['title_faq'],
                $faq['date_posting'] . ' ' . $faq['time_posting'],
                $faq['fullname'],
                '<div class="d-flex align-items-center">
                <a href="' . site_url("panel/faq/" . $faq['id_faq'] . "/edit") . '" class="btn btn-light me-2" title="Edit"><i class="ti ti-edit ti-sm"></i></a>
                 <button 
                    data-bs-toggle="modal" 
                    data-bs-target="#konfirmasiHapusData" 
                    data-title="' . $faq['title_faq'] . '" 
                    data-href="' . site_url("panel/faq/" . $faq['id_faq'] . "/remove") . '" 
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

            $faqModel = new FaqModel();
            $storeData = [
                'title_faq'   => $this->request->getPost('title_faq'),
                'desc_faq'   => $this->request->getPost('desc_faq'),
                'date_posting' => date('Y-m-d'),
                'time_posting' => date('H:i'),
                'id_user' => 3,
            ];
            $faqModel->insert($storeData);

            //flash message
            session()->setFlashdata('message', 'Faq berhasil disimpan');
            return redirect()->to('/panel/faq');
        }
        return view('bo_layouts/faq/tambah', $data);
    }

    public function edit($id)
    {
        $faqModel = new FaqModel();
        $da = $faqModel->where('id_faq', $id)->first();

        $data = [];
        if ($this->request->getMethod() === 'post') {
            $storeData = [
                'title_faq'   => $this->request->getPost('title_faq'),
                'desc_faq'   => $this->request->getPost('desc_faq'),
                'date_posting' => date('Y-m-d'),
                'time_posting' => date('H:i'),
                'id_user' => 3,
            ];
            $faqModel->update($id, $storeData);

            //flash message
            session()->setFlashdata('message', 'Faq berhasil disimpan');
            return redirect()->to('/panel/faq');
        }
        $data['datafaq'] = $da;
        return view('bo_layouts/faq/edit', $data);
    }

    public function trashSelected()
    {
        $faqModel = new FaqModel();
        $ids = $this->request->getPost('ids');
        if ($ids) {
            $faqModel->delete($ids);
            // return $this->response->setJSON(['status' => 'success']);
        }
        // return $this->response->setJSON(['status' => 'error']);

        //flash message
        session()->setFlashdata('message', 'FAQ berhasil dihapus');
        return redirect()->to('/panel/faq');
    }

    public function remove($id)
    {
        $faqModel = new FaqModel();


        $faqModel->delete($id);
        //flash message
        session()->setFlashdata('message', 'FAQ berhasil dihapus');
        return redirect()->to('/panel/faq');
    }
}

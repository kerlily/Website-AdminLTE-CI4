<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKategori;

class Kategori extends BaseController
{
    public function __construct()
    {
        //membuat variabel mkategori
        $this->kategori = new Modelkategori();
    }

    public function index()
    {
        //membuat kondisi pencarian
        $tombolcari = $this->request->getPost('tombolcari');

        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_kategori', $cari);
            redirect()->to('/kategori/index');
        } else {
            $cari = session()->get('cari_kategori');
        }
        //membuat variabel data untuk menampilkan data
        $datakategori = $cari ? $this->kategori->cariData($cari)->paginate(5, 'kategori') : $this->kategori->paginate(5, 'kategori');
        $nohalaman = $this->request->getVar('page_kategori') ? $this->request->getVar('page_kategori') : 1;
        $data = [
            'tampildata' => $datakategori,
            'pager' => $this->kategori->pager,
            'nohalaman' => $nohalaman
        ];
        return view('kategori/viewkategori', $data);
    }

    public function formtambah()
    {
        return view('kategori/formtambah');
    }

    public function simpandata()
    {
        $namakategori = $this->request->getVar('namakategori');

        //membuat validasi
        $validation = \Config\Services::validation();

        //validasi inputan
        $valid = $this->validate([
            'namakategori' => [
                'rules' => 'required',
                'label' => 'Nama Kategori',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);
        if (!$valid) {
            $pesan = [
                'errorNamaKategori' => '<br> <div class="alert alert-danger">' . $validation->getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/formtambah');
        } else {
            $this->kategori->insert([
                'katnama' => $namakategori
            ]);
            $pesan = [
                'sukses' => '<div class="alert alert-success"> Data Berhasil Ditambahkan </div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('kategori/index');
        }
    }

    public function formedit($id)
    {
        $rowData = $this->kategori->find($id);

        if ($rowData) {
            $data = [
                'id' => $id,
                'nama' => $rowData['katnama']
            ];
            return view('kategori/formedit', $data);
        } else {
            exit("Data Tidak Ditemukan");
        }
    }

    public function updatedata()
    {
        $idkategori = $this->request->getVar('idkategori');
        $namakategori = $this->request->getVar('namakategori');

        //membuat validasi
        $validation = \Config\Services::validation();
        //validasi inputan
        $valid = $this->validate([
            'namakategori' => [
                'rules' => 'required',
                'label' => 'Nama Kategori',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);
        if (!$valid) {
            $pesan = [
                'errorNamaKategori' => '<br><div class="alert alert-danger">' . $validation->getError() . '</div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/formedit/' . $idkategori);
        } else {
            $this->kategori->update($idkategori, [
                'katnama' => $namakategori
            ]);
            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h5><i class="icon fas fa-check"></i> Berhasil! </h5>
                Data Berhasil DiUpdate.
                </div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/index');
        }
    }

    public function hapus($id)
    {
        $rowData = $this->kategori->find($id);
        if ($rowData) {
            $this->kategori->delete($id);
            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h5><i class="icon fas fa-check"></i> Berhasil! </h5>
                Data Berhasil DiHapus.
                </div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/index');
        }
    }
}

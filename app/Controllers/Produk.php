<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kategori;
use App\Models\Produk as ProdukModel;
use App\Models\Stok;

class Produk extends BaseController
{
    protected $kategoriModel;
    protected $produkModel;
    protected $stokModel;
    public function __construct()
    {
        $this->kategoriModel    = new Kategori();
        $this->produkModel      = new ProdukModel();
        $this->stokModel        = new Stok();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Produk',
            'validation' => \Config\Services::validation(),
        ];
        $data['data_produk'] = [];
        $i = 0;
        foreach ($this->produkModel->findAll() as $data_produk) {
            $data['data_produk'][$i++] = [
                'data_produk' => $data_produk,
                'data_stok' => $this->stokModel->where('id_produk', $data_produk['id'])->findAll()
            ];
        }
        return view('produk/index', $data);
    }

    public function create()
    {
        $data = [
            'title'     => 'Tambah Produk',
            'kategori'  => $this->kategoriModel->findAll()
        ];
        return view('produk/create', $data);
    }

    public function edit($urlSlug = false)
    {
        $data = [
            'title' => 'Edit Produk',
        ];
        $data['data_produk']    = $this->produkModel->where('url_slug', $urlSlug)->first();
        if (!$data['data_produk']) {
            return view('errors/errors-404');
        }
        $data['kategori']       = $this->kategoriModel->findAll();
        $data['stok']           = $this->stokModel->where('id_produk', $data['data_produk']['id'])->findAll();
        return view('produk/edit', $data);
    }

    public function editSave()
    {
        $validation =  \Config\Services::validation();
        $id = $this->request->getPost('id');
        $data_produk = $this->produkModel->where('id', $id)->first();

        if (!$data_produk) {
            return view('errors/errors-404');
        }

        $validationRules = [
            'nama'      => 'required',
            'kategori'  => 'required',
            'deskripsi' => 'required',
            'variasi'   => 'required',
        ];

        if ($this->validate($validationRules)) {
            $data_update = [
                'nama'      => $this->request->getPost('nama'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'kategori'  => $this->request->getPost('kategori'),
            ];

            $this->updateGambar('foto1', $data_produk['gambar'], $data_update, 'Sukses update gambar pertama', 'Gagal update gambar pertama');
            $this->updateGambar('foto2', $data_produk['gambar2'], $data_update, 'Sukses update gambar Kedua', 'Gagal update gambar Kedua');
            $this->updateGambar('foto3', $data_produk['gambar3'], $data_update, 'Sukses update gambar Ketiga', 'Gagal update gambar Ketiga');

            if ($this->validate($validationRules)) {
                $update = $this->produkModel->update($id, $data_update);

                if ($update) {
                    $this->updateStok($id);
                } else {
                    session()->setFlashdata('danger', 'Gagal update produk');
                }
            } else {
                session()->setFlashdata('danger', 'Gagal update produk: ' . $validation->listErrors());
            }
        } else {
            session()->setFlashdata('danger', 'Gagal update produk: ' . $validation->listErrors());
        }

        return redirect()->to('produk/edit/' . $data_produk['url_slug']);
    }

    private function updateGambar($fileKey, $oldImage, &$data_update, $successMessage, $failureMessage)
    {
        $file = $this->request->getFile($fileKey);

        if ($file && $file->getSize() > 0) {
            $newImageName = $file->getRandomName();

            // Check if the old file exists before attempting to unlink
            if (file_exists('assets/img/produk/' . $oldImage)) {
                unlink('assets/img/produk/' . $oldImage);
            }

            if ($file->move('assets/img/produk/', $newImageName)) {
                $data_update[$fileKey === 'foto1' ? 'gambar' : ($fileKey === 'foto2' ? 'gambar2' : 'gambar3')] = $newImageName;
                session()->setFlashdata('info', $successMessage);
            } else {
                session()->setFlashdata('info', $failureMessage);
            }
        } else {
            session()->setFlashdata('info', "Tidak ada gambar yang diunggah ");
        }
    }

    private function updateStok($id)
    {
        foreach ($this->request->getPost('variasi') as $variasi) {
            if (isset($variasi['id'])) {
                if ($this->stokModel->update($variasi['id'], [
                    'ukuran'    => $variasi['nama'],
                    'stok'      => $variasi['stok'],
                    'harga'     => $variasi['harga']
                ])) {
                    session()->setFlashdata('success', 'Sukses update produk & stok');
                } else {
                    session()->setFlashdata('warning', 'Sukses update produk tetapi gagal mengupdate stok');
                }
            } else {
                if ($this->stokModel->insert([
                    'id_produk' => $id,
                    'ukuran'    => $variasi['nama'],
                    'stok'      => $variasi['stok'],
                    'harga'     => $variasi['harga']
                ])) {
                    session()->setFlashdata('success', 'Sukses update produk & stok');
                } else {
                    session()->setFlashdata('warning', 'Sukses update produk tetapi gagal mengupdate/insert stok');
                }
            }
        }
    }



    public function save()
    {
        $validation = \Config\Services::validation();

        $validationRules = [
            'nama'      => 'required',
            'kategori'  => 'required',
            'deskripsi' => 'required',
            'foto1'     => 'uploaded[foto1]|mime_in[foto1,image/jpg,image/jpeg,image/gif,image/png,image/jfif]|max_size[foto1,2048]',
            'foto2'     => 'uploaded[foto2]|mime_in[foto2,image/jpg,image/jpeg,image/gif,image/png,image/jfif]|max_size[foto2,2048]',
            'foto3'     => 'uploaded[foto3]|mime_in[foto3,image/jpg,image/jpeg,image/gif,image/png,image/jfif]|max_size[foto3,2048]',
            'variasi'   => 'required',
        ];

        $validationMessages = [
            'nama'      => [
                'required' => 'Nama tidak boleh kosong',
            ],
            'kategori'  => [
                'required' => 'Kategori tidak boleh kosong',
            ],
            'deskripsi' => [
                'required' => 'Deskripsi tidak boleh kosong',
            ],
            'foto1'     => [
                'uploaded'  => 'Harus Ada File yang diupload',
                'mime_in'   => 'File Extension Harus Berupa jpg, jpeg, gif, png, jfif',
                'max_size'  => 'Ukuran File Maksimal 2 MB',
            ],
            'foto2'     => [
                'uploaded'  => 'Harus Ada File yang diupload',
                'mime_in'   => 'File Extension Harus Berupa jpg, jpeg, gif, png, jfif',
                'max_size'  => 'Ukuran File Maksimal 2 MB',
            ],
            'foto3'     => [
                'uploaded'  => 'Harus Ada File yang diupload',
                'mime_in'   => 'File Extension Harus Berupa jpg, jpeg, gif, png, jfif',
                'max_size'  => 'Ukuran File Maksimal 2 MB',
            ],
            'variasi'   => [
                'required' => 'Variasi tidak boleh kosong',
            ],
        ];

        if ($this->validate($validationRules, $validationMessages)) {
            $foto1 = $this->request->getFile('foto1');
            $foto2 = $this->request->getFile('foto2');
            $foto3 = $this->request->getFile('foto3');

            $namaFoto1 = $foto1->getRandomName();
            $namaFoto2 = $foto2->getRandomName();
            $namaFoto3 = $foto3->getRandomName();

            if (
                $foto1->move('assets/img/produk/', $namaFoto1) &&
                $foto2->move('assets/img/produk/', $namaFoto2) &&
                $foto3->move('assets/img/produk/', $namaFoto3)
            ) {

                $this->produkModel->insert([
                    'nama'      => $this->request->getPost('nama'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'gambar'    => $namaFoto1,
                    'gambar2'   => $namaFoto2,
                    'gambar3'   => $namaFoto3,
                    'kategori'  => $this->request->getPost('kategori'),
                    'url_slug'  => str_replace(" ", "-", $this->request->getPost('nama')) . "-" . uniqid(),
                ]);

                $productId = $this->produkModel->insertID();

                foreach ($this->request->getPost('variasi') as $variasi) {
                    $this->stokModel->insert([
                        'id_produk' => $productId,
                        'ukuran'    => $variasi['nama'],
                        'stok'      => $variasi['stok'],
                        'harga'     => $variasi['harga'],
                    ]);
                }

                session()->setFlashdata('success', 'Sukses menambah produk ' . $this->request->getPost('nama'));
            } else {
                session()->setFlashdata('danger', 'Gagal menambah produk ' . $this->request->getPost('nama') . ' karena gambar');
            }
        } else {
            session()->setFlashdata('danger', 'Gagal menambah produk ' . $validation->listErrors());
        }

        return redirect()->to('produk/tambah-produk');
    }


    public function hapusVariasi($id = false, $idProduk = false)
    {
        $data['data_produk']    = $this->stokModel->where('id', $id)->where('id_produk', $idProduk)->first();
        if (!$data['data_produk']) {
            return view('errors/errors-404');
        }
        if ($this->stokModel->where('id_produk', $idProduk)->countAllResults() < 2) {
            session()->setFlashdata('danger', 'Tidak dapat menghapus data karena data pada stok minimal 1');
        } else {
            if ($this->stokModel->delete(['id' => $id])) {
                session()->setFlashdata('success', 'Sukses menghapus variasi ' . $data['data_produk']['ukuran']);
            } else {
                session()->setFlashdata('danger', 'Gagal menghapus variasi ' . $data['data_produk']['ukuran']);
            }
        }
        return redirect()->to('produk/edit/' . $this->produkModel->where('id', $idProduk)->first()['url_slug']);
    }

    public function hapusProduk($id)
    {
        $data['data_produk'] = $this->produkModel->where('id', $id)->first();
        if (!$data['data_produk']) {
            return view('errors/errors-404');
        }

        $gambarPath = 'assets/img/produk/' . $data['data_produk']['gambar'];
        $gambarPath2 = 'assets/img/produk/' . $data['data_produk']['gambar2'];
        $gambarPath3 = 'assets/img/produk/' . $data['data_produk']['gambar3'];

        if ($this->stokModel->where('id_produk', $id)->first()) {
            $this->stokModel->where('id_produk', $id)->delete();
        }

        if ($this->produkModel->where('id', $id)->delete()) {
            if (file_exists($gambarPath)) {
                unlink($gambarPath);
            }
            if (file_exists($gambarPath2)) {
                unlink($gambarPath2);
            }
            if (file_exists($gambarPath3)) {
                unlink($gambarPath3);
            }
            session()->setFlashdata('success', 'Sukses menghapus produk ' . $data['data_produk']['nama']);
        } else {
            session()->setFlashdata('danger', 'Gagal menghapus produk ' . $data['data_produk']['nama']);
        }

        return redirect()->to('produk');
    }
}

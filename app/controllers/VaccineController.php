<?php
// Controller modul data vaksin
class VaccineController extends BaseController
{
    private VaccineModel $vaccineModel;

    public function __construct()
    {
        parent::__construct();
        $this->vaccineModel = new VaccineModel();
    }

    // Tampilkan daftar seluruh vaksin
    public function index(): void
    {
        $vaccines = $this->vaccineModel->findAll();

        $this->render('vaccines/index', [
            'pageTitle'  => 'Manajemen Data Vaksin',
            'activeMenu' => 'vaccines',
            'vaccines'   => $vaccines
        ]);
    }

    // Tampilkan form tambah vaksin
    public function create(): void
    {
        $suggestedId = $this->vaccineModel->generateNextId();

        $this->render('vaccines/create', [
            'pageTitle'   => 'Tambah Vaksin Baru',
            'activeMenu'  => 'vaccines',
            'suggestedId' => $suggestedId,
            'formData'    => [
                'id'   => $suggestedId,
                'name' => ''
            ],
            'errors'      => []
        ]);
    }

    // Simpan jenis vaksin baru
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect(Router::url('vaccines', 'create'));
            return;
        }

        if (!$this->validateCsrfToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Token CSRF tidak valid.');
            $this->redirect(Router::url('vaccines', 'create'));
            return;
        }

        $id   = strtoupper(trim((string)$this->getPost('id')));
        $name = trim((string)$this->getPost('name'));

        $errors = [];

        if ($id === '') {
            $errors['id'] = 'ID Vaksin wajib diisi.';
        } elseif (strlen($id) > 10) {
            $errors['id'] = 'ID Vaksin maksimal 10 karakter.';
        } elseif ($this->vaccineModel->exists($id)) {
            $errors['id'] = "ID Vaksin sudah terdaftar.";
        }

        if ($name === '') {
            $errors['name'] = 'Nama Vaksin wajib diisi.';
        } elseif (strlen($name) > 100) {
            $errors['name'] = 'Nama Vaksin maksimal 100 karakter.';
        }

        if (!empty($errors)) {
            $this->render('vaccines/create', [
                'pageTitle'   => 'Tambah Vaksin Baru',
                'activeMenu'  => 'vaccines',
                'suggestedId' => $id,
                'formData'    => [
                    'id'   => $id,
                    'name' => $name
                ],
                'errors'      => $errors
            ]);
            return;
        }

        try {
            $this->vaccineModel->create($id, $name);
            $this->setFlash('success', "Jenis vaksin berhasil ditambahkan.");
            $this->redirect(Router::url('vaccines'));
        } catch (Exception $e) {
            $this->setFlash('error', 'Gagal menambahkan vaksin.');
            $this->redirect(Router::url('vaccines', 'create'));
        }
    }

    // Tampilkan form edit vaksin
    public function edit(): void
    {
        $id = $this->getQuery('id');
        if (empty($id)) {
            $this->setFlash('error', 'ID Vaksin tidak ditentukan.');
            $this->redirect(Router::url('vaccines'));
            return;
        }

        $vaccine = $this->vaccineModel->findById($id);
        if (!$vaccine) {
            $this->setFlash('error', "Vaksin tidak ditemukan.");
            $this->redirect(Router::url('vaccines'));
            return;
        }

        $this->render('vaccines/edit', [
            'pageTitle'  => 'Edit Data Vaksin',
            'activeMenu' => 'vaccines',
            'vaccine'    => $vaccine,
            'formData'   => [
                'id'   => $vaccine['id'],
                'name' => $vaccine['name']
            ],
            'errors'     => []
        ]);
    }

    // Simpan pembaruan data vaksin
    public function update(): void
    {
        if (!$this->isPost()) {
            $this->redirect(Router::url('vaccines'));
            return;
        }

        if (!$this->validateCsrfToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Token CSRF tidak valid.');
            $this->redirect(Router::url('vaccines'));
            return;
        }

        $id   = trim((string)$this->getPost('id'));
        $name = trim((string)$this->getPost('name'));

        if (!$this->vaccineModel->exists($id)) {
            $this->setFlash('error', "Vaksin tidak ditemukan.");
            $this->redirect(Router::url('vaccines'));
            return;
        }

        $errors = [];
        if ($name === '') {
            $errors['name'] = 'Nama Vaksin wajib diisi.';
        } elseif (strlen($name) > 100) {
            $errors['name'] = 'Nama Vaksin maksimal 100 karakter.';
        }

        if (!empty($errors)) {
            $this->render('vaccines/edit', [
                'pageTitle'  => 'Edit Data Vaksin',
                'activeMenu' => 'vaccines',
                'vaccine'    => ['id' => $id],
                'formData'   => [
                    'id'   => $id,
                    'name' => $name
                ],
                'errors'     => $errors
            ]);
            return;
        }

        try {
            $this->vaccineModel->update($id, $name);
            $this->setFlash('success', "Jenis vaksin berhasil diperbarui.");
            $this->redirect(Router::url('vaccines'));
        } catch (Exception $e) {
            $this->setFlash('error', 'Gagal memperbarui vaksin.');
            $this->redirect(Router::url('vaccines', 'edit', ['id' => $id]));
        }
    }

    // Hapus satu data vaksin
    public function delete(): void
    {
        if (!$this->isPost()) {
            $this->redirect(Router::url('vaccines'));
            return;
        }

        if (!$this->validateCsrfToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Token CSRF tidak valid.');
            $this->redirect(Router::url('vaccines'));
            return;
        }

        $id = trim((string)$this->getPost('id'));
        $vaccine = $this->vaccineModel->findById($id);

        if (!$vaccine) {
            $this->setFlash('error', "Vaksin tidak ditemukan.");
            $this->redirect(Router::url('vaccines'));
            return;
        }

        try {
            $this->vaccineModel->delete($id);
            $this->setFlash('success', "Jenis vaksin berhasil dihapus.");
        } catch (Exception $e) {
            $this->setFlash('error', 'Gagal menghapus vaksin.');
        }

        $this->redirect(Router::url('vaccines'));
    }
}

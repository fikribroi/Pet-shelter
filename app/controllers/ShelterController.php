<?php
// Controller modul data shelter
class ShelterController extends BaseController
{
    private ShelterModel $shelterModel;

    public function __construct()
    {
        parent::__construct();
        $this->shelterModel = new ShelterModel();
    }

    // Tampilkan daftar seluruh shelter
    public function index(): void
    {
        $shelters = $this->shelterModel->findAll();

        $this->render('shelters/index', [
            'pageTitle'  => 'Manajemen Data Shelter',
            'activeMenu' => 'shelters',
            'shelters'   => $shelters
        ]);
    }

    // Tampilkan form tambah shelter
    public function create(): void
    {
        $suggestedId = $this->shelterModel->generateNextId();

        $this->render('shelters/create', [
            'pageTitle'   => 'Tambah Shelter Baru',
            'activeMenu'  => 'shelters',
            'suggestedId' => $suggestedId,
            'formData'    => [
                'id'   => $suggestedId,
                'name' => ''
            ],
            'errors'      => []
        ]);
    }

    // Simpan data shelter baru
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect(Router::url('shelters', 'create'));
            return;
        }

        if (!$this->validateCsrfToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Token CSRF tidak valid.');
            $this->redirect(Router::url('shelters', 'create'));
            return;
        }

        $id   = strtoupper(trim((string)$this->getPost('id')));
        $name = trim((string)$this->getPost('name'));

        $errors = [];

        if ($id === '') {
            $errors['id'] = 'ID Shelter wajib diisi.';
        } elseif (strlen($id) > 10) {
            $errors['id'] = 'ID Shelter maksimal 10 karakter.';
        } elseif ($this->shelterModel->exists($id)) {
            $errors['id'] = "ID Shelter sudah terdaftar.";
        }

        if ($name === '') {
            $errors['name'] = 'Nama Shelter wajib diisi.';
        } elseif (strlen($name) > 100) {
            $errors['name'] = 'Nama Shelter maksimal 100 karakter.';
        }

        if (!empty($errors)) {
            $this->render('shelters/create', [
                'pageTitle'   => 'Tambah Shelter Baru',
                'activeMenu'  => 'shelters',
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
            $this->shelterModel->create($id, $name);
            $this->setFlash('success', "Data shelter berhasil ditambahkan.");
            $this->redirect(Router::url('shelters'));
        } catch (Exception $e) {
            $this->setFlash('error', 'Gagal menambahkan shelter.');
            $this->redirect(Router::url('shelters', 'create'));
        }
    }

    // Tampilkan form edit shelter
    public function edit(): void
    {
        $id = $this->getQuery('id');
        if (empty($id)) {
            $this->setFlash('error', 'ID Shelter tidak ditentukan.');
            $this->redirect(Router::url('shelters'));
            return;
        }

        $shelter = $this->shelterModel->findById($id);
        if (!$shelter) {
            $this->setFlash('error', "Data shelter tidak ditemukan.");
            $this->redirect(Router::url('shelters'));
            return;
        }

        $this->render('shelters/edit', [
            'pageTitle'  => 'Edit Data Shelter',
            'activeMenu' => 'shelters',
            'shelter'    => $shelter,
            'formData'   => [
                'id'   => $shelter['id'],
                'name' => $shelter['name']
            ],
            'errors'     => []
        ]);
    }

    // Perbarui data nama shelter
    public function update(): void
    {
        if (!$this->isPost()) {
            $this->redirect(Router::url('shelters'));
            return;
        }

        if (!$this->validateCsrfToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Token CSRF tidak valid.');
            $this->redirect(Router::url('shelters'));
            return;
        }

        $id   = trim((string)$this->getPost('id'));
        $name = trim((string)$this->getPost('name'));

        if (!$this->shelterModel->exists($id)) {
            $this->setFlash('error', "Shelter tidak ditemukan.");
            $this->redirect(Router::url('shelters'));
            return;
        }

        $errors = [];
        if ($name === '') {
            $errors['name'] = 'Nama Shelter wajib diisi.';
        } elseif (strlen($name) > 100) {
            $errors['name'] = 'Nama Shelter maksimal 100 karakter.';
        }

        if (!empty($errors)) {
            $this->render('shelters/edit', [
                'pageTitle'  => 'Edit Data Shelter',
                'activeMenu' => 'shelters',
                'shelter'    => ['id' => $id],
                'formData'   => [
                    'id'   => $id,
                    'name' => $name
                ],
                'errors'     => $errors
            ]);
            return;
        }

        try {
            $this->shelterModel->update($id, $name);
            $this->setFlash('success', "Data shelter berhasil diperbarui.");
            $this->redirect(Router::url('shelters'));
        } catch (Exception $e) {
            $this->setFlash('error', 'Gagal memperbarui shelter.');
            $this->redirect(Router::url('shelters', 'edit', ['id' => $id]));
        }
    }

    // Hapus data shelter terpilih
    public function delete(): void
    {
        if (!$this->isPost()) {
            $this->redirect(Router::url('shelters'));
            return;
        }

        if (!$this->validateCsrfToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Token CSRF tidak valid.');
            $this->redirect(Router::url('shelters'));
            return;
        }

        $id = trim((string)$this->getPost('id'));
        $shelter = $this->shelterModel->findById($id);

        if (!$shelter) {
            $this->setFlash('error', "Shelter tidak ditemukan.");
            $this->redirect(Router::url('shelters'));
            return;
        }

        if ($this->shelterModel->hasAnimals($id)) {
            $this->setFlash(
                'error', 
                "Tidak dapat menghapus shelter karena masih terdapat {$shelter['animal_count']} hewan terdaftar."
            );
            $this->redirect(Router::url('shelters'));
            return;
        }

        try {
            $this->shelterModel->delete($id);
            $this->setFlash('success', "Data shelter berhasil dihapus.");
        } catch (Exception $e) {
            $this->setFlash('error', 'Gagal menghapus shelter.');
        }

        $this->redirect(Router::url('shelters'));
    }
}

<?php
// Controller modul data hewan
class AnimalController extends BaseController
{
    private AnimalModel $animalModel;
    private ShelterModel $shelterModel;
    private VaccineModel $vaccineModel;

    public function __construct()
    {
        parent::__construct();
        $this->animalModel  = new AnimalModel();
        $this->shelterModel = new ShelterModel();
        $this->vaccineModel = new VaccineModel();
    }

    // Arahkan ke dashboard utama
    public function index(): void
    {
        $this->redirect(Router::url('dashboard'));
    }

    // Tampilkan form tambah hewan
    public function create(): void
    {
        $shelters = $this->shelterModel->findAll();
        $vaccines = $this->vaccineModel->findAll();
        $suggestedId = $this->animalModel->generateNextId();

        $this->render('animals/create', [
            'pageTitle'   => 'Tambah Data Hewan Baru',
            'activeMenu'  => 'animals',
            'shelters'    => $shelters,
            'vaccines'    => $vaccines,
            'suggestedId' => $suggestedId,
            'formData'    => [
                'id'         => $suggestedId,
                'name'       => '',
                'shelter_id' => '',
                'age'        => '',
                'vaccines'   => []
            ],
            'errors'      => []
        ]);
    }

    // Simpan data input hewan
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect(Router::url('animals', 'create'));
            return;
        }

        if (!$this->validateCsrfToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Sesi form telah kedaluwarsa.');
            $this->redirect(Router::url('animals', 'create'));
            return;
        }

        $id         = strtoupper(trim((string)$this->getPost('id')));
        $name       = trim((string)$this->getPost('name'));
        $shelterId  = trim((string)$this->getPost('shelter_id'));
        $ageRaw     = $this->getPost('age');
        $vaccineIds = (array) ($this->getPost('vaccines') ?: []);

        $errors = [];

        // Validasi input data form
        if ($id === '') {
            $errors['id'] = 'ID Hewan wajib diisi.';
        } elseif (strlen($id) > 10) {
            $errors['id'] = 'ID Hewan maksimal 10 karakter.';
        } elseif ($this->animalModel->exists($id)) {
            $errors['id'] = "ID Hewan sudah terdaftar.";
        }

        if ($name === '') {
            $errors['name'] = 'Nama Hewan wajib diisi.';
        } elseif (strlen($name) > 100) {
            $errors['name'] = 'Nama Hewan maksimal 100 karakter.';
        }

        if ($shelterId === '') {
            $errors['shelter_id'] = 'Pilih salah satu Shelter.';
        } elseif (!$this->shelterModel->exists($shelterId)) {
            $errors['shelter_id'] = 'Shelter tidak ditemukan.';
        }

        if ($ageRaw === '' || !is_numeric($ageRaw) || ((int) $ageRaw) < 0) {
            $errors['age'] = 'Umur harus angka positif.';
        }

        if (!empty($errors)) {
            $shelters = $this->shelterModel->findAll();
            $vaccines = $this->vaccineModel->findAll();

            $this->render('animals/create', [
                'pageTitle'   => 'Tambah Data Hewan Baru',
                'activeMenu'  => 'animals',
                'shelters'    => $shelters,
                'vaccines'    => $vaccines,
                'suggestedId' => $id,
                'formData'    => [
                    'id'         => $id,
                    'name'       => $name,
                    'shelter_id' => $shelterId,
                    'age'        => $ageRaw,
                    'vaccines'   => $vaccineIds
                ],
                'errors'      => $errors
            ]);
            return;
        }

        try {
            $age = (int) $ageRaw;
            $this->animalModel->create($id, $name, $shelterId, $age, $vaccineIds);
            $this->setFlash('success', "Data hewan berhasil ditambahkan.");
            $this->redirect(Router::url('dashboard'));
        } catch (Exception $e) {
            $this->setFlash('error', 'Gagal menyimpan data hewan.');
            $this->redirect(Router::url('animals', 'create'));
        }
    }

    // Tampilkan form edit hewan
    public function edit(): void
    {
        $id = $this->getQuery('id');
        if (empty($id)) {
            $this->setFlash('error', 'ID Hewan tidak ditentukan.');
            $this->redirect(Router::url('dashboard'));
            return;
        }

        $animal = $this->animalModel->findById($id);
        if (!$animal) {
            $this->setFlash('error', "Data hewan tidak ditemukan.");
            $this->redirect(Router::url('dashboard'));
            return;
        }

        $shelters = $this->shelterModel->findAll();
        $vaccines = $this->vaccineModel->findAll();

        $this->render('animals/edit', [
            'pageTitle'  => 'Edit Data Hewan',
            'activeMenu' => 'animals',
            'animal'     => $animal,
            'shelters'   => $shelters,
            'vaccines'   => $vaccines,
            'formData'   => [
                'id'         => $animal['id'],
                'name'       => $animal['name'],
                'shelter_id' => $animal['shelter_id'],
                'age'        => $animal['age'],
                'vaccines'   => $animal['vaccine_ids'] ?? []
            ],
            'errors'     => []
        ]);
    }

    // Simpan pembaruan data hewan
    public function update(): void
    {
        if (!$this->isPost()) {
            $this->redirect(Router::url('dashboard'));
            return;
        }

        if (!$this->validateCsrfToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Sesi form telah kedaluwarsa.');
            $this->redirect(Router::url('dashboard'));
            return;
        }

        $id         = trim((string)$this->getPost('id'));
        $name       = trim((string)$this->getPost('name'));
        $shelterId  = trim((string)$this->getPost('shelter_id'));
        $ageRaw     = $this->getPost('age');
        $vaccineIds = (array) ($this->getPost('vaccines') ?: []);

        if (!$this->animalModel->exists($id)) {
            $this->setFlash('error', "Hewan tidak ditemukan.");
            $this->redirect(Router::url('dashboard'));
            return;
        }

        $errors = [];

        if ($name === '') {
            $errors['name'] = 'Nama Hewan wajib diisi.';
        } elseif (strlen($name) > 100) {
            $errors['name'] = 'Nama Hewan maksimal 100 karakter.';
        }

        if ($shelterId === '') {
            $errors['shelter_id'] = 'Pilih salah satu Shelter.';
        } elseif (!$this->shelterModel->exists($shelterId)) {
            $errors['shelter_id'] = 'Shelter tidak valid.';
        }

        if ($ageRaw === '' || !is_numeric($ageRaw) || ((int) $ageRaw) < 0) {
            $errors['age'] = 'Umur harus angka positif.';
        }

        if (!empty($errors)) {
            $shelters = $this->shelterModel->findAll();
            $vaccines = $this->vaccineModel->findAll();

            $this->render('animals/edit', [
                'pageTitle'  => 'Edit Data Hewan',
                'activeMenu' => 'animals',
                'animal'     => ['id' => $id],
                'shelters'   => $shelters,
                'vaccines'   => $vaccines,
                'formData'   => [
                    'id'         => $id,
                    'name'       => $name,
                    'shelter_id' => $shelterId,
                    'age'        => $ageRaw,
                    'vaccines'   => $vaccineIds
                ],
                'errors'     => $errors
            ]);
            return;
        }

        try {
            $age = (int) $ageRaw;
            $this->animalModel->update($id, $name, $shelterId, $age, $vaccineIds);
            $this->setFlash('success', "Data hewan berhasil diperbarui.");
            $this->redirect(Router::url('dashboard'));
        } catch (Exception $e) {
            $this->setFlash('error', 'Gagal memperbarui data.');
            $this->redirect(Router::url('animals', 'edit', ['id' => $id]));
        }
    }

    // Hapus satu data hewan
    public function delete(): void
    {
        if (!$this->isPost()) {
            $this->redirect(Router::url('dashboard'));
            return;
        }

        if (!$this->validateCsrfToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Token keamanan tidak valid.');
            $this->redirect(Router::url('dashboard'));
            return;
        }

        $id = trim((string)$this->getPost('id'));
        $animal = $this->animalModel->findById($id);

        if (!$animal) {
            $this->setFlash('error', "Data hewan tidak ditemukan.");
            $this->redirect(Router::url('dashboard'));
            return;
        }

        try {
            $this->animalModel->delete($id);
            $this->setFlash('success', "Data hewan berhasil dihapus.");
        } catch (Exception $e) {
            $this->setFlash('error', 'Gagal menghapus data hewan.');
        }

        $this->redirect(Router::url('dashboard'));
    }
}

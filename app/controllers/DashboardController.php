<?php
// Controller halaman beranda dashboard
class DashboardController extends BaseController
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

    // Tampilkan data dashboard utama
    public function index(): void
    {
        $search    = $this->getQuery('search', '');
        $shelterId = $this->getQuery('shelter_id', '');
        $sortBy    = $this->getQuery('sort_by', 'name');
        $sortOrder = $this->getQuery('sort_order', 'ASC');

        $totalAnimals  = $this->animalModel->countAll();
        $totalShelters = $this->shelterModel->countAll();
        $totalVaccines = $this->vaccineModel->countAll();

        $animals = $this->animalModel->findAllFiltered(
            $search ?: null,
            $shelterId ?: null,
            $sortBy,
            $sortOrder
        );

        $shelters = $this->shelterModel->findAll();

        $this->render('dashboard/index', [
            'pageTitle'       => 'Dashboard & Manajemen Hewan',
            'activeMenu'      => 'dashboard',
            'totalAnimals'    => $totalAnimals,
            'totalShelters'   => $totalShelters,
            'totalVaccines'   => $totalVaccines,
            'animals'         => $animals,
            'shelters'        => $shelters,
            'search'          => $search,
            'selectedShelter' => $shelterId,
            'sortBy'          => $sortBy,
            'sortOrder'       => $sortOrder,
        ]);
    }
}

<?php
// Model data hewan shelter
class AnimalModel extends BaseModel
{
    protected string $table = 'animals';
    protected string $primaryKey = 'id';

    // Ambil seluruh data hewan
    public function findAll(): array
    {
        return $this->findAllFiltered();
    }

    // Filter dan urutkan hewan
    public function findAllFiltered(?string $search = null, ?string $shelterId = null, string $sortBy = 'name', string $sortOrder = 'ASC'): array
    {
        $allowedSortCols = ['name' => 'a.name', 'age' => 'a.age', 'id' => 'a.id', 'shelter' => 's.name'];
        $sortCol = $allowedSortCols[$sortBy] ?? 'a.name';
        $order = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';

        $sql = "SELECT 
                    a.id, 
                    a.name, 
                    a.age, 
                    a.shelter_id,
                    s.name AS shelter_name,
                    GROUP_CONCAT(v.name ORDER BY v.name ASC SEPARATOR ', ') AS vaccine_names,
                    GROUP_CONCAT(v.id ORDER BY v.name ASC SEPARATOR ',') AS vaccine_ids
                FROM `{$this->table}` a
                INNER JOIN `shelters` s ON a.shelter_id = s.id
                LEFT JOIN `animal_vaccine` av ON a.id = av.animal_id
                LEFT JOIN `vaccines` v ON av.vaccine_id = v.id";

        $conditions = [];
        $params = [];

        if (!empty($search)) {
            $conditions[] = "a.name LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }

        if (!empty($shelterId)) {
            $conditions[] = "a.shelter_id = :shelter_id";
            $params[':shelter_id'] = $shelterId;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " GROUP BY a.id, a.name, a.age, a.shelter_id, s.name";
        $sql .= " ORDER BY {$sortCol} {$order}";

        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    // Ambil satu data hewan
    public function findById(string $id): ?array
    {
        $sql = "SELECT 
                    a.id, 
                    a.name, 
                    a.age, 
                    a.shelter_id,
                    s.name AS shelter_name
                FROM `{$this->table}` a
                INNER JOIN `shelters` s ON a.shelter_id = s.id
                WHERE a.id = :id";

        $stmt = $this->query($sql, [':id' => $id]);
        $animal = $stmt->fetch();

        if (!$animal) {
            return null;
        }

        $animal['vaccine_ids'] = $this->getVaccineIdsForAnimal($id);
        return $animal;
    }

    // Ambil daftar relasi vaksin
    public function getVaccineIdsForAnimal(string $animalId): array
    {
        $sql = "SELECT vaccine_id FROM `animal_vaccine` WHERE animal_id = :animal_id";
        $stmt = $this->query($sql, [':animal_id' => $animalId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
    }

    // Simpan data hewan baru
    public function create(string $id, string $name, string $shelterId, int $age, array $vaccineIds = []): bool
    {
        $this->beginTransaction();

        try {
            $sqlAnimal = "INSERT INTO `{$this->table}` (`id`, `name`, `shelter_id`, `age`) 
                          VALUES (:id, :name, :shelter_id, :age)";
            $this->query($sqlAnimal, [
                ':id'         => $id,
                ':name'       => $name,
                ':shelter_id' => $shelterId,
                ':age'        => $age
            ]);

            if (!empty($vaccineIds)) {
                $sqlVaccine = "INSERT INTO `animal_vaccine` (`animal_id`, `vaccine_id`) VALUES (:animal_id, :vaccine_id)";
                $stmtVaccine = $this->db->prepare($sqlVaccine);

                foreach ($vaccineIds as $vaccineId) {
                    $vaccineId = trim($vaccineId);
                    if ($vaccineId !== '') {
                        $stmtVaccine->execute([
                            ':animal_id'  => $id,
                            ':vaccine_id' => $vaccineId
                        ]);
                    }
                }
            }

            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    // Update data dan vaksin
    public function update(string $id, string $name, string $shelterId, int $age, array $vaccineIds = []): bool
    {
        $this->beginTransaction();

        try {
            $sqlAnimal = "UPDATE `{$this->table}` 
                          SET `name` = :name, `shelter_id` = :shelter_id, `age` = :age 
                          WHERE `id` = :id";
            $this->query($sqlAnimal, [
                ':name'       => $name,
                ':shelter_id' => $shelterId,
                ':age'        => $age,
                ':id'         => $id
            ]);

            $sqlDelete = "DELETE FROM `animal_vaccine` WHERE `animal_id` = :animal_id";
            $this->query($sqlDelete, [':animal_id' => $id]);

            if (!empty($vaccineIds)) {
                $sqlInsert = "INSERT INTO `animal_vaccine` (`animal_id`, `vaccine_id`) VALUES (:animal_id, :vaccine_id)";
                $stmtInsert = $this->db->prepare($sqlInsert);

                foreach ($vaccineIds as $vaccineId) {
                    $vaccineId = trim($vaccineId);
                    if ($vaccineId !== '') {
                        $stmtInsert->execute([
                            ':animal_id'  => $id,
                            ':vaccine_id' => $vaccineId
                        ]);
                    }
                }
            }

            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    // Hapus data hewan
    public function delete(string $id): bool
    {
        $sql = "DELETE FROM `{$this->table}` WHERE `id` = :id";
        $stmt = $this->query($sql, [':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    // Buat ID hewan otomatis
    public function generateNextId(): string
    {
        $sql = "SELECT id FROM `{$this->table}` ORDER BY id DESC LIMIT 1";
        $stmt = $this->query($sql);
        $lastId = $stmt->fetchColumn();

        if ($lastId && preg_match('/^AN(\d+)$/', $lastId, $matches)) {
            $nextNum = ((int) $matches[1]) + 1;
            return sprintf("AN%03d", $nextNum);
        }

        return "AN001";
    }
}

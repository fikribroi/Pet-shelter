<?php
// Model data master shelter
class ShelterModel extends BaseModel
{
    protected string $table = 'shelters';
    protected string $primaryKey = 'id';

    // Ambil semua data shelter
    public function findAll(): array
    {
        $sql = "SELECT s.id, s.name, COUNT(a.id) AS animal_count 
                FROM `{$this->table}` s
                LEFT JOIN `animals` a ON s.id = a.shelter_id
                GROUP BY s.id, s.name
                ORDER BY s.id ASC";

        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    // Ambil shelter berdasarkan ID
    public function findById(string $id): ?array
    {
        $sql = "SELECT s.id, s.name, COUNT(a.id) AS animal_count 
                FROM `{$this->table}` s
                LEFT JOIN `animals` a ON s.id = a.shelter_id
                WHERE s.id = :id
                GROUP BY s.id, s.name";

        $stmt = $this->query($sql, [':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    // Tambah data shelter baru
    public function create(string $id, string $name): bool
    {
        $sql = "INSERT INTO `{$this->table}` (`id`, `name`) VALUES (:id, :name)";
        $stmt = $this->query($sql, [
            ':id'   => $id,
            ':name' => $name
        ]);
        return $stmt->rowCount() > 0;
    }

    // Perbarui data nama shelter
    public function update(string $id, string $name): bool
    {
        $sql = "UPDATE `{$this->table}` SET `name` = :name WHERE `id` = :id";
        $stmt = $this->query($sql, [
            ':id'   => $id,
            ':name' => $name
        ]);
        return $stmt->rowCount() >= 0;
    }

    // Hapus data shelter terpilih
    public function delete(string $id): bool
    {
        if ($this->hasAnimals($id)) {
            return false;
        }

        $sql = "DELETE FROM `{$this->table}` WHERE `id` = :id";
        $stmt = $this->query($sql, [':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    // Cek keterkaitan data hewan
    public function hasAnimals(string $id): bool
    {
        $sql = "SELECT COUNT(*) FROM `animals` WHERE `shelter_id` = :shelter_id";
        $stmt = $this->query($sql, [':shelter_id' => $id]);
        return ((int) $stmt->fetchColumn()) > 0;
    }

    // Buat ID shelter otomatis
    public function generateNextId(): string
    {
        $sql = "SELECT id FROM `{$this->table}` ORDER BY id DESC LIMIT 1";
        $stmt = $this->query($sql);
        $lastId = $stmt->fetchColumn();

        if ($lastId && preg_match('/^SH(\d+)$/', $lastId, $matches)) {
            $nextNum = ((int) $matches[1]) + 1;
            return sprintf("SH%03d", $nextNum);
        }

        return "SH001";
    }
}

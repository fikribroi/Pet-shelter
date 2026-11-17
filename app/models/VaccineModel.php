<?php
// Model data master vaksin
class VaccineModel extends BaseModel
{
    protected string $table = 'vaccines';
    protected string $primaryKey = 'id';

    // Ambil semua jenis vaksin
    public function findAll(): array
    {
        $sql = "SELECT v.id, v.name, COUNT(av.animal_id) AS animal_count 
                FROM `{$this->table}` v
                LEFT JOIN `animal_vaccine` av ON v.id = av.vaccine_id
                GROUP BY v.id, v.name
                ORDER BY v.id ASC";

        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    // Ambil vaksin berdasarkan ID
    public function findById(string $id): ?array
    {
        $sql = "SELECT v.id, v.name, COUNT(av.animal_id) AS animal_count 
                FROM `{$this->table}` v
                LEFT JOIN `animal_vaccine` av ON v.id = av.vaccine_id
                WHERE v.id = :id
                GROUP BY v.id, v.name";

        $stmt = $this->query($sql, [':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    // Tambah jenis vaksin baru
    public function create(string $id, string $name): bool
    {
        $sql = "INSERT INTO `{$this->table}` (`id`, `name`) VALUES (:id, :name)";
        $stmt = $this->query($sql, [
            ':id'   => $id,
            ':name' => $name
        ]);
        return $stmt->rowCount() > 0;
    }

    // Perbarui data nama vaksin
    public function update(string $id, string $name): bool
    {
        $sql = "UPDATE `{$this->table}` SET `name` = :name WHERE `id` = :id";
        $stmt = $this->query($sql, [
            ':id'   => $id,
            ':name' => $name
        ]);
        return $stmt->rowCount() >= 0;
    }

    // Hapus jenis data vaksin
    public function delete(string $id): bool
    {
        $sql = "DELETE FROM `{$this->table}` WHERE `id` = :id";
        $stmt = $this->query($sql, [':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    // Buat ID vaksin otomatis
    public function generateNextId(): string
    {
        $sql = "SELECT id FROM `{$this->table}` ORDER BY id DESC LIMIT 1";
        $stmt = $this->query($sql);
        $lastId = $stmt->fetchColumn();

        if ($lastId && preg_match('/^VK(\d+)$/', $lastId, $matches)) {
            $nextNum = ((int) $matches[1]) + 1;
            return sprintf("VK%03d", $nextNum);
        }

        return "VK001";
    }
}

<?php
// Abstract class dasar model
abstract class BaseModel
{
    protected PDO $db;
    protected string $table = '';
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Method abstrak ambil data
    abstract public function findAll(): array;

    // Method abstrak cari ID
    abstract public function findById(string $id): ?array;

    // Eksekusi prepared statement query
    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Cek keberadaan data ID
    public function exists(string $id): bool
    {
        $sql = "SELECT COUNT(*) FROM `{$this->table}` WHERE `{$this->primaryKey}` = :id";
        $stmt = $this->query($sql, [':id' => $id]);
        return ((int) $stmt->fetchColumn()) > 0;
    }

    // Hitung total seluruh baris
    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) FROM `{$this->table}`";
        $stmt = $this->query($sql);
        return (int) $stmt->fetchColumn();
    }

    // Mulai transaksi database
    public function beginTransaction(): bool
    {
        if (!$this->db->inTransaction()) {
            return $this->db->beginTransaction();
        }
        return true;
    }

    // Simpan permanen transaksi database
    public function commit(): bool
    {
        if ($this->db->inTransaction()) {
            return $this->db->commit();
        }
        return true;
    }

    // Batalkan perubahan transaksi database
    public function rollBack(): bool
    {
        if ($this->db->inTransaction()) {
            return $this->db->rollBack();
        }
        return true;
    }
}

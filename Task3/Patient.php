<?php
require_once 'PatientRecord.php';
require_once 'Insurance.php';

class Patient implements PatientRecord {
    private int $_id;
    private string $pn;
    private string $first;
    private string $last;
    private array $insurances = [];

    public function __construct(int $id, string $pn, string $first, string $last) {
        $this->_id = $id;
        $this->pn = $pn;
        $this->first = $first;
        $this->last = $last;
    }
    
    public function getId(): int {
        return $this->_id;
    }

    public function getPatientNumber(): string {
        return $this->pn;
    }

    public function getFullName(): string {
        return "{$this->first} {$this->last}";
    }

    public function getInsurances(Insurance $insurance = null): array {
        if ($insurance !== null) {
            $this->insurances[] = $insurance;
        }
        return $this->insurances;
    }

    public function printInsTable(string $date): void {
        foreach ($this->insurances as $insurance) {
            $isValid = $insurance->isOnValidRange($date) ? 'Yes' : 'No';
            echo "{$this->pn}, {$this->getFullName()}, {$insurance->iname}, $isValid<br>";
        }
    }
}

?>
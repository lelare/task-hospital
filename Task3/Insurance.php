<?php
require_once 'PatientRecord.php';

class Insurance implements PatientRecord {
    private int $_id;
    private string $pn;
    public string $iname;
    private string $from_date;
    private ?string $to_date;

    public function __construct(int $id, string $pn, string $iname, string $from_date, ?string $to_date = null) {
        $this->_id = $id;
        $this->pn = $pn;
        $this->iname = $iname;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function getId(): int {
        return $this->_id;
    }

    public function getPatientNumber(): string {
        return $this->pn;
    }

    public function isOnValidRange(string $date): bool {
        $dateConverted = DateTime::createFromFormat('m-d-y', $date)->format('Y-m-d');

        $fromDateObj = new DateTime($this->from_date);
        $dateObj = new DateTime($dateConverted);

        if (!$this->to_date) {
            return $dateObj >= $fromDateObj;
        } else {
            $toDateObj = new DateTime($this->to_date);

            return $dateObj >= $fromDateObj && $dateObj <= $toDateObj;
        }
    }
}
?>
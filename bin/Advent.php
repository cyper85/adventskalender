<?php

// Config laden
include(__DIR__ . "/config.php");

class Advent
{
    public $advent_files = ADVENT_FILES;
    /**
     * Mock-Funktion um UnitTests zu machen
     *
     * @return int aktueller Timestamp
     */
    protected function now(): int
    {
        return time();
    }

    private static function json_response(array $status): void
    {
        header('Content-Type: application/json');
        http_response_code($status['http_status_code']);
        $data = array(
            "status" => $status['status'],
            "message" => $status['message'],
        );
        echo json_encode($data);
    }

    final public function open_door(?int $monthday, bool $download): void
    {
        // Prüfe ob ordentlicher Wert übermittelt wurde
        if (!filter_var($monthday, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range" => 31)))) {
            self::json_response(ERROR_OUT_OF_RANGE);
            return;
        }

        // Prüfe, ob zu früh abgefragt wird
        if ((YEAR > date('Y')) || ((YEAR == date('Y', $this->now())) && (($monthday > date('j', $this->now())) || (12 > date('n', $this->now()))))) {
            $error = ERROR_TO_EARLY;
            $days_left = date("z", mktime(0, 0, 0, 12, $monthday, YEAR)) - date("z", $this->now());
            $error['message'] = sprintf($error['message'], $days_left);
            self::json_response($error);
            return;
        }

        // Prüfe ob Datei bereits existiert
        if (!array_key_exists($monthday, $this->advent_files) || !file_exists($this->advent_files[$monthday])) {
            self::json_response(ERROR_NOT_AVAILABLE);
            return;
        }

        // Bei Check-Abfrage ein Success zurückgeben
        if (!$download) {
            self::json_response(SUCCESS);
            return;
        }

        // Bei Download einfach lesen und ausgeben
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($this->advent_files[$monthday]));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($this->advent_files[$monthday]));
        ob_clean();
        flush();
        readfile($this->advent_files[$monthday]);
    }
}
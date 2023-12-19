<?php

namespace App\Repository;

use PDO;

/**
 * Infographic repository class
 */
class InfographicRepository
{

    private static ?self $instance = null;

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            $user = getenv('MYSQL_USER');
            $password = getenv('MYSQL_PASSWORD');
            $dbName = getenv('MYSQL_DATABASE');
            $dbHost = getenv('MYSQL_HOST');
            $dbPort = getenv('MYSQL_DB_PORT');

            $dsn = sprintf('mysql:host=%s;dbname=%s;port=%s', $dbHost, $dbName, $dbPort);
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);


            self::$instance = new self($pdo);
        }
        return self::$instance;
    }

    /**
     * @param PDO $pdo
     */
    protected function __construct(private readonly PDO $pdo)
    {
    }

    protected function __clone()
    {
        // singleton
    }

    /**
     * @param string $date
     * @return array
     */
    public function getInfoByDate(string $date): array
    {
        $sql = "SELECT `proceeds`, `hard_cash`, `non_cash`, `credit_cards`, `avg_bill`, `avg_guest`, `removal_from_check`, `removal_from_bill`, `number_of_checks`, `number_of_guests`
        FROM `infographic` WHERE `date` = STR_TO_DATE(:date, '%Y-%m-%d')";

        $stmt = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        try {
            $stmt->execute(['date' => $date]);
        } catch (\Exception $e) {
            dd($e);
        }
        $fetchedData = $stmt->fetchAll();


        foreach ($fetchedData as $item) {
            $result[] = [
                'proceeds' => $item['proceeds'],
                'hardCash' => $item['hard_cash'],
                'nonCash' => $item['non_cash'],
                'creditCards' => $item['credit_cards'],
                'avgBill' => $item['avg_bill'],
                'avgGuest' => $item['avg_guest'],
                'removalFromCheck' => $item['removal_from_check'],
                'removalFromBill' => $item['removal_from_bill'],
                'numberOfChecks' => $item['number_of_checks'],
                'numberOfGuests' => $item['number_of_guests'],
            ];
        }

        return $result ?? [];
    }
}
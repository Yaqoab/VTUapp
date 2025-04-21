<?php
require_once "../../../classes/actions.php";
require_once '../../../db_connect.php';

 $processData= new Actions();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
        if (isset($_GET['cat'])) {
            $categories = $processData->select("categories","*","","fetchAll");
            echo json_encode([
                "status" => "successful",
                "data" => $categories
            ]);
    
        }elseif(isset($_GET['catId'])){
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
            $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
            $catId  = $_GET['catId'];
            $userId = $_GET['userId'];
            $res;

        if ($catId === 'all') {
            // Fetch all categories
            
            $query = "SELECT dt_id AS id, 'data' AS category, cat_id, user_id, date, amount, status, NULL AS transaction_type
                FROM data_history
                WHERE user_id='$userId'
                
                UNION ALL
                
                SELECT t_id AS id, 'tv_Cable' AS category, cat_id, user_id, date, amount, status, NULL AS transaction_type
                FROM tvcable_history
                WHERE user_id='$userId'
                
                UNION ALL
                
                SELECT air_id AS id, 'airtime' AS category, cat_id, user_id, date, amount, status, NULL AS transaction_type
                FROM airtime_history
                WHERE user_id='$userId'
                
                UNION ALL 
                
                SELECT e_id AS id, 'electricity' AS category, cat_id, user_id, date, amount, status, NULL AS transaction_type
                FROM electric_history
                WHERE user_id='$userId'
                
                UNION ALL 
                
                SELECT transfer_id AS id, 'transfer' AS category, cat_id, sender_id AS user_id, date, amount, status, 'Sent' AS transaction_type
                FROM transfer
                WHERE sender_id='$userId'
                
                UNION ALL 
                
                SELECT transfer_id AS id, 'transfer' AS category, cat_id, receiver_id AS user_id, date, amount, status, 'Received' AS transaction_type
                FROM transfer
                WHERE receiver_id='$userId'
                ORDER BY date DESC LIMIT $limit OFFSET $offset";

                // This will count all the rows your union returns, without LIMIT
        $countQuery = "
        SELECT COUNT(*) AS total FROM (
            SELECT 1 FROM data_history WHERE user_id='$userId'
            UNION ALL
            SELECT 1 FROM tvcable_history WHERE user_id='$userId'
            UNION ALL
            SELECT 1 FROM airtime_history WHERE user_id='$userId'
            UNION ALL
            SELECT 1 FROM electric_history WHERE user_id='$userId'
            UNION ALL
            SELECT 1 FROM transfer WHERE sender_id='$userId'
            UNION ALL
            SELECT 1 FROM transfer WHERE receiver_id='$userId'
        ) AS combined_data";

        $totalResult = $processData->select("RAW_QUERY", $countQuery, "", "fetch");
        $totalCount = isset($totalResult['total']) ? (int)$totalResult['total'] : 0;


            $getAll = $processData->select('RAW_QUERY', $query, '', 'fetchAll');
            $res = ["status" => "success", "data" => $getAll, "totalCount" =>$totalCount ];
        
        } else {
            // Fetch specific category
            
            $tableMapping = [
                '1' => [
                    'table' => 'data_history',
                    'columns' => "dt_id AS id, 'data' AS category, cat_id, user_id, date, amount, status, NULL AS transaction_type
                    ",
                    'condition' => "user_id = $userId"
                ],
                '2' => [
                    'table' => 'airtime_history',
                    'columns' => "air_id AS id, 'airtime' AS category, cat_id, user_id, date, amount, status, NULL AS transaction_type
                   ",
                    'condition' =>  "user_id = $userId"
                ],
                '3' => [
                    'table' => 'transfer',
                    'columns' => "transfer_id AS id, 'transfer' AS category, cat_id, sender_id AS user_id, date, amount, status, 
                                  CASE 
                                      WHEN sender_id =  $userId THEN 'Sent'
                                      WHEN receiver_id =  $userId THEN 'Received'
                                  END AS transaction_type",
                    'condition' => "(sender_id = $userId OR receiver_id = $userId)"
                ],
                '4' => [
                    'table' => 'electric_history',
                    'columns' => "e_id AS id, 'electricity' AS category, cat_id, user_id, date, amount, status, NULL AS transaction_type
                    ",
                    'condition' => "user_id = $userId"
                ],
                '5' => [
                    'table' => 'tvcable_history',
                    'columns' => "t_id AS id, 'tv_Cable' AS category, cat_id, user_id, date, amount, status, NULL AS transaction_type
                    ",
                    'condition' => "user_id = $userId"
                ],
            ];

            switch ($catId) {
                case '1':
                    $countQuery = "SELECT COUNT(*) AS total FROM data_history WHERE user_id='$userId'";
                    break;
                case '5':
                    $countQuery = "SELECT COUNT(*) AS total FROM tvcable_history WHERE user_id='$userId'";
                    break;
                case '2':
                    $countQuery = "SELECT COUNT(*) AS total FROM airtime_history WHERE user_id='$userId'";
                    break;
                case '4':
                    $countQuery = "SELECT COUNT(*) AS total FROM electric_history WHERE user_id='$userId'";
                    break;
                case '3':
                    // Sent + Received combined
                    $countQuery = "
                        SELECT COUNT(*) AS total FROM (
                            SELECT 1 FROM transfer WHERE sender_id='$userId'
                            UNION ALL
                            SELECT 1 FROM transfer WHERE receiver_id='$userId'
                        ) AS t
                    ";
                    break;
                default:
                    $countQuery = "SELECT 0 AS total"; // fallback
                    break;
               };
               $totalResult = $processData->select("RAW_QUERY", $countQuery, "", "fetch");
               $totalCount = isset($totalResult['total']) ? (int)$totalResult['total'] : 0;
            
            // Check if the category ID exists in the mapping
            if (array_key_exists($catId, $tableMapping)) {
                $tableInfo = $tableMapping[$catId];
                $tableName = $tableInfo['table'];
                $columns = $tableInfo['columns'];
                $condition = $tableInfo['condition'];
                
                $query = "SELECT $columns FROM $tableName WHERE $condition ORDER BY date DESC LIMIT $limit OFFSET $offset";


                // Execute the query with prepared statements
                 $getSpecific = $processData->select('RAW_QUERY', $query, '', 'fetchAll');
                
                $res = ["status" => "success", "data" => $getSpecific, "totalCount" => $totalCount];
            } else {
                $res = ["status" => "error", "message" => "Invalid category ID"];
            }
            
        }
        
        echo json_encode($res);



         }
        //  echo json_encode($res);
}else{

}

?>

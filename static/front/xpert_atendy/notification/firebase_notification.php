<?php
    $servername = "localhost";
    $username = "wtf_dba";
    $password = "@AsifryK0212";
    $dbname = "wtf_db";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $tone_id = $_GET['id'];
    $sql = "SELECT * from fcm_tokens";
    $result = $conn->query($sql);
    $sql_tone = "SELECT * from web WHERE status = 1 AND id='$tone_id'";
        $result_tone = $conn->query($sql_tone);
        if ($result_tone->num_rows > 0) {
            while($row = $result_tone->fetch_assoc()) {
                $tone_data['tone_id'] = $row['id'];
                $tone_data['title'] = $row['title'];
                $tone_data['message'] = $row['des'];
                $dataa['data'] = $tone_data;
            }
        }
    
    require_once './google-api-php-client/vendor/autoload.php';
    foreach ($result as $key => $value):
    	send($value['token'], $dataa);
    endforeach;
    
    function send($to, $message) {
        date_default_timezone_set("Asia/Karachi");
        $file_name ='./xpertatendy-firebase-adminsdk-crvvw-6dcb55a422.json';
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.$file_name);
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $httpClient = $client->authorize();
        $project = "xpertatendy";
        // Creates a notification for subscribers to the debug topic
        $message = [
    	    "message" => [
    	        "token" => $to,
    	        "data" => [
    	            'tone_id' => $message['data']['tone_id'],
                    'title' => $message['data']['title'],
                    'message' => $message['data']['message'],
                ],
    	    ]
    	];
    	$response = $httpClient->post("https://fcm.googleapis.com/v1/projects/{$project}/messages:send", ['json' => $message]);
    //     "<br><br>";
    // 	print_r($response);
    }
?>
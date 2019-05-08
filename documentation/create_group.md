 **Create Group** 
  ----
   [Back to Summary](endpoints.md#groups-endpoints)
   
    Create a group.
  
  * **URL**
  
    /api/groups
  
  * **Method:**
  
    `POST`
    
  *  **URL Params**
  
     **Required:**
   
     None 
  
  * **Data Params**
  
    ```json
      { 
          "name": "Group 999"
      }
      ```
  
  * **Success Response:**
  
    * **Code:** 200 <br />
      **Content:** 
      ```json
      {
          "data": {
              "id": 56,
              "name": "Group 999",
              "updated_at": "2019-05-07 22:50:41",
              "created_at": "2019-05-07 22:50:41"
          }
      }
      ```
   
  * **Error Responses:**
  
    * **Code:** 401 UNAUTHORIZED <br />
      **Content:** `{ "error": "Unauthenticated" }`
      
    OR
    
    * **Code:** 422 Unprocessable Entity <br />
      **Content:** 
      ```
      {
          "name": [
              "The name field is required."
          ],
          "email": [
              "The email field is required."
                    ],
          "password": [
              "The password field is required."
                    ]
          "password": [
              "The password confirmation does not match."
          ]
      }
      ```
  

 
  * **Sample Call with cURL:**
  
    ```php
    <?php
        // User to be authenticated
        $auth_data = array(
            'email' 	=> 'admin@email.com',
            'password' 	=> 'admin'
        );
    
        $url = 'http://<SERVER ADDRESS>/api';
        $c   = curl_init();
    
        // Authenticate and get token
        curl_setopt($c, CURLOPT_URL, $url . '/login');
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $auth_data);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec ($c);
        $token  = json_decode($result)->data->api_token;
    
        $headers = [
            'Cache-control: no-cache',
            'Content-Type : application/json',
            'Authorization: Bearer '. $token
        ];
    
        $data = [
                    'name' => 'Group 999'
                ];
    
        // Access API
        curl_setopt($c, CURLOPT_URL, $url . '/groups');
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            
        $result = curl_exec ($c);
        
        // Print results
        echo '<pre>';
        print_r(json_decode($result));
      
        curl_close ($c);
    ```
    
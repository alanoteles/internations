 **Update User** 
  ----
   [Back to Summary](endpoints.md#users-endpoints)
   
    Update a user.
  
  * **URL**
  
    /api/users/{id}
  
  * **Method:**
  
    `PUT`
    
  *  **URL Params**
  
     **Required:**
   
     `ID = [integer]` 
  
  * **Data Params**
  
    ```json
      { 
          "name": "Eladio Fay",
          "email": "eladio.fay@example.org",
          "admin": 0,
          "password": "123456"
      }
      ```
  
  * **Success Response:**
  
    * **Code:** 200 <br />
      **Content:** 
      ```json
      { 
          "id": 45,
          "name": "Eladio Fay",
          "email": "eladio.fay@example.org",
          "admin": 0,
          "api_token": null,
          "created_at": "2019-05-06 21:13:44",
          "updated_at": "2019-05-07 14:10:51"
      }
      ```
   
  * **Error Responses:**
  
    * **Code:** 404 NOT FOUND <br />
      **Content:** `{ "error": "Resource not found" }`
  
    OR
  
    * **Code:** 401 UNAUTHORIZED <br />
      **Content:** `{ "error": "Unauthenticated" }`
      
    OR
        
    * **Code:** 400 Bad Request <br />
      **Content:** `{ "error": "Method not Allowed" }`
      
    OR
    
    * **Code:** 422 Unprocessable Entity <br />
      **Content:** 
      ```
      {
          "name": [
              "The name field is required."
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
                'name' 	                => 'John Doe',
                'email' 	            => 'john@email.com',
                'password' 	            => '123456',
                'password_confirmation' => '123456',
        ];
    
        
        // Access API
        curl_setopt($c, CURLOPT_URL, $url . '/users/5');
        curl_setopt($c, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            
        $result = curl_exec ($c);
        
        // Print results
        echo '<pre>';
        print_r(json_decode($result));
      
        curl_close ($c);
    ```
    
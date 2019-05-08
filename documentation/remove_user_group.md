 **Remove User from Group** 
  ----
   [Back to Summary](endpoints.md#groups-endpoints)
   
    Remove user from a group.
  
  * **URL**
  
    /api/groups/{id}/users/{id}/remove
  
  * **Method:**
  
    `POST`
    
  *  **URL Params**
  
     **Required:**
   
     `group id=[integer]`\
     `user id=[integer]`
  
  * **Data Params**
  
    None
  
  * **Success Response:**
  
    * **Code:** 204 <br />
      **Content:** No content 
      
   
  * **Error Responses:**
  
    * **Code:** 400 UNAUTHORIZED <br />
          **Content:** `{ "error": "This User is already on this group." }`
          
    OR
    
    * **Code:** 401 UNAUTHORIZED <br />
      **Content:** `{ "error": "Unauthenticated" }`
      
    OR
    
    * **Code:** 404 NOT FOUND <br />
    **Content:** `{ "error": "Resource not found" }`\
    **Content:** `{ "error": "Group/User not found" }`

    
  

 
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
        curl_setopt($c, CURLOPT_URL, $url . '/groups/12/users/3/remove');
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            
        $result = curl_exec ($c);
        
        // Print results
        echo '<pre>';
        print_r(json_decode($result));
      
        curl_close ($c);
    ```
    
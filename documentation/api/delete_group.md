 **Delete Group** 
  ----
   [Back to Summary](endpoints.md#users-endpoints)
   
    Delete a group.
  
  * **URL**
  
    /api/users/{id}
  
  * **Method:**
  
    `DELETE`
    
  *  **URL Params**
  
     **Required:**
   
     `ID = [integer]` 
  
  * **Data Params**
  
    None
  
  * **Success Response:**
  
    * **Code:** 204 <br />
      **Content:**  No content
      
   
  * **Error Responses:**
  
    * **Code:** 404 NOT FOUND <br />
      **Content:** `{ "error": "Resource not found" }`
  
    OR
  
    * **Code:** 401 UNAUTHORIZED <br />
      **Content:** `{ "error": "Unauthenticated" }`
      
    OR
        
    * **Code:** 400 Bad Request <br />
      **Content:** `{ "error": "Method not Allowed" }`
      

 
  * **Sample Call with cURL:**
  
    ```php
    <?php
        // User to be authenticated
        $auth_data = array(
            'email' 	=> 'admin@email.com',
            'password' 	=> 'admin'
        );
    
        $url = 'http://<SERVER ADDRESS>/api';
        $c = curl_init();
    
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
    
     
        // Access API
        curl_setopt($c, CURLOPT_URL, $url . '/groups/5');
        curl_setopt($c, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            
        $result = curl_exec ($c);
      
        curl_close ($c);
    ```
    
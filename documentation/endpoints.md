**Users endpoints** :\
[List users](#list-users) : GET `/api/users`\

[Create user](#create_user.md)  : POST `/api/users`\
[Read user](#read-user)  : GET `/api/users/{id}`\
[Update user](#update-user)  : PUT `/api/users/{id}`\
[Delete user](#create-user)  : DELETE `/api/users/{id}`\


**Groups endpoints** :\
[List groups](#list-groups) : GET `/api/groups`\

[Create group](#create-group)  : POST `/api/groups`\
[Read group](#read-group)  : GET `/api/groups/{id}`\
[Update group](#update-group)  : PUT `/api/groups/{id}`\
[Delete group](#create-group)  : DELETE `/api/groups/{id}`\
  
  
  **Create User** 
  ----
    Creates a user.
  
  * **URL**
  
    /users
  
  * **Method:**
  
    `POST`
    
  *  **URL Params**
  
     **Required:**
   
     None  
  
  * **Data Params**
  
    ```json
      { 
          "name": "Eladio Fay",
          "email": "eladio.fay@example.org",
          "admin": 0,
          "password": "123456",
          "password_confirmation": "123456"
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
    
        $c = curl_init();
    
        // Authenticate and get token
        curl_setopt($c, CURLOPT_URL, 'http://<SERVER ADDRESS>/api/login');
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $auth_data);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec ($c);
        $token  = json_decode($result)->data->api_token;
    
        $headers = [
            'Authorization: Bearer '. $token
        ];
    
        $data = [
    
        ]
    
        // Access API
        curl_setopt($c, CURLOPT_URL, 'http://<SERVER ADDRESS>/api/users/5');
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $headers, );
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            
        $result = curl_exec ($c);
        
        // Print results
        echo '<pre>';
        print_r(json_decode($result));
      
        curl_close ($c);
    ```
    
    **Read User**
    ----
      Returns json data about a single user.
    [Create User](#create-user)
    * **URL**
    
      /users/{id}
    
    * **Method:**
    
      `GET`
      
    *  **URL Params**
    
       **Required:**
     
       `id=[integer]`
    
    * **Data Params**
    
      None
    
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
     
    * **Error Response:**
    
      * **Code:** 404 NOT FOUND <br />
        **Content:** `{ "error": "Resource not found" }`
    
      OR
    
      * **Code:** 401 UNAUTHORIZED <br />
        **Content:** `{ "error": "Unauthenticated" }`
    
    * **Sample Call with cURL:**
    
      ```php
      <?php
          // User to be authenticated
          $auth_data = array(
              'email' 	=> 'admin@email.com',
              'password' 	=> 'admin'
          );
      
          $c = curl_init();
      
          // Authenticate and get token
          curl_setopt($c, CURLOPT_URL, 'http://<SERVER ADDRESS>/api/login');
          curl_setopt($c, CURLOPT_POST, 1);
          curl_setopt($c, CURLOPT_POSTFIELDS, $auth_data);
          curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec ($c);
          $token  = json_decode($result)->data->api_token;
      
          $headers = [
              'Content-Type: application/json',
              'Authorization: Bearer '. $token
          ];
      
          // Access API
          curl_setopt($c, CURLOPT_URL, 'http://<SERVER ADDRESS>/api/users/5');
          curl_setopt($c, CURLOPT_POST, 0);
          curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
              
          $result = curl_exec ($c);
          
          // Print results
          echo '<pre>';
          print_r(json_decode($result));
        
          curl_close ($c);
      ```
      
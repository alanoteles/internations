**Read User**
  ----
  [Back to Summary](endpoints.md#users-endpoints)
  
  Returns json data about a single user.

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
      curl_setopt($c, CURLOPT_URL, $url . '/users/5');
      curl_setopt($c, CURLOPT_POST, 0);
      curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
          
      $result = curl_exec ($c);
      
      // Print results
      echo '<pre>';
      print_r(json_decode($result));
    
      curl_close ($c);
  ```
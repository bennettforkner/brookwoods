<?php
namespace Brookwoods {

	class FMService
	{
		private string $token;

		public function __construct($host, $username, $password)
		{
			$this->token = $this::getToken($host, $username, $password, "Get token");
		}

		private static function getToken($host, $username, $password, $payloadName)
		{

			$additionalHeaders = '';
			$ch = curl_init($host);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch); // Execute the cURL statement
			curl_close($ch); // Close the cURL connection

			var_dump($result);
		
			// Decode the resulting JSON
			$json_token = json_decode($result, true);
		
			// Extract just the token value from the JSON result
			$token_received = $json_token['response']['token'];
		
			// Return the token from this function
			return($token_received);
		}

		private function getData($host, $payloadName)
		{
					
			$additionalHeaders = "Authorization: Bearer ".$this->token; // Prepare the authorisation token
			$ch = curl_init($host);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $additionalHeaders )); // Inject the token into the header
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
			curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName); // Set the posted fields
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch); // Execute the cURL statement
			curl_close($ch); // Close the cURL connection
		
			// Decode the resulting JSON
			$json_data = json_decode($result);
		
			// Return the data from this function
			return $json_data;
		}
	}

}

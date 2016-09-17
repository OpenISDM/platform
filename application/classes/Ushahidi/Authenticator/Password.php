<?php defined('SYSPATH') or die('No direct script access');

/**
 * Ushahidi Password Authenticator
 *
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

use Ushahidi\Core\Tool\PasswordAuthenticator;
use Ushahidi\Core\Exception\AuthenticatorException;

class Ushahidi_Authenticator_Password implements PasswordAuthenticator
{
	// Original definition: public function checkPassword($plaintext, $hash)
	// TODO : write interface  implement new class

	public function checkPassword($email, $password)
	{	
		// authentication from VMS

		if(strcmp($email, "admin") == 0) {
			// admin login authentication (local database)
			if (!password_verify($email, $password)) {
				throw new AuthenticatorException("Password does not match this account");
			}

			return true;

		} else {
			$url = "http://vms-dev.herokuapp.com/api/auth";
			$header = array(
				"Content-Type: application/json",
				"X-VMS-API-Key: 581dba93a4dbafa42a682d36b015d8484622f8e3543623bec5a291f67f5ddff1"
			);
			$data = array(
				"email" => $email,
				"password" => $password,
			);

			$json_data = json_encode($data);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			// send request to vms api
			$result = curl_exec($curl);
			curl_close($curl);
		
			if (isset(json_decode($result) -> errors[0])) {
				throw new AuthenticatorException("Third party authentication failed.");
			}
			return true;
		}
	}
}

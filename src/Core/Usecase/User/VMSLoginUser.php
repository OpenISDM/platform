<?php

/**
 * Ushahidi Platform User Login Use with VMS Case
 *
 * @author     Yucheng Lin
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 *
 */

namespace Ushahidi\Core\Usecase\User;

use Ushahidi\Core\Entity\UserRepository;
use Ushahidi\Core\Tool\PasswordAuthenticator;
use Ushahidi\Core\Tool\RateLimiter;
use Ushahidi\Core\Usecase\ReadRepository;
// use Ushahidi\Core\Usecase\ReadUsecase;
use Ushahidi\Core\Usecase\CreateUsecase;
use Ushahidi\Core\Exception\AuthorizerException;
use Ushahidi\Core\Entity;
use Ushahidi\Core\Entity\User;
use Ushahidi\Core\Traits\IdentifyRecords;
use Ushahidi\Core\Traits\VerifyEntityLoaded;


class VMSLoginUser extends CreateUsecase
{
	use IdentifyRecords;
	use VerifyEntityLoaded;

	/**
	 * @var Authenticator
	 */
	protected $authenticator;

	/**
	 * @var RateLimiter
	 */
	protected $rateLimiter;

	/**
	 * @param  Authenticator $authenticator
	 * @return void
	 */
	public function setAuthenticator(PasswordAuthenticator $authenticator)
	{
		$this->authenticator = $authenticator;
		return $this;
	}

	/**
	 * @param RateLimiter $rateLimiter
	 */
	public function setRateLimiter(RateLimiter $rateLimiter)
	{
		$this->rateLimiter = $rateLimiter;
	}

	// ** when "True", email will be varified first
	public function isWrite()
	{
		return false;
	}

	// Usecase
	public function interact()
	{
		// Verify the account and password

		if(strcmp($this->getRequiredIdentifier('email'), "admin") == 0) {
			// admin login authentication (local database)
			// Fetch the entity, using provided identifiers...
			$entity = $this->getEntity();

			// Rate limit login attempts
			$this->rateLimiter->limit($entity);

			// ... verify that the password matches
			$this->authenticator->checkPassword($this->getRequiredIdentifier('password'), $entity->password);

			// ... and return the formatted result.
			return $this->formatter->__invoke($entity);
		}
		else {
			$authenticatePass = $this->authenticator->checkPassword($this->getRequiredIdentifier('email'), $this->getRequiredIdentifier('password'));
			
			if($authenticatePass) {
				// Fetch the entity, using provided identifiers... if there is no that entity, create it
				$entity = $this->getEntity();

				// Rate limit login attempts
				// $this->rateLimiter->limit($entity);

				// ... and return the formatted result.
				return $this->formatter->__invoke($entity);
		}
		echo 'passwordcheck() no pass'.PHP_EOL;
		}
	}

	// ReadUsecase
	protected function getEntity()
	{
		// Make sure the repository has then methods necessary.
		$this->verifyUserRepository($this->repo);

		// Entity will be loaded using the provided email
		$email = $this->getRequiredIdentifier('email');

		// ... attempt to load the entity
		$entity = $this->repo->getByEmail($email);
		// +account
		if(is_null($entity->getId())) {
			// echo 'entity->getId() is null. Regist user.'.PHP_EOL;
			$data = array(
				'realname' => $email, // get the real name
				'email'    => $email,
				'password' => 'crosscross',  // fake password, authenticate from VMS
				);
			// new a user entity
			$entityRegist = new User($data);
			// persist the new entity
			$id = $this->repo->register($entityRegist);
			// get the newly created entity
			$entity = $this->getCreatedEntity($id);
		}
		// var_dump($entity);

		// ... and verify that the entity was actually loaded
		$this->verifyEntityLoaded($entity, compact('email'));

		// ... then return it
		return $entity;
	}

	/**
	 * Verify that the given repository is a the correct type.
	 * (PHP is weird about overloaded type hinting.)
	 * @return UserRepository
	 */
	private function verifyUserRepository(UserRepository $repo)
	{
		return true;
	}
}
<?php

namespace Edu\Cnm\Sjackson37;

use Edu\Cnm\DataDesign\ValidateDate;

require_once("autoload.php");

/**
 * * Small Cross Section of a Twitter like Message
 *
 * This Tweet can be considered a small example of what services like Twitter store when messages are sent and
 * received using Twitter. This can easily be extended to emulate more features of Twitter.
 *
 * @author Sabastian Jackson <sjackson37@cnm.edu>
 * @version 4.0.0
 * **/
class Profile implements \JsonSerializable {
	use ValidateDate;

	/**
	 * id for this Profile; this is the primary key
	 * @var int $profileId
	 */
	private $profileId;

	/**
	 *profile email
	 */
	private $profileEmail;

	/**
	 * salt
	 */

	private $profileDate;
	/**
	 * hash
	 */

	private $profileHash;

	/**
	 * constructor for this Tweet
	 *
	 * @param int|null $newProfileId id of this Profile or null if a new Profile
	 * @param int $newProfileEmail id of the Email that sent this Profile
	 * @param string $newTweetContent string containing actual tweet data
	 * @param \DateTime|string|null $newTweetDate date and time Tweet was sent or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newProfileId, string $newprofileEmail, string $newProfileHash, string $newProfileSalt) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileHash($newProfileHash);
			$this->profileSalt($newProfileSalt);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * return int|null value of profile id
	 */
	public function getProfileId(): ?int {
		return ($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param int|null $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 */
	public function setProfileId(?int $newProfileId): void {
		//if profile id is null immediately return it
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}
		//verify the profile id is positive
		if($newProfileId <= 0) {
			throw(new\RangeException("profile id is not positive"));
		}
		//convert and store the profile id
		$this->profileId = $newProfileId;
	}

	/**
	 * accessor method for profile email
	 *
	 * @return string value of profile email
	 */
	public function getProfileEmail(): string {
		return ($this->profileEmail);
	}

	/**
	 * mutator method for profile email
	 *
	 * @param string $newProfileEmail new value of tweet content
	 * @throws \InvalidArgumentException if $newProfileEmail is not a string or insecure
	 * @throws \RangeException if $newProfileEmail is > 32 characters
	 * @trows \TypeError if $newProfileEmail is not a string
	 */
	public function setProfileEmail(string $newProfileEmail): void {
		//verify the content is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}
		//verify the profile email will fit in the database
		if(strlen($newProfileEmail) > 32) {
			throw(new \RangeException("profile email too large"));
		}
		//store the profile email
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for tweet date
	 *
	 * @return \DateTime value of profile date
	 */
	public function getProfileDate(): \DateTime {
		return ($this->profileDate);
	}

	/**
	 * mutator method for profile date
	 *
	 * @param \DateTime|string|null $newProfileDate profile date as a DateTime object or tring (or null to load the current time)
	 * @throws \InvalidArgumentException if $newProfileDate is not a valide object or string
	 * @throws \RangeException if $newPRofileDate is a date that does not exist
	 */
	public function setProfileDate($newProfileDate = null): void {
		//base case: if the date is null use the current date and time
		if($newProfileDate === null) {
			$this->profileDate = new \DateTime();
			return;
		}
		//store the like date using the ValidateDate trait
		try {
			$newProfileDate = self::validateDateTime($newProfileDate);
		} catch(\InvalidArgumentException | \rangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new$exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->profileDate = $newProfileDate;
	}

	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo): void {
		//enforce the profileID is null (i.e., don't insert a profile that already exists)
		if($this->profileId !== null) {
			throw(new \PDOException("not a new profile"));
		}
		//create a query template
		$query = "INSERT INTO profile(profileEmail, profileDate) VALUES(:profileEmail, :profileDate) ";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$formattedDate = $this->profileDate->format("Y-m-d H:i:s.u");
		$parameters = ["profileEmail" => $this->profileEmail, "profileDate" => $formattedDate];
		$statement->execute($parameters);
		//update the null profileId with what mySQL just gave us
		$this->profileId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		//enforce the profileId is not null (i.e., don't delete a profile that hasn't been inserted
		if($this->profileId === null) {
					throw(new \PDOException("unable to delete a profile that does not exist"));
		}
		//create a query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holder in the template
	$parameters = ["profileId" => $this->profileId];
	$statement->execute($parameters);
	}
	/**
	 * updates this profile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) : void {
		//enforce the profileId is not null (i.e., don't update a profile that hasn't been inserted)
	if($this->profileId === null) {
			throw(new \PDOException("unable to update a tweet that does not exist"));
	}
	//create a query template
	$query = "UPDATE profile SET profileEmail = :profileEmail, profileDate = :profileDate WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);
	//bind the member bariables to the place holders in the template
}
}
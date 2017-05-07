<?php

namespace Edu\Cnm\Sjackson37;

use Edu\Cnm\DataDesign\ValidateDate; //todo delete this

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
class Profile implements \JsonSerializable { //todo you have to implement JsonSerialize at the bottom of the document - see line
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
	 * hash
	 */

	private $profileHash;
	/**
	 * salt
	 */

	private $profileSalt;

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
			$this->setProfileEmail($newProfileEmail);
			//todo add method for email here too
			$this->setProfileHash($newProfileHash); //todo you have not created this method yet
			$this->setProfileSalt($newProfileSalt); //todo you have not created this method yet
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
		$query = "INSERT INTO profile(profileId, profileEmail, profileHash, profileSalt) VALUES( :profileId, :profileEmail, :profileHash, :profileSalt) "; //todo you do not need to insert a date here because date is not a part of the profile entity. you will need to insert your profileId, profileEmail, profileHash, and profileSalt
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template

		$parameters = ["profileEmail" => $this->profileEmail, "profileId" => $this->profileId, "profileSalt" => $this->profileSalt, "profileHash" => $this->profileHash], //todo the parameters for this should be more like: "profileId" => this->profileId, "profileEmail" => this->profileEmail, "profileHash" => this->profileHash, "profileSalt" -> this->profileSalt
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
	$query = "UPDATE profile SET profileEmail = :profileEmail, profileHash = :profileHash, profileSalt = :profileSalt WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);
	//bind the member bariables to the place holders in the template
		$parameters = ["profileId" => $this->profileId, "profileEmail"=> $this->profileEmail, "profileHash" => $this->profileHash, "profileSalt" => $this->profileSalt]; //todo this uses [] not {}. you will also want to add profileEmail, profileHash, and profileSalt to the parameters
		$statement->execute($parameters);
		//todo don't forget to execute your parameters
}

/* todo you now need to make methods to access the profile in different ways. I suggest creating a method called getProfileByProfileId and a method called getProfileByProfileEmail.
	todo use the following example

/**
	 * gets a Profile by tweetId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileId profile id to search for
	 * @return Profile|null Profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

public static function getProfileByProfileId(\PDO $pdo, int $tprofileId) : ?Profile {
		// sanitize the profileId before searching
		if($profileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}
		// create query template
		$query = "SELECT profileId, profileEmail, profileDate FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId];
		$statement->execute($parameters);
		// grab the tweet from mySQL
		try {
			$tprofile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileEmail"], $row["profileDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

//todo following this you will need to make a getAllProfiles method - see the following for an example:

	/**
	 * gets all Profile
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Tweets found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllProfile(\PDO $pdo) : \SplFixedArray {
		// create query template
		$query = "SELECT profileId, profileEmail, profileDate FROM profile";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of tweets
		$tweets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tweet = new Profile($row["profileId"], $row["profileEmail"], $row["profileDate"]);
				$profiles[$profiles->key()] = $profiles;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($tweets);
	}

	//todo you now need to implement JsonSerialize() you will want it to look something like the following:

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		unset($fields["profilePasswordHash"]);
		unset($fields["profileSalt"]);
		return($fields);
	}
}
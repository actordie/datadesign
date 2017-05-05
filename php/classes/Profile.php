<?php
namespace Edu\Cnm\Sjackson37
use Edu\Cnm\DataDesign\ValidateDate;

require_once ("autoload.php");
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

	private $profileSalt;
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
	}
		//determine what exception type was thrown
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
public function getProfileId() : ?int {
		return($this->profileId);
}
/**
 * mutator method for profile id
 *
 * @param int|null $newProfileId new value of profile id
 * @throws \RangeException if $newProfileId is not positive
 * @throws \TypeError if $newProfileId is not an integer
 */
public function setProfileId(?int $newProfileId) : void {
		//if profile id is null immediately return it
		if($newProfileId === null) {
				$this->profileId = null;
				return;
		}
		//verify the profile id is positive
}
}
<?php
namespace Edu\Cnm\DataDesign;
require_once ("profile.php");
/**
 * Typical Profile for an eCommerce site
 * This Profile is an abbreviated example of data collected and stored about a user for eCommerce purposes.
 * @author Sabastian Jackson <sjackson37@cnm.edu>
 **/
class Profile implements \JsonSerializable {
	/**
	 * id for this Profile; this is the primary key
	 **/
	private $profileId;
	/**
	 *  email of this person
	 **/
	private $profileEmail;
	/**
	 * hash for profile password
	 */
	private $profileHash;
	/**
	 * id of Profile that likes item
	 */
	private $itemProfileId;
	/**
	 * id of an item
	 */
	private $itemId;
	/**
	 * price of item
	 */
	private $itemPrice;
	/**
	 * salt for profile password
	 */
	private $profileSalt;
	/**
	 * constructor for this tweet
	 *
	 * @param int|notnull $newItemId id of this item or null if a new tweet
	 * @param int $newItemProfileId of profile that sent tweet
	 * @param string $newItemPrice string containing price
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \TypeError if daya types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function _construct(?int $newItemId, int $newItemProfileId, float $newItemPrice) {
		try {
			$this->setItemId($newItemId);
			$this->setItemProfileId($newItemProfileId);
			$this->setItemPrice($newItemPrice);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \ RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
/**
 * accessor method for profile id
 *
 * @return int value of profile id
 **/
	/**
	 * @return mixed
	 */
	public function getProfileId() {
		return $this->profileId;
	}

	/**
	 * mutator method for profile id
	 *
	 * @param int|null $newItemId new value of item id
	 * @throws | RangeException if $newItemId is not positive
	 * @throws \ TypeError if $newItemId is not an integer
	 * **/
	public function setItemId(?int $newItemId) : void {
		//if itemId is null immediately return it
		if($newItemId=== null) {
			$this->itemId = null;
			return;
		}
		//veify the tweet id is positive
		if($newItemId <= 0)
			throw(new \RangeException("tweet id is not positive"));

		}
		//convert and store the profile id
		$this->itemId = $newItemId;

	}
	/**
	 * accessor method for tweet profile id
	 *
	 * @return int value of tweet profile id
	 **/
	public function getItemProfileId() : int{
		return($this->itemProfileId);
}
/**
 * mutator method for item profile id
 *
 * @param int $newItemProfileId new value of item profile id
 * @throws \RangeException if $newProfileId is not positive
 * @throws \TypeError if $newProfileId is not an integer
 **/
public function setItemProfileId(int $newItemProfileId) : void {
	//verify the profile id is positive
	if($newItemProfileId <= 0) {
		throw(new \RangeException("item profile id not positive"));
	}
	//convert and store the profile id
	$this->itemProfileId = $newItemProfileId;
}
/**
 * accessor method for item content
 *
 * @return string value of tweet content
 **/
public function getItemContent() :string {
	return($this->itemContent);
	}
	/**
	 * mutator method for tweet content
	 *
	 * @param string $newItemContent new value of item content
	 * @throws \InvalidArgumentException if $newItemContent is not a string or insecure
	 * @throws \RangeException if $newItemPrice is > 140 characters
	 * @throws \TypeError if $newItemPrice is not a string
	 **/
	public function setItemPrice(string $newItemPrice) : void{
		//verify the item content is secure
		$newItemContent = trim($newItemPrice});
		$newItemContent = filter_var($newItemPrice, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newItemPrice)=== true) {
			throw(new \RangeException("item content is empty or insecure"));
					}
					//verify the tweet content will fit in the database
					if(strlen($newItemPrice) > 8) {
						throw(new \RangeException("item price too large "));
					}
					//store the item price
					$this->itemContent = $newItemPrice;
		/**
		 * inserts this Item into mySQL
		 *
		 * @param \PDO $pdo PDO connection object
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 **/
		public function insert (\PDO $pdo) : void {
			//enforce the tweetId is null
}


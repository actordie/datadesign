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
			//enforce the itemId is not null (i.e., don't update an item that hasn't been inserted)
				if($this->itemId === null) {
					throw(new \PDOException("unable to update an item that doesn't exist"));
				}
				// create query template
				$query = "INSERT INTO item (itemProfileId, itemPrice) VALUES(:itemProfileId, :itemPrice)";
				$statement = $pdo->prepare($query);
				//bind the member variables to the place holders in the template
				$parameters = ["itemProfileId" => $this->itemProfileId, "itemPrice" => this->itemPrice];
				$statement->execute($parameters);
				//update the null itemId with what mySQl just gave us
				$this->itemId = intval($pdo->lastInsertId());
}

/**
 * deletes this Item from mySQL
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function delete(\PDO $pdo) : void {
	//enforce the itemId is not null (i.e., don't delete a tweet that hasn't been inserted)
	if($this->itemId === null) {
		throw(new \PDOException("unable to delete an item that does not exist"));
	}
	//create a query template
	$query = "DELETE FROM item WHERE itemId = :itemId";
	$statement = $pdo->prepare($query);
	//bind the member variables to the place holder in the template
	$parameters = ["itemID" => $this->itemId];
	$statement->execute($parameters);
}

/**
 * updates this item in mySQL
 *
 * @param \pdo $pdo PDO connection object
 * @throws \PDOException when mySQl related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function update(\PDO $pdo) : void {
	//enforce the itemId is not null (i.e., don't update a tweet that hasn't been inserted)
	if($this->itemId === null){
		throw(new \PDOException("unable to update an item that does not exist"));
	}
	//create query template
	$query = "UPDATE item SET itemProfileId" = :itemProfileId, itemPrice = :itemPrice = WHERE itemId = :itemId;
				$statement = $pdo->prepare($query);
				//bind the member variables to the place holders in the template
				$parameters = ["itemProfileId" => $this->itemProfileId, "itemContent" => this->itemPrice, "itemId" => $this->itemId];
				$statement->execute($parameters);
}

/**
 *
 * gets a item by itemId
 * @param \PDO $pdo PDO connection object
 * @param int $itemId item id to search for
 * @return Item|null item found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static finction getItemByItemId(\PDO $pdo, int $itemId) : ?Item {item} {
	// sanitize the itemId before searching
	if($itemId <= 0) {
		throw(new \PDOException("item id is not positive"));
	}
	//create query template
	$query = "SELECT itemId, itemProfileId, itemPrice FROM item WHERE itemId = : itemId";
	$statement = $pdo->prepare($query);
	//bind the item id to the place holder in the template
	$parameters =[itemId => $itemId];
	$statement->execute($parameters);
	//grab the item from mySQl
	try {
		$tweet = null;
		$statement->setFetchMode(\PDO:: FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$item= new Item($row["itemId"], $row["itemProfileId"],
		}
	} catch (\Exception $exception) {
		//if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
}
return($item);
}

/**
 * gets items by profile id
 *
 * @param \PDO $pdo PDO connection object
 * @param int $itemProfileId profile id
 * @return \SplFixedArray SplFixedArray of item found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getItemByItemProfileId(\PDO $pdo, int $itemProfileId) : \SplFixedArray {
		// sanitize the profile id before searching
		if($itemProfileId <= 0) {
					throw(new \RangeExceotion("item profile id must be positive"));
		}
//create query template
$query = "SELECT itemId, itemProfileId, itemPrice = :tweetProfileId";
$statement = $pdo->prepare($query);
//bind the item profile id to the place holder in the template
$parameters = ["itemProfileId" => $itemProfileId];
$statement->execute($parameters);
//build an array of tweets
$tweets=new \splFixedArray($statement->rowCount());
$statement->setFetchMode(\PDO::FETCH_ASSOC);
while($row = $statement->fetch()) !== false) {
				try {
					$tweet = new Item($row["tweetId"], $row["itemProfileId"], $row["itemProfileId"], $row["itemPrice"]);
					$tweets[$tweets->key()] = $item;
					$tweets->next();
				} catch(\Exception $exception) {
					//if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception)->getMessage(),0, $exception));
				}
	}
	return($items);
}

/**
 * gets Items by content
 *
 * @param \PDO $pdo PDO connection object
 * @param string $itemPrice item content to search for
 * @return \SplFixedArray SplFixed Array of item found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getItemByItemPrice(\PDO $pdo, string $itemPrice): \SplFixedArray {
	//sanitize the description before searching
	$itemPrice = trip($itemPrice);
	$itemPrice = filter_var($itemPrice, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($itemPrice) === true) {
		throw(new \PDOException("Item price is invalid"));
		$statement->execute($parameters);
		//build an array of tweets
		$tweets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDo::FETCH_ASSOC);
		while(($row = $statement->fetch())!==false) {
			try {
					$item = new Item($row)[ "itemId"], $row["itemProfileId"], $row["itemPrice"]);
					$items[$items->key()] = $item;
					$$items->next();
			} catch(\Exception $exception) {
					//if the row coant be converted, rethrow it
				throw(new\PDOException($exception->getMessage(), 0, $exception));
			}
	}
	return ($titems);
}
/**
 * gets all items
 *
 * @param \PDO $pdo PDO connection object
 * @return \SplFixedArray SplFixedAaray of tweets found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getAllItems(\PDO $pdo) : \SplFixedArray {
			// create query template
			$query = "SELECT itemId, itemProfileId, itemPrice";
			$statement=$pdo->prepare($query);
			$statement->execute();
			//build an array of titems
			$items = new \SplFixedArray($statement->rowCount());
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while((row = $statement->fetch())) !== false {
					try {
						$item = new Item($row[itemId], $row{"itemProfileId"], $row["itemPrice"]);
						$items[$items->key()] =$item;
						$items->next();
						} catch (\Exception $exception) {
									//if the tow couldn't be converted, rethrow it
									throw(new \PDOException($exception->getMessage(), 0, $exception));
						}
		}
		return ($items);
}
/**
 * formats the state variables for JSON serialization
 *
 * @return array resulting state variables to serialize

public function jsonSerailize(){
		$fields = get_OBject_vars($this);
		//format the date sp that the front end can consume it
			$fields
}
 *
 **/
	}
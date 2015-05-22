<?php
namespace Smite;

class API {
	private static $languageCodeMap = [
		1 => 'en',
		2 => 'de',
		3 => 'fr',
		7 => 'es',
		9 => 'es-419',
		10 => 'pt',
		11 => 'ru',
		12 => 'pl',
		13 => 'tr',
	];

	private static $queueMap = [
		423 => 'Conquest5v5',
		424 => 'NoviceQueue',
		426 => 'Conquest',
		427 => 'Practice',
		429 => 'ConquestChallenge',
		430 => 'ConquestRanked',
		433 => 'Domination',
		434 => 'MOTD1',
		435 => 'Arena',
		438 => 'ArenaChallenge',
		439 => 'DominationChallenge',
		440 => 'JoustLeague',
		441 => 'JoustChallenge',
		445 => 'Assault',
		446 => 'AssaultChallenge',
		448 => 'Joust3v3',
		451 => 'ConquestLeague',
		452 => 'ArenaLeague',
		465 => 'MOTD2'
	];

	private static $tierMap = [
		1 => 'Bronze5',
		2 => 'Bronze4',
		3 => 'Bronze3',
		4 => 'Bronze2',
		5 => 'Bronze1',
		6 => 'Silver5',
		7 => 'Silver4',
		8 => 'Silver3',
		9 => 'Silver2',
		10 => 'Silver1',
		11 => 'Gold5',
		12 => 'Gold4',
		13 => 'Gold3',
		14 => 'Gold2',
		15 => 'Gold1',
		16 => 'Platinum5',
		17 => 'Platinum4',
		18 => 'Platinum3',
		19 => 'Platinum2',
		20 => 'Platinum1',
		21 => 'Diamond5',
		22 => 'Diamond4',
		23 => 'Diamond3',
		24 => 'Diamond2',
		25 => 'Diamond1',
		26 => 'Masters1'
	];

	private $returnArrays = false;

	private $languageCode = 1;

	private $devId;

	private $authKey;

	private $sessionTimestamp;

	private $guzzleClient;

	private static $smiteAPIUrl = 'http://api.smitegame.com/smiteapi.svc';

	public function getDevId() {
		return $this->devId;
	}

	public function getAuthKey() {
		return $this->authKey;
	}

	public function getGuzzleClient() {
		return $this->guzzleClient;
	}

	public function __construct ($devId, $authKey){
		if (!$devId) {
			throw new \Exception("You need to pass a Dev Id");
		}

		if (!$authKey) {
			throw new \Exception("You need to pass an Auth Key");
		}

		$this->devId = $devId;
		$this->authKey = $authKey;
		$this->guzzleClient = new \GuzzleHttp\Client();
	}

	public function preferFormat($format) {
		$this->returnArrays = strtolower($format) == 'array';
	}

	public function useLanguage($languageCode) {
		// TODO: Write language mapping function
	}

	public function request() {
		$args = func_get_args();
		$method = substr($args[0], 1);
		$signature = $this->createSignature($method);
		if ($this->checkSession()) {
			$session = $this->createSession();
		}
		// TODO:: Finish Request implementation.
	}

	/**
	 * @param	string Pre-stripped method name
	 * @return	string
	 */
	private function createSignature($method) {
		return md5($this->getDevId().$method.$this->getAuthKey().self::createTimestamp());
	}

	private function checkSession() {
		return time() - $this->sessionTimestamp > 900;
	}

	private function createSession() {
		$signature = $this->createSignature('createsession');
		$url = self::$smiteAPIUrl."/createsessionjson/".$this->getDevId()."/$signature/".self::createTimestamp();
		$response = $this->guzzleClient->get($url);
		$body = $response->getBody();
		return $body->session_id;
	}

	private static function createTimestamp() {
		$datetime = new \DateTime('Now', \DateTimeZone::UTC);
		return $datetime->format('YmdHis');
	}
}
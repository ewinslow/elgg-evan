<?php
namespace Evan\Http;


interface Session {
	public function getLoggedInUser();
	
	public function getLoggedInUserGuid();
	
	public function assertAdminLoggedIn();
}
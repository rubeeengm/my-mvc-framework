<?php
declare(strict_types=1);

namespace app\core;

class Response {

    /**
     * Set http response code
     * @param int $code
     */
	public function setStatusCode(int $code) {
		http_response_code($code);
	}

    /**
     * Redirect the application to other url
     * @param String $url
     */
	public function redirect(String $url) : void {
	    header('Location: ' . $url);
    }
}

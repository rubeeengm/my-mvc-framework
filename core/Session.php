<?php
declare(strict_types=1);

namespace app\core;

class Session {
    protected const FLASH_KEY = 'flash_messages';

    /**
     * Session constructor.
     */
    public function __construct() {
        session_start();

        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            // Mark to be removed
            $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * Session destructor
     */
    public function __destruct() {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * Set message with key value in session
     * @param string $key
     * @param string $message
     */
    public function setFlash(string $key, string $message) : void {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false
            , 'value' => $message
        ];
    }

    /**
     * Get the value of flash message
     * @param $key
     * @return string
     */
    public function getFlash($key) : string {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? '';
    }
}
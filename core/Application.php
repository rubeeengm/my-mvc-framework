<?php
declare(strict_types=1);

namespace app\core;

class Application {
	public Router $router;
	public Request $request;
	public Response $response;
	public Session $session;

	public static string $ROOT_DIR;
	public static Application $app;

	public Controller $controller;

	public Database $database;

    /**
     * Application constructor.
     * @param String $rootPath
     * @param array $config
     */
	public function __construct(String $rootPath, array $config) {
		self::$ROOT_DIR = $rootPath;
		self::$app = $this;

		$this->request = new Request();
		$this->response = new Response();
		$this->session = new Session();
		$this->router = new Router($this->request, $this->response);
		$this->database = new Database($config['db']);
	}

	public function run() {
		echo $this->router->resolve();
	}

    /**
     * @return Controller
     */
    public function getController(): Controller {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void {
        $this->controller = $controller;
    }
}

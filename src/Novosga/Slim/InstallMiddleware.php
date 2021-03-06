<?php
namespace Novosga\Slim;

use \Novosga\SGAContext;

/**
 * SlimFramework middleware para verificar
 * se o Novo SGA está instalado
 * 
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class InstallMiddleware extends \Slim\Middleware {
    
    private $context;
    
    public function __construct(SGAContext $context) {
        $this->context = $context;
    }
    
    public function call() {
        $req = $this->app->request();
        $uri = $req->getResourceUri();
        $installed = NOVOSGA_INSTALLED;
        if (!$installed && !self::isInstallPage($uri)) {
            $this->app->redirect($req->getRootUri() . '/install');
        } else if ($installed && self::isInstallPage($uri)) {
            $this->app->redirect($req->getRootUri() . '/login');
        } else {
            $this->next->call();
        }
    }
    
    public static function isInstallPage($uri) {
        return substr($uri, 0, 8) === '/install';
    }
    
}
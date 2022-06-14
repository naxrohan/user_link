<?php
namespace Drupal\user_link;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Description of AuthTokenLogin
 *
 * @author Rohan
 */
class AuthTokenLogin implements HttpKernelInterface {
    
    /**
     * The kernel.
     *
     * @var HttpKernelInterface
     */
    protected $httpKernel;

    /**
     * Constructs the FirstMiddleware object.
     *
     * @param HttpKernelInterface $http_kernel
     *   The decorated kernel.
     */
    public function __construct(HttpKernelInterface $http_kernel) {
        $this->httpKernel = $http_kernel;
    }
    
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true) {
        $urlStr = $request->getUri();
        
        $url_parts = parse_url($urlStr);
        parse_str($url_parts['query'], $query);
        
        
        if(isset($query['authtoken'])){
            $auth_token = $query['authtoken'];
            
            //todo: lookup & validate
            //todo: do login for the user account & redirect to the home page..?
            var_dump($auth_token);
            var_dump($request->getClientIp());
            
            return new Response($this->t('hello world!! authtoken found...'), 403);
            
        }
    }

}

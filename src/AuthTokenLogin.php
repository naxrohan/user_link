<?php
namespace Drupal\user_link;

use Drupal\user\Entity\User;
use Drupal\user_link\AuthToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Description of AuthTokenLogin
 *
 * @author Rohan
 */
class AuthTokenLogin implements HttpKernelInterface {

    /**
     *
     * @var type
     */
    private $argument_name = 'authtoken';

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

    /**
     *
     * @param Request $request
     * @param type $type
     * @param type $catch
     * @return \Drupal\user_link\Response
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true) {
        $urlStr = $request->getUri();
        $url_parts = parse_url($urlStr);
        parse_str($url_parts['query'], $query);
        if(isset($query[$this->argument_name])){
            $auth_token = $query[$this->argument_name];

            //todo: lookup & validate
            $auth = new AuthToken();
            $userFound = $auth->lookUpToken($auth_token);
            if(isset($userFound)){
                //fixme: do login for the user account & redirect to the home page..?
                $account = User::load($userFound);
//                user_login_finalize($account);
//                dump($account);
//                return RedirectResponse::create(Url::fromUri('<front>'),302);
            }

        }
         return $this->httpKernel->handle($request, $type, $catch);
    }

}

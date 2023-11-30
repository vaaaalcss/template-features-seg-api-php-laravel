<?php

namespace App\Http\Middleware;

header_remove('x-powered-by');

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Stevebauman\Purify\Facades\Purify;

class SymmetricEncryptionDecryption
{
    private $app;
    protected $cipher = 'AES-256-CBC';
    protected $secret = 'oNSSASxLVso2ayG9gefIaDqn89y63z8C'; // 32 characters length
    protected $encryptApi = true;
    protected $noApplyToUrls = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle($request, Closure $next)
    {
        if( $request->ajax() ){

            $newRequest = $request;
            $checkConfig = $this->encryptApi === true &&
                          !$this->checkIgnoredUrls($request);

            if( $checkConfig ){

                $containsDataEncrypted = $request->has('encrypted') ||
                                         $request->has('encryptedParams');

                if( $containsDataEncrypted ) {

                    $params = $request->query->all();
                    $content = $request->getContent();

                    if( $request->has('encrypted') ){
                        $content = json_decode(
                            $request->getContent(),
                            true
                        );
                        $content = self::decrypt($content['encrypted']);
                    }

                    if( $request->has('encryptedParams') ){
                        $params = json_decode(
                            self::decrypt($params['encryptedParams']),
                            true
                        );
                    }

                    $baseRequest = new SymfonyRequest();
                    $baseRequest->initialize(
                        $params,
                        $request->request->all(),
                        $request->attributes->all(),
                        $request->cookies->all(),
                        $request->files->all(),
                        $request->server->all(),
                        $content
                    );

                    $newRequest = Request::createFromBase($baseRequest);
                    $this->app->instance(Request::class, $newRequest);
                }

                $response = $next($newRequest);

                return response(
                    [
                        'encrypted' => self::encrypt($response->original)
                    ]
                );

            }

            return $next($request);

        } else {
            abort(401);
        }
    }

    public function decrypt($content)
    {
        $info = explode('|', $content);

        $encrypted = $info[0];
        $iv = base64_decode($info[1]);

        $decrypted = openssl_decrypt(
            $encrypted,
            $this->cipher,
            $this->secret,
            $options = 0,
            $iv
        );

        return json_decode( Purify::clean($decrypted) );
    }

    public function encrypt($response)
    {
        $iv = $this->getIv( openssl_cipher_iv_length($this->cipher) );

        $encrypted = openssl_encrypt(
            json_encode($response),
            $this->cipher,
            $this->secret,
            $options = 0,
            $iv
        );

        return $encrypted.'|'.base64_encode($iv);
    }

    protected function getIv($length)
    {
        $iv = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for( $i = 0; $i < $length; $i++ ) {
            $iv .= $characters[ mt_rand(0, strlen($characters) - 1) ];
        }

        return $iv;
    }

    protected function checkIgnoredUrls(Request $request)
    {
        foreach( $this->noApplyToUrls as $url ) {
            if ( $url !== '/' ) {
                $url = trim($url, '/');
            }

            if ( $request->fullUrlIs($url) || $request->is($url) ) {
                return true;
            }
        }

        return false;
    }
}

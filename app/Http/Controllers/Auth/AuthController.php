<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Traits\AdminTrait;
use App\Models\User;
use App\Models\RegUser;
use App\Models\RegRol;
use League\OAuth2\Client\Provider\GenericProvider;
use LonghornOpen\LaravelCelticLTI\LtiTool;
use \Firebase\JWT\JWT;




class AuthController extends Controller
{
    use AdminTrait;
    //Ver pantalla login
    public function index()
    {
        return view('auth.login');
    } 
      
    //valida Login
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //$credentials = $request->only('email', 'password');
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'bloqueado' => 0])) {
            $user = DB::select("CALL sp_autenticado('".$request->email."')");
            Session::put('user',$user);
            //dd($request->session()->get('user'));
            //return view('home');
            if($user){
                if($user[0]->email_verified_at == null){
                    return back()->with('fail', __('El correo electrónico no ha sido validado'));

                }elseif($user[0]->completa_datos == 1 && $user[0]->usuario_cct_id!=null){//si ya completó sus datos, se va directamente al dashboard

                    return redirect()->route('assemble',[$user[0]->usuario_cct_id]);
                
                }else{//de lo contrario se va a completar datos

                    return redirect()->route('home');
                }
            }else{
                return redirect()->route('home');
            }
        }
        return back()->with('fail', __('These credentials do not match our records.'));
        //dd($credentials);
    }
      
    //ver pantalla del reset
    public function reset()
    {
        return view('auth.passwords.reset');
    }
    
    //salir
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    // Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google callback
    public function handleGoogleCallback()
    {

        $user = Socialite::driver('google')->user();
        //dd($user);
        return $this->_registerOrLoginUser($user);

    }

    // Facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        //dd($user);
        return $this->_registerOrLoginUser($user);

    }

    // Microsoft login
    public function redirectToMicrosoft()
    {
        return Socialite::driver('azure')->redirect();
    }

    // Microsoft callback
    public function handleMicrosoftCallback()
    {
        $user = Socialite::driver('azure')->user();
        return $this->_registerOrLoginUser($user);

    }

    public function handleMeeCallback()
    {
        $user = $this->redirectToMee();
        //dd($user);
        return $this->_registerOrLoginUser($user);

    }

    //Mee login
    public function redirectToMee(){
        $code_challenge=$this->base64_urlencode(Str::random(43));
        //dd($code_challenge);

        //Productivo
        $provider = new GenericProvider([
            'response_type'           =>'code',
			'clientId'                => '46',    // The client ID assigned to you by the provider
			'clientSecret'            => '7050D133-D4C2-4EDD-A3ED-B551063DA6BA',   // The client password assigned to you by the provider
			'redirectUri'             => 'https://servicios.macmillanlatam.com/login/mee',
			'urlAuthorize'            => 'https://identity.macmillaneducationeverywhere.com/connect/authorize',
			'urlAccessToken'          => 'https://identity.macmillaneducationeverywhere.com/connect/token',
			'urlResourceOwnerDetails' => 'https://identity.macmillaneducationeverywhere.com/connect/userinfo',
            'code_challenge'          => $code_challenge,
            'state'                   => Str::random(10)
		]);

        //Desarrollo
        /*$provider = new GenericProvider([
			'clientId'                => '46',    // ID que proporcionó mee
			'clientSecret'            => 'DB39E735-9EB3-4645-9C4B-92517342D7FF',   // tambien proporcionado por mee
			'redirectUri'             => 'https://desarrollo360.macmillan.com.mx/manager-dev1/index.php/mee_sso/callbacktest',
			'urlAuthorize'            => 'https://identity-uat.macmillaneducationeverywhere.com/connect/authorize',
			'urlAccessToken'          => 'https://identity-uat.macmillaneducationeverywhere.com/connect/token',
			'urlResourceOwnerDetails' => 'https://identity-uat.macmillaneducationeverywhere.com/connect/userinfo'
		]);*/


        //dd($request->code);
        
        // If we don't have an authorization code then get one
        if (!isset($_GET['code'])) {
        
            // Fetch the authorization URL from the provider; this returns the
            // urlAuthorize option and generates and applies any necessary parameters
            // (e.g. state).
            $authorizationUrl = $provider->getAuthorizationUrl([
				'scope' => ['openid']
			]);
        
            // Get the state generated for you and store it to the session.
            $_SESSION['oauth2state'] = $provider->getState();
        
            // Redirect the user to the authorization URL.
            header('Location: ' . $authorizationUrl);

            exit;
        
        // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {
        
            if (isset($_SESSION['oauth2state'])) {
                unset($_SESSION['oauth2state']);
            }
        
            exit('Invalid state');
        
        } else {
        
            try {
        
                // Try to get an access token using the authorization code grant.
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
        
                // We have an access token, which we may use in authenticated
                // requests against the service provider's API.
                // echo 'Access Token: ' . $accessToken->getToken() . "<br>";
                // echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
                // echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
                // echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";
        
                // Using the access token, we may look up details about the
                // resource owner.
                $resourceOwner = $provider->getResourceOwner($accessToken);
                $result = $resourceOwner->toArray();
        
                //var_export($resourceOwner->toArray()
                $data = [
                    'id' => $result['SessionId'],
                    'name' => $result['given_name'],
                    'lastname' => $result['family_name'],
                    'email' => $result['email'],
                    'nickname' => $result['name'],
                    'token' => $accessToken->getToken()
                ];

                //dd($data);

                // The provider provides a way to get an authenticated API request for
                // the service, using the access token; it returns an object conforming
                // to Psr\Http\Message\RequestInterface.
                $request = $provider->getAuthenticatedRequest(
                    'GET',
                    'https://service.example.com/resource',
                    $accessToken
                );

                //return $accessToken;

                $object=(object)$data;
                //dd($object);
                return $object;
        
            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        
                // Failed to get the access token or user details.
                exit($e->getMessage());
        
            }
        
        }

    }

    public function redirectToLtiMee(Request $request) {

        //Revisar que estos valores sean los correctos y hagan match con la documentacion de https://www.imsglobal.org/spec/lti/v1p3
        $message_jwt = [
            "iss" => 'https://testservicios.macmillanlatam.com',
            "aud"=>  ["7050D133-D4C2-4EDD-A3ED-B551063DA6BA"],
            "sub" => '46',
            "exp" => time() + 600,
            "iat" => time(),
            "nonce" => uniqid("nonce"),
            "https://purl.imsglobal.org/spec/lti/claim/deployment_id" => '9a031ee6-685f-4e5b-8f73-785c88ce2aed',
            "https://purl.imsglobal.org/spec/lti/claim/message_type" => "LtiResourceLinkRequest",
            "https://purl.imsglobal.org/spec/lti/claim/version" => "1.3.0",
            "https://purl.imsglobal.org/spec/lti/claim/target_link_uri" =>"https://lti-uat.macmillaneducationeverywhere.com/session",
            "https://purl.imsglobal.org/spec/lti/claim/roles" => [
                "http://purl.imsglobal.org/vocab/lis/v2/membership#Instructor"
            ],
            "https://purl.imsglobal.org/spec/lti/claim/resource_link" => [
                "id" => "9a031ee6-685f-4e5b-8f73-785c88ce2aed",
            ],
            "https://purl.imsglobal.org/spec/lti-nrps/claim/namesroleservice" => [
                "context_memberships_url" => "http://localhost/platform/services/nrps",
                "service_versions" => ["2.0"]
            ],
            "https://purl.imsglobal.org/spec/lti-ags/claim/endpoint" => [
                "scope" => [
                  "https://purl.imsglobal.org/spec/lti-ags/scope/lineitem",
                  "https://purl.imsglobal.org/spec/lti-ags/scope/result.readonly",
                  "https://purl.imsglobal.org/spec/lti-ags/scope/score"
                ],
                "lineitems" => "http://localhost/platform/services/ags/lineitems.php",
            ]
        ];

    

        // Realiza la redirección directamente
        return redirect()->to($request->input('redirect_uri'))
            ->with('id_token', $message_jwt)
            ->with('state', $request->input('state'));
    }
    

    
    public function handleLtiCallback(Request $request)
    {
        $state = $request->session()->pull('sso_state');

        if (!$state || $state !== $request->input('state')) {
            // Comprobar que el estado sea válido para protección CSRF
            abort(403, 'Invalid state');
        }

        $response = Http::asForm()->post('URL_DEL_LMS/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.lms.client_id'),
            'client_secret' => config('services.lms.client_secret'),
            'redirect_uri' => config('services.lms.redirect'),
            'code' => $request->input('code'),
        ]);

        $accessToken = $response->json('access_token');

        // Usa el token de acceso para autenticar al usuario en tu aplicación Laravel
        // Puedes guardar el token de acceso en la sesión o en una base de datos
    }

    function base64_urlencode($str) {
        
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }

    function sha256($code) {
        return Hash::make($code);
    }

    protected function _registerOrLoginUser($data)
    {
        //dd($data->token);
        $user = User::where('email', $data->email)->first();
        //dd($user);

        if (!$user) {

            $user = User::create([
                'email' => $data->email,
                'provider_id' =>  $data->id,
                'confirmation_code' => Str::random(25)
            ]);

            $register_user = RegUser::create([
                'nombres' => $data->name,
                'correo' => $data->email,
                'tokenredessociales' => $data->token,
                'usuario_id' => $user->id,//toma el id del usuario que se acaba de crear
            ]);

        }
        //dd($data);
        //actualizamos en token de redes sociales si ya existe el usuario
        $regUser = RegUser::where('correo', $data->email)->first();
        $regUser->tokenredessociales = $data->token;

        Auth::login($user, true);
        $login = DB::select("CALL sp_autenticado('".$data->email."')");
        if($login[0]->completa_datos == 1){//si ya completo sus datos, se va directamente al dashboard
            return redirect()->route('assemble',['usuario_id'=>$user[0]->usuario_cct_id]);
        
        }else{//de lo contrario se va a completar datos
            
            return redirect()->route('home');
        }
       
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function helpdesk(){
        return view('helpdesk');
    }

    public function busca_cuenta(Request $request){
        $data = DB::select("CALL sp_HDconsulta('".$request->email."')");
        //return view('helpdesk',compact('data'));

        if($data){
            return view('helpdesk',['data'=>$data]);
        }else{
            return redirect()->route("helpdesk")->with('fail','No se encontraron coincidencias con su búsqueda');
        }
        
        //dd($login);
    }

    public function valida_cuenta($idusuario){
        $usuario = User::where('id', $idusuario)->first();
        $usuario->confirmation_code = NULL;
        $usuario->email_verified_at =  now();
        $usuario->save();

        return redirect()->route("helpdesk")->with('success','cuenta de usuario validada '.$usuario->email);
    }

    public function valida_cuenta_mesa_ayuda($idusuario){
        $usuario = User::where('id', $idusuario)->first();
        $usuario->confirmation_code = NULL;
        $usuario->email_verified_at =  now();
        $usuario->save();

        return back()->withInput();
    }

    // public function test(Request $request)
    // {
        
    //     if (Auth::check()) {
    //         echo 'The user is logged in...';
    //     }

    //     $user2 = Auth::user();
	// 	$user = $request->user();
    //     print_r($user);
    //     print_r($user2);
	// 	return 'listo';
	// }

}

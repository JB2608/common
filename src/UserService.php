<?php


namespace Microservices;


use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class UserService
{
    private $USERS_MICROSERVICE_API;

    public function __construct()
    {
        $this->USERS_MICROSERVICE_API = env('USERS_MICROSERVICE_ENDPOINT');
    }

    public function headers(){
        return [
            'Authorization' => request()->headers->get('Authorization'),
        ];
    }

    public function request() {
        return Http::withHeaders($this->headers());
    }

    /*  public function parseUser($json): User{
        $user = new User();
        $user->id = $json['id'];
        $user->nombre = $json['nombre'];
        $user->a_pat = $json['a_pat'];
        $user->a_mat = $json['a_mat'];
        $user->email = $json['email'];
        $user->is_promotor = $json['is_promotor'];

        return $user;
    }
    */

    public function getUser()
    {

        $response = Http::withHeaders($this->headers())->get(self::USERS_MICROSERVICE_API . '/user');
        $json = $response->json();

        return new User($json);

    }

    public function isAdmin(){

        return Http::withHeaders($this->headers())->get(self::USERS_MICROSERVICE_API . '/admin')->successful();
    }

    public function isPromotor(){

        return Http::withHeaders($this->headers())->get(self::USERS_MICROSERVICE_API . '/promotor')->successful();
    }

    public function allows($action, $route){
        return Gate::forUser($this->getUser())->authorize($action, $route);
    }

    public function all($page){
        return Http::withHeaders($this->headers())->get(self::USERS_MICROSERVICE_API . '/users?page=' . $page)->json();

    }

    public function get($id): User{
       $json = Http::withHeaders($this->headers())->get(self::USERS_MICROSERVICE_API . '/users/' . $id)->json();
        return new User($json);
    }

    public function create($data){
        $json = Http::withHeaders($this->headers())->post(self::USERS_MICROSERVICE_API . '/users', $data)->json();
        return new User($json);
    }

    public function update($id, $data){
        $json = Http::withHeaders($this->headers())->put(self::USERS_MICROSERVICE_API . '/users/' . $id, $data)->json();
        return new User($json);
    }

    public function delete($id){
        return Http::withHeaders($this->headers())->delete(self::USERS_MICROSERVICE_API . '/users/' . $id)->successful();
    }

}

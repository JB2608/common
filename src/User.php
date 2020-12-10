<?php

namespace Microservices;



class User
{
    public $id;
    public $nombre;
    public $a_pat;
    public $a_mat;
    public $email;
    public $is_promotor;


    public function __construct($json)
    {
        $this->id = $json['id'];
        $this->nombre = $json['nombre'];
        $this->a_pat = $json['a_pat'];
        $this->a_mat = $json['a_mat'];
        $this->email = $json['email'];
        $this->is_promotor = $json['is_promotor'] ?? 0;
    }


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function isAdmin(): bool {
        return $this->is_promotor === 0;
    }

    public function isPromotor(): bool{
        return $this->is_promotor === 1;
    }



   public function fullName(){
        return $this->nombre . ' ' . $this->a_pat . ' ' . $this->a_mat;
    }


}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }


    public function seguidores()
    {
        return $this->hasMany(Seguidor::class, 'usuario_id');
    }

    public function seguidos()
    {
        return $this->hasMany(Seguidor::class, 'usuario_seguido_id');
    }

    public function noticias()
    {
        return $this->hasMany(Noticia::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function mensajesEnviados(){
        return $this->hasMany(Mensaje::class, 'emisor_id');
    }

    public function mensajesRecibidos(){
        return $this->hasMany(Mensaje::class, 'receptor_id');
    }

}

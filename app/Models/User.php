<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user',
        'name',
        'email',
        'password',
        'rol',
        'id_organization',
        'id_logistics_center',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'id_organization');
    }
    public function movements()
    {
        return $this->hasMany(Movement::class, 'id_user');
    }
    public function logisticsCenter()
    {
        return $this->belongsTo(LogisticsCenter::class, 'id_logistics_center');
    }
    /**
     *Create a new user with an organization in a single transaction.
     *
     * @param array $userData
     * @param string $organizationName
     * @return \App\Models\User
     */
    public static function createWihtOrganization(array $userData, string $organizationName)
    {
        DB::beginTransaction();

        try {
            
            // Crea la organización
            $organization = Organization::create([
                'organizationName' => strtolower($organizationName),
            ]);

            // Crea el usuario asignando el ID de la organización
            $userData['id_organization'] = $organization->id;
            $user = static::create($userData);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public static function createUser(array $userData)
    {

        $user = static::create($userData);

        return $user;
    }
    public static function alterPass($userData)
    {
        $user = static::where("id", $userData["id"])->first();
        $user->password = $userData["password"];
        // dd($user->save());
        $user->save();
    }

   
}

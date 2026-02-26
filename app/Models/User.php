<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'type',
        'is_active',
        'code',
        'expire_at',
        'fcm_token',
        'email_verified_at',
        'category_excursion_id',
        'arrival_date',
        'departure_date',
        'language',
        'city_id',
        'hotel_id',
        'sub_category_excursion_id'
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
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'type'              => \App\Enums\UserType::class,
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'tour_leader_files', 'user_id', 'file_id');
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'tour_leader_hotels', 'user_id', 'hotel_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function categoryExcursion()
    {
        return $this->belongsTo(CategoryExcursion::class, 'category_excursion_id', 'id');
    }

    public function subCategoryExcursion()
    {
        return $this->belongsTo(SubCategoryExcursion::class, 'sub_category_excursion_id', 'id');
    }

    public function OrderStatus()
    {
        return $this->hasMany(OrderStatus::class, 'user_id', 'id');
    }



public function getRelevantOrders()
{

    if ($this->type->value === 'representative') {
        $hotelIds = $this->hotels()->pluck('hotels.id');

        return \App\Models\Order::whereIn('hotel_id', $hotelIds)
            ->with('status')
            ->latest()
            ->get();
    }

    if ($this->type->value === 'supplier') {
        return $this->OrderStatus()->with('order')->latest()->get()->map(function($os) {
            return $os->order;
        });
    }
    return collect();
}

}

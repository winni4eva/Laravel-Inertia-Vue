<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Float_;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'url',
        'email',
        'rating'
    ];

    /** 
    * The accessors to append to the model's array form. 
    * 
    * @var array 
    */ 
    protected $appends = ['rating', 'ratingCount', 'userRating'];

    /**
     * A collection of ratings for a company
     *
     * @return HasMany
     */
    public function filterQuery(Request $request)
    {
        $query = $this->query()->with('ratings');
        
        if ($request->has('name') && $request->get('name')) {
            $searchTerm = $request->get('name');
            $query = $query->where('name', 'like', "%".$searchTerm."%");
        }

        if ($request->has('rating_min') && $request->get('rating_min')) {
            $minRating = $request->get('rating_min');
            $query = $query->orWhereHas('ratings', function ($query) use($minRating) {
                $query->where('rating', '>=', $minRating);
            });
        }

        if ($request->has('rating_max') && $request->get('rating_max')) {
            $maxRating = $request->get('rating_max');
            $query = $query->orWhereHas('ratings', function ($query) use($maxRating) {
                $query->where('rating', '<=', $maxRating);
            });
        }
        
        return $query->orderBy('companies.id', 'desc')
            ->paginate($request->get('per_page', 10));
    }

    /**
     * A collection of ratings for a company
     *
     * @return HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /** 
    * An average rating of a company
    *
    * @return float 
    */ 
    public function getRatingAttribute() { 
        $sumRatings = $this->ratings()->sum('rating');
        $ratingCount = $this->ratings()->count() ?: 1;
        
        return $sumRatings / $ratingCount; 
    }

    /** 
    * The total rating received by a company 
    *
    * @return int 
    */ 
    public function getRatingCountAttribute() { 
        return $this->ratings()->count(); 
    }

    /** 
    * The logged in users rating for a company 
    *
    * @return int 
    */ 
    public function getUserRatingAttribute() { 
        $rating = $this->ratings()
            ->where(['user_id' => auth()->user()->id ?? 0])
            ->pluck('rating'); 
        
        return (int)collect($rating)->first();
    }   

}

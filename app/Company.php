<?php

namespace App;

use App\Comment as Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    protected $table = 'companies';

    const STATUS_ENABLE = 1;

    protected $fillable = [
        'name', 'slug', 'type', 'size', 'address', 'logo', 'status'
    ];

    /**
     * Get the comments for the company post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'company_id', 'id');
    }

    /***
     * Get list company with pagination
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListCompany()
    {
        $companies = DB::table('companies as co')
            ->select('co.id', 'co.name', 'co.slug', 'co.type', 'co.size', 'co.address',
                'co.logo', DB::raw('COUNT(c.company_id) AS total_comment'), DB::raw('AVG(c.star) AS avg_star'))
            ->leftJoin('comments as c', function ($leftJoin) {
                $leftJoin->on('c.company_id', '=', 'co.id');
                $leftJoin->where('c.status', self::STATUS_ENABLE);
            })
            ->where('co.status', self::STATUS_ENABLE)
            ->groupBy('co.id')
            ->orderByRaw(DB::raw('COALESCE(GREATEST(co.created_at, MAX(c.created_at)), co.created_at) DESC'))
            ->paginate(25);
        return $companies;
    }

    /***
     * Search company
     *
     * @param string $textSearch
     * @return bool|\Illuminate\Support\Collection
     */
    public function searchCompany(string $textSearch)
    {
        if (empty($textSearch)) {
            return false;
        }
        return DB::table('companies as co')
            ->select('co.id', 'co.name', 'co.slug', 'co.type', 'co.size', 'co.address', 'co.logo')
            ->where('co.name', 'LIKE', '%' . $textSearch . '%')
            ->where('co.status', self::STATUS_ENABLE)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function getCompanyDetail(string $slug)
    {
        return DB::table('companies as co')
            ->select('co.id', 'co.name', 'co.slug', 'co.type', 'co.size', 'co.address',
                'co.logo', DB::raw('COUNT(c.company_id) AS total_comment'),  DB::raw('AVG(c.star) AS avg_star'))
            ->leftJoin('comments as c', function ($leftJoin) {
                $leftJoin->on('c.company_id', '=', 'co.id');
                $leftJoin->where('c.status', self::STATUS_ENABLE);
            })
            ->where('co.slug', $slug)
            ->where('co.status', self::STATUS_ENABLE)
            ->groupBy('co.id')
            ->first();
    }

}

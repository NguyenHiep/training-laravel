<?php

namespace App;

use App\Company as Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use SoftDeletes;

    const STATUS_ENABLE = 1;

    protected $table = 'comments';

    protected $fillable = [
        'company_id', 'parent_id', 'reviewer', 'position', 'content',
        'reaction', 'star', 'status'
    ];

    /**
     * Get the company that owns the comment.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /***
     * Get latest comment
     *
     * @return \Illuminate\Support\Collection
     */
    public function getLatestComment()
    {
        $comments = DB::table('comments as c')
            ->select('c.id', 'c.reviewer', 'c.content', 'c.created_at', 'co.name as company_name', 'co.slug')
            ->join('companies as co', function ($join) {
                $join->on('co.id', '=', 'c.company_id')
                    ->where('co.status', self::STATUS_ENABLE);
            })
            ->where('c.status', self::STATUS_ENABLE)
            ->orderBy('id', 'desc')
            ->limit(7)
            ->get();
        return $comments;
    }

    /***
     * Get comment by company id
     *
     * @param int $companyId
     * @return \Illuminate\Support\Collection
     */
    public function getCommentByCompanyId(int $companyId)
    {
        $comments = DB::table('comments as c')
            ->select('c.id', 'c.reviewer', 'c.content', 'c.position', 'c.reaction', 'c.created_at')
            ->join('companies as co', function ($join) {
                $join->on('co.id', '=', 'c.company_id')
                    ->where('co.status', self::STATUS_ENABLE);
            })
            ->where('c.company_id', $companyId)
            ->where('c.status', self::STATUS_ENABLE)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $comments;
    }

}

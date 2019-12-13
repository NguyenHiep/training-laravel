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
        'company_id', 'reviewer', 'position', 'content', 'star', 'status'
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
        return DB::table('comments as c')
            ->select('c.id', 'c.reviewer', 'c.star', 'c.content', 'c.created_at', 'co.name as company_name', 'co.slug')
            ->join('companies as co', function ($join) {
                $join->on('co.id', '=', 'c.company_id')
                    ->where('co.status', self::STATUS_ENABLE);
            })
            ->where('c.status', self::STATUS_ENABLE)
            ->orderBy('id', 'desc')
            ->limit(15)
            ->get();
    }

    /****
     * Get comment by $companyId
     * @param int $companyId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCommentByCompanyId(int $companyId)
    {
        return DB::table('comments as c')
            ->select('c.id', 'c.reviewer', 'c.star', 'c.content', 'c.position', 'c.created_at')
            ->join('companies as co', function ($join) {
                $join->on('co.id', '=', 'c.company_id')
                    ->where('co.status', self::STATUS_ENABLE);
            })
            ->where('c.company_id', $companyId)
            ->where('c.status', self::STATUS_ENABLE)
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function getCommentReply(int $commentId)
    {
        return DB::table('comments_reply as cr')
            ->select('cr.id', 'cr.reviewer', 'cr.content', 'cr.reaction', 'cr.created_at')
            ->join('comments as c', function ($join) {
                $join->on('c.id', '=', 'cr.comment_id')
                    ->where('c.status', self::STATUS_ENABLE);
            })
            ->where('cr.comment_id', $commentId)
            ->where('cr.status', self::STATUS_ENABLE)
            ->orderBy('cr.id', 'desc')
            ->paginate(5, ['*'], 'p');
    }

}

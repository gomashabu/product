<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Claim extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'claim',
        'row_number',
        'user_id',
        'post_id',
        ];
        
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    // 行ごとの配列としてclaimをget
    public function getClaimsByRows($postId){
        $claimsForPost  = $this::with('post')->where('post_id', $postId)->get();
        $claimsRows = $claimsForPost->unique('row_number')->pluck('row_number');
        $claimsByRow = [];
        
        foreach($claimsRows as $claimsRow){
            $claimsArray = $claimsForPost->where('row_number', $claimsRow);
            $claimsByRow[$claimsRow] = $claimsArray;
        }
        return $claimsByRow;
    }
    
    // claimの結びついている行をget
    public function getClaimsRows($postId){
        $claimsForPost  = $this::with('post')->where('post_id', $postId)->get();
        return $claimsForPost->unique('row_number')->pluck('row_number');
    }
    
    // あるユーザーのあるポストに対する注釈を行ごとに配列にして取得
    public function getClaimOfThisUser($postId, $userId){
        $claimsOfThisUser = $this::with('post')->where('post_id', $postId)->where('user_id', $userId)->get();
        $claimsOfThisUserByRow = [];
        foreach($claimsOfThisUser as $claim){
            $claimsOfThisUserByRow[$claim['row_number']]=$claim['claim'];
        }
        return $claimsOfThisUserByRow;
    }
}

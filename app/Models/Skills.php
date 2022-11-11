<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_title'
        , 'provider_id'
    ];

    public function saveSkillsSet($provider_id,$skillsSets){

        $skillsSets = explode(',',$skillsSets);
        self::where('provider_id',$provider_id)->whereNotIn('skill_title',$skillsSets)->delete();

        if(count($skillsSets)>0){
            foreach($skillsSets as $skill){
                if( in_array($skill,getSkillList()) ){
                    self::updateOrCreate(['provider_id'=>$provider_id,'skill_title'=>$skill],['skill_title'=>$skill]);
                }
            }

        }
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BugStatus extends Model
{
    protected $fillable = [
        'title',
        'created_by',
        'order',
    ];

    public function bugs($project_id)
    {
      if(\Auth::user()->type == 'company')
        return Bug::where('status', '=', $this->id)->where('project_id', '=', $project_id)->orderBy('order')->get();
      elseif(\Auth::user()->type == 'client'){
        return Bug::where('status', '=', $this->id)->where('project_id', '=', $project_id)->orderBy('order')->get();
      }
      else
        return Bug::where('status', '=', $this->id)->where('project_id', '=', $project_id)->whereRaw(Utility::csvContainsExpression('assign_to'), [(string) \Auth::user()->id])->orderBy('order')->get();
    }

    public function assign_bugs($project_id)
    {
        return Bug::where('status', '=', $this->id)->where('project_id', '=', $project_id)->where('assign_to', '=', \Auth::user()->id)->orderBy('order')->get();
    }
}

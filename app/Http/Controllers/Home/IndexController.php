<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Admin\Match;
use App\Information;
use App\Rater_match;
use App\Production;

class IndexController extends Controller
{
    /**
     * 首页
     * @param  Request     $request [description]
     * @param  Match       $match   [description]
     * @param  Information $info    [description]
     * @return [type]               [description]
     */
    public function index(Request $request, Match $match, Information $info)
    {
        $res = $match->when(isset($request->status), function ($query) use ($request) {
            return $query->where('status', $request->status);
        }, function ($query) use ($request) {
            return $query->whereIn('status', [2,3,4,5]);
        })->whereIn('cat',[0,1])->orderBy('push_time', 'desc')->orderBy('id', 'desc')->Paginate(12);

        $news = $info->orderBy('created_at', 'desc')->limit(9)->get();
        
        return view('home.index.index', ['matches'=>$res,'news'=>$news,'status'=>$request->status]);
    }
    



    public function review_score(Request $request, Production $production)
    {
        return  $production->review_score($request);
    }

   
    /**
     * 资讯详情页
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function news(Request $request, $id)
    {
        try {
            $new = \DB::table('information')->find($id);
            if(!count($new)) return back();

            $data = [];

            if ($new->type == 1) {
                $win = \DB::table('win')->where('match_id',$new->match_id)->orderBy('no')->get();

                foreach ($win as $wv) {
                    $temp = array('name'=>$wv->name,'pic'=>[]);
                    $res = \DB::table('result')->select('production_id')->where('win_id',$wv->id)->get();
                    if(count($res)) {
                        $pid = [];
                        foreach ($res as $rv) {
                            $pid[] = $rv->production_id;
                        }
                        $pic = \DB::table('productions')->whereIn('id',$pid)->get();
                        if(count($pic)) {
                            $pic = $pic->toArray();
                            $temp['pic'] = $pic;
                        }
                    }
                    $data[] = $temp;
                }
            }
            return view('home.index.new', ['news'=>$new,'data'=>$data]);
        } catch (\Exception $e) {
            return view('home.index.new', ['news'=>$new,'data'=>$data]);
            return back();
        }
    }
}

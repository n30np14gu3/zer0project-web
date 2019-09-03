<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Ban;
use App\Models\Cheat;
use App\Models\PromoCode;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index(Request $request){
        if(!UserHelper::CheckAuth($request))
            return redirect()->route('logout');

        $data = [
            'user' => null,
            'user_bans' => null,
            'cheats' => Cheat::all(),
            'used_promo' => null,
            'subscriptions' => null
        ];

        $user = UserHelper::GetUser($request);
        $data['user'] = $user;

        $bans_db = Ban::where('user_id', $user->id)->where('active', 1)->where('is_lifetime', 1)->orWhere('end_date', '>', time())->get();
        $bans = [
            'has_bans' => count($bans_db) != 0,
            'bans' => []
        ];

        if($bans['has_bans']){
            foreach($bans_db as $ban){
                array_push($bans['bans'], [
                    'end_date' => $ban->is_lifetime ? 'Навсегда' : date("d-m-Y H:i:s", $ban->end_date),
                    'reason' => $ban->reason
                ]);
            }
        }
        $data['user_bans'] = $bans;

        $promo_db = PromoCode::where('user_id', $user->id)->get();
        $promo = [];
        foreach($promo_db as $p){
            array_push($promo, [
                'id' => $p->id,
                'token' => $p->promo,
                'game' => @Cheat::where('id', $p->cheat_id)->get()->first()
            ]);
        }

        $data['used_promo'] = $promo;

        $subscriptions_db = Subscription::where('user_id', $user->id)->get();
        $subscriptions = [];
        foreach($subscriptions_db as $s){
            array_push($subscriptions, [
                'base' => $s,
                'game' => @Cheat::where('id', $s->cheat_id)->get()->first()
            ]);
        }
        $data['subscriptions'] = $subscriptions;
        return view('pages.dashboard')->with(['data' => $data, 'logged' => UserHelper::CheckAuth($request)]);
    }

    public function download($id){
        $headers = [
            'Content-Type: application/zip, application/octet-stream'
        ];

        $cheat = @Cheat::where('id', $id)->get()->first();
        if(!$cheat)
            return back();

        return response()->download(storage_path("app/loaders/$cheat->loader_path"), 'loader.zip', $headers);

    }
}

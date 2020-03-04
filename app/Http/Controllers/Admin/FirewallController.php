<?php
// error_reporting(-1);

namespace App\Http\Controllers\Admin;

use App\ZoneSetting;
use App\Zone;
use App\Cfaccount;
use App\FirewallRule;
use App\wafGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Jobs\UpdateWAFGroup;
use App\Jobs\UpdateWAFPackage;
use App\Jobs\UpdateFirewallRule;
use App\Jobs\UpdateUaRule;
use App\Jobs\UpdateWAFRule;
use App\UaRule;

use App\wafRule;
use App\Jobs\FetchFirewallRules;
use App\Jobs\FetchUaRules;
use App\Jobs\UpdateSPWAF;
use App\Jobs\DeleteFirewallRule;
use App\Jobs\FetchWAFEvents;
use App\wafEvent;


use App\Jobs\DeleteUaRule;
class FirewallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($zone , Request $req)
    {   
		
		// ini_set('memory_limit', '-1');

        $zone=Zone::where('name',$zone)->first();

        //$cf = Cfaccount::where('id',$zone->cfaccount_id)->first();

       $cfaccount = new FetchFirewallRules($zone);
 
         // return $cf;
       // return "ok";

     $cfaccount->handle();
     

     $cfaccount2 = new FetchWAFEvents($zone);
 
         // return $cf;
       // return "ok";

	 $cfaccount2->handle();
	
      
        if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->user->owner OR auth()->user()->id == 1))
    {
            return abort(401);
    }

        
        $records=$zone->ZoneSetting;
        $zoneSetting=$zone->ZoneSetting;
        $minutes=0;
        if($minutes ==null)
        {
           // $minutes=$request->input('minutes');
           $minutes=1440;    
        }
        else
        {
            $minutes=1440;    
        }
        
        
         switch ($minutes) {
                    case 1440:
                        $timestamp = 'Last 24 Hours';
                        $xlabel= 'hour';
                        break;
                     case 10080:
                        $timestamp = 'Last 7 Days';
                        $xlabel= 'day';
                        break;
                     case 43200:
                        $timestamp = 'Last Month';
                        $xlabel= 'day';
                        break;
                    case 720:
                        $timestamp = 'Last 12 Hours';
                        $xlabel= '30m';
                        break;
                    case 360:
                        $timestamp = 'Last 6 Hours';
                        $xlabel= '15m';
                        break;
                    case 30:
                        $timestamp = 'Last 30 Minutes';
                        $xlabel= 'minute';
                        break;
                    
                    default:
                        $timestamp = 'Last 24 Hours';
                        $xlabel= 'hour';
                        break;
                }
        // foreach ($records as $record) {
        //     # code...
        //     dump($record->name);
        //     dump($record->content);
        //     dump($record->type);
        //     dump($record->type);
            
        // } 


         $wafPackages=$zone->wafPackage;
          $events=$zone->wafEvent->sortBy('timestamp')->take(50000);

          $used_id=$zone->id;
          // $count = DB::table('waf_events')->distinct('client_ip')->count('client_ip');


          //$groupedByValue =$zone->wafEvent->groupBy('client_ip')->take(10);

  

       //  dd($groupedByValue);


         $duplicates = DB::table('waf_events')
         ->select('client_ip', DB::raw('COUNT(client_ip) as `count` '))
         ->where('zone_id',$used_id )
         ->groupBy('client_ip')
         ->havingRaw('COUNT(client_ip) > 1')
         ->orderBy('count', 'DESC')
         ->take(5)
         ->get();


         $duplicates=json_decode($duplicates,true);

         $accounts = DB::table('waf_events')
         ->select('user_agent', DB::raw('COUNT(client_ip) as `counts` '))
         ->where('zone_id',$used_id )
         ->groupBy('user_agent')
         ->havingRaw('COUNT(user_agent) > 1')
         ->orderBy('counts', 'DESC')
         ->take(5)
         ->get();


         $accounts=json_decode($accounts,true);

         $paths = DB::table('waf_events')
         ->select('uri', DB::raw('COUNT(uri) as `countes` '))
         ->where('zone_id',$used_id )
         ->groupBy('uri')
         ->havingRaw('COUNT(uri) > 1')
         ->orderBy('countes', 'DESC')
         ->take(5)
         ->get();


         $paths=json_decode($paths,true);

         $countries = DB::table('waf_events')
         ->select('country', DB::raw('COUNT(country) as `countees` '))
         ->where('zone_id',$used_id )
         ->groupBy('country')
         ->havingRaw('COUNT(country) > 1')
         ->orderBy('countees', 'DESC')
         ->take(5)
         ->get();


         $countries=json_decode($countries,true);
         

         $domain = DB::table('waf_events')
         ->select('domain', DB::raw('COUNT(domain) as `domains` '))
         ->where('zone_id',$used_id )
         ->groupBy('domain')
         ->havingRaw('COUNT(domain) > 1')
         ->orderBy('domains', 'DESC')
         ->take(5)
         ->get();


         $domain=json_decode($domain,true);


         $method = DB::table('waf_events')
         ->select('method', DB::raw('COUNT(method) as `methods` '))
         ->where('zone_id',$used_id )
         ->groupBy('method')
         ->havingRaw('COUNT(method) > 1')
         ->orderBy('methods', 'DESC')
         ->take(5)
         ->get();


         $method=json_decode($method,true);





         $eve = json_decode($events ,true);
         $period = array();


           // $request_cached_uncached[$key]['period'] = dateFormatting(date("Y-m-d H:i:s", strtotime($value->since)),hour);
         // dd($eve);
         $challenge = array();
         $block = array();
         $allow = array();
         $log = array();

         for($i = 0 ; $i < count($eve) ; $i++){
               $a =  substr($eve[$i]['timestamp'], -7,-5);
               $period[$i] =  $a;
           }
       
   $unique =  array_unique($period);
   $key = array_keys($unique);
   // print_r($unique[1]); 
 // dd(count($period));
   end($unique);
   $index = key($unique);

   $key1 = count($key);

// dd($key);   
$find =array();
$find1 =array();

$challenge =array();
$allow =array();
$drop =array();
$log =array(); 
// dd($zone->id);

$counter = 0 ;
           // echo  count($drop);



$like_query = array();

       if($req->time !="" || $req->time > 0){
           $time =  $req->time; 
           if($time == "month" ){
               $arr = array();

              for($i = 0 ;$i < 24 ; $i++){   
        
                           
               if($i == 0){
                        $start = date('Y-m-d  H:i:s'); 
                        $end = strtotime('-30 Day',strtotime($start));
                        $temp =  date( "Y-m-d  H:i:s" , $end);
                        $arr[0]=   date( "Y-m-d  H:i:s" , strtotime($temp)); 
                        $like_query[] =  date( "Y-m-d  H" , strtotime($temp)); 
                   }
        
            else {
                       $arr[$i] = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                       $converted = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                       $arr[$i] = date( "Y-m-d  H:i:s" ,strtotime('-30 Day',strtotime($converted)));
                       $temp = date( "Y-m-d  H:i:s" ,strtotime('-1 Hour',strtotime($converted)));
                       $like_query[$i] = date("Y-m-d H",strtotime($temp));
                  }
               }
           }
           else if($time == "week" ){
                     $arr = array();
            for($k = 1 ; $k <= 7 ; $k++ ){         
              for($i = 0 ;$i < 24 ; $i++){   
        
                           
               if($i == 0){
                        $start = date('Y-m-d  H:i:s'); 
                        $end = strtotime('-$k Day',strtotime($start));
                        $temp =  date( "Y-m-d  H:i:s" , $end);
                        $arr[0]=   date( "Y-m-d  H:i:s" , strtotime($temp)); 
                        $like_query[] =  date( "Y-m-d  H" , strtotime($temp)); 
                   }
        
            else {
                       $arr[$i] = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                       $converted = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                       $arr[$i] = date( "Y-m-d  H:i:s" ,strtotime('-$k Day',strtotime($converted)));
                       $temp = date( "Y-m-d  H:i:s" ,strtotime('-1 Hour',strtotime($converted)));
                       $like_query[$i] = date("Y-m-d H",strtotime($temp));
                       }
                   }
               }
           }
           else if($time > 0){
               
               if($time == 24){
           
                   $arr = array();

              for($i = 0 ;$i < 24 ; $i++){   
        
                           
               if($i == 0){
                        $start = date('Y-m-d  H:i:s'); 
                        $end = strtotime('-1 Hour',strtotime($start));
                        $temp =  date( "Y-m-d  H:i:s" , $end);
                        $arr[0]=   date( "Y-m-d  H:i:s" , strtotime($temp)); 
                        $like_query[] =  date( "Y-m-d  H" , strtotime($temp)); 
                   }
        
            else {
                       $arr[$i] = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                       $converted = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                       $arr[$i] = date( "Y-m-d  H:i:s" ,strtotime('-1 Hour',strtotime($converted)));
                       $temp = date( "Y-m-d  H:i:s" ,strtotime('-1 Hour',strtotime($converted)));
                       $like_query[$i] = date("Y-m-d H",strtotime($temp));
                  }
               }

           }     
               else if($time == 12){
                       $arr = array();

              for($i = 0 ;$i < 12 ; $i++){   
        
                           
               if($i == 0){
                        $start = date('Y-m-d  H:i:s'); 
                        $end = strtotime('-1 Hour',strtotime($start));
                        $temp =  date( "Y-m-d  H:i:s" , $end);
                        $arr[0]=   date( "Y-m-d  H:i:s" , strtotime($temp)); 
                        $like_query[] =  date( "Y-m-d  H" , strtotime($temp)); 
                   }
        
               else {
                           $arr[$i] = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                           $converted = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                           $arr[$i] = date( "Y-m-d  H:i:s" ,strtotime('-1 Hour',strtotime($converted)));
                           $temp = date( "Y-m-d  H:i:s" ,strtotime('-1 Hour',strtotime($converted)));
                            $like_query[$i] = date("Y-m-d H",strtotime($temp));
                       }
                   }
               }
               else if($time == 6){
                    $arr = array();

              for($i = 0 ;$i < 6 ; $i++){   
        
                           
               if($i == 0){
                        $start = date('Y-m-d  H:i:s'); 
                        $end = strtotime('-1 Hour',strtotime($start));
                        $temp =  date( "Y-m-d  H:i:s" , $end);
                        $arr[0]=   date( "Y-m-d  H:i:s" , strtotime($temp)); 
                        $like_query[] =  date( "Y-m-d  H" , strtotime($temp)); 
                   }
        
               else {
                           $arr[$i] = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                           $converted = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                           $arr[$i] = date( "Y-m-d  H:i:s" ,strtotime('-1 Hour',strtotime($converted)));
                           $temp = date( "Y-m-d  H:i:s" ,strtotime('-1 Hour',strtotime($converted)));
                            $like_query[$i] = date("Y-m-d H",strtotime($temp));
                       }
                   }
               }
               else if($time == 01){
                    $arr = array();

              for($i = 0 ;$i < 1 ; $i++){   
        
                           
               if($i == 0){
                        $start = date('Y-m-d  H:i:s'); 
                        $end = strtotime('-1 Hour',strtotime($start));
                        $temp =  date( "Y-m-d  H:i:s" , $end);
                        $arr[0]=   date( "Y-m-d  H:i:s" , strtotime($temp)); 
                        $like_query[] =  date( "Y-m-d  H" , strtotime($temp)); 
                   }
        
               else {
                           $arr[$i] = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                           $converted = date("Y-m-d  H:i:s" , strtotime($arr[$i-1]));
                           $arr[$i] = date( "Y-m-d  H:i:s" ,strtotime('-1 Hour',strtotime($converted)));
                           $temp = date( "Y-m-d  H:i:s" ,strtotime('-1 Hour',strtotime($converted)));
                            $like_query[$i] = date("Y-m-d H",strtotime($temp));
                       }
                   }
               }
           }
       }


 for($i = 0 ; $i < count($like_query) ; $i++){
                 // $ind = 0;
                   error_reporting(0);// phe;a result lakr aja sub 

                 $find [$i] = wafEvent::where([['zone_id',$zone->id ],[ 'updated_at', 'LIKE',  $like_query[$i] . '%'],])->get()->take(50000);
   
                 
                   for($j = 0 ; $j < count($find[$i]) ; $j++){
                   
                     if($find[$i][$j]['action'] == "drop"){
                            $drop[$i]++;
                      } 
                       if($find[$i][$j]['action'] == "allow"){
                            $allow[$i]++;
                      } 
                      if($find[$i][$j]['action'] == "block"){
                            $log[$i]++;
                      } 
                      if($find[$i][$j]['action'] == "challenge"){
                            $challenge[$i]++;
                      } 
                  }
               
               if($drop[$i]=="" || $drop[$i] ==0)
               {
                   $drop[$i] = 0 ; 
               }

               if($challenge[$i]=="" || $challenge[$i] ==0)
               {
                   $challenge[$i] = 0 ;
               }

               if($allow[$i]=="" || $allow[$i] ==0)
               {
                   $allow[$i] = 0 ;
               }

               if($log[$i]=="" || $log[$i] ==0)
               {
                   $log[$i] = 0 ; 
               }
           }
         
      


         $period = array_unique($period);

       
//dd($domain);

/*
foreach($duplicates as $duplicate){

echo  $duplicate['client_ip'];


}

die();
  */          //dd($product);
        
/*
            array_multisort(array_column($product->items, 'count'), SORT_DESC, $product);

            echo '<pre>';
            print_r($product);

           //$duplicates=array($duplicates);
         echo  array_multisort(array_column($duplicates, 'count'), SORT_DESC, $duplicates);
         $dupes = $groupedByValue->filter(function (Collection $duplicates) {
           return $duplicates->count() > 1;
                 });


*/
    

           //dd($product);
            
        //die();

    // $ok=$zone->wafEvent->sortBy('timestamp')->take(500);
        // echo "$ok";
        // die();        
        
        if($zone->cfaccount_id!=0)
        {   


            FetchFirewallRules::dispatch($zone)->onConnection('sync');
            FetchUaRules::dispatch($zone)->onConnection('sync');
            $rules=$zone->FirewallRule;

            $uaRules=$zone->UaRule;
            return view('admin.firewall.index', compact('records','zone','zoneSetting','rules','uaRules','wafPackages','events','duplicates','accounts','paths','countries','domain','method','challenge','block' , 'allow', 'log','period',"drop"));    
        }
        else
        {
            $rules=$zone->SpRule;
            // dd($rules);
            
            // dd($events);
            return view('admin.spfirewall.index', compact('records','zone','zoneSetting','rules','wafPackages','events','duplicates','accounts','paths','countries','domain','method','challenge','block' , 'allow', 'log','period',"drop"));
        }
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function createAccessRule(Request $request)
    {
        //

        $zone_id=$request->input('zid');

        $zone= Zone::find($zone_id);
        if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->cfaccount->reseller->id OR auth()->user()->id == 1))
    {
            return abort(401);
    }

        $target=$request->input('target');
    
        $value=$request->input('value');
         $mode=$request->input('mode');
$notes=$request->input('note');

       
        $data=[
            'record_ID'  =>  'PENDING',
            'target'  =>  $target,
            'value'  =>  $value,
            'mode'   =>  $mode,
            'scope'    => 'zone',
            'status' => 'active',
		'notes' => $notes,
            'zone_id'   => $zone_id,
        ];

       
        $record=FirewallRule::create($data);


        UpdateFirewallRule::dispatch($zone,$record->id)->onConnection('sync');

        echo "success";
         //return redirect()->route('admin.dns',['zone'   =>  $zone->name]);
    }

    public function createUaRule(Request $request)
    {
        //

        $zone_id=$request->input('zid');

        $zone= Zone::find($zone_id);
        if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->cfaccount->reseller->id OR auth()->user()->id == 1))
    {
            return abort(401);
    }

        $description=$request->input('description');
    
        $value=$request->input('value');
         $mode=$request->input('mode');

       
        $data=[
            'record_ID'  =>  'PENDING',
            'description'  =>  $description,
            'value'  =>  $value,
            'mode'   =>  $mode,
            
            'paused' => false,
            'zone_id'   => $zone_id,
        ];

       
        $record=UaRule::create($data);


        UpdateUaRule::dispatch($zone,$record->id)->onConnection('sync');

        echo "success";
         //return redirect()->route('admin.dns',['zone'   =>  $zone->name]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dns  $dns
     * @return \Illuminate\Http\Response
     */
    public function show(Dns $dns)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dns  $dns
     * @return \Illuminate\Http\Response
     */
    public function edit(Dns $dns)
    {
        //


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dns  $dns
     * @return \Illuminate\Http\Response
     */


        public function wafGroupDetails($zone,$pid,$gid)
    {
        //
  $zone =   Zone::where('name',$zone)->first();
            

            $wafRules=$zone->wafPackage->where('id',$pid)->first()->wafGroup->where('id',$gid)->first()->wafRule;
            // dd($wafRules->wafRule);
            // 
            
                    return view('admin.firewall.wafGroupDetails', compact('wafRules'));
    }

        public function editUaRule(Request $request)
    {
        //



        $zone_id=$request->input('zid');
        $rule_id= $request->input('ruleid');

        $zone= Zone::find($zone_id);
        if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->user->owner OR auth()->user()->id == 1))
    {
            return abort(401);
    }

        $value=$request->input('value');
        $description=$request->input('description');
        $mode=$request->input('mode');
        
        $data=[
            
            'value'  =>  $value,
            'description'  =>  $description,
            'mode'  =>  $mode
    
        ];

         $uaRule = UaRule::findOrFail($rule_id);
          
           $uaRule->update($data);

           $uaRule->save();


       
        

        
        
         UpdateUaRule::dispatch($zone,$uaRule->id)->onConnection('sync');

         echo "success";
         // return redirect()->route('admin.pagerules',['zone'   =>  $zone->name]);
    }
    public function updateFirewallRule(Request $request, $zone)
    {
        //

        $zone=Zone::where('name',$zone)->first();

        if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->user->owner OR auth()->user()->id == 1))
    {
            return abort(401);
    }

         $rule=$zone->FirewallRule->where('id',$request->input('id'))->first();

        //echo($rule->mode);
        $rule->mode=$request->input('value');
        $rule->save();
        // $rule1=Zone::where('name',$zone)->first()->FirewallRule->where('id',$request->input('id'))->first();
        //   echo($rule1->mode);
        //   
        
        UpdateFirewallRule::dispatch($zone, $rule->id);

        echo "Access Rule Updated";
   
    }

        public function updateUaRule(Request $request, $zone)
    {
        //

        $zone=Zone::where('name',$zone)->first();

        if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->user->owner OR auth()->user()->id == 1))
    {
            return abort(401);
    }

         $rule=$zone->UaRule->where('id',$request->input('id'))->first();

        //echo($rule->mode);
        $rule->mode=$request->input('value');
        $rule->save();
        // $rule1=Zone::where('name',$zone)->first()->FirewallRule->where('id',$request->input('id'))->first();
        //   echo($rule1->mode);
        //   
        
        UpdateUaRule::dispatch($zone, $rule->id);

        echo "Access Rule Updated";
   
    }

        public function uaRuleStatus(Request $request)
    {

        $data=$request->all();

        $zone=UaRule::find($data['id'])->zone;

       if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->user->owner OR auth()->user()->id == 1))
    {
            return abort(401);
    }
        if($data['value']!='1')
        {
            $data['value']='0';
        }

        $UaRule=UaRule::where('id', $data['id'])->first();
        $UaRule->paused=$data['value'];

        $UaRule->save();

        UpdateUaRule::dispatch($zone,$UaRule->id)->onConnection('sync');

    
    }
    public function updateWafGroup(Request $request, $zone)
    {
        //

        $zone = Zone::where('name',$zone)->first();
        // dd($zone);
        if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->user->owner OR auth()->user()->id == 1))
    {
            return abort(401);
    }

         // $rule=Zone::where('name',$zone)->first()->wafPackage->whereIn('id',function ($query) {
         //        $query->select('package_id')->from('waf_groups')
         //        ->Where('id','=','valueRequired');
        $id=$request->input('id');

        $wafGroup = wafGroup::where('id',$id)->first();


        if($request->input('value')=="true")
        {
            $value="on";
        }
        else
        {
            $value="off";
        }

       
        $wafGroup->mode=$value;
        $wafGroup->save();
       



        
        if($zone->cfaccount_id!=0)
        {
            UpdateWAFGroup::dispatch($zone, $wafGroup->id);
        }
        else
        {
            UpdateSPWAF::dispatch($zone, $wafGroup->id);
        }
        
        
    }
    public function updateWafRule(Request $request, $zone)
    {
        //

        $zone = Zone::where('name',$zone)->first();
        // dd($zone);
        if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->user->owner OR auth()->user()->id == 1))
    {
            return abort(401);
    }

         // $rule=Zone::where('name',$zone)->first()->wafPackage->whereIn('id',function ($query) {
         //        $query->select('package_id')->from('waf_groups')
         //        ->Where('id','=','valueRequired');
        $id=$request->input('id');

        $wafRule = wafRule::where('id',$id)->first();

        $value=$request->input('value');
        

       
        $wafRule->mode=$value;
        $wafRule->save();
       



        
        if($zone->cfaccount_id!=0)
        {
            UpdateWAFRule::dispatch($zone, $wafRule->id)->onConnection('sync');
        }
        else
        {
            // UpdateSPWAF::dispatch($zone, $wafGroup->id);
        }
        
        echo "success";
        
    }

public function updateWafPackage(Request $request, $zone)
    {
        //


         // $rule=Zone::where('name',$zone)->first()->wafPackage->whereIn('id',function ($query) {
         //        $query->select('package_id')->from('waf_groups')
         //        ->Where('id','=','valueRequired');
            $id=$request->input('id');

         $zone = Zone::where('name',$zone)->first();

         if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->user->owner OR auth()->user()->id == 1))
    {
            return abort(401);
    }


        $wafPackage = $zone->wafPackage->where('id',$id)->first();

        echo $wafPackage->{$request->input('setting')};
        $wafPackage->{$request->input('setting')}=$request->input('value');

        $wafPackage->save();

        $wafPackage = $zone->wafPackage->where('id',$id)->first();

        echo $wafPackage->{$request->input('setting')};

        // if($request->input('value')=="true")
        // {
        //     $value="on";
        // }
        // else
        // {
        //     $value="off";
        // }

       
       
       



       

        UpdateWAFPackage::dispatch($zone, $wafPackage->id);
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dns  $dns
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        $data=$request->all();
        $firewallRule=FirewallRule::find($data['id']);

        
        $zone=$firewallRule->zone;

        if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->user->owner OR auth()->user()->id == 1))
    {
            return abort(401);
    }

        

            $rule_id=$firewallRule->record_id;
            $firewallRule->delete();

            DeleteFirewallRule::dispatch($zone,$rule_id)->onConnection('sync');




        


    }

    public function destroyUaRule(Request $request)
    {
        //

        $data=$request->all();
        $UaRule=UaRule::find($data['id']);

        
        $zone=$UaRule->zone;

        if(!(auth()->user()->id == $zone->user->id OR auth()->user()->id == $zone->user->owner OR auth()->user()->id == 1))
    {
            return abort(401);
    }

        

            $rule_id=$UaRule->record_id;
            $UaRule->delete();

            DeleteUaRule::dispatch($zone,$rule_id);




        


    }
}

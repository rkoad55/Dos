<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Zone;
use App\SpAnalytics;
use Carbon\Carbon;
use App\wafEvent;


class FetchWAFEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user_id,$zone;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Zone $zone)
    {
        //
        $this->zone=$zone;
        $this->user_id=auth()->user()->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        

       



 $key     = new \Cloudflare\API\Auth\APIKey($this->zone->cfaccount->email, $this->zone->cfaccount->user_api_key);
        $adapter = new \Cloudflare\API\Adapter\Guzzle($key);
        $waf   = new \Cloudflare\API\Endpoints\WAF($adapter);



        $events=$waf->getEvents($this->zone->zone_id,1,20);
        


$i=0;

$events=(array)$events;
// dd($events);
//ini_set('max_execution_time', '0');
$temp = array();
        // for($i = 0 ; $i < count($events) ; $i++){
        //       $temp[$i] = $events["result"][0];
        //     //   print_r($temp);
        //     dd($temp);
        //     //   die();
        // }

//         foreach ($events["result"] as $key => $val){
//             $count = count($val->matches);
//            // dd($val->matches);
// $a=0;
//             foreach($val->matches as $v){

//                 // if($a==15){
//                 //     $temp =  count($v[0]->metadata);
//                 //     if ( $temp > 0)
//                 // print_r($v[0]->metadata);
//                 // // die();
//                 // }
//                 // $a++;

                
//                 if(property_exists($v,'metadata')){
//     // echo    $v->metadata;
//      print_r($evente['scope']=$v->metadata->group);
//         // $evente['scope']=$event->matches[0]->metadata->group;
//         // $evente['rule_name']=$event->matches[0]->metadata->rule_message;

// // }

// //echo "Found";
//             // dd($val->matches[0]->metadata);
//         }else {

//             echo "Not Found";

//         }
//     }
// }
//         // dd($temp);
       
//         die();

        foreach ($events['result'] as $event) {
            # code...
           

      //dd($event);
    //   echo   $evente['headers']=$event->matches[0]->metadata->matched_var;
    //   echo  $evente['scope']=$event->matches[0]->metadata->group;
    //   echo  $evente['rule_name']=$event->matches[0]->metadata->rule_message;
       // dd($event->matches[0]);

         // print_r($event['0']->ray_id);
          // die();




        //   foreach($event->matches as $v){

          

            
            if(property_exists($event->matches[0],'metadata')){
// echo    $v->metadata;
if(property_exists($event->matches[0]->metadata,'group')){
 $evente['scope']=$event->matches[0]->metadata->group;

            }

            if(property_exists($event->matches[0]->metadata,'matched_var')){
 $evente['headers']=$event->matches[0]->metadata->matched_var;

            }

            if(property_exists($event->matches[0]->metadata,'rule_message')){
            $evente['rule_name']=$event->matches[0]->metadata->rule_message;
           
                       }
//  $evente['headers']=$event->matches[0]->metadata->matched_var;
//          $evente['scope']=$event->matches[0]->metadata->group;
         // $evente['rule_name']=$event->matches[0]->metadata->rule_message;

// }

//echo "Found";
        // dd($val->matches[0]->metadata);
    }

   
    
 // }

       // die();  
            $check['resource_id']=$event->ray_id;
            $check['zone_id']=$this->zone->id;



            
         
       // die();
        $evente['client_ip']=$event->ip;

        $evente['rule_id']=$event->rule_id;

        $evente['country']=$event->country;
        $evente['method']=$event->method;

        $evente['type']=$event->kind;

        $evente['uri']=$event->uri;

        $evente['action']=$event->action;

        $evente['ref_id']=$event->rule_id;

        $evente['user_agent']=$event->ua;
        $evente['scheme']=$event->scheme;

        $evente['request_type']=$event->source;
        //$evente['rule_name']=$event->kind;
       

// if(property_exists($event->matches[0],'metadata')){
//         $evente['headers']=$event->matches[0]->metadata->matched_var;
//         $evente['scope']=$event->matches[0]->metadata->group;
//         $evente['rule_name']=$event->matches[0]->metadata->rule_message;

// }
            $evente['scheme']=$event->proto;
            $evente['domain']=$event->host;
           // $event['rule_name']=$event['rule_message'];
            $evente['timestamp']=strtotime($event->occurred_at);
            $evente['count']=1;
           // $evente['ref_id']='';

            // if($event['rule_id']==null)
            // {   
            //     $event['rule_id']=0;
            //     var_dump($event['rule_name']);
            //      // $event['rule_info']=$event['rule_info']->value;
            // }

           
             $check['resource_id']."<br>";
             
            unset($event->ray_id,$event->ip,$event->proto,$event->host,$evente['request_duration'],$evente['triggered_rule_ids'],$evente['cloudflare_location'],$evente['occurred_at'],$evente['rule_detail'],$evente['type'],$evente['rule_info']);
            //var_dump($event);

            
           
           $insertedEvent=wafEvent::updateOrCreate($check,$evente);
            // dd($insertedEvent);
        // $i++;

        }



      //die();
        
    }

  
}

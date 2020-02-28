@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app2')

@section('content')



{{-- Firewall Code Starts --}}
<div class="panel with-nav-tabs panel-default">
  <div class="panel-heading">
          <ul class="nav nav-tabs">
              <li class="active"><a href="#tab1default" data-toggle="tab">Overview</a></li>
              <li><a href="#tab2default" data-toggle="tab">Managed Rules</a></li>
              <li><a href="#tab3default" data-toggle="tab">Firewall Rules</a></li>
              <li><a href="#tab4default" data-toggle="tab">Tools</a></li>
          </ul>
  </div>
  <div class="panel-body">
      <div class="tab-content">
          <div class="tab-pane fade in active" id="tab1default">
		  

@if(count($events))
    <div class="panel panel-default panel-main">
      <div class="panel-heading"><h2 style="display: inline">Firewall Events </h2>



      <div id="statuses-graph" class="graphbox" style="height: 230px;"></div>
    
  </div>


      <input type="hidden" name="csrftoken" value="{{csrf_token()}}" >

        <div class="panel-body table-responsive">
      

            <table class="table table-striped table-condensed firewallEvents">

                <thead>
                    <tr>
                        <th>Description</th>

                        <th>Action</th>
                        
                        <th>IP</th>
                        <th>Country</th>
                        <th>Date</th>
                         <th>&nbsp;</th>
                        <th>&nbsp;</th>

                    </tr>
                </thead>

                <tbody>
                    @if (count($events) > 0)
                        @foreach ($events as $event)
                            <tr id="record_{{ $event->id }}" data-entry-id="{{ $event->id }}">
                                <td>{{ $event->rule_name }}</td>

                                <td>
                                  {{ $event->action }}
                                </td>

                               

                                <td>
                                  {{ $event->client_ip }}
                                </td>
                                <td>
                                  {{ $event->country }}
                                </td>
                                
                                <td>
                                  {{ $event->timestamp }}
                                </td>
                                <td>
                                  {{ $event->ts }}
                                </td>
                                <td>
                                    
                                    <button data-rulename="{{ $event->rule_name }}" 
                                       data-date="{{ $event->timestamp }}" 
                                        data-action="{{ $event->action }}" 
                                         data-schememethod="{{ $event->scheme }} {{ $event->method }}" 
                                          data-uri="{{ $event->uri }}" 
                                           data-querystring="{{ $event->query_string }}" 
                                            data-domain="{{ $event->domain }}" 
                                             data-clientip="{{ $event->client_ip }}" 
                                              data-country="{{ $event->country }}" 
                                               data-useragent="@if($event->user_agent!="") {{ $event->user_agent }} @endif" 
                                         
                                              class="btn btn-info eventDetail">Details</button>

                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
          <div class="tab-pane fade" id="tab2default">
		  
   <div class="panel panel-default panel-main">
      <div class="panel-body  row">
          <div class="col-lg-8">
          <div  class="setting-title" ><h3>
 Web Application Firewall 
    
    
</h3>




  <p>Enable / Disable Web Application Firewall </p>


  <p class="text-info">This setting was last changed 2 days ago</p>


</div>

          <?php echo  $waf=$zoneSetting->where('name','waf')->first()->value; ?>
          </div>
          <div class="col-lg-4 right ">
           <div  class="setting-title" >

           </div>
          <select settingid="{{$zoneSetting->where('name','waf')->first()->id }}"  style="width: 200px;" class="select2 changeableSetting" id="waf" name="waf">
                        <option {{ $waf === "off" ? "selected":"" }}  value="off">OFF</option>
                        <option {{ $waf === "on" ? "selected":"" }} value="on">ON</option>
                        
                      
                        
                    </select>
          </div>
      </div>

    </div>



@foreach($wafPackages as $wafPackage)

 <div class="panel panel-default panel-main">
      <div class="panel-body  ">
      <div class="row">
          <div class="col-lg-8">
          <div  class="setting-title" ><h3>

  {{ title_case(str_replace("CloudFlare","BlockDOS",str_replace("_"," ",$wafPackage->name))) }}
    
    
</h3>




  <p>{{ title_case(str_replace("CloudFlare","BlockDOS",str_replace("_"," ",$wafPackage->description))) }}</p>


  <p class="text-info">This setting was last changed 2 days ago</p>


</div>

          <?php $sensitivity=$wafPackage->sensitivity;
                $action=$wafPackage->action;
                
           ?>
          </div>

          @if($wafPackage->detection_mode!="traditional")
          <div class="col-lg-4 right ">
           <div  class="waf-package-title" >
              Senstivity
           </div>
          <select package-id="{{$wafPackage->id }}" setting="sensitivity"  style="width: 200px;" class="select2 wafPackageSetting" id="sensitivity" name="sensitivity">
                        <option {{ $wafPackage->sensitivity === "off" ? "selected":"" }} disabled="" value="off">Off</option>
                       
                        <option {{ $wafPackage->sensitivity === "low" ? "selected":"" }} value="low">Low</option>
                        <option {{ $wafPackage->sensitivity === "medium" ? "selected":"" }} value="medium">Medium</option>
                        <option {{ $wafPackage->sensitivity === "high" ? "selected":"" }} value="high">High</option>
                        
                        
                    </select>


                     <div  class="waf-package-title" >
              Action
           </div>
          <select package-id="{{$wafPackage->id }}" setting="action_mode"  style="width: 200px;" class="select2 wafPackageSetting" id="action1" name="action">
                        <option {{ $wafPackage->action_mode === "simulate" ? "selected":"" }} value="simulate">Simulate</option>
                        <option {{ $wafPackage->action_mode === "challenge" ? "selected":"" }} value="challenge">Challenge</option>
                        <option {{ $wafPackage->action_mode === "block" ? "selected":"" }} value="block">Block</option>
                        
                        
                    </select>
          </div>
          @endif
     
</div>

      <div class="expandable wafGroups">

        

           <table class="table table-bordered table-striped table-condensed">
           <thead>
                <tr>
                <th>Group</th>
                <th>Description</th>
                <th>Mode</th>
                </tr>
</thead>
                @foreach($wafPackage->wafGroup as $wafGroup)

                  <tr>
                <td><a class="pointer showWAFGroupDetails" data-pid="{{ $wafPackage->id }}" data-gid="{{ $wafGroup->id }}">{{ str_replace("Cloudflare","BlockDOS",$wafGroup->name) }}</a></td>
                <td>{{ str_replace("Cloudflare","BlockDOS",$wafGroup->description) }}</td>
                <td> 

                <input group-id="{{ $wafGroup->id }}" class="wafGroupToggle" type="checkbox" data-onstyle="primary" data-offstyle="default" {{ $wafGroup->mode === "on" ? "checked" : "" }} data-toggle="toggle" data-on=" ON" data-off="OFF">
                


                </td>
                </tr>

                @endforeach
            </table>
            

     

      </div>
 </div>
    </div>
@endforeach
		  </div>
          <div class="tab-pane fade" id="tab3default">
		         <div class="panel-heading"><h2 style="display: inline">Access Rules for {{ $records->first()->zone->name }}</h2>
        <div class="pull-right">
      <a class="btn btn-primary" id="add_rule" data-toggle="modal" > Add New Rule</a>

    </div>
  </div>


      <input type="hidden" name="csrftoken" value="{{csrf_token()}}" >

        <div class="panel-body table-responsive">
        

            <table class="table table-bordered table-striped table-condensed">

                <thead>
                    <tr>
                        
                        <th >Value</th>
                        
                        <th>Action</th>
			<th> Notes </th>
                        <th>&nbsp;</th>

                    </tr>
                </thead>

                <tbody>
                    @if (count($rules) > 0)
                        @foreach ($rules as $rule)
                            <tr id="rule_{{ $rule->id }}" data-entry-id="{{ $rule->id }}">
                                <td>{{ $rule->value }}</td>

                                 
                                
                                <td>

                              
                <select style="width:200px;" class="select2 firewallAction" id="{{ $rule->id }}" name="firewallAction">
                <option {{ $rule->mode  == "whitelist" ? "selected":"" }} value="whitelist">Whitelist</option>
                <option {{ $rule->mode == "block" ? "selected":"" }} value="block">Block</option>
                <option {{ $rule->mode == "challenge" ? "selected":"" }} value="challenge">Challenge</option>
                <option {{ $rule->mode == "js_challenge" ? "selected":"" }} value="js_challenge">JS Challenge</option>
               
            </select>
                                    </td>
                              <td style="color:grey; font-size:12px; width:40%;">{{ $rule->notes }}</td>
                                <td>
                                    <a class="deleteRule" rule-id="{{$rule->id}}" class="btn btn-default">
                                    <i class="glyphicon glyphicon-remove"></i>
                                    </a>


                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
</div>
          <div class="tab-pane fade" id="tab4default">Default 4</div>
      </div>
  </div>
</div>
{{-- Firewall Code Ends --}}

@endif

</div>
@stop

@section('javascript')
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('admin.users.mass_destroy') }}';
    </script>
@endsection

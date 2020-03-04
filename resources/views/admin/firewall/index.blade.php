@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app2')

@section('content')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

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
              {{-- For Firewall Events --}}
			<div class="panel panel-default panel-main">
				<div class="panel-heading">
                    <h2 style="display: inline">Firewall Events </h2>
				</div>
				
				<div class="panel-body">
                    <!--button class="btn btn-primary">Add Filters</button-->	

<br/>


<form method="get" action="#">

<select class="select2 form-control " id="minutes" name="time" >
                        
     <option value="01" >Last 01 Hour</option>
  
     <option  value="06">Last 6 Hours</option>
     <option value="12">Last 12 Hours</option>
     
     <option  value="24">Last 24 Hours</option>
     <option  value="week">Last 7 Days</option>
     <option  value="month">Last Month</option>

</select>

</form>

                   

				</div>

            </div>
            {{-- For Firewall Events Ends --}}

            {{-- For Events By Action --}}
			<div class="panel panel-default panel-main">
				<div class="panel-heading">
                    <h2 style="display: inline">Events By Action</h2>
                   
				</div>
				
				<div class="panel-body">

        
  


        <div id="container"></div>


					
         
                   
				</div>

       

            </div>
            {{-- For Events By Action --}}

            {{-- For Events By Service --}}
			<div class="panel panel-default panel-main">
				<div class="panel-heading">
                    <h2 style="display: inline">Events By Service</h2>
				</div>
				
				<div class="panel-body">
					<center>
                        <h1>Graph Here</h1>
                    </center>
				</div>

            </div>
            {{-- For Events By Service --}}

            {{-- For Top Events By Resources --}}
			<div class="panel panel-default panel-main">
				<div class="panel-heading">
                    <h2 style="display: inline">Top Events By Resources</h2>
				</div>
				
				<div class="panel-body">
					<div class="container">
  <div class="row">
    <div class="col col-lg-6">
    <h2><b>Ip Addresses</b></h2>
   <?php $i=0; ?>
    @foreach($duplicates as $row)
    <div class=" col col-lg-12" >
       <h6><b>{{ $row['client_ip'] }}</b></h6>  
    
</div>
    <div class="progress col col-lg-10" >
  <div class="progress-bar"  role="progressbar" style="width: <?php $count=$row['count']; if($count>=100) { echo "100"; }else{ echo $row['count']; } ?>%"  aria-valuemin="0" ><?php echo $row['count']; ?></div>
</div>
  
  
  




    <?php $i++;?>
       
       
   @endforeach
                  
    </div>

    <div class="col col-lg-6">
    <h2><b>User Agents</b></h2>
    <?php $j=505050; ?>
    @foreach($accounts as $row1)
    <div class=" col col-lg-12" > 
       <h6><b>{{ $row1['user_agent'] }}</b></h6>
    
</div>

    <div class="progress col col-lg-10" >
  <div class="progress-bar"  role="progressbar" style="width: <?php $count=$row1['counts']; if($count>=100) { echo "100"; }else{ echo $row1['counts']; }  ?>%"  aria-valuemin="0" ><?php echo $row1['counts']; ?></div>
</div>
   
    
    
    
    




    
       <?php $j++; ?>
       
   @endforeach
                  
    </div>
  </div>

  <div class="row">
  <div class="col col-lg-6">
    <h2><b>Paths</b></h2>
    <?php $j=5050504534; ?>
    @foreach($paths as $row2)
    <div class=" col col-lg-10" >
       <h6><b>{{ $row2['uri'] }}</b></h6>  
</div>

<div class="progress col col-lg-10" >
  <div class="progress-bar"  role="progressbar" style="width: <?php $count=$row2['countes']; if($count>=100) { echo "100"; }else{ echo $row2['countes']; } ?>%"  aria-valuemin="0" ><?php echo $row2['countes']; ?></div>
</div>




    
       <?php $j++; ?>
       
   @endforeach
                  
    </div>



    <div class="col col-lg-6">
    <h2><b>Countries</b></h2>
    <?php $j=50503545504534; ?>
    @foreach($countries as $row3)
    <div class=" col col-lg-10" > 
       <h6><b><?php 
    
    $names = json_decode(file_get_contents("http://country.io/names.json"), true);
echo $names[$row3['country']];
    
    
    ?></b></h6> 

</div>

<div class="progress col col-lg-10" >
  <div class="progress-bar"  role="progressbar" style="width: <?php $count=$row3['countees']; if($count>=100) { echo "100"; }else{ echo $row3['countees']; } ?>%"  aria-valuemin="0" ><?php echo $row3['countees']; ?></div>
</div>


    
       <?php $j++; ?>
       
   @endforeach
                  
    </div>


</div>



<div class="row">

  <div class="col col-lg-6">
    <h2><b>Hosts</b></h2>
    <?php $j=345050504534; ?>
    @foreach($domain as $row3)
    <div class=" col col-lg-12" >
       <h6><b>{{ $row3['domain'] }}</b></h6> 
</div>
    
    <div class="progress col col-lg-10" >
  <div class="progress-bar"  role="progressbar" style="width: <?php $count=$row3['domains']; if($count>=100) { echo "100"; }else{ echo $row3['domains'];}  ?>%"  aria-valuemin="0" ><?php echo $row3['domains']; ?></div>
</div>



    
       <?php $j++; ?>
       
   @endforeach
                  
    </div>



    <div class="col col-lg-6">
    <h2><b>HTTP Methods</b></h2>
    <?php $j=50503545504534; ?>
    @foreach($method as $row3)
       
    <div class=" col col-lg-12" >
       <h6><b>{{ $row3['method'] }}</b></h6> 
</div>
    
    <div class="progress col col-lg-10" >
  <div class="progress-bar"  role="progressbar" style="width: <?php $count=$row3['methods']; if($count>=100) { echo "100"; }else{ echo $row3['methods'];}  ?>%"  aria-valuemin="0" ><?php echo $row3['methods']; ?></div>
</div>




    
       <?php $j++; ?>
       
   @endforeach
                  
    </div>


</div>



<!--div class="row">

  <div class="col col-lg-6">
    <h2><b>Paths</b></h2>
    <?php $j=5050504534; ?>
    @foreach($paths as $row2)
       
       <h6><b>{{ $row2['uri'] }}</b></h6>  <p>{{ $row2['countes'] }} <script>
  $( function() {
    $( "#progressbar<?php echo $j;?>" ).progressbar({
      value: <?php echo $row2['countes'];?>
    });
  } );
  </script>

 
<div id="progressbar<?php echo $j;?>" style="
    width: 50%;"></div></p>




    
       <?php $j++; ?>
       
   @endforeach
                  
    </div>



    <div class="col col-lg-6">
    <h2><b>Countries</b></h2>
    <?php $j=50503545504534; ?>
    @foreach($countries as $row3)
       
       <h6><b><?php 
    
    $names = json_decode(file_get_contents("http://country.io/names.json"), true);
echo $names[$row3['country']];
    
    
    ?></b></h6>  <p>{{ $row3['countees'] }} <script>
  $( function() {
    $( "#progressbar<?php echo $j;?>" ).progressbar({
      value: <?php echo $row3['countees'];?>
    });
  } );
  </script>

 
<div id="progressbar<?php echo $j;?>" style="
    width: 50%;"></div></p>




    
       <?php $j++; ?>
       
   @endforeach
                  
    </div>


</div-->




  </div>
				</div>

            </div>
            {{-- For Top Events By Resources --}}

            {{-- Activity Log starts --}}
@if(count($events))
    <div class="panel panel-default panel-main">
      <div class="panel-heading"><h2 style="display: inline">Activity Logs </h2>
    
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
                                       data-resource_id="{{ $event->resource_id }}" 
                                        data-action="{{ $event->action }}" 
                                         data-schememethod="{{ $event->scheme }} {{ $event->method }}" 
                                          data-uri="{{ $event->uri }}" 
                                           data-querystring="{{ $event->query_string }}" 
                                            data-domain="{{ $event->domain }}" 
                                             data-clientip="{{ $event->client_ip }}" 
                                              data-country="{{ $event->country }}" 
                                              data-scope="{{ $event->scope }}" 
                                               data-useragent="@if($event->user_agent!='') {{ $event->user_agent }} @endif" 
                                         
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
    {{-- activity Logs Ends --}}
    
</div>
{{-- 1st pane end --}}

          <div class="tab-pane fade" id="tab2default">
		  
   <div class="panel panel-default panel-main">
      <div class="panel-body  row">
          <div class="col-lg-8">
          <div  class="setting-title" ><h3>Web Application Firewall</h3>




  <p>Provides enhanced security through a built-in ruleset to stop a wide range of application attacks.</p>


  <span>This setting was last changed 4 years ago</span>


</div>

          <?php $waf=$zoneSetting->where('name','waf')->first()->value; ?>
          </div>
          <div class="col-lg-4 right ">
           <div  class="setting-title" >

           </div>
          <select settingid="{{$zoneSetting->where('name','waf')->first()->id }}" class="select2 changeableSetting" id="waf" name="waf">
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
<br>
      <div class="expandable wafGroups">
      <table class="table table-bordered table-striped table-condensed">
           <thead>
                <tr>
                <th>Group</th>
                <th>Description</th>
                <th>Mode</th>
                </tr>
			</thead>
			<tbody>
                @foreach($wafPackage->wafGroup as $wafGroup)

                  <tr>
                <td><a class="pointer showWAFGroupDetails" data-pid="{{ $wafPackage->id }}" data-gid="{{ $wafGroup->id }}">{{ str_replace("Cloudflare","BlockDOS",$wafGroup->name) }}</a></td>
                <td>{{ str_replace("Cloudflare","BlockDOS",$wafGroup->description) }}</td>
                
				<td> 
                <input group-id="{{ $wafGroup->id }}" class="wafGroupToggle" type="checkbox" data-onstyle="primary" data-offstyle="danger" {{ $wafGroup->mode === "on" ? "checked" : "" }} data-toggle="toggle" data-on=" ON" data-off="OFF">
                
                </td>
                </tr>

                @endforeach
			</tbody>
          </table>
          

      </div>
 </div>
    </div>
@endforeach
<div class="panel panel-default panel-main">
			<div class = "panel-body">
					<h2>Cloudflare DDoS Protection</h2>
					<p>Prevents DDoS attacks across the network and application layers. These mitigations are automatically enabled for all customers across all plans.</p>
					<br>
					<table class="table table-condensed">
						<thead>
							<tr>
								<th>Group</th>
								<th>Description</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>HTTP Flood</td>
								<td>Prevents attacks caused from a flood of HTTP requests.</td>
								<td><center><a href = 'https://www.cloudflare.com/learning/ddos/http-flood-ddos-attack/'>Learn More</a></center></td>
							</tr>
							<tr>
								<td>UDP Flood</td>
								<td>Prevents attacks caused from a flood of UDP packets.</td>
								<td><center><a href = 'https://www.cloudflare.com/learning/ddos/udp-flood-ddos-attack/'>Learn More</a></center></td>
							</tr>
							<tr>
								<td>SYN Flood</td>
								<td>Prevents attacks caused from a flood of TCP packets sent with SYN flag.</td>
								<td><center><a href = 'https://www.cloudflare.com/learning/ddos/syn-flood-ddos-attack/'>Learn More</a></center></td>
							</tr>
							<tr>
								<td>ACK Flood</td>
								<td>Prevents attacks caused from a flood of TCP packets sent with ACK flag.</td>
								<td><center><a href = 'https://www.cloudflare.com/learning/ddos/what-is-an-ack-flood/'>Learn More</a></center></td>
							</tr>
							<tr>
								<td>QUIC Flood</td>
								<td>Prevents attacks caused from a flood of QUIC requests.</td>
								<td><center><a href = 'https://www.cloudflare.com/learning/ddos/what-is-a-quic-flood/'>Learn More</a></center></td>
							</tr>
							<tr>
								<td> 1–5 of 5</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				
			</div>
			</div>
          </div>
          {{-- 2nd Panel End --}}
          <div class="tab-pane fade" id="tab3default">
		         <div class="panel-heading">
              <div class="pull-left">    
                <h2>Firewall Rules</h2>
                  {{-- $records->first()->zone->name --}}
                <p>
                  Controlling incoming traffic to your zone by filtering requests based on location, IP address, user agents, URI, and more.
                </p>
            </div>
            <div class="pull-right">
            <br>
            <br>
            {{-- 
              <a class="btn btn-primary" id="add_rule" data-toggle="modal">Create a Firewall Rule</a> --}}
            </div>
  </div>
  <div class="clear-fix"></div>
<br>
<br>
<br>
<br>
  <div class="panel-body">
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
                                    <a class="deleteRule" rule-id="{{$rule->id}}" class="btn btn-danger">
                                    <i  class="glyphicon glyphicon-remove text-danger"></i>
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
</div>
        {{-- 3rd Panel Ends --}}
        <div class="tab-pane fade" id="tab4default">
              {{-- For IP Access Rules --}}
			<div class="panel panel-default panel-main container-fluid">
				
              <div class="pull-left">    
                <h2>IP Access Rules</h2>
                  {{-- $records->first()->zone->name --}}
                <p>
                  IP Access Rules can be IP address, IP address range, Autonomous System Number (ASN) or country.
                </p>
            </div>
            <div class="pull-right">
            <br>
            <br>
              <a class="btn btn-primary" id="add_rule" data-toggle="modal">Add Rule</a>
            </div>

  <div class="clear-fix"></div>
<br>
<br>
<br>
<br>
  <div class="panel-body">
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
                                    <a class="deleteRule" rule-id="{{$rule->id}}" class="btn btn-danger">
                                    <i  class="glyphicon glyphicon-remove text-danger"></i>
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
            </div>
            {{-- IP Access Rules Ends --}}

            {{-- For IP Access Rules Graph --}}
			<div class="panel panel-default panel-main">
				
				<div class="panel-body">
					<center>
                        <h1>Graph Here</h1>
                    </center>
				</div>

            </div>
            {{-- IP Access Rules Graph Ends --}}

            {{-- For Rate Limiting --}}
			<div class="panel panel-default panel-main">
      <div class="panel-body">
          <div class="pull-left">
            <h2>Rate Limiting</h2>
            <p>Protect your site or API from malicious traffic by blocking client IP addresses that hit a URL pattern<br> and exceed a threshold you define. Your existing Rate Limiting Rules are listed below. This feature<br> is a usage-based product. Learn more about how billing works for Rate Limiting.</p>
          </div>
          <div class="pull-right">
            <br>
            <br>
              <a class="btn btn-primary"> Add Rate Limit</a>
            </div>
				</div>
            </div>
            {{-- Rate Limiting Ends --}}

            {{-- For User Agent Blocking --}}
	<div class="panel panel-default panel-main">
        <div class = "container-fluid">
		<br>
			<h2>User Agent Blocking</h2> 
		{{--
		Rules for {{ $records->first()->zone->name }}
        --}}
<?php
  $allowed=10;

  if($zone->plan=="pro")
  {
    $allowed=20;
  }
  elseif($zone->plan=="business")
  {
    $allowed=50;
  }
  elseif($zone->plan=="enterprise")
  {
    $allowed=100;
  }      
?>
<br>
<br>
	<div class="pull-left">
		<p>Create a rule to block or challenge a specific User Agent from accessing your zone.</p>
		<p style="font-weight: bold;">You have used <span id="ruleCount">{{  count($uaRules->where('paused','0')) }}</span> out of <span id="allowed">{{ $allowed }}</span> User Agent rules active <span class="glyphicon glyphicon-info-sign"data-toggle="tooltip" data-placement="top" title="Note: Only rules that are ON count towards your rules quota." ></span></p>
	</div>
	<div class="pull-right">
      <a class="btn btn-primary" id="add_ua_rule" data-toggle="modal" data-target="#ua-rule-modal" > Create Blocking Rule</a>
    </div>
</div>
<br>
    
      <input type="hidden" name="csrftoken" value="{{csrf_token()}}" >
        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th >Rule Name / Description</th>
                        <th>Action</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($uaRules) > 0)
                        @foreach ($uaRules as $rule)
                            <tr id="rule_{{ $rule->id }}" data-entry-id="{{ $rule->id }}">
                                <td>
									<div>
										{{ $rule->description }}
									</div>
                                  <span class="lightText">{{ $rule->value }}</span>
								</td>
                                <td>
									<select style="width:200px;" class="select2 uaAction" id="{{ $rule->id }}" name="uaAction">
										<option {{ $rule->mode == "block" ? "selected":"" }} value="block">Block</option>
										<option {{ $rule->mode == "challenge" ? "selected":"" }} value="challenge">Challenge</option>
										<option {{ $rule->mode == "js_challenge" ? "selected":"" }} value="js_challenge">JS Challenge</option>
									</select>
                                </td>
                              
                                <td>
                                    
                                  <div class="pull-top">
                                  <center>  
                                  <a style="margin:20px;"  data-toggle="modal" data-target="#rule-edit-modal_{{ $rule->id }}" class="editUaRule" rule-id="{{$rule->id}}" class="btn btn-secondary">
                                    <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                  
                                    <a class="deleteUaRule" rule-id="{{$rule->id}}" class="btn btn-danger">
                                    <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </a>
                                  </center>
                                  </div>
                                    <div class="pull-bottom">

                                    <input class="uaRuleStatus"  record-id="{{$rule->id}}"  type="checkbox" data-onstyle="success" data-offstyle="default" {{ $rule->paused == "0" ? "checked" : "" }} data-toggle="toggle" data-on="<i class='fa fa-check'></i> Active" data-off="<i class='fa fa-exclamation'></i> Paused">
                                  </div>
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
            {{-- User Agent Blocking Ends --}}

            {{-- For Zone LockDown --}}
			
	<div class="panel panel-default panel-main">
        <div class = "container-fluid">
		<br>
			<h2>Zone Lockdown</h2> 
		{{--
		Rules for {{ $records->first()->zone->name }}
        --}}
<?php
  $allowed=10;

  if($zone->plan=="pro")
  {
    $allowed=20;
  }
  elseif($zone->plan=="business")
  {
    $allowed=50;
  }
  elseif($zone->plan=="enterprise")
  {
    $allowed=100;
  }      
?>
<br>
<br>
	<div class="pull-left">
		<p>Lockdown a specific URL on your zone to specific IP addresses. This is useful to protect an admin or protected area from non-specified IP addresses.</p>
		<p style="font-weight: bold;">You have used <span id="ruleCount">{{  count($uaRules->where('paused','0')) }}</span> out of <span id="allowed">{{ $allowed }}</span> Zone Lockdown Rules <span class="glyphicon glyphicon-info-sign"data-toggle="tooltip" data-placement="top" title="Note: Only rules that are ON count towards your rules quota." ></span></p>
	</div>
	<div class="pull-right">
      <a class="btn btn-primary" id="add_ua_rule" data-toggle="modal" data-target="#zonelockdown-modal" > Create Zone Lockdown Rules</a>
    </div>
</div>
<br>
    
      <input type="hidden" name="csrftoken" value="{{csrf_token()}}" >
        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th >Rule Name / Description</th>
                        
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($uaRules) > 0)
                        @foreach ($uaRules as $rule)
                            <tr id="rule_{{ $rule->id }}" data-entry-id="{{ $rule->id }}">
                                <td>
									<div>
										{{ $rule->description }}
									</div>
                                  <span class="lightText">{{ $rule->value }}</span>
								</td>
                                <td>
									<select style="width:200px;" class="select2 uaAction" id="{{ $rule->id }}" name="uaAction">
										<option {{ $rule->mode == "block" ? "selected":"" }} value="block">Block</option>
										<option {{ $rule->mode == "challenge" ? "selected":"" }} value="challenge">Challenge</option>
										<option {{ $rule->mode == "js_challenge" ? "selected":"" }} value="js_challenge">JS Challenge</option>
									</select>
                                </td>
                              
                                <td>
                                  <div class="pull-top">
                                  <center>
                                  <a style="margin:20px;"  data-toggle="modal" data-target="#rule-edit-modal_{{ $rule->id }}" class="editUaRule" rule-id="{{$rule->id}}" class="btn btn-secondary">
                                    <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                  
                                    <a style ="color: red;" class="deleteUaRule" rule-id="{{$rule->id}}" class="btn btn-danger">
                                    <i  class="glyphicon glyphicon-remove text-danger"></i>
                                    </a>
                                  </center>
                                  </div>
                                <div class="pull-top">
                                    <input class="uaRuleStatus"  record-id="{{$rule->id}}"  type="checkbox" data-onstyle="success" data-offstyle="default" {{ $rule->paused == "0" ? "checked" : "" }} data-toggle="toggle" data-on="<i class='fa fa-check'></i> Active" data-off="<i class='fa fa-exclamation'></i> Paused">
                                </div>
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
            {{-- Zone LockDown Ends --}}

          </div>

          {{-- 4th Panel End --}}
      </div>
  </div>
</div>
{{-- Firewall Code Ends --}}


</div>


<div class="modal" id="eventModal" data-reveal>

<div class="modal-dialog modal-lg" >
 <div class="modal-content">
   <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Event Details</h4>
   </div>
   <div class="modal-body">
   <div class="row">
     
     <div class="col-lg-5">
       <label>Description</label>
      <div id="rulename"></div>
     </div>
     
     <div class="col-lg-4">
       <label>Date</label>
      <div id="date"></div>
     </div>
     <div class="col-lg-3">
        <label>Action Taken</label>
      <div id="action"></div>

     </div>

   </div>

   <div style="margin-top: 10px" class="row">
     
     <div class="col-lg-5">
       <label id="schememethod"></label>
      <div id="domain"></div>
     </div>
     <div class="col-lg-4">
       <label>URI</label>
      <div id="uri"></div>
     </div>
     <div class="col-lg-3">
     
       <label>Client IP</label>
      <div id="clientip"></div>
     

     </div>

   </div>


   <div style="margin-top: 10px" class="row">
     
    
     <div class="col-lg-5">
       <label>Country</label>
      <div id="country"></div>
     </div>

     <div class="col-lg-7">
        <label>User Agent</label>
      <div id="useragent"></div>

     </div>
    
     
   </div>
   <div class="col-lg-5">
       <label>Ray Id</label>
      <div id="scope"></div>
     </div>

   <div style="padding-top: 20px;" class="row">
   <div class="col-lg-12 text-right pull-right">
         <input style="display: none;" class="btn btn-success createRuleFromEvent" name="" value="Create Firewall Rule Based on this Event" type="submit">
     </div>
     </div>
</div></div>

</div>
</div>


 @else


   
 @endif


</div></div>

 
<!-- Modal start -->
 <div id="add_rule_modal" class="modal fade add_rule_modal" tabindex="-1" role="dialog" aria-labelledby="Add Rule">
   <div class="modal-dialog modal-lg" >
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title">Add IP Access Rule</h4>
       </div>
       <div class="modal-body">
        <div class=" container-fluid"> 
         <form id="accessRule" class="form-group">
   
     {{ csrf_field() }}
    <input type="hidden" name="zid" value="{{ $zone->id }}">
<div class="form-group">
   <select name="target" id="accessRuleTarget" class="select2 form-control">
      <option value="ip">IP Address</option>
      <option value="ip_range">IP Range </option>
      <option value="asn">ASN</option>
      <option value="country">Country</option>
   </select>
 </div>
 <br>
   <div class="valueDiv form-group">
   <input type="text" name="value" class="form-control">
   
 </div>
 <br>

 <div class="form-group" >
    <select  class="select2 form-control" name="mode">
      <option  value="whitelist">Whitelist</option>
      <option  value="block">Block</option>
      <option  value="challenge">Challenge</option>
      <option  value="js_challenge">JS Challenge</option>
    </select>
  </div>
  <br>
 <div class="form-group" >
 
   <input type="text" class="form-control" placeholder="note (optional)" name="note">
 
 </div>
 <br>
 
 <div class="form-group" >
    <center>
      <input type="submit" value="Add Access Rule" class="form-control btn btn-success" name="">
    </center>
 </div>
 </div>
 </form>
</div>
       </div>
     </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->
 <!-- Modal end -->
 
 





<div class="modal" id="ua-rule-modal" data-reveal>

<div class="modal-dialog modal-lg" >
 <div class="modal-content">
   <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Add User Agent Blocking Rule</h4>
   </div>
   <div class="modal-body">



 <div class="">

<form method="post" action="addUaRule" id="uaRule" class="uaRuleForm">
<input type="hidden" name="csrftoken" value="{{csrf_token()}}" >

<div class="form-group">
<p>Name/Description</p>
<input class="form-control" required="" placeholder="Example: Block Internet Explorer" name="description"  type="text">


</div>
<br>
<div class="form-group">
<p>Action</p>
<select style="width:100%;" class="select2 form-control"  name="mode">
             
             <option  value="block">Block</option>
             <option value="challenge">Challenge</option>
             <option  value="js_challenge">JS Challenge</option>
            
         </select>


</div>
<br>
<div class="form-group">
<p>User Agent</p>
<textarea  class="form-control" required="required" placeholder="Example: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/603.2.4 (KHTML, like Gecko) Version/10.1.1 Safari/603.2.4" name="value"></textarea>


</div>

<input type="hidden" name="zid" value="{{ $zone->id }}">
<div class="row">
<div class="col-lg-12 text-right">
<input class="btn btn-success" type="submit" value="Add Rule">
</div>
</div>
</form>

</div>



</div></div>

</div>

</div>





@if (count($uaRules) > 0)
@foreach ($uaRules as $rule)
                       


<div class="modal ruleEditModal" id="rule-edit-modal_{{ $rule->id }}"  data-reveal>

<div class="modal-dialog modal-lg" >
 <div class="modal-content">
   <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Edit User Agent Blocking Rule</h4>
   </div>
   <div class="modal-body">



 <div class="">

<form method="post" action="addUaRule" id="uaRule" class="uaRuleEditForm">
<input type="hidden" name="csrftoken" value="{{csrf_token()}}" >

<div class="form-group">
<p>Name/Description</p>
<input value="{{ $rule->description }}"  class="form-control" required="" placeholder="Example: Block Internet Explorer" name="description"  type="text">


</div>
<br>
<div class="form-group">
<p>Action</p>
<select style="width:100%;" class="select2 form-control"  name="mode">
             
             <option @if($rule->mode=="block") selected="selected" @endif  value="block">Block</option>
             <option @if($rule->mode=="challenge") selected="selected" @endif    value="challenge">Challenge</option>
             <option @if($rule->mode=="js_challenge") selected="selected" @endif    value="js_challenge">JS Challenge</option>
            
         </select>


</div>
<br>
<div class="form-group">
<p>User Agent</p>
<textarea  class="form-control" required="required" placeholder="Example: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/603.2.4 (KHTML, like Gecko) Version/10.1.1 Safari/603.2.4" name="value">{{ $rule->value }}</textarea>


</div>

<input type="hidden" name="zid" value="{{ $zone->id }}">
<input type="hidden" name="ruleid" value="{{ $rule->id }}">
<div class="row">
<div class="col-lg-12 text-right">
<input class="btn " type="submit" value="Edit Rule">
</div>
</div>
</form>

</div>



</div></div>

</div>

</div>



@endforeach

@endif



<div class="modal" id="zonelockdown-modal" data-reveal>

<div class="modal-dialog modal-lg" >
 <div class="modal-content">
   <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Add Zone Lockdown Rule</h4>
   </div>
   <div class="modal-body">



 <div class="">

<form method="post" action="addUaRule" id="uaRule" class="uaRuleForm">
<input type="hidden" name="csrftoken" value="{{csrf_token()}}" >

<div class="form-group">
<p>Name</p>
<input class="form-control" required="required" placeholder="Example: Allow traffic from Office IP address" name="zonelockdown-name"  type="text">
</div>

<br>

<div class="form-group">
<p>URLs</p>
<p>Seperate URLs by new line</p>
<textarea class="form-control" required="required" placeholder = "Example: www.yoursite.com/login or www.yoursite.com" rows="4" cols="50" name= "zonelockdown-url"></textarea>


</div>
<br>
<div class="form-group">
<p>IP Range</p>
<p>Separate IP Addresses by new line</p>
<textarea  class="form-control" required="required" placeholder="Example: 1.1.1.0/28 " rows="4" cols="50" name="value" name= "zonelockdown-ip"></textarea>


</div>

<input type="hidden" name="zid" value="{{ $zone->id }}">
<div class="row">
<div class="col-lg-12 text-right">
<input class="btn btn-success" type="submit" name = 'zonelockdown-submit' value="Add Zone Lockdown Rule">
</div>
</div>
</form>

</div>



</div></div>

</div>

</div>


<div class="modal" id="WAFGroupDetailsModal" data-reveal>

<div class="modal-dialog modal-ip" >
 <div class="modal-content">
   <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">WAF Group Details</h4>
   </div>
   <div id="WAFGroupDetailsModalBody" class="modal-body">


</div></div>

</div>
</div>


<script type="text/javascript">

Highcharts.chart('container', { 
 chart: {
     type: 'line'
 },
 title: {
     text: 'Events By Action' 
 },
 subtitle: {
     text: 'Source: WorldClimate.com'
 }, 
 xAxis: {
     categories: [ <?php foreach ($period as $key )  echo $key.',';   ?> ]
 },
 yAxis: {
     title: {
         text: 'Number Of Events'
     }
 },
 plotOptions: {
     line: {
         dataLabels: {
             enabled: true
         },
         enableMouseTracking: false
     }
 },
 series: [ 
 {
     name: 'Challenge',
     data: [<?php foreach ($challenge as $key )  {  echo $key.',' ;  } ?>]
 }, {
     name: 'Log/Simulate',
     data: [<?php foreach ($log as $key )  {  echo $key.',' ;  } ?>]
 },
 {
     name: 'Allow',
     data: [<?php foreach ($allow as $key )  {  echo $key.',' ;  } ?>]
 }, {
     name: 'Drop',
     data: [<?php foreach ($drop as $key )  {  echo $key.',' ;  } ?>]
 }

 ]
})


</script>

 
@stop


@section('javascript')
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('admin.users.mass_destroy') }}';
    </script>
@endsection

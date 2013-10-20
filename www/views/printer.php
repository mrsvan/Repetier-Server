<div class="container">
<div class="row">
<div class="col-md-3 col-xs-12">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">{{active.status.name}}
                    <div class="btn-group" style="float: right;top: -9px;right: -13px;">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-cog"></i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" style="right:0;left:auto">
                            <li ng-hide="active.status.active"><a ng-click="activate()"
                                                                  href="javascript:void(0)"><?php _("Activate") ?></a>
                            </li>
                            <li ng-show="active.status.active"><a ng-click="deactivate()"
                                                                  href="javascript:void(0)"><?php _("Deactivate") ?></a>
                            </li>
                            <li ng-show="active.status.active"><a ng-click="showCommunication()"
                                                                  href="javascript:void(0)"><?php _("Connection Informations") ?></a>
                            </li>
                            <li ng-show="active.status.active"><a ng-click="editEeprom()"
                                                                  href="javascript:void(0)"><?php _("EEPROM Settings") ?></a>
                            </li>
                            <li><a href="#/scriptConfig/{{activeSlug}}"><?php _("Scripts") ?></a></li>
                            <li><a href="#/printerConfig/{{activeSlug}}"><?php _("Configuration") ?></a></li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body small-font" style="padding-left:0px;padding-right:0;">
                    <div class="row small-margin">
                        <div class="col-xs-5"><?php _("Status:") ?></div>
                        <div class="col-xs-7" ng-bind-html-unsafe="active.status | online"></div>
                    </div>
                    <div ng-show="active.status.online">
                        <div class="row small-margin" ng-repeat="e in active.state.extruder">
                            <div class="col-xs-5"><?php _("Extr.") ?> {{$index+1}}:</div>
                            <div class="col-xs-7">{{e.tempRead | temp}} / {{e.tempSet | temp}}</div>
                        </div>
                        <div class="row small-margin" ng-show="activeConfig.general.heatedBed">
                            <div class="col-xs-5"><?php _("Bed:") ?></div>
                            <div class="col-xs-7">{{active.state.bedTempRead | temp}} / {{active.state.bedTempSet
                                | temp}}
                            </div>
                        </div>
                        <div class="row small-margin">
                            <div class="col-xs-5"><?php _("Speed:") ?></div>
                            <div class="col-xs-7">{{active.state.speedMultiply}}%</div>
                        </div>
                        <div class="row small-margin">
                            <div class="col-xs-5"><?php _("Flow:") ?></div>
                            <div class="col-xs-7">{{active.state.flowMultiply}}%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default" ng-show="isJobActive">
                <div class="panel-heading"><?php _("Current Print") ?></div>
                <div class="panel-body small-font">
                    <div class="row">
                        <div class="col-xs-5"><?php _("Printing:") ?></div>
                        <div class="col-xs-7">{{active.status.job}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5">E<?php _("TA:") ?></div>
                        <div class="col-xs-7">{{active.status.printTime-active.status.printedTimeComp | hms}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="progress progress-striped">
                                <div class="metertext">{{active.status.done | number:2}}%</div>
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     style="width: {{active.status.done}}%"></div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <button ng-click="stopPrint()" class="btn btn-danger btn-block"><i
                                    class="icon-stop"></i> <?php _("Stop") ?>
                            </button>
                        </div>
                        <div class="col-xs-6">
                            <button ng-click="pausePrint()" class="btn btn-primary btn-block"><i class="icon-pause"></i>
                                <?php _("Pause") ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default small-font"
                 ng-show="active.status.online && (queue.length>1 || (queue.length==1 && queue[0].id!=active.status.jobid))">
                <div class="panel-heading"><?php _("Print Queue") ?></div>
                <div class="panel-body small-font">
                    <div class="row queue" ng-repeat="q in queue" ng-click="selectQueue(q,$event);"
                         ng-hide="q.id==active.status.jobid" ng-class="{queueactive:queueFileSelected(q)}">
                        <div class="col-xs-12">
                            {{q.name}}
                        </div>
                    </div>
                    <div class="row" ng-show="activeQueue" style="margin-top:10px">
                        <div class="col-xs-6">
                            <button class="btn btn-block btn-danger" ng-click="dequeActive()"><i class="icon-minus"></i>
                                <?php _("Remove") ?>
                            </button>
                        </div>
                        <div class="col-xs-6">
                            <button class="btn btn-block btn-primary" ng-hide="isJobActive"
                                    ng-click="printActiveQueue()"><i
                                    class="icon-print"></i> <?php _("Print") ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-9 col-xs-12">
<ul class="nav nav-tabs" id="printerTabs">
    <li ng-show="active.status.online"><a href="#panel1" data-toggle="tab"><?php _("Control") ?></a></li>
    <li ng-show="active.status.online"><a href="#panelConsole" data-toggle="tab"><?php _("Console") ?></a></li>
    <li ng-show="activeConfig.webcam.method"><a href="#panel4" data-toggle="tab"><?php _("Camera") ?></a></li>
    <li><a href="#panel3" data-toggle="tab"><?php _("G-Codes") ?></a></li>
</ul>
<div class="tab-content">
<div class="tab-pane active fade" id="panel1" ng-show="active.status.online">
    <div class="row">
        <div class="col-12 col-sm-8 hidden-sm" id="control-row">
            <div id="control-hscroll-container" style="margin-left:40px;padding:10px 11px">
                <div id="xpos" slider orientation="horizontal" min="{{activeConfig.movement.xMin}}"
                     max="{{activeConfig.movement.xMax}}" step="0.1" precision="1" size="{{hsliderSize}}"
                     ng-model="movoToXPos" enabled="{{!isJobActive}}" moved="xMoveTo(value)" letter="X"></div>
            </div>
            <div style="float:left;width:40px;height:300px;padding:11px 10px">
                <div id="control-vscoll-container" slider orientation="vertical"
                     min="{{activeConfig.movement.yMin}}" max="{{activeConfig.movement.yMax}}" step="0.1"
                     precision="1" ng-model="movoToYPos" style="height:300px" enabled="{{!isJobActive}}"
                     moved="yMoveTo(value)" flip="true" letter="Y"></div>
                <br/>
            </div>
            <div id="control-view" class="well"
                 style="float:left;width:300px;height:300px;padding:10px"></div>
            <div style="float:left;width:40px;height:300px;padding:11px 10px">
                <div id="control-vscoll-container2" slider orientation="vertical"
                     min="{{activeConfig.movement.zMin}}" max="{{activeConfig.movement.zMax}}" step="0.1"
                     precision="1" ng-model="movoToZPos" style="height:300px" enabled="{{!isJobActive}}"
                     moved="zMoveTo(value)" flip="true" letter="Z"></div>
                <br/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="row margin-top">
                <div class="col-xs-8">
                    X: {{movoToXPos | number:2}} mm
                </div>
                <div class="col-xs-4">
                    <button ng-show="activeConfig.movement.xEndstop" class="btn btn-block"
                            ng-click="sendGCode('G28 X0')" ng-hide="isJobActive"><i
                            class="icon-home"></i> X
                    </button>
                </div>
            </div>
            <div class="row margin-top">
                <div class="col-xs-8">
                    Y: {{movoToYPos | number:2}} mm
                </div>
                <div class="col-xs-4">
                    <button ng-show="activeConfig.movement.yEndstop" class="btn btn-block"
                            ng-click="sendGCode('G28 Y0')" ng-hide="isJobActive"><i
                            class="icon-home"></i> Y
                    </button>
                </div>
            </div>
            <div class="row margin-top">
                <div class="col-xs-8">
                    Z: {{movoToZPos | number:2}} mm
                </div>
                <div class="col-xs-4">
                    <button ng-show="activeConfig.movement.zEndstop" class="btn btn-block"
                            ng-click="sendGCode('G28 Z0')" ng-hide="isJobActive"><i
                            class="icon-home"></i> Z
                    </button>
                </div>
            </div>
            <div class="row margin-top">
                <div class="col-xs-8">
                </div>
                <div class="col-xs-4">
                    <button ng-show="activeConfig.movement.allEndstops" class="btn btn-block"
                            ng-click="sendGCode('G28')" ng-hide="isJobActive"><i
                            class="icon-home"></i> All
                    </button>
                </div>
            </div>
            <div class="row margin-top">
                <div class="col-xs-12">
                    <?php _("Speed multiplier:") ?>
                    <button class="btn btn-small" ng-click="speedChange(-1)"><i class="icon-minus-sign"></i>
                    </button>
                    {{active.state.speedMultiply}}%
                    <button class="btn btn-small" ng-click="speedChange(1)"><i class="icon-plus-sign"></i>
                </div>
                <div id="control-hscroll-container" style="padding:10px 11px">
                    <div slider orientation="horizontal" min="25"
                         max="300" step="1" precision="0" size="220"
                         ng-model="active.state.speedMultiply"
                         moved="sendGCode('M220 S'+value)" letter="S"></div>
                </div>
            </div>
            <div class="row margin-top">
                <div class="col-xs-12">
                    <?php _("Flow multiplier:") ?>
                    <button class="btn btn-small" ng-click="flowChange(-1)"><i class="icon-minus-sign"></i>
                    </button>
                    {{active.state.flowMultiply}}%
                    <button class="btn btn-small" ng-click="flowChange(1)"><i class="icon-plus-sign"></i>
                </div>
                <div id="control-hscroll-container" style="padding:10px 11px">
                    <div slider orientation="horizontal" min="50"
                         max="150" step="1" precision="0" size="220"
                         ng-model="active.state.flowMultiply"
                         moved="sendGCode('M221 S'+value)" letter="F"></div>
                </div>
            </div>
            <div class="row margin-top" ng-show="activeConfig.general.fan">
                <div class="col-xs-8 vcenter-btnline">
                    <?php _("Fan:") ?> {{fanPercent | number:1}}%
                </div>
                <div class="col-xs-4">
                    <boolswitch class="small" on="On" off="Off" value="active.state.fanOn"
                                changed="fanEnabledChanged()"></boolswitch>
                </div>
                <div id="control-hscroll-container" style="padding:10px 11px">
                    <div slider orientation="horizontal" min="0"
                         max="100" step="0.5" precision="1" size="220"
                         ng-model="fanPercent"
                         moved="fanSpeedChanged(value)" letter="F"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 margin-top" ng-repeat="e in activeConfig.extruders">
            Extruder {{$index+1}}:<input type="number" class="input-small" ng-model="e.settemp">
            <button class="btn btn-default" ng-click="setExtruderTemperature($index,e.settemp)"><?php _("Set") ?></button>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                   <?php _("Quick temperatures") ?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="javascript:void(0)" ng-click="setExtruderTemperature($index,0)"><?php _("Off") ?></a></li>
                    <li class="divider"></li>
                    <li ng-repeat="t in e.temperatures"><a href="javascript:void(0)" ng-click="setExtruderTemperature($parent.$index,t.temp)">{{t.name}}</a></li>
                </ul>
            </div>
        </div>
        <div class="col-xs-12 margin-top" ng-show="activeConfig.general.heatedBed">
            <?php _("Heated bed") ?>:<input type="number" class="input-small" ng-model="activeConfig.heatedBed.settemp">
            <button class="btn btn-default" ng-click="setBedTemperature(activeConfig.heatedBed.settemp)"><?php _("Set") ?></button>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <?php _("Quick temperatures") ?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="javascript:void(0)" ng-click="setBedTemperature(0)"><?php _("Off") ?></a></li>
                    <li class="divider"></li>
                    <li ng-repeat="t in activeConfig.heatedBed.temperatures"><a href="javascript:void(0)" ng-click="setBedTemperature(t.temp)">{{t.name}}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="panelConsole">
    <div class="row margin-top" ng-show="active.status.online">
        <div class="col-xs-2 vcenter-btnline">
            <?php _("Commands") ?>
        </div>
        <div class="col-xs-2">
            <switch class="small" value="logCommands"></switch>
        </div>
        <div class="col-xs-2 vcenter-btnline">
            <?php _("ACK") ?>
        </div>
        <div class="col-xs-2">
            <switch class="small" value="logACK"></switch>
        </div>
        <div class="col-xs-2 vcenter-btnline">
            <?php _("Pause") ?>
        </div>
        <div class="col-xs-2">
            <switch class="small" value="logPause"></switch>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 margin-top">
            <div class="row">
                <div class="col-xs-7">
                    <input type="text" class="form-control" ng-model="cmd"
                           placeholder="<?php _("Enter your g-code here") ?>"
                           enter="sendCmd()">
                </div>
                <div class="col-xs-5">
                    <div class="btn-group">
                        <button type="button" ng-click="sendCmd()"
                                class="btn btn-primary"><?php _("Send") ?>
                        </button>
                        <button type="button" class="btn btn-primary dropdown-toggle"
                                data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0)"
                                   ng-click="sendGCode('G28')"><?php _("Home All") ?></a></li>
                            <li><a href="javascript:void(0)"
                                   ng-click="sendGCode('M115')"><?php _("Show Capabilities") ?></a>
                            </li>
                            <li><a href="javascript:void(0)"
                                   ng-click="sendGCode('M119')"><?php _("Show Endstop Status") ?></a>
                            </li>
                            <li><a href="javascript:void(0)"
                                   ng-click="sendGCode('M114')"><?php _("Show Coordinates") ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 margin-top">
            <div id="logpanel" class="logpanel" style="height:300px;overflow:scroll" autoscroll2="logAutoscroll">
                <div ng-repeat="l in active.log" ng-bind-html-unsafe="l.t" class="{{l.c}}"></div>
            </div>
        </div>
        <div class="col-xs-12">
            <p>
                <small><?php _("Commands shows commands send to the printer. ACK shows normally suppressed acknowledgement data send back from the printer. You should only enable them for debug purposes or they might slow down your interface. If pause is enabled, new log messages get suppressed, so you can check the log without a hurry.<br/>Use the command interface to send any arbitrary commands to your printer. Remember to use uppercase letter for the parameter. Some usefull commands are available in the drop down list.") ?>
                </small>
            </p>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="panel4">
    <div class="row">
        <div class="col-xs-6">
            <select class="form-control" ng-model="webcammode"
                    ng-options="w.id as w.name for w in webcammodes"></select>
        </div>
        <div class="col-lg-2 col-xs-4">
            <button ng-click="refreshWebcamImage()"><i class="icon-refresh"></i> <?php _("Reload") ?></button>
        </div>
    </div>

    <div ng-show="webcammode" style="margin-top:10px">
        <img ng-src="{{webcamUrl}}"/>
    </div>
</div>
<div class="tab-pane fade" id="panel3">
    <div class="row" style="margin-top:10px">
        <div class="col-lg-6 col-sm-6" style="margin-bottom:10px">
            <div class="filelist">
                <div class="file" ng-repeat="f in models" ng-class="{active:f==activeGCode}"
                     ng-click="selectGCode(f)">{{f.name}}
                </div>
                <div ng-show="models.length==0" class="padding">
                    <?php _("No g-code files available") ?>
                </div>
            </div>
            <button data-toggle="modal" data-target="#uploadGCode" class="btn btn-primary"><i
                    class="icon-plus-squared"></i> <?php _("Upload G-Code") ?>
            </button>
        </div>
        <div class="col-lg-6 col-sm-6 well" ng-show="activeGCode">
            <h4 style="margin-top:0"><?php _("File Informations") ?></h4>

            <div class="infodesc"><?php _("Filename:") ?><span>{{activeGCode.name}}</span></div>
            <div class="infodesc"><?php _("Printed:") ?><span>{{activeGCode.printed}} times</span></div>
            <div class="infodesc"><?php _("Printing time:") ?><span>{{activeGCode.printTime | hms}}</span></div>
            <div class="infodesc"><?php _("Filesize / Lines:") ?><span>{{activeGCode.length | byte}} / {{activeGCode.lines}}</span>
            </div>
            <div class="infodesc"><?php _("Lines:") ?><span>{{activeGCode.lines}}</span></div>
            <div class="infodesc"><?php _("Layer:") ?><span>{{activeGCode.layer}}</span></div>
            <div class="infodesc"><?php _("Filament usage:") ?><span>{{activeGCode.filamentTotal | number:0}} mm</span>
            </div>
            <div class="btn btn-primary" ng-click="printGCode()"><i class="icon-print"></i>
                <?php _("Print") ?>
            </div>
            <div class="btn btn-primary" ng-click="previewGCode(activeGCode.id)"><i class="icon-eye-open"></i>
                <?php _("Preview") ?>
            </div>
            <div class="btn btn-danger" data-reveal-id="deleteGCodeQuestion"><i
                    class="icon-trash"></i> <?php _("Delete") ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="row">
    <div class="col-sm-12" ng-hide="true">{{printerConfig}}</div>
</div>
</div>

<div id="deleteGCodeQuestion" class="modal fade">
    <h2><?php _("Security question") ?></h2>

    <p class="lead"><?php _("Do you really want to delete") ?> {{activeGCode.name}}?</p>

    <div class="row">
        <div class="small-4 columns button" ng-click="closeReveal('deleteGCodeQuestion')"><?php _("No") ?></div>
        <div class="small-4 small-offset-4 columns button alert" ng-click="deleteActiveGCode()"><i
                class="icon-trash"></i> <?php _("Yes") ?>
        </div>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>
<div id="uploadGCode" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php _("Upload G-Code") ?></h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="/printer/model/{{activeSlug}}" id="formuploadgcode">
                    <input type="hidden" name="a" value="upload"/>
                    <label><?php _("Job Name") ?></label>
                    <input type="text" name="name" placeholder="Optional name"/>
                    <label><?php _("G-Code File") ?></label>
                    <input type="file" name="file"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" ng-click="uploadGCode()"><i
                        class="icon-upload-cloud"></i><?php _("Upload") ?></button>
            </div>
        </div>
    </div>
</div>
<div id="dialogPreview" class="modal fade">
    <div class="modal-dialog" style="width:95%;padding:0">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php _("Preview G-Code") ?> {{activeSlug}}/{{previewData}}</h4>
            </div>
            <div class="modal-body" style="padding:0">
                <div gcodepreview data="{{previewData}}" slug="{{activeSlug}}" style="width:100%;height:100%"></div>
            </div>
            <div class="modal-footer" style="margin-top:0">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php _("Close") ?></button>
            </div>
        </div>
    </div>
</div>
<div id="dialogConnectionData" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php _("Connection Informations") ?></h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td><?php _("Data send:") ?></td>
                        <td>{{comData.bytesSend| byte}}</td>
                    </tr>
                    <tr>
                        <td><?php _("Data received:") ?></td>
                        <td>{{comData.bytesReceived| byte}}</td>
                    </tr>
                    <tr>
                        <td><?php _("Lines send:") ?></td>
                        <td>{{comData.linesSend}}</td>
                    </tr>
                    <tr>
                        <td><?php _("Errors:") ?></td>
                        <td>{{comData.resendErrors}}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php _("Close") ?></button>
            </div>
        </div>
    </div>
</div>
<div id="dialogEeprom" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php _("EEPROM Settings") ?></h4>
            </div>
            <div class="modal-body" style="overflow:auto;height:300px">
                <table class="table table-condensed">
                    <tr>
                        <th><?php _("Parameter") ?></th>
                        <th><?php _("Value") ?></th>
                    </tr>
                    <tr ng-repeat="e in eeprom" ng-class="{warning:e.value!=e.valueOrig}">
                        <td>{{e.text}}</td>
                        <td><input type="text" ng-model="e.value"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" ng-click="saveEeprom()"><i
                        class="icon-save"></i> <?php _("Save") ?></button>
                <button type="button" class="btn" data-dismiss="modal"><?php _("Close") ?></button>
            </div>
        </div>
    </div>
</div>

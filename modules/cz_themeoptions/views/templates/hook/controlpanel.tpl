<div class="control-paneltool">
<div class="panel_content">
    <div class="panel-close hidepanel"><a href="javascript:void(0)"></a></div>

    <h2 class="panel_headding">Theme Customizer</h2>
    
    <div class="panel-settings">
            <div class="control-group-wrapper color-group skin-setting">
                <div class="control_grouptitle">Default Skins</div>
                <div class="control-group">
                    <div class="control-grouplist">
                        <div class="color-items"> 
                            <div class="color-item" data-color="#d9ae21" style="background-color:#d9ae21"></div>                                                      
                            <div class="color-item" data-color="#719d79" style="background-color:#719d79"></div> 
                            <div class="color-item" data-color="#d98c21" style="background-color:#d98c21"></div>                                    
                            <div class="color-item" data-color="#6b971b" style="background-color:#6b971b"></div>
                            <div class="color-item" data-color="#a69442" style="background-color:#a69442"></div>    
                            <div class="color-item" data-color="#c7392c" style="background-color:#c7392c"></div>
                            <div class="color-item" data-color="#838920" style="background-color:#838920"></div>  
                            <div class="color-item" data-color="#34373c" style="background-color:#34373c"></div>
                        </div> 
                    </div>
                </div>
            </div>

            <div class="control-group-wrapper color-group color-setting">
                <div class="control_grouptitle">Color & Font Settings</div>
                <div class="control-group">

                    <div class="control-grouplist">                    
                        <div class="control_label">Primary Color</div>
                        <div class="control-tool">
                            <input type="text" id="primaryColor" class="preview_color"> 
                        </div>
                    </div>

                    <div class="control-grouplist">                    
                        <div class="control_label">Secondary Color</div>
                        <div class="control-tool">
                            <input type="text" id="secondaryColor" class="preview_color">
                        </div>                         
                    </div>

                    <div class="control-grouplist">                    
                        <div class="control_label">Price Color</div>
                        <div class="control-tool">
                            <input type="text" id="priceColor" class="preview_color">
                        </div>                         
                    </div>

                    <div class="control-grouplist">                    
                        <div class="control_label">Link Hover Color</div>
                        <div class="control-tool">
                            <input type="text" id="linkHoverColor" class="preview_color">
                        </div>                         
                    </div>

                    <div class="control-grouplist">                    
                        <div class="control_label">Body Font</div>
                        <div class="control-tool">
                            <div class="preview_font">
                                <select name="bodyFont" id="bodyFont">
                                    {foreach from=$fontlist_array item=i}
                                        <option value="{$i.name}" data-link="//fonts.googleapis.com/css2?family={$i.link}">{$i.name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>                         
                    </div>

                     <div class="control-grouplist">                    
                        <div class="control_label">Body Font Size</div>
                        <div class="control-tool">
                            <div class="preview_font">
                                <select name="bodyFontSize" id="bodyFontSize">
                                    {foreach from=$fontsize_array item=i}
                                        <option value="{$i.name}">{$i.name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>                         
                    </div>

                    <div class="control-grouplist">                    
                        <div class="control_label">Title Font</div>
                        <div class="control-tool">
                            <div class="preview_font">
                                <select name="titleFont" id="titleFont">
                                    {foreach from=$fontlist_array item=i}
                                        <option value="{$i.name}" data-link="//fonts.googleapis.com/css2?family={$i.link}">{$i.name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>                         
                    </div>

                    <div class="control-grouplist">                    
                        <div class="control_label">Banner Font</div>
                        <div class="control-tool">
                            <div class="preview_font">
                                <select name="bannerFont" id="bannerFont">
                                    {foreach from=$fontlist_array item=i}
                                        <option value="{$i.name}" data-link="//fonts.googleapis.com/css2?family={$i.link}">{$i.name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>                         
                    </div>

                </div>
            </div>

            <div class="control-group-wrapper layout-setting">
                <div class="control_grouptitle">Layout Settings</div>
                <div class="control-group">   
                    <div class="control-grouplist"> 
                        <div class="control_label">Boxed Layout</div>
                        <div class="control-tool">                        
                            <div class="switchOption layoutOption">
                                <input type="radio" id="layoutWide" name="switch_layout" value="widelayout">
                                <label for="layoutWide"><span></span></label>
                                <input type="radio" id="layoutBoxed" name="switch_layout" value="boxlayout">
                                <label for="layoutBoxed"><span></span></label>                                
                                <span class="slider"></span>
                            </div>                        
                        </div>
                    </div>
                    
                    <div class="control-grouplist" id="pattern_block" style="display:none"> 
                        <div class="control-grouplist">                    
                            <div class="control_label">Body Back Color</div>
                            <div class="control-tool">
                                <input type="text" id="bodyBkgColor" class="preview_color">
                            </div>
                        </div>
                        <div class="pattern-items">  
                            {for $i=1 to 10}
                                <div class="pattern-item" id="pattern{$i}" style="background-image:url({$image_url}/body-bg{$i}.png)" data-image-url="{$image_url}/body-bg{$i}.png"></div>
                            {/for}
                        </div> 
                    </div>

                    <div class="control-grouplist"> 
                        <div class="control_label">Sticky Header</div>
                        <div class="control-tool">                        
                            <div class="switchOption stickyHeader">                            
                                <input type="radio" id="noSticky" name="sticky_header" value="no">
                                <label for="noSticky"><span></span></label>
                                <input type="radio" id="yesSticky" name="sticky_header" value="yes">
                                <label for="yesSticky"><span></span></label>
                                <span class="slider"></span>
                            </div>                        
                        </div>
                    </div>

                    <div class="control-grouplist"> 
                        <div class="control_label">Border Radius</div>
                        <div class="control-tool">                        
                            <div class="switchOption borderRadius">                            
                                <input type="radio" id="noRadius" name="border_radius" value="no">
                                <label for="noRadius"><span></span></label>
                                <input type="radio" id="yesRadius" name="border_radius" value="yes">
                                <label for="yesRadius"><span></span></label>
                                <span class="slider"></span>
                            </div>                        
                        </div>
                    </div>

                </div>
            </div>
 
            <div class="control-group-wrapper control-reset">
                <button class="reset_settings btn btn-primary" id="resetSettings">Reset Settings</button>
            </div>
    </div>
</div>
</div>



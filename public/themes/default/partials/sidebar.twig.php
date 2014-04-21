			<div class='hidden-xs col-md-2 col-lg-2 center' id="sidebar" style="margin-top: 15px;">
    			<a href="{{ URL.to('expression/add') }}" class="btn btn-embossed btn-wide btn-success"><strong><span class="fui-plus"></span> Add Your <br/>Expression</a></strong>
    			<hr/>
    			<p><a href="http://www.cafehostel.com.br" title="Cafe Hostel" alt="Cafe Hostel"><img src='{{ URL.to('/themes/default/assets/img/ads/banner-cafehostel.png') }}' class='img-thumbnail' /></a></p>
    			<hr/>
    			<p class='sidebar-paragraph'>Subscribe to our "word of the day" mailing list</p>
                {{ Form.open({'url': 'subscribe', 'class': 'form-vertical', 'id': 'subscribeForm'})}}
                    <div class='form-group'>
                        <div class='input-group'>
                            {{ Form.input('email', 'email', '', {'class': 'form-control input-sm', 'placeholder': 'E-mail'}) }}
                            <span class='input-group-btn'>
                                <button type="submit" class="btn btn-inverse input-sm">
                                    <span class='fui-new'></span>
                                </button>   
                            </span>
                        </div>
    				</div>
                    <div class="control-group" style="display:none;">
                        <div class="controls">
                            {{ Form.honeypot('name', 'time') }}
                        </div>
                    </div>
    			{{ Form.close() }}
    		</div>
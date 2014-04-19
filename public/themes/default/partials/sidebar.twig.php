			<div class='span2 center' style="margin-top: 15px;">
    			<p><a href="{{ URL.to('expression/add') }}" class="btn btn-success"><strong><i class="icon-plus"></i> Add Your Expression</a></p>
    			<hr/>
    			<p><a href="http://www.cafehostel.com.br" title="Cafe Hostel" alt="Cafe Hostel"><img src='{{ URL.to('/themes/default/assets/img/ads/banner-cafehostel.png') }}' width="120px" class='' /></a></p>
    			<hr/>
    			<p><a href="http://tupilabs.com" title="TupiLabs" alt="TupiLabs"><img src='{{ URL.to('/themes/default/assets/img/tupilabs/ad_01.png') }}' width="120px" class='' /></a></p>
    			<hr/>
    			<h4>Word of the day</h4>
    			<p>Subscribe to the SLBR word of the day mailing list</p>
                {{ Form.open({'url': 'subscribe', 'class': 'form-vertical', 'id': 'subscribeForm'})}}
                    <div class="control-group">
    				    <div class="controls">
    					   {{ Form.input('email', 'email', '', {'class': 'input-small', 'placeholder': 'E-mail'}) }}
    					   <button type="submit" value="" class="btn btn-info"><i class="icon-pencil"></i></button>
                        </div>
    				</div>
                    <div class="control-group" style="display:none;">
                        <div class="controls">
                            {{ Form.honeypot('name', 'time') }}
                        </div>
                    </div>
    			{{ Form.close() }}
    		</div>
<section id='main' style="top: 0; left: 0;">
	<div class='container-fluid'>
		<div class="row-fluid">
			<div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=221891907922920";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <div id="share" style="background-color: #EEEEEE; margin: 0px; padding: 0px;">
        		<div class='text'>
        			<br />
        			<div>
        				<h2 class='subtitle'>{{ definition.expression.text }} </h2>
        				<div class='rating'>
        					{{ Form.open({'url': '/rate' }) }}
        					    <input type="hidden" name="expressionId" value="{{ definition.expression_id }}" />
                                <input type="hidden" name="definitionId" value="{{ definition.id }}" />
                                <span class="like_count">{{ likes }} </span> 
                                <input type="hidden" name="rating" value="0" /> ups, 
                                <span class="dislike_count">{{ dislikes }} </span> 
                                downs <a href="#" class="like"><i class="icon-thumbs-up">&nbsp;</i>
                                </a> <a href="#" class="dislike"><i class="icon-thumbs-down">&nbsp;</i>
                                </a>
        					{{ Form.close() }}
        				</div>
        				<div class="date">
        					{{ definition.create_date }}
        				</div>
        			</div>
        		</div>
        		<div class='description'>
        			<p>
        				{{ definition.description }}
        			</p>
        		</div>
        		<div class='example'>
        			<p>
        				{{ definition.example }}
        			</p>
        		</div>
        		<div class='tags'>
        			<strong>Tags</strong>&nbsp;
        			{% if definition.tags is defined %}
                        {% for tag in definition.tags|split(',') %}
                            {% set tag = tag|trim %}
        			<span class="tag box">{{ tag }} </span>
        				{% endfor %}
        			{% endif %}
        		</div>
        		<div class="authorship">
        			<strong>Author:</strong> <span class="author box">{{ definition.contributor }}
        			</span>
        		</div>
        		<br />
        		<div id="social_medias">
        		    <a href="https://twitter.com/share" class="twitter-share-button" data-url="{{ URL.to('/expression/define?e=' ~ definition.expression.text) }}" data-text="{{ definition.expression.text }}" data-via="SpeakLikeABR" data-hashtags="BrazilianPortuguese">Tweet</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        			<div class="fb-like" data-href="{{ URL.to('expression/define?e=' ~ definition.expression.text) }}" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
        		</div>
        		<div id="contact">
        			{{ Form.open({'url': Request.url(), 'class': 'form-horizontal', 'id': 'shareExpressionForm'}) }}
        			<div class="controls">
        				<h5>Send by e-mail</h5>
        			</div>
        			<div class="control-group-pad">
        				{{ Form.label('from_name', 'Your name', {'class': 'control-label'}) }}
        				<div class="controls">
        					{{ Form.input('text', 'from_name', old.from_name, {'id': 'from_name', 'name': 'from_name', 'style': 'width: 90%;'}) }}
        				</div>
        			</div>
        			<div class="control-group-pad">
        				{{ Form.label('from_email', 'Your email', {'class': 'control-label'}) }}
        				<div class="controls">
        					{{ Form.input('text', 'from_email', old.from_email, {'id': 'from_email', 'name': 'from_email', 'style': 'width: 90%;'}) }}
        				</div>
        			</div>
        			<div class="control-group-pad">
        				{{ Form.label('to', 'To', {'class': 'control-label'}) }}
        				<div class="controls">
        					{{ Form.input('text', 'to', old.to, {'id': 'to', 'name': 'to', 'style': 'width: 90%'}) }}
        				</div>
        			</div>
        			<div class="control-group-pad">
        				{{ Form.label('email', 'Email', {'class': 'control-label'}) }}
        				<div class="controls">
        					{{ Form.input('text', 'email', old.email, {'id': 'email', 'name': 'email', 'style': 'width: 90%;'}) }}
        				</div>
        			</div>
        			<div class="control-group-pad" style='display: none;'>
        				<div class="controls">
        					{{ Form.honeypot('custom_name', 'expire') }}
        				</div>
        			</div>
        			<hr />
        			<div class="row">
        				<div class="" style="text-align: center;">
        					{{ Form.submit('Send', {'class': "btn btn-primary", 'id': 'btnSubmitForm'}) }}
        				</div>
        			</div>
        			<br />
        			{{ Form.close() }}
        		</div>
            </div>
		</div>
	</div>
</section>
<script type='text/javascript'>
templatecallback = function() {
	base_url = '{{ URL.to('/') }}';
    console.log('Loading YUI...');
    YUI().use(
      'aui-form-validator',
      'node',
      function(Y) {
        var rules = {
            from_name: {
                required: true, 
                rangeLength: [1, 50]
            },
            from_email: {
                email: true, 
                required: true
            },
            to: {
                required: true, 
                rangeLength: [1, 50]
            },
            email: {
                required: true, 
                email: true
            }
        };

        var validator = new Y.FormValidator(
        {
            boundingBox: '#shareExpressionForm',
            rules: rules,
            showAllMessages: true
        });

        var btn = Y.one('#btnSubmitForm');
        Y.one('#shareExpressionForm').on('submit', function(e) {
            var originalText = btn.get('value');
            btn.set('value', 'Sending...');
            btn.set('disabled', 'disabled');
            validator.validate();
            if(validator.hasErrors()) {
                btn.set('value', originalText);
                btn.set('disabled', null);
                e.preventDefault();
            }
        });
      }
    );
}
</script>
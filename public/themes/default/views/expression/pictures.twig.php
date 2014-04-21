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
                        <small>
                            <input type="hidden" name="expressionId" value="{{ definition.expression_id }}" />
                            <input type="hidden" name="definitionId" value="{{ definition.id }}" />
                            <span class="like_count">{{ likes }} </span> 
                            <input type="hidden" name="rating" value="0" /> ups, 
                            <span class="dislike_count">{{ dislikes }} </span> 
                            downs <a href="#" class="like"><span class="glyphicon glyphicon-thumbs-up"></span>
                            </a> <a href="#" class="dislike"><span class="glyphicon glyphicon-thumbs-down"></span>
                            </a>
                        </small>
                        {{ Form.close() }}
                    </div>
                        <div class="date">
                            {{ definition.create_date }}
                        </div>
                    </div>
                </div>
                <div class='description'>
                    <p class='entry-paragraph'>
                        {{ definition.description }}
                    </p>
                </div>
                <div class='example'>
                    <p class='entry-paragraph'>
                        {{ definition.example }}
                    </p>
                </div>
                <div class='tags'>
                    <small><strong>Tags</strong></small>
                    {% if definition.tags is defined %}
                        {% for tag in definition.tags|split(',') %}
                            {% set tag = tag|trim %}
                    <span class='label label-default'>{{ tag }}</span> 
                        {% endfor %}
                    {% endif %}
                </div>
                <div class="authorship">
                    <strong><small>Author:</strong> <span class="author box">{{ definition.contributor }}</small>
                    </span>
                </div>
                <br />
                <div id="social_medias">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="{{ URL.to('/expression/define?e=' ~ definition.expression.text) }}" data-text="{{ definition.expression.text }}" data-via="SpeakLikeABR" data-hashtags="BrazilianPortuguese">Tweet</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                    <div class="fb-like" data-href="{{ URL.to('expression/define?e=' ~ definition.expression.text) }}" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
                </div>
                <br/>
                <div id="pictures">
                    {{ Form.open({'url': Request.url(), 'class': 'form-horizontal', 'id': 'pictureExpressionForm'}) }}
                    <div>
                        <p>Add Picture</p>
                    </div>
                    <div class="form-group">
                        {{ Form.label('url', 'Image URL', {'class': 'col-xs-2 control-label'}) }}
                        <div class='col-xs-10'>
                            {{ Form.input('text', 'url', old.url, {'id': 'url', 'class': 'form-control'}) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form.label('reason', 'Why is this picture related to this expression?', {'class': 'col-xs-2 control-label'}) }}
                        <div class="col-xs-10">
                            {{ Form.input('text', 'reason', old.reason, {'id': 'reason', 'class': 'form-control'}) }}
                        </div>
                    </div>
                    <div class="control-group-pad" style='display: none;'>
                        <div class="controls">
                            {{ Form.honeypot('custom_name', 'expire') }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form.label('contributor', 'Pseudonym', {'class': 'col-xs-2 control-label'}) }}
                        <div class="col-xs-10">
                            {{ Form.input('text', 'contributor', old.contributor, {'id': 'contributor', 'class': 'form-control'}) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form.label('email', 'E-mail', {'class': 'col-xs-2 control-label'}) }}
                        <div class="col-xs-10">
                            {{ Form.input('text', 'email', old.email, {'id': 'email', 'class': 'form-control'}) }}
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
    YUI().use(
      'aui-form-validator',
      'node',
      function(Y) {
        var rules = {
            url: {
                required: true, 
                url: true
            },
            reason: {
                required: true,
                rangeLength: [3, 50]
            },
            contributor: {
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
            boundingBox: '#pictureExpressionForm',
            rules: rules,
            showAllMessages: true
        });

        var btn = Y.one('#btnSubmitForm');
        Y.one('#pictureExpressionForm').on('submit', function(e) {
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
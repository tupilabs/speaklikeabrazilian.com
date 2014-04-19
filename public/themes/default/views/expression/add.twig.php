<section id='main'>
	<div class='container'>
		<div class="row">
    		<div class='span10'>
    			<div class='row'>
    				<div class='span8'>
    					<h2 class='subtitle'>Add expression</h2>
    				</div>
    				<hr class='clearfix' />
    				<div class='span10'>
                        {{ Form.open({'url': URL.current(), 'class': 'form-horizontal', 'id': 'addExpressionForm'}) }}
    						<div class="control-group">
                                {{ Form.label('text', 'Expression', {'class': 'control-label'}) }}
            					<div class="controls">
                                    {{ Form.input('text', 'text', expression, {'id': 'expression', 'style': 'width: 95%;'}) }}
                                    {% if errors.has('expression') %}
            						<span>
                                        <div class='alert'>
                                            {{ errors.first('expression') }}
                                        </div>
									</span>
                                    {% endif %}
            					</div>
            				</div>
            				<div class="control-group">
                                {{ Form.label('definition', 'Definition', {'class': 'control-label'}) }}
            					<div class="controls">
                                    {{ Form.textarea('definition', definition, {'id': 'definition', 'style': 'width: 95%;', 'rows': 4}) }}
                                    <br/><span class="" id="definitionCounter"></span> character(s) remaining
            						<span class="help-block"><small>
            							Include as much information about your expression as possible. You can mention 
            							other expressions with the following syntax: [expression_name]
            						</small></span>
            						{% if errors.has('definition') %}
                                    <span>
                                        <div class='alert'>
                                            {{ errors.first('definition') }}
                                        </div>
                                    </span>
                                    {% endif %}
            					</div>
            				</div>
            				<div class="control-group">
                                {{ Form.label('example', 'Example', {'class': 'control-label'}) }}
            					<div class="controls">
                                    {{ Form.textarea('example', example, {'id': 'example', 'style': 'width: 95%', 'rows': '4'}) }}
            						<span class="help-block"><small>
            						List some synonyms, related words, places or misspellings, separated by 
            						commas (e.g.: Sao Paulo City, NSFW, oldie).
            						</small></span>
            						{% if errors.has('example') %}
                                    <span>
                                        <div class='alert'>
                                            {{ errors.first('example') }}
                                        </div>
                                    </span>
                                    {% endif %}
            					</div>
            				</div>
            				<div class="control-group">
                                {{ Form.label('tags', 'Tags', {'class': 'control-label'}) }}
            					<div class="controls">
                                    {{ Form.input('text', 'tags', tags, {'id': 'tags', 'style': 'width: 95%;'}) }}
            						{% if errors.has('tags') %}
                                    <span>
                                        <div class='alert'>
                                            {{ errors.first('tags') }}
                                        </div>
                                    </span>
                                    {% endif %}
            					</div>
            				</div>
            				<hr />
            				<h4>Who are you?</h4>
            				<div class="control-group">
                                {{ Form.label('pseudonym', 'Your pseudonym', {'class': 'control-label'}) }}
            					<div class="controls">
                                    {{ Form.input('text', 'pseudonym', pseudonym, {'id': 'pseudonym', 'style': 'width? 95%;'}) }}
            						<span class="help-block"><small>
            						This is how you will be identified as author of this definition.
            						</small></span>
            						{% if errors.has('pseudonym') %}
                                    <span>
                                        <div class='alert'>
                                            {{ errors.first('pseudonym') }}
                                        </div>
                                    </span>
                                    {% endif %}
            					</div>
            				</div>
            				<div class="control-group">
                                {{ Form.label('email', 'Your e-mail', {'class': 'control-label'}) }}
            					<div class="controls">
                                    {{ Form.email('email', email, {'style': 'width: 95%'}) }}
            						{% if errors.has('email') %}
                                    <span>
                                        <div class='alert'>
                                            {{ errors.first('email') }}
                                        </div>
                                    </span>
                                    {% endif %}
            						<div>
            							<label class='checkbox muted'>
                                            <small>{{ Form.checkbox('subscribe', 'checked', subscribe)}} Subscribe to our word of day</small>
            							</label>
            						</div>
            					</div>
            				</div>
            				<div class="control-group" style="display:none;">
            					<div class="controls">
                                    {{ Form.honeypot('le_name', 'le_time') }}
            					</div>
            				</div>
            				<hr />
            				<div class="row">
            					<div class="" style="text-align: center;">
                                    {{ Form.submit('Send', {'class': 'btn btn-primary', 'id': 'btnSubmitForm'}) }}
            					</div>
            				</div>
    					{{ Form.close() }}
    				</div>
    			</div>
    		</div>
    		{# 2 columns wide #}
    		{% include 'partials/sidebar.twig.php' %}
		</div>
	</div>
</section>
<script type='text/javascript'>
templatecallback = function() {
	base_url = "{{ URL.to('/') }}";
    YUI().use(
      'aui-form-validator',
      'aui-char-counter',
      'node',
      function(Y) {
        new Y.CharCounter(
          {
            counter: '#definitionCounter',
            input: '#definition',
            maxLength: 1000
          }
        );

        var rules = {
            text: {
                required: true, 
                rangeLength: [1, 255]
            },
            definition: {
                required: true, 
                rangeLength: [3, 1000]
            },
            example: {
                required: true, 
                rangeLength: [3, 1000]
            },
            tags: {
                required: true, 
                rangeLength: [3, 100]
            },
            pseudonym: {
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
            boundingBox: '#addExpressionForm',
            //fieldStrings: fieldStrings,
            rules: rules,
            showAllMessages: true
        });

        var btn = Y.one('#btnSubmitForm');
        Y.one('#addExpressionForm').on('submit', function(e) {
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
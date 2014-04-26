<style>
.first-icon {
    top: 10px !important;
}

.second-icon {
    top: 10px !important;
}
</style>
<section id='main'>
	<div class='container'>
		<div class="row">
    		<div class='col-xs-10'>
    			<div class='row'>
    				<h2 class='subtitle'>Add expression</h2>
                    <br/>
    				<div class='span10'>
                        {{ Form.open({'url': URL.current(), 'class': 'form-horizontal', 'id': 'addExpressionForm', 'role': 'form'}) }}
    						<div class="form-group">
                                {{ Form.label('expression', 'Expression', {'class': 'col-xs-2 control-label'}) }}
            					<div class="col-xs-10">
                                    {{ Form.input('text', 'text', expression, {'id': 'expression', 'class': 'form-control'}) }}
                                    {% if errors.has('expression') %}
            						<span>
                                        <div class='alert'>
                                            {{ errors.first('expression') }}
                                        </div>
									</span>
                                    {% endif %}
            					</div>
            				</div>
            				<div class="form-group">
                                {{ Form.label('definition', 'Definition', {'class': 'col-xs-2 control-label'}) }}
            					<div class="col-xs-10">
                                    {{ Form.textarea('definition', definition, {'id': 'definition', 'class': 'form-control', 'rows': 4}) }}
                                    <br/>
                                    <span class="help-block"><small><span class="" id="definitionCounter"></span> character(s) remaining<br/>
            							Include as much information about your expression as possible. You can mention 
            							other expressions with the following syntax: [expression_name]</small></span>
            						{% if errors.has('definition') %}
                                    <span>
                                        <div class='alert'>
                                            {{ errors.first('definition') }}
                                        </div>
                                    </span>
                                    {% endif %}
            					</div>
            				</div>
                            <div class='form-group'>
                                {{ Form.label('language', 'Language', {'class': 'col-xs-2 control-label'})}}
                                <div class='col-xs-10'>
                                    {{ Form.select('language', languages, lang, {'class': 'form-control', 'id': 'language'}) }}
                                    <span class="help-block"><small>
                                        Enter the language of the definition.
                                        </small></span>
                                </div>
                            </div>
            				<div class="form-group">
                                {{ Form.label('example', 'Example', {'class': 'col-xs-2 control-label'}) }}
            					<div class="col-xs-10">
                                    {{ Form.textarea('example', example, {'id': 'example', 'class': 'form-control', 'rows': '4'}) }}
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
            				<div class="form-group">
                                {{ Form.label('tags', 'Tags', {'class': 'col-xs-2 control-label'}) }}
            					<div class="col-xs-10">
                                    {{ Form.input('text', 'tags', tags, {'id': 'tags', 'class': 'form-control'}) }}
                                    <span class="help-block"><small>
                                    Comma separated list of tags (e.g.: feij&atilde;o, ovo, tromba)
                                    </small></span>
            						{% if errors.has('tags') %}
                                    <span>
                                        <div class='alert'>
                                            {{ errors.first('tags') }}
                                        </div>
                                    </span>
                                    {% endif %}
            					</div>
            				</div>
            				<div class="form-group">
                                {{ Form.label('pseudonym', 'Your pseudonym', {'class': 'col-xs-2 control-label'}) }}
            					<div class="col-xs-10">
                                    {{ Form.input('text', 'pseudonym', pseudonym, {'id': 'pseudonym', 'class': 'form-control'}) }}
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
            				<div class="form-group">
                                {{ Form.label('email', 'Your e-mail', {'class': 'col-xs-2 control-label'}) }}
            					<div class="col-xs-10">
                                    {{ Form.email('email', email, {'class': 'form-control'}) }}
            						{% if errors.has('email') %}
                                    <span>
                                        <div class='alert'>
                                            {{ errors.first('email') }}
                                        </div>
                                    </span>
                                    {% endif %}
            					</div>
            				</div>
                            <div class='form-group'>
                                <div class="col-xs-offset-2 col-xs-8">
                                    <label class='checkbox' for='subscribe'>
                                        {{ Form.checkbox('subscribe', 'checked', subscribe, {"data-toggle": "checkbox"})}} <span class="help-block"><small>Subscribe to our word of day</small></span>
                                    </label>
                                </div>
                            </div>
            				<div class="form-group" style="display:none;">
            					<div class="col-xs-10">
                                    {{ Form.honeypot('le_name', 'le_time') }}
            					</div>
            				</div>
            				<div class="row">
            					<div class="" style="text-align: center;">
                                    {{ Form.submit('Send', {'class': 'btn btn-primary btn-wide', 'id': 'btnSubmitForm'}) }}
            					</div>
            				</div>
    					{{ Form.close() }}
                        <br/>
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
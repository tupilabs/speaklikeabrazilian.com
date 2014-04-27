<section id="main">
    <div class='container'>
        <div class='row'>
        	{# 2 columns wide #}
            {% include 'partials/moderators/menu.twig.php' %}
            <div class='col-xs-8' style='padding-top: 20px;'>

            	<p>Edit your profile</p>

                {{ Form.open({'url': URL.current(), 'class': 'form-horizontal', 'id': 'updateProfileForm'}) }}
                	<div class="form-group">
                        {{ Form.label('first_name', 'First name', {'class': 'col-xs-4 control-label'}) }}
    					<div class="col-xs-8">
                            {{ Form.input('text', 'first_name', user.attributes.first_name, {'id': 'first_name', 'class': 'form-control'}) }}
    					</div>
    				</div>
    				<div class="form-group">
                        {{ Form.label('last_name', 'Last name', {'class': 'col-xs-4 control-label'}) }}
    					<div class="col-xs-8">
                            {{ Form.input('text', 'last_name', user.attributes.last_name, {'id': 'last_name', 'class': 'form-control'}) }}
    					</div>
    				</div>
                	<div class="form-group">
                        {{ Form.label('email', 'E-mail', {'class': 'col-xs-4 control-label'}) }}
    					<div class="col-xs-8">
                            {{ Form.input('text', 'email', user.email, {'id': 'email', 'class': 'form-control'}) }}
    					</div>
    				</div>
    				<div class="form-group">
                        {{ Form.label('password', 'New password', {'class': 'col-xs-4 control-label'}) }}
    					<div class="col-xs-8">
                            {{ Form.input('password', 'password', '', {'id': 'password', 'class': 'form-control'}) }}
                            <span class="help-block"><small>Won't change if you don't fill it</small></span>
    					</div>
    				</div>
    				<div class="form-group">
                        {{ Form.label('password_confirm', 'Confirm new password', {'class': 'col-xs-4 control-label'}) }}
    					<div class="col-xs-8">
                            {{ Form.input('password', 'password_confirm', '', {'id': 'password_confirm', 'class': 'form-control'}) }}
    					</div>
    				</div>
                    <div class='form-group'>
                        {{ Form.submit('Save', {'class': 'btn btn-success', 'id': 'btnSubmitForm'}) }}
                    </div>
                {{ Form.close() }}

            </div>
            {# 2 columns wide #}
            {% include 'partials/sidebar.twig.php' %}
        </div>
    </div>
</section>
<br/>
<script type='text/javascript'>
templatecallback = function() {
	base_url = "{{ URL.to('/') }}";
    YUI().use(
      'aui-form-validator',
      'node',
      function(Y) {
        var rules = {
            first_name: {
                required: true, 
                rangeLength: [1, 50]
            },
            last_name: {
                required: true, 
                rangeLength: [1, 50]
            },
            email: {
            	email: true,
                required: true
            }
        };

        var validator = new Y.FormValidator(
        {
            boundingBox: '#updateProfileForm',
            //fieldStrings: fieldStrings,
            rules: rules,
            showAllMessages: true
        });

        var btn = Y.one('#btnSubmitForm');
        Y.one('#updateProfileForm').on('submit', function(e) {
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
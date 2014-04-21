<style type="text/css">
  .form-signin {
    max-width: 300px;
    padding: 19px 29px 29px;
    margin: 0 auto 20px;
    background-color: #fff;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 5px;
       -moz-border-radius: 5px;
            border-radius: 5px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
       -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            box-shadow: 0 1px 2px rgba(0,0,0,.05);
  }
  .form-signin .form-signin-heading,
  .form-signin .checkbox {
    margin-bottom: 10px;
  }
  .form-signin input[type="text"],
  .form-signin input[type="password"] {
    font-size: 16px;
    height: auto;
    margin-bottom: 15px;
    padding: 7px 9px;
  }

</style>
<section id='main'>
	<div class='container'>
		<div class="row">
    		<div class='offset1 span9'>
    			<div class='row'>
    				<br class='clearfix' />
    				<div class='span10'>
    					{{ Form.open({'url': '/user/login', 'class': 'form-signin', 'id': 'formSignin'}) }}
                            <h2 class="center form-signin-heading">Log in</h2>
                            <input type='hidden' name='from' value='{{ from }}' />
                            <input type="text" name='user' id='user' class="input-block-level" placeholder="Email address">
                            <input type="password" name='password' id='password' class="input-block-level" placeholder="Password">
                            <label class="checkbox" for='remember-me'>
                              <input type="checkbox" name='remember-me' id='remember-me' value="remember-me"> Remember me
                            </label>
                            <div class='center'>
                                <button class="btn btn-primary" id='btnSubmitForm' type="submit">Sign in</button>
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
      'node',
      function(Y) {
        var rules = {
            user: {
                email: true,
                required: true, 
                rangeLength: [1, 255]
            },
            password: {
                required: true, 
                rangeLength: [3, 1000]
            }
        };

        var validator = new Y.FormValidator(
        {
            boundingBox: '#formSignin',
            //fieldStrings: fieldStrings,
            rules: rules,
            showAllMessages: true
        });

        var btn = Y.one('#btnSubmitForm');
        Y.one('#formSignin').on('submit', function(e) {
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
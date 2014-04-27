<section id="main">
    <div class='container'>
        <div class='row'>
            {% include 'partials/moderators/menu.twig.php' %}
            <div class='col-xs-8' style='padding-top: 20px;'>
            {% if media is defined and media is not empty %}
                <p>Pending Picture</p>

                <p class='entry-paragraph'><strong>{{ media.definition.first.expression.first.text }}</strong></p>

                {% include 'partials/expressions/picture.twig.php' %}

                <div class='col-xs-offset-3 col-xs-3'>
                {{ Form.open({'url': '/moderators/approvePicture', 'class': 'form-inline center'}) }}
                    <input type='hidden' name='mediaId' value='{{ media.id }}' />
                    <div class='form-group'>
                        {{ Form.submit('Approve', {'class': 'btn btn-success'}) }}
                    </div>
                {{ Form.close() }}
                </div>
                <div class='col-xs-3'>
                {{ Form.open({'url': '/moderators/rejectPicture', 'class': 'form-inline center'}) }}
                    <input type='hidden' name='mediaId' value='{{ media.id }}' />
                    <div class='form-group'>
                        {{ Form.submit('Reject', {'class': 'btn btn-danger'}) }}
                    </div>
                {{ Form.close() }}
                </div>

            {% else %}
                <p>There are no pending pictures</p>
            {% endif %}
            </div>
            {# 2 columns wide #}
            {% include 'partials/sidebar.twig.php' %}
        </div>
    </div>
</section>
<br/>
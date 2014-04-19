{% block content %}
<section id="main">
    <div class='container'>
        <div class='row'>
            <div class='span10'>
                {% if definitions is defined and definitions[0] is defined %}
                <div class='row'>
                    <div class='span10'>
                        <h2 class='subtitle'>{{ subtitle }}</h2>
                    </div>
                </div>
                {% endif %}
                <div class='row'>
                {% if definitions is defined and definitions[0] is defined %}
                    <div class='span5'>
                        {% for definition in definitions|slice(0, 5) %}
                            {% include 'partials/expressions/single.twig.php' %}
                        {% endfor %}
                    </div>
                    <div class='span5'>
                        {% for definition in definitions|slice(5, 10) %}
                            {% include 'partials/expressions/single.twig.php' %}
                        {% endfor %}
                    </div>
                {% else %}
                    <div class='span10'>
                        <h4>{{ no_expressions_message }}</h4>
                        <p><strong>No expression found. {{ HTML.link('expression/add', 'Add yours!') }}</strong></p>
                    </div>
                {% endif %}
                </div>
            </div>
            {# 2 columns wide #}
            {% include 'partials/sidebar.twig.php' %}
        </div>
        {% if expressions is defined and expressions[0] is defined %}
        <div class='row center'>
            {{ pagination_links }}
        </div>
        {% endif %}
    </div>
</section>
{% endblock %}
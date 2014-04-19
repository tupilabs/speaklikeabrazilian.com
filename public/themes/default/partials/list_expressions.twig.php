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
                <div class='row'>
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
                <div class='row'>
                    <div class='span10'>
                    {% if expression is defined and expression is not empty %}
                        <h2 class='subtitle'>No definitions of '{{ expression }}' found. {{ HTML.link('expression/add?e=' ~ expression, 'Add yours!') }}</h2>
                    {% elseif letter is defined and letter is not empty %}
                        <h2 class='subtitle'>No expressions starting with '{{ letter }}' found. {{ HTML.link('expression/add', 'Add yours!') }}</h2>
                    {% else %}
                        <h2>No expression found. {{ HTML.link('expression/add', 'Add yours!') }}</h2>
                    {% endif %}
                    </div>
                </div>
                {% endif %}
            </div>
        </div>
        {# 2 columns wide #}
        {% include 'partials/sidebar.twig.php' %}
        {% if expressions is defined and expressions[0] is defined %}
        <div class='row center'>
            {{ pagination_links }}
        </div>
        {% endif %}
    </div>
</section>
{% endblock %}
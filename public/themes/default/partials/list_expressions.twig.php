<section id="main">
    <div class='container'>
        <div class='row'>
            <div class='col-sm-12 col-md-10 col-lg-10'>
                {% if definitions is defined and definitions[0] is defined %}
                <h2 class='subtitle'>{{ subtitle }}</h2>
                <div class='row'>
                    <div class='col-sm-12 col-md-6 col-lg-6'>
                        {% for definition in definitions|slice(0, 5) %}
                            {% include 'partials/expressions/single.twig.php' %}
                        {% endfor %}
                    </div>
                    <div class='col-sm-12 col-md-6 col-lg-6'>
                        {% for definition in definitions|slice(5, 10) %}
                            {% include 'partials/expressions/single.twig.php' %}
                        {% endfor %}
                    </div>
                </div>
                <div class='row'>
                    <div class='col-xs-10 center'>
                        {{ definitions.links }}
                    </div>
                </div>
                {% else %}
                <div class='row'>
                    <div class='col-xs-10'>
                    {% if expression is defined and expression is not empty %}
                        <h2 class='subtitle'>{{ Lang.get('messages.no_definitions_of', {'definition': expression}) }}. {{ HTML.link('expression/add?e=' ~ expression, Lang.get('messages.add_yours')) }}</h2>
                    {% elseif letter is defined and letter is not empty %}
                        <h2 class='subtitle'>No expressions starting with '{{ letter }}' found. {{ HTML.link('expression/add', 'Add yours!') }}</h2>
                    {% else %}
                        <h2 class='subtitle'>No expression found. {{ HTML.link('expression/add', 'Add yours!') }}</h2>
                    {% endif %}
                    </div>
                </div>
                {% endif %}
            </div>
            {# 2 columns wide #}
            {% include 'partials/sidebar.twig.php' %}
        </div>
        <br/>
    </div>
</section>
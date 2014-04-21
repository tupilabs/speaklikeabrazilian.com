<section id="main">
    <div class='container'>
        <div class='row'>
            <div class='col-xs-2' style='padding-top: 20px;'>
            	<ul class="nav nav-pills nav-stacked">
                    <li><a href='{{ URL.to('/moderators') }}'>Moderators Home</a></li>
                    <li><a href='{{ URL.to('/moderators/pendingExpressions') }}'>Pending expressions</a></li>
                    <li><a href='{{ URL.to('/moderators/pendingVideos') }}'>Pending videos</a></li>
                    <li><a href='{{ URL.to('/moderators/editExpression') }}'>Edit expression</a></li>
                    <li><a href="{{ URL.to('/user/logout') }}">Logout</a>
                </ul>
            </div>
            <div class='col-xs-8' style='padding-top: 20px;'>
                <p>Hello moderator!</p>
            </div>
            {# 2 columns wide #}
            {% include 'partials/sidebar.twig.php' %}
        </div>
    </div>
</section>